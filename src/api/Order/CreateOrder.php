<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../common/Constant.php';
// get database connection
include_once '../../common/DBConnection.php';
// instantiate product object
include_once '../../model/Order/Order.php';
include_once '../../model/Order/OrderDetail.php';
include_once '../../model/Customer/Customer.php';
include_once '../../dao/ProductDAO.php';
include_once '../../dao/CheckDAO.php';
include_once '../../dao/CustomerDAO.php';
include_once '../../common/cities/Zone.php';

$db = new DBConnect();
$productDAO = new ProductDAO();
$productDAO->setConn($db->getConn());

$checkoutDAO = new CheckoutDAO();
$checkoutDAO->setConn($db->getConn());

$customerDAO = new CustomerDAO();
$customerDAO->setConn($db->getConn());

$zone = new Zone();

// get posted data
$data = json_decode(file_get_contents("php://input"));

    if(!empty($data->customer_name) &&
    !empty($data->phone_number) &&
    !empty($data->email) &&
    !empty($data->address) &&
    !empty($data->cityId) &&
    !empty($data->districtId) &&
    !empty($data->villageId) &&
    !empty($data->shipping) &&
    !empty($data->total_amount) &&
    !empty($data->total_checkout)) {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create order. Data is incomplete. Data: $data"));
        return;
    }
    try {
        // create user
        $customer = new Customer();
        $customer->setName($data->customer_name);
        $customer->setPhone($data->phone_number);
        $customer->setEmail($data->email);
        $customer->setAddress($data->address);
        $customer->setCity_id($data->cityId);
        $customer->setDistrict_id($data->districtId);
        $customer->setVillage_id($data->villageId);
        $cusId = $customerDAO->save_customer($customer);

        // create order
        $order = new Order();
        $order->setTotal_amount($data->total_amount);
        $order->setTotal_checkout($data->total_checkout);
        $order->setType(Constant::WEBSITE);
        $order->setStatus(Constant::PROCESSING);
        $order->setShipping($data->shipping);
        $orderId = $checkoutDAO->saveOrder($order);
        if (empty($orderId)) {
          throw new Exception("Insert order is failure", 1);
        }

        // create order detail
        $details = $data->detail;
        for ($i = 0; $i < count($details); $i++) {
            $detail = new OrderDetail();
            $detail->setOrder_id($orderId);
            $detail->setProduct_id($details[$i]->product_id);
            $detail->setVariant_id($details[$i]->variant_id);
            $detail->setSku($details[$i]->sku);
            $detail->setPrice($details[$i]->price);
            $detail->setQuantity($details[$i]->quantity);
            $lastId = $checkoutDAO->saveOrderDetail($detail);
            if (empty($lastId)) {
                throw new Exception("Insert order detail is failure", 1);
            }
        }

        // all Ok
        $db->commit();
        http_response_code(201);
        echo json_encode(array("message" => "Order was created."));

    } catch (Exception $e) {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create order. $e"));
        $db->rollback();
    }

