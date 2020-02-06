<?php
include("../../common/DBConnection.php");
include("../../dao/CheckoutDAO.php");
include("../../dao/ProductDAO.php");
include("../../model/Order/Order.php");
include("../../model/Order/OrderDetail.php");
include("PrinterReceiptExchange.php");

$db = new DBConnect();

$productDAO = new ProductDAO();
$productDAO->setConn($db->getConn());

$checkoutDAO = new CheckoutDAO();
$checkoutDAO->setConn($db->getConn());

if(isset($_POST["method"]) && $_POST["method"]=="find_order")   {
    $order_id = $_POST["orderId"];
    try
    {
        $order = $checkoutDAO->find_by_id($order_id, 0);
        echo json_encode($order);
    } catch(Exception $ex)
    {
        throw new Exception($ex);
    }
}

if(isset($_POST["method"]) && $_POST["method"]=="exchange") {
    try {
        $exchanges = $_POST["data"];
        $data = json_decode($exchanges);
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
        $order->setType(2); // exchange
        $order->setCustomer_id(0); // retail customer
        $order->setStatus(6);// order exchange
        $order->setVoucherCode($data->voucher_code);
        $order->setVoucherValue($data->voucher_value);
        $order->setOrderRefer($data->current_order_id);
        $order->setPaymentExchangeType($data->payment_exchange_type);
        $orderId = $checkoutDAO->saveOrder($order);
        $order->setId($orderId);
        if(empty($orderId)) {
            throw new Exception("Cannot insert order");
        } else {
            $curr_arr = get_details($data->curr_products, $orderId, 1); // product exchange
            if(count($curr_arr) <= 0) {
                throw new Exception("Have no product!!");
            }
            $exchange_arr = get_details($data->exchange_products, $orderId, 2);// new product of exchange
            if(count($exchange_arr) <= 0) {
                throw new Exception("Have no product exchange!!");
            }
            $add_new_arr = get_details($data->add_new_products, $orderId, 0); // add new product
            // printer receipt
            $response_array = array();
            if($data->flag_print_receipt) {
                $printer = new PrinterReceiptExchange();
                $filename = $printer->print($order, $exchange_arr, $curr_arr, $add_new_arr);
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

function get_details($details, $orderId, $productType) {
    global $checkoutDAO;
    global $productDAO;
    $detailsObj = array();
    for($i=0; $i<count($details); $i++)
    {
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
        if(!empty($details[$i]->sku))
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
        $detail->setType($productType);
        $checkoutDAO->saveOrderDetail($detail);
        $detail->setProductName($details[$i]->product_name);
        array_push($detailsObj, $detail);
        if(!empty($sku)) {
            $productDAO->update_quantity_by_sku((int) $sku, (int) $qty);
        } else
        {
            throw new Exception("SKU is empty");
        }
    }
    return $detailsObj;
}
