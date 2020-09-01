<?php
require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../dao/CommonDAO.php");
include("../../dao/CheckoutDAO.php");
include("../../dao/ProductDAO.php");
include("../../dao/WalletDAO.php");
include("../../dao/CustomerDAO.php");
include("../../model/Wallet/Wallet.php");
include("../../model/Order/Order.php");
include("../../model/Order/OrderDetail.php");
include("PrinterReceiptExchange.php");

$db = new DBConnect();

$productDAO = new ProductDAO();
$productDAO->setConn($db->getConn());

$checkoutDAO = new CheckoutDAO();
$checkoutDAO->setConn($db->getConn());

$walletDAO = new WalletDAO();
$walletDAO->setConn($db->getConn());

$customerDAO = new CustomerDAO();
$customerDAO->setConn($db->getConn());

if (isset($_POST["method"]) && $_POST["method"] == "find_order") {
    $order_id = $_POST["orderId"];
    try {
        Common::authen_get_data();
        $order = $checkoutDAO->find_by_id($order_id, 0);
        echo json_encode($order);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "exchange") {
    try {
        Common::authen_get_data();
        $exchanges = $_POST["data"];
        $data = json_decode($exchanges);
        $total_amount = $data->total_amount;
        $total_checkout = $data->total_checkout;
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
//        $order->setRepayType($data->repay_type);
        $order->setCustomer_id($data->customer_id);
        $order->setType(2); // exchange
        $order->setStatus(6);// order exchange
        $order->setVoucherCode($data->voucher_code);
        $order->setVoucherValue($data->voucher_value);
        $order->setOrderRefer($data->current_order_id);
        $order->setPaymentExchangeType($data->payment_exchange_type);
        $order->setSource($data->source);
        $order->setOrder_date(date('Y-m-d H:i:s'));
        $orderId = $checkoutDAO->saveOrder($order);
        $order->setId($orderId);
        if (empty($orderId)) {
            throw new Exception("Cannot insert order");
        } else {
            $response_array = array();
            $curr_arr = get_details($data->curr_products, $orderId, 1); // product exchange
            if (count($curr_arr) <= 0) {
                throw new Exception("Have no product!!");
            }
            $exchange_arr = get_details($data->exchange_products, $orderId, 2);// new product of exchange
            if (count($exchange_arr) <= 0) {
                throw new Exception("Have no product exchange!!");
            }
            $add_new_arr = get_details($data->add_new_products, $orderId, 0); // add new product

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
                    throw new Exception("Error insert customer point!!!");
                }
            }

            // printer receipt
            if ($data->flag_print_receipt) {
                $customer_name = '';
                if(!empty($data->customer_id)) {
                    $customer = $customerDAO->find_by_id($data->customer_id);
                    if(!empty($customer)) {
                        $customer_name = $customer[0]["name"];
                    }
                }
                $order->setCustomerName($customer_name);
                $order->setPointSave($data->wallet_saved);
                $printer = new PrinterReceiptExchange();
                $filename = $printer->print($order, $exchange_arr, $curr_arr, $add_new_arr);
                $response_array['fileName'] = $filename;
            }
            $response_array['orderId'] = $orderId;
            echo json_encode($response_array);

            // $sendMail = new SendMail();
            // $sendMail->send();
        }
    } catch (Exception $e) {
        $db->rollback();
        echo $e;
    }
    // all Ok
    $db->commit();
}

function get_details($details, $orderId, $productType)
{
    global $checkoutDAO;
    global $productDAO;
    $detailsObj = array();
    for ($i = 0; $i < count($details); $i++) {
        $price = 0;
        $qty = 0;
        $reduce = 0;
        $reduce_percent = 0;
        $profit = 0;
        $product_id = 0;
        if (!empty($details[$i]->product_id)) {
            $product_id = $details[$i]->product_id;
        } else {
            echo "Product_Id is null";
        }
        $variant_id = 0;
        if (!empty($details[$i]->variant_id)) {
            $variant_id = $details[$i]->variant_id;
        } else {
            echo "Variant_id is null";
        }
        $sku = '';
        if (!empty($details[$i]->sku)) {
            $sku = $details[$i]->sku;
        } else {
            echo "SKU is null";
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
        if (!empty($details[$i]->profit)) {
            $profit = $details[$i]->profit;
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
        $detail->setType($productType);
        $detail->setProfit($profit);
        try {
            $checkoutDAO->saveOrderDetail($detail);
            $detail->setProductName($details[$i]->product_name);
            array_push($detailsObj, $detail);
            if (!empty($sku)) {
                $productDAO->update_qty_variation_by_sku((int)$sku, (int)$qty, $productType);
            } else {
                throw new Exception("SKU is empty");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
    return $detailsObj;
}
