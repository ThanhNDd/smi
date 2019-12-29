<?php
include("../../common/DBConnection.php");
include("../../dao/ProductDAO.php");
include("../../dao/CheckoutDAO.php");
include("../../dao/VoucherDAO.php");
include("../../model/Order/Order.php");
include("../../model/Order/OrderDetail.php");
include("PrinterReceipt.php");

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
        $total_checkout = 0;
        if(!empty($data->total_checkout))
        {
            $total_checkout = $data->total_checkout;
        }
        $total_reduce = 0;
        $total_reduce_percent = 0;    
        if(!empty($data->total_reduce)) {
            $total_reduce = $data->total_reduce;
            $total_reduce_percent = round($total_reduce*100/$total_checkout);
        }
        $order = new Order();
        $order->setTotal_amount(empty($data->total_amount) ? 0 : $data->total_amount);
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
        $orderId = $checkout_dao->saveOrder($order);
        $order->setId($orderId);     
        if(empty($orderId)) {
            throw new Exception("Cannot insert order");
        } else {
            $details = $data->details;
            for($i=0; $i<count($details); $i++)
            {
                $price = 0;
                $qty = 0;
                $reduce = 0;
                $reduce_percent = 0;

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
                $detail->setProduct_id(empty($details[$i]->product_id) ? 0 : $details[$i]->product_id);
                $detail->setVariant_id(empty($details[$i]->variant_id) ? 0 : $details[$i]->variant_id);
                $detail->setSku(empty($details[$i]->sku) ? 0 : $details[$i]->sku);
                $detail->setPrice(empty($details[$i]->price) ? 0 : $details[$i]->price);
                $detail->setQuantity(empty($details[$i]->quantity) ? 0 : $details[$i]->quantity);
                $detail->setReduce(empty($details[$i]->reduce) ? 0 : $details[$i]->reduce);
                $detail->setReduce_percent($reduce_percent);
                $checkout_dao->saveOrderDetail($detail);
                if(!empty($details[$i]->sku)) {
                    $dao->update_quantity_by_sku($details[$i]->sku, $details[$i]->quantity);
                } else
                {
                    throw new Exception("Cannot update quantity by SKU");
                }
            }  
            if(!empty($data->voucher_code)) {
                $type_code = 1;
                $used_status = 3;
                $voucherDAO->update_status($data->voucher_code, $used_status, $type_code); // type = 1 is inactive by code
            }
            // printer receipt
            if($data->flag_print_receipt) {        
                $printer = new PrinterReceipt();
                $filename = $printer->print($order, $details);         
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