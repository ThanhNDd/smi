<?php
require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../dao/CommonDAO.php");
include("../../dao/ProductDAO.php");
include("../../dao/CheckoutDAO.php");
include("../../dao/VoucherDAO.php");
include("../../dao/CustomerDAO.php");
include("../../dao/WalletDAO.php");
include("../../model/Order/Order.php");
include("../../model/Order/OrderDetail.php");
include("../../model/Wallet/Wallet.php");
include("PrinterReceipt.php");
include("../exchange/PrinterReceiptExchange.php");

$db = new DBConnect();

$dao = new ProductDAO($db);
// $dao->setConn($db->getConn());

$checkout_dao = new CheckoutDAO($db);
// $checkout_dao->setConn($db->getConn());

$voucherDAO = new VoucherDAO($db);
// $voucherDAO->setConn($db->getConn());

$customerDAO = new CustomerDAO($db);
// $customerDAO->setConn($db->getConn());

$walletDAO = new WalletDAO($db);
// $walletDAO->setConn($db->getConn());

if (isset($_POST["type"]) && $_POST["type"] == "find_product") {
    try {
        Common::authen_get_data();
        $sku = $_POST["sku"];
        $product = $dao->find_by_sku($sku);
        echo json_encode($product);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST["type"]) && $_POST["type"] == "checkout") {
    try {
        Common::authen_get_data();
        $data = $_POST["data"];
        $data = json_decode($data);
        $total_amount = 0;
        if (!empty($data->total_amount)) {
            $total_amount = $data->total_amount;
        } else {
            echo "total_amount is null";
        }
        $total_checkout = 0;
        if (!empty($data->total_checkout)) {
            $total_checkout = $data->total_checkout;
        } else {
            echo "Total_Checkout is null";
        }
        $total_reduce = 0;
        $total_reduce_percent = 0;
        if (!empty($data->total_reduce)) {
            $total_reduce = $data->total_reduce;
            $total_reduce_percent = round($total_reduce * 100 / $total_checkout);
        }
        $order = new Order();
        $order->setTotal_amount($total_amount);
        $order->setTotal_reduce($total_reduce);
        $order->setTotal_reduce_percent($total_reduce_percent);
        $order->setDiscount($data->discount);
        $order->setWallet($data->wallet);
        $order->setTotal_checkout($total_checkout);
        $order->setCustomer_payment($data->customer_payment);
        $order->setPayment_type($data->payment_type);
        $order->setRepay($data->repay);
        $order->setTransferToWallet($data->transfer_to_wallet);
        $order->setCustomer_id($data->customer_id);
        $order->setType(0);
        $order->setStatus(3);
        $order->setVoucherCode($data->voucher_code);
        $order->setVoucherValue($data->voucher_value);
        $order->setOrderRefer($data->current_order_id);
        $order->setPaymentExchangeType($data->payment_exchange_type);
        $order->setSource($data->source);
        $order->setOrder_date(date('Y-m-d H:i:s'));
        $orderId = $checkout_dao->saveOrder($order);
        $order->setId($orderId);
        if (empty($orderId)) {
            throw new Exception("Cannot insert order");
        } else {
            $detailsObj = array();
            $details = $data->details;
            for ($i = 0; $i < count($details); $i++) {
                $product_id = 0;
                $variant_id = 0;
                $sku = 0;
                $price = 0;
                $qty = 0;
                $reduce = 0;
                $reduce_percent = 0;
                $reduce_type = 0;

                if (!empty($details[$i]->product_id)) {
                    $product_id = $details[$i]->product_id;
                } else {
                    throw new Exception("Product_Id is null");
                }
                if (!empty($details[$i]->variant_id)) {
                    $variant_id = $details[$i]->variant_id;
                } else {
                    throw new Exception("Variant_id is null");
                }
                if ($details[$i]->sku != "") {
                    $sku = $details[$i]->sku;
                } else {
                    throw new Exception("SKU is null");
                }
                if (!empty($details[$i]->price)) {
                    $price = $details[$i]->price;
                }
                if (!empty($details[$i]->quantity)) {
                    $qty = $details[$i]->quantity;
                }
                if (!empty($details[$i]->reduce)) {
                    $reduce = $details[$i]->reduce;
                }
                if (!empty($details[$i]->reduce_percent)) {
                    $reduce_percent = $details[$i]->reduce_percent;
                }
                if (!empty($details[$i]->reduce_type)) {
                    $reduce_type = $details[$i]->reduce_type;
                }

                $detail = new OrderDetail();
                $detail->setOrder_id($orderId);
                $detail->setProduct_id($product_id);
                $detail->setVariant_id($variant_id);
                $detail->setSku($sku);
                $detail->setPrice($price);
                $detail->setQuantity($qty);
                $detail->setReduce($reduce);
                $detail->setReduce_percent($reduce_percent);
                $detail->setReduceType($reduce_type);
                $detail->setType(0);//add new
                $detail->setProfit($details[$i]->profit);
                $checkout_dao->saveOrderDetail($detail);
                $detail->setProductName($details[$i]->product_name);

                array_push($detailsObj, $detail);
                if (!empty($sku)) {
                    $dao->update_qty_variation_by_sku((string)$sku, (int)$qty, 1);
                } else {
                    throw new Exception("SKU is empty");
                }
            }
            // save customer point
            if (!empty($orderId) && !empty($data->customer_id)) {
                $wallet = new Wallet();
                $wallet->setOrderId($orderId);
                $wallet->setCustomerId($data->customer_id);
                $wallet->setSaved($data->wallet_saved);
                $wallet->setUsed($data->wallet_used);
                $wallet->setRepay($data->wallet_repay);
                $wallet->setRemain($data->wallet_remain);
                $lastId = $walletDAO->save_wallet($wallet);
                if(empty($lastId)) {
                    throw new Exception("Error insert customer wallet!!!");
                }
            }

            if (!empty($data->voucher_code)) {
                $type_code = 1;
                $used_status = 3;
                if ($data->voucher_code != "VCKTOS0") {
                    $voucherDAO->update_status($data->voucher_code, $used_status, $type_code); // type = 1 is inactive by code
                }
            }
            // printer receipt
            if ($data->flag_print_receipt) {
                $printer = new PrinterReceipt();
                try {
                    $customer_name = '';
                    if(!empty($data->customer_id)) {
                        $customer = $customerDAO->find_by_id($data->customer_id);
                        if(!empty($customer)) {
                            $customer_name = $customer[0]["name"];
                        }
                    }
                    $order->setCustomerName($customer_name);
                    $order->setPointSave($data->wallet_saved);
                    $filename = $printer->print($order, $detailsObj);
                    $response_array['fileName'] = $filename;
                } catch (Exception $ex) {
                    $response_array['fileName'] = '';
                }
            }
            $response_array['orderId'] = $orderId;
            echo json_encode($response_array);
        }
        // all Ok
        $db->commit();
    } catch (Exception $e) {
        $db->rollback();
        echo "Error Processing Request: " . $e->getMessage();
    }
}

