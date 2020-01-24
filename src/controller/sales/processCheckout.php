<?php
include("../../common/DBConnection.php");
include("../../dao/ProductDAO.php");
include("../../dao/CheckoutDAO.php");
include("../../dao/VoucherDAO.php");
include("../../model/Order/Order.php");
include("../../model/Order/OrderDetail.php");
include("PrinterReceipt.php");
include("../exchange/PrinterReceiptExchange.php");

$db = new DBConnect();

$dao = new ProductDAO();
$dao->setConn($db->getConn());

$checkout_dao = new CheckoutDAO();
$checkout_dao->setConn($db->getConn());

$voucherDAO = new VoucherDAO();
$voucherDAO->setConn($db->getConn());

if(isset($_POST["type"]) && $_POST["type"]=="find_product")   {
    try {   
        $sku = $_POST["sku"];
        $product = $dao->find_by_sku($sku);
        echo json_encode($product);
    } catch(Exception $e)
    {
        throw new Exception($e);
    }
}

if(isset($_POST["type"]) && $_POST["type"]=="checkout")   {
    try {
        $data = $_POST["data"];
        $data = json_decode($data); 
        $total_amount = 0;
        if(!empty($data->total_amount))
        {
            $total_amount = $data->total_amount;
        } else {
            throw new Exception("total_amount is null");
        }
        $total_checkout = 0;
        if(!empty($data->total_checkout))
        {
            $total_checkout = $data->total_checkout;
        } else {
            throw new Exception("Total_Checkout is null");
        }
        $total_reduce = 0;
        $total_reduce_percent = 0;    
        if(!empty($data->total_reduce)) {
            $total_reduce = $data->total_reduce;
            $total_reduce_percent = round($total_reduce*100/$total_checkout);
        }
        $order = new Order();
        $order->setTotal_amount($total_amount);
        $order->setTotal_reduce($total_reduce);
        $order->setTotal_reduce_percent($total_reduce_percent);
        $order->setDiscount(empty($data->discount) ? 0 : $data->discount);
        $order->setTotal_checkout($total_checkout);
        $order->setCustomer_payment(empty($data->customer_payment) ? 0 : $data->customer_payment);
        $order->setPayment_type(empty($data->payment_type) ? 0 : $data->payment_type);
        $order->setRepay(empty($data->repay) ? 0 : $data->repay);
        $order->setCustomer_id(empty($data->customer_id) ? 0 : $data->customer_id);
        $order->setType(0); // Sale on shop
        $order->setCustomer_id(0); // retail customer
        $order->setStatus(3);// order completed
        $order->setVoucherCode($data->voucher_code);
        $order->setVoucherValue($data->voucher_value);
        $order->setOrderRefer($data->current_order_id);
        $order->setPaymentExchangeType($data->payment_exchange_type);
        $orderId = $checkout_dao->saveOrder($order);
        $order->setId($orderId);
        if(empty($orderId)) {
            throw new Exception("Cannot insert order");
        } else {
            $detailsObj = array();
            $details = $data->details;
            for($i=0; $i<count($details); $i++)
            {
                $product_id = 0;
                $variant_id = 0;
                $sku = 0;
                $price = 0;
                $qty = 0;
                $reduce = 0;
                $reduce_percent = 0;

                if(!empty($details[$i]->product_id))
                {
                    $product_id = $details[$i]->product_id;
                } else {
                    throw new Exception("Product_Id is null");
                }
                if(!empty($details[$i]->variant_id))
                {
                    $variant_id = $details[$i]->variant_id;
                } else {
                    throw new Exception("Variant_id is null");
                }
                if($details[$i]->sku != "")
                {
                    $sku = $details[$i]->sku;
                } else {
                    throw new Exception("SKU is null");
                }
                if(!empty($details[$i]->price))
                {
                    $price = $details[$i]->price;
                }
                if(!empty($details[$i]->quantity))
                {
                    $qty = $details[$i]->quantity;
                }
                if(!empty($details[$i]->reduce))
                {
                    $reduce = $details[$i]->reduce;
                }
                if(!empty($details[$i]->reduce_percent))
                {
                    $reduce_percent = $details[$i]->reduce_percent;
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
                $detail->setType(0);//add new
                $checkout_dao->saveOrderDetail($detail);
                $detail->setProductName($details[$i]->product_name);
                array_push($detailsObj, $detail);
                if($sku != "") {
                    $dao->update_quantity_by_sku((int) $sku, (int) $qty);
                } else
                {
                    throw new Exception("SKU is empty");
                }
            }  
            if(!empty($data->voucher_code)) {
                $type_code = 1;
                $used_status = 3;
                if($data->voucher_code != "VCKTOS0") {
                    $voucherDAO->update_status($data->voucher_code, $used_status, $type_code); // type = 1 is inactive by code
                }
            }
            // printer receipt
            if($data->flag_print_receipt) {
                    $printer = new PrinterReceipt();
                
                $filename = $printer->print($order, $detailsObj);
                $response_array['fileName'] = $filename;
            }  
            $response_array['orderId'] = $orderId;  
            echo json_encode($response_array);

        //     // $sendMail = new SendMail();
        //     // $sendMail->send();
        }
    } catch(Exception $e)
    {
        $db->rollback();
        throw new Exception("Error Processing Request: ". $e -> getMessage());
    }

    // all Ok
    $db->commit();
}

