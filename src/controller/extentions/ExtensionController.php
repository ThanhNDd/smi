<?php
header('Access-Control-Allow-Origin: *');

require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../dao/CheckoutDAO.php");
include("../../dao/CustomerDAO.php");
include("../../dao/ProductDAO.php");
include("../../dao/UserDAO.php");
include("../../common/cities/Zone.php");
include("../../model/Order/Order.php");
include("../../model/Order/OrderDetail.php");
include("../../model/Order/OrderLogs.php");
include("../../model/Customer/Customer.php");

$db = new DBConnect();
// $customerDAO = new CustomerDAO($db);
$checkoutDAO = new CheckoutDAO($db);
$productDAO = new ProductDAO($db);
$userDAO = new UserDAO($db);
$userDAO->setConn($db->getConn());

$zone = new Zone();

if (isset($_POST["method"]) && $_POST["method"] == "searchOrder") {
    try {
        $data = $_POST["data"];
        $data = json_decode($data);
        $start_date = isset($data->startDate) ? $data->startDate : "";
        $end_date = isset($data->endDate) ? $data->endDate : "";
        $phone = isset($data->phone) ? $data->phone : "";
        $customer_id = null;
        
        if(!empty($phone)) {
            $customer = $customerDAO->find_by_phone($phone);
            if(!empty($customer)) {
                $customer_id = $customer[0]["id"];
            } else {
                $arr = array();
                echo json_encode($arr);
                return;
            }
        }
        
        $data_response = [];
        $orders = $checkoutDAO->find_all($start_date, $end_date, null, $customer_id, null, 1,null, null);
        $orders = $orders["data"];
        if(count($orders) > 0) {
            foreach ($orders as $key => $value) {
                $response = $checkoutDAO->find_detail($value["order_id"]);
                $ord = $response[0];
                $order = [];
                $details = [];
                    $order["order_id"] = $ord["order_id"];
                    $order["product_name"] = $ord["product_name"];
                    // $order["customer_id"] = $ord["customer_id"];
                    // $order["customer_name"] = $ord["customer_name"];
                    // $order["customer_phone"] = $ord["phone"];
                    // $order["full_address"] = $ord["address"];
                    // $order["facebook"] = $ord["facebook"];
                    // $order["link_fb"] = $ord["link_fb"];
                    $order["total_checkout"] = $ord["total_checkout"];
                    $order["order_date"] = $ord["order_date"];
                    $order["bill_of_lading_no"] = $ord["bill_of_lading_no"];
                    $order["shopee_order_id"] = $ord["shopee_order_id"];
                    
                    $orderDetails = $ord["details"];
                    foreach ($orderDetails as $key1 => $order_detail) {
                        $d = [];
                        $d["sku"] = $order_detail["sku"];
                        $d["quantity"] = $order_detail["quantity"];
                        $d["price"] = $order_detail["price"];
                        $d["reduce"] = $order_detail["reduce"];
                        $d["image"] = $order_detail["image"];
                        $d["size"] = $order_detail["size"];
                        $d["color"] = $order_detail["color"];
                        array_push($details, $d);
                    }
                $order["details"] = $details;
                array_push($data_response, $order);
            }
        }
        echo json_encode($data_response);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

// if (isset($_POST["method"]) && $_POST["method"] == "checkPhone") {
//     try {
//         $phone = $_POST["data"];
//         $customer = $customerDAO->findCustomerByPhone($phone);
//         echo json_encode($customer);
//     } catch (Exception $e) {
//         throw new Exception($e);
//     }
// }

if (isset($_POST["method"]) && $_POST["method"] == "getAllStaff") {
    try {
        $users = $userDAO->getAllStaff();
        echo json_encode($users);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "loadVariations") {
    try {
        $productId = $_POST["data"];
        $products = $productDAO->loadVariations($productId);
        echo json_encode($products);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}
if (isset($_POST["method"]) && $_POST["method"] == "loadProducts") {
    try {
        $products = $productDAO->loadAllProducts();
        echo json_encode($products);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}

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
    } else if(substr($billCode,0, 1) == "8") {
        $shippingUnit = "J&T";
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
        if(!empty($data->source) && $data->source == 2) {
            $customer = new Customer();
            $customer->setName($data->customerName);
            $customer->setPhone($data->customerPhone);
            $customer->setFullAddress($data->fullAddress);
            $customer->setAddress($data->address);
            $customer->setCityId($data->cityId);
            $customer->setDistrictId($data->districtId);
            $customer->setVillageId($data->villageId);
            $customer->setLinkFb($data->linkFb ?? null);
            $customer->setFacebook($data->facebook ?? null);
            if(empty($cusId)) {
                $cusId = $customerDAO->save_customer($customer);
            } else {
                $customer->setId($cusId);
                $customerDAO->update_customer($customer);
            }
        }

        $total_checkout = $data->total_checkout;
        $total_reduce = 0;
        $total_reduce_percent = 0;
        if (!empty($data->total_reduce)) {
            $total_reduce = $data->total_reduce;
            $total_reduce_percent = round($total_reduce * 100 / $total_checkout);
        }
        // $bill_of_lading_no = $data->bill_of_lading_no;
        $order->setShopee_order_id($data->shopee_order_id ?? 0);
        $order->setBill_of_lading_no($data->bill_of_lading_no ?? null);
        $order->setShipping_fee($data->shipping_fee ?? 0);
        $order->setShipping($data->shipping ?? 0);
        $order->setShipping_unit($data->shipping_unit ?? "J&T");
        $order->setTotal_amount($data->total_amount);
        $order->setTotal_reduce($total_reduce ?? 0);
        $order->setTotal_reduce_percent($total_reduce_percent ?? 0);
        $order->setDiscount($data->discount ?? 0);
        $order->setWallet($data->wallet ?? 0);
        $order->setTotal_checkout($data->total_checkout);
        $order->setCod($data->cod ?? 0);
        $order->setCustomer_payment($data->customer_payment ?? 0);
        $order->setPayment_type($data->payment_type ?? 1);
        $order->setRepay($data->repay ?? 0);
        $order->setTransferToWallet($data->transfer_to_wallet ?? 0);
        $order->setCustomer_id($cusId ?? null);
        $order->setType($order_type ?? 0);
        $order->setStatus($data->order_status ?? 0);
        $order->setVoucherValue(0);
        $order->setOrder_date($data->order_date ?? date('Y-m-d H:i:s'));
        $order->setAppointmentDeliveryDate($data->appointment_delivery_date ?? null);
        $order->setSource($data->source ?? 2);
        $order->setDescription($data->description ?? null);
        $order->setCreatedBy($data->createdBy ?? "unknown");
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
            $detail->setProduct_id($details[$i]->product_id);
            $detail->setVariant_id($details[$i]->variant_id);
            $detail->setSku($details[$i]->sku);
            $detail->setPrice($details[$i]->price);
            $detail->setQuantity($details[$i]->quantity);
            $detail->setReduce($details[$i]->reduce ?? 0);
            $detail->setReduce_percent($details[$i]->reduce_percent ?? 0);
            $detail->setReduceType($reduce_type ?? 0);
            $detail->setProfit($details[$i]->profit);
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
        $orderLogs->setCreatedBy($data->createdBy);
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
