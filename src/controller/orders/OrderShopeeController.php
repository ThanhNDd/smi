<?php
header('Access-Control-Allow-Origin: *');

require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../dao/CheckoutDAO.php");
include("../../dao/CustomerDAO.php");
include("../../dao/ProductDAO.php");
include("../../common/cities/Zone.php");
include("../../model/Order/Order.php");
include("../../model/Order/OrderDetail.php");
include("../../model/Order/OrderLogs.php");
include("../../model/Customer/Customer.php");

$db = new DBConnect();
$customerDAO = new CustomerDAO($db);
$checkoutDAO = new CheckoutDAO($db);
$productDAO = new ProductDAO($db);

$zone = new Zone();

if (isset($_POST["method"]) && $_POST["method"] == "checkExistOrderShopee") {
    try {
        $shopeeOrderId = $_POST["data"];
        $orderNumber = $checkoutDAO->checkExistOrderShopee($shopeeOrderId);
        echo json_encode($orderNumber);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "getData") {
    try {
        $data = $_POST["data"];

        $rowData = [];
        $rowData["order_id"] = null;
        $rowData["order_type"] = 1;
        $rowData["source"] = 3;
        $rowData["order_status"] = 13;
        $rowData["wallet"] = 0;
        $rowData["shipping_fee"] = 0;
        $rowData["shipping"] = 0;
        $rowData["payment_type"] = 1;
        $rowData["shopee_order_id"] = $data["orderId"];
        $rowData["order_date"] = $data["orderDate"];
        $rowData["bill_of_lading_no"] = $data["billCode"];
        $rowData["shipping_unit"] = getShippingUnit($data["billCode"]);
        $rowData["totalFee"] = $data["totalFee"];

        $cityName = $data["cityName"];
        $districtName = $data["districtName"];
        $villageName = $data["villageName"];

        
        $cityId = $zone->getCityIdByName($cityName);
        $districtId = $zone->getDistrictIdByName($districtName);
        $villageId = $zone->getWardIdByName($villageName);

        $customerPhone = $data["customerPhone"];
        $customer = $customerDAO->find_customer($customerPhone, 'phone');

        $rowData["customer_id"] = empty($customer) ? null : $customer->id;
        $rowData["customerName"] = $data["customerName"];
        $rowData["customerPhone"] = $customerPhone;
        $rowData["cityId"] = $cityId;
        $rowData["cityName"] = $cityName;
        $rowData["districtId"] = $districtId;
        $rowData["districtName"] = $districtName;
        $rowData["villageId"] = $villageId;
        $rowData["villageName"] = $villageName;
        $rowData["address"] = $data["address"];
        $rowData["fullAddress"] = $data["address"].", ".$villageName.", ".$districtName.", ".$cityName;
        $rowData["fullAddressShopee"] = $data["addressOnShopee"];
        if(empty($cityId) || empty($districtId) || empty($villageId)) {
            $rowData["orderError"] = false;
        }
        
        $rowData["isNotExistProduct"] = 0;      

        $totalQty = 0;
        $description = "";
        $totalReduceOnProduct = 0;
        $totalAmount = 0;

        $rowData["products"] = [];

        // $newProducts = [];
        $products = $data["products"];
        for($i=0; $i<count($products); $i++) {
            $sku = $products[$i]["sku"];
            $variation = $productDAO->find_by_sku($sku);
            $variant = [];
            if(empty($variation)) {
                $rowData["orderError"] = false;
                $rowData["isNotExistProduct"] = intval($rowData["isNotExistProduct"]) + 1;
                $variant["product_id"] = null;
                $variant["variant_id"] = null;
                $variant["product_name"] = "";
                $variant["reduce"] = 0;
                $variant["reduce_percent"] = null;
                $variant["reduce_type"] = null;
                $variant["product_exchange"] = null;
                $variant["profit"] = null;
                $variant["sku"] = null;
                $variant["name"] = null;
                $variant["price"] = null;
                $variant["quantity"] = null;
            } else {
                $variation = $variation[0];
                $productName = $variation["name"];
                $variant["product_id"] = $variation["product_id"];
                $variant["variant_id"] = $variation["variant_id"];
                $variant["product_name"] = $variation["name"];
                $variant["reduce"] = intval(str_replace(",","",$variation["retail"])) - intval($products[$i]["price"]);
                $variant["reduce_percent"] = null;
                $variant["reduce_type"] = null;
                $variant["product_exchange"] = null;
                $variant["profit"] = intval(str_replace(",","",$variation["profit"]));
                $variant["sku"] = $variation["sku"];
                $variant["name"] = $variation["color"].",".$variation["size"];
                $variant["price"] = intval(str_replace(",","",$variation["retail"]));
                $variant["quantity"] = intval($products[$i]["qty"]);
                $totalQty += intval($products[$i]["qty"]);
                $description .= ($i+1).". ".$productName.",".$variation["color"].",".$variation["size"]. PHP_EOL;
                $totalReduceOnProduct += intval($variant["reduce"]);
                $totalAmount += intval(str_replace(",","",$variation["retail"]));
            }
            // array_push($newProducts, $variant);
            array_push($rowData['products'], $variant);
        }
        $rowData["quantity"] = $totalQty;
        $rowData["description"] = $description;
        $rowData["discount"] = $data["totalFee"];
        $rowData["total_reduce"] = intval($data["totalFee"]) + $totalReduceOnProduct;
        $rowData["total_amount"] = intval($totalAmount);
        $rowData["total_checkout"] = intval($totalAmount) - intval($rowData["total_reduce"]);
        
        

        echo json_encode($rowData);

    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}


function getShippingUnit($billCode) {
    $shippingUnit = "";
    if(substr($billCode,0, 3) == "SPX") {
      $shippingUnit = "SPXEXPRESS";
    } else if(substr($billCode,0, 3) == "SPE") {
      $shippingUnit = "NINJAVAN";
    } else if(substr($billCode,0, 2) == "GA") {
      $shippingUnit = "GHN";
    }
    return $shippingUnit;
}

if (isset($_POST["method"]) && $_POST["method"] == "add_new") {
    try {
        $data = $_POST["data"];
        $data = json_decode($data);

        $message_log = 'Tạo mới đơn hàng (Chrome Extension)';

        $order = new Order();
        $order_type = $data->order_type;
        $cusId = $data->customer_id;
        if(empty($cusId)) {
            $customer = new Customer();
            $customer->setName($data->customerName);
            $customer->setPhone($data->customerPhone);
            $customer->setFullAddress($data->fullAddress);
            $customer->setAddress($data->address);
            $customer->setCityId($data->cityId);
            $customer->setDistrictId($data->districtId);
            $customer->setVillageId($data->villageId);
            $cusId = $customerDAO->save_customer($customer);
        }
        $total_checkout = $data->total_checkout;
        $total_reduce = 0;
        $total_reduce_percent = 0;
        if (!empty($data->total_reduce)) {
            $total_reduce = $data->total_reduce;
            $total_reduce_percent = round($total_reduce * 100 / $total_checkout);
        }
        $bill_of_lading_no = $data->bill_of_lading_no;
        $order->setShopee_order_id($data->shopee_order_id ?? null);
        $order->setBill_of_lading_no($data->bill_of_lading_no ?? null);
        $order->setShipping_fee($data->shipping_fee ?? null);
        $order->setShipping($data->shipping ?? null);
        $order->setShipping_unit($data->shipping_unit ?? null);
        $order->setTotal_amount($data->total_amount ?? null);
        $order->setTotal_reduce($total_reduce ?? null);
        $order->setTotal_reduce_percent($total_reduce_percent ?? null);
        $order->setDiscount($data->discount ?? null);
        $order->setWallet($data->wallet ?? null);
        $order->setTotal_checkout($data->total_checkout ?? null);
        $order->setCustomer_payment($data->customer_payment ?? null);
        $order->setPayment_type($data->payment_type ?? null);
        $order->setRepay($data->repay ?? null);
        $order->setTransferToWallet($data->transfer_to_wallet ?? null);
        $order->setCustomer_id($cusId ?? null);
        $order->setType($order_type ?? null);
        $order->setStatus($data->order_status ?? null);
        $order->setPayment_type($data->payment_type ?? null);
        $order->setVoucherValue(0);
        $order->setOrder_date($data->order_date ?? null);
        $order->setAppointmentDeliveryDate($data->appointment_delivery_date ?? null);
        $order->setSource($data->source ?? null);
        $order->setDescription($data->description ?? null);
        if (isset($data->order_id) && $data->order_id > 0) {
            $message_log = 'Cập nhật đơn hàng';
            $order->setId($data->order_id);
            $orderId = $checkoutDAO->updateOrder($order);
            if (!empty($orderId)) {
                $checkoutDAO->update_qty_by_order_id($orderId);
                $checkoutDAO->delete_order_detail_by_order_id($orderId);
            }
        } else {
            $orderId = $checkoutDAO->saveOrder($order);
        }
        if (empty($orderId)) {
            throw new Exception("Insert order is failure", 1);
        }
        $order->setId($orderId);
        $details = $data->products;
        for ($i = 0; $i < count($details); $i++) {
            $price = 0;
            $qty = 0;
            $reduce_type = 0;
            if (!empty($details[$i]->price)) {
                $price = $details[$i]->price;
            }
            if (!empty($details[$i]->quantity)) {
                $qty = $details[$i]->quantity;
            }
            if (!empty($details[$i]->reduce_type)) {
                $reduce_type = $details[$i]->reduce_type;
            }
            $detail = new OrderDetail();
            $detail->setOrder_id($orderId);
            $detail->setProduct_id($details[$i]->product_id ?? null);
            $detail->setVariant_id($details[$i]->variant_id ?? null);
            $detail->setSku($details[$i]->sku ?? null);
            $detail->setPrice($details[$i]->price ?? null);
            $detail->setQuantity($details[$i]->quantity ?? null);
            $detail->setReduce($details[$i]->reduce ?? null);
            $detail->setReduce_percent($details[$i]->reduce_percent ?? null);
            $detail->setReduceType($reduce_type ?? null);
            $detail->setProfit($details[$i]->profit ?? null);
            $lastId = $checkoutDAO->saveOrderDetail($detail);
            if (empty($lastId)) {
                throw new Exception("Insert order detail is failure", 1);
            }
            if (!empty($details[$i]->sku)) {
                $productDAO->update_qty_variation_by_sku((int)$details[$i]->sku, (int)$qty);
            } else {
                throw new Exception("SKU is empty");
            }
        }
        //update Order Logs
        $orderLogs = new OrderLogs();
        $orderLogs->setOrderId($orderId);
        $orderLogs->setAction($message_log);
        try {
          $checkoutDAO->saveOrderLogs($orderLogs);
        } catch (Exception $e) {
          echo $e->getMessage();
        }

        // all Ok
        $db->commit();

        $response["order_id"] = $orderId;
        echo json_encode($response);
        
    } catch (Exception $e) {
        $db->rollback();
        echo $e->getMessage();
    }
    
}

if (isset($_POST["method"]) && $_POST["method"] == "loadDataCity") {
    try {
        echo $zone->get_list_city();
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "loadDataDistrict") {
    try {
        if (isset($_POST["data"])) {
            $cityId = $_POST["data"];
            echo $zone->get_list_district($cityId);
        } else {
            die();
        }
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}
if (isset($_POST["method"]) && $_POST["method"] == "loadDataVillage") {
    try {
        if (isset($_POST["data"])) {
            $districtId = $_POST["data"];
            echo $zone->get_list_village($districtId);
        } else {
            die();
        }
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}
