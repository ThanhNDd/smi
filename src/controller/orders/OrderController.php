<?php
// require '../../common/WooAPI.php';
require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../dao/ProductDAO.php");
include("../../dao/CheckoutDAO.php");
include("../../dao/CustomerDAO.php");
include("../../common/cities/Zone.php");
include("../../model/Order/Order.php");
include("../../model/Order/OrderDetail.php");
include("../../model/Customer/Customer.php");
include("PrintReceiptOnline.php");
include("../sales/PrinterReceipt.php");
include("../exchange/PrinterReceiptExchange.php");

$db = new DBConnect();
$productDAO = new ProductDAO();
$productDAO->setConn($db->getConn());

$checkoutDAO = new CheckoutDAO();
$checkoutDAO->setConn($db->getConn());

$customerDAO = new CustomerDAO();
$customerDAO->setConn($db->getConn());

$zone = new Zone();

if (isset($_POST["method"]) && $_POST["method"] == "print_receipt") {
  try {
    Common::authen_get_data();
    $order_id = $_POST["order_id"];
    $type = $_POST["type"];
    if ($type == 1) {
      // print receipt online
      $print_receipt = new PrintReceiptOnline();
      $receipt = $checkoutDAO->get_data_print_receipt($order_id);
      $filename = $print_receipt->print($receipt);
    } else if ($type == 0) {
      // on shop
      $order = $checkoutDAO->find_order_by_order_id($order_id);
      $details = $checkoutDAO->find_order_detail_by_order_id($order_id);
      $printer = new PrinterReceipt();
      $filename = $printer->print($order, $details);
      $response_array['fileName'] = $filename;
    } else if ($type == 2) {
      // exchange
      $order = $checkoutDAO->find_order_by_order_id($order_id);
      $details = $checkoutDAO->find_order_detail_by_order_id($order_id);
      $curr_products = [];
      $exchange_products = [];
      $add_new_products = [];
      for ($i = 0; $i < count($details); $i++) {
        $type = $details[$i]->getType();
        if ($type == 0) {
          // add new product
          array_push($add_new_products, $details[$i]);
        } else if ($type == 1) {
          // exchange product
          array_push($curr_products, $details[$i]);
        } else if ($type == 2) {
          // add new of exchange product
          array_push($exchange_products, $details[$i]);
        }
      }
      print_r($curr_products);
      $curr_arr = get_details($curr_products, $order_id, 1); // product exchange
      if (count($curr_arr) <= 0) {
        throw new Exception("Have no product!!");
      }
      $exchange_arr = get_details($exchange_products, $order_id, 2);// new product of exchange
      if (count($exchange_arr) <= 0) {
        throw new Exception("Have no product exchange!!");
      }
      $add_new_arr = get_details($add_new_products, $order_id, 0); // add new product
      $printer = new PrinterReceiptExchange();
      $filename = $printer->print($order, $exchange_arr, $curr_arr, $add_new_arr);
      $response_array['fileName'] = $filename;
    }
    $response_array['fileName'] = $filename;
    echo json_encode($response_array);
  } catch (Exception $ex) {
    throw new Exception($ex);
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "edit_order") {
  try {
    Common::authen_get_data();
    $order_id = $_POST["order_id"];
    $order_type = $_POST["order_type"];
    $order = $checkoutDAO->find_by_id($order_id, $order_type);
    echo json_encode($order);
  } catch (Exception $ex) {
    throw new Exception($ex);
  }
}


if (isset($_POST["method"]) && $_POST["method"] == "get_info_total_checkout") {
  try {
    Common::authen_get_data();
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $info_total = $checkoutDAO->get_info_total_checkout($start_date, $end_date);
    echo json_encode($info_total);
  } catch (Exception $ex) {
    throw new Exception($ex);
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "delete_order") {

  try {
    Common::authen_get_data();
    $order_id = $_POST["order_id"];
    // update quantity of product will be deleted
    $rowUpdated = $checkoutDAO->update_qty_by_order_id($order_id);
    // detele status order. Status Deleted = 1
    $checkoutDAO->delete_order($order_id);
    $repsonse = "success";
    echo json_encode($repsonse);
  } catch (Exception $ex) {
    $db->rollback();
    throw new Exception($ex);
  }
  $db->commit();
}

/**
 *    get data to generate select2 combobox
 */
if (isset($_GET["orders"]) && $_GET["orders"] == "loadDataCity") {
  try {
    Common::authen_get_data();
    echo $zone->get_list_city();
  } catch (Exception $ex) {
    throw new Exception($ex);
  }
}

if (isset($_GET["orders"]) && $_GET["orders"] == "loadDataDistrict") {
  try {
    Common::authen_get_data();
    if (isset($_GET["cityId"])) {
      $cityId = $_GET["cityId"];
      echo $zone->get_list_district($cityId);
    } else {
      die();
    }
  } catch (Exception $ex) {
    throw new Exception($ex);
  }
}
if (isset($_GET["orders"]) && $_GET["orders"] == "loadDataVillage") {
  try {
    Common::authen_get_data();
    if (isset($_GET["districtId"])) {
      $districtId = $_GET["districtId"];
      echo $zone->get_list_village($districtId);
    } else {
      die();
    }
  } catch (Exception $ex) {
    throw new Exception($ex);
  }
}
if (isset($_GET["method"]) && $_GET["method"] == "find_all") {
  try {
    Common::authen_get_data();
    $start_date = $_GET["start_date"];
    $end_date = $_GET["end_date"];
    $orders = $checkoutDAO->find_all($start_date, $end_date);
    echo json_encode($orders);
  } catch (Exception $e) {
    throw new Exception($e);
  }
}
if (isset($_POST["method"]) && $_POST["method"] == "find_detail") {
  try {
    Common::authen_get_data();
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $order_id = $_POST["order_id"];
    $orders = $checkoutDAO->find_detail($start_date, $end_date, $order_id);
    echo json_encode($orders);
  } catch (Exception $e) {
    throw new Exception($e);
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "find_product_by_sku") {
  try {
    Common::authen_get_data();
    $sku = $_POST["sku"];
    $products = $productDAO->find_by_sku($sku);
    echo json_encode($products);
  } catch (Exception $e) {
    throw new Exception($e);
  }
}
if (isset($_POST["method"]) && $_POST["method"] == "find_products") {
  try {
    Common::authen_get_data();
    $products = $productDAO->find_all_for_select2();
    echo json_encode($products);
  } catch (Exception $e) {
    throw new Exception($e);
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "add_new") {
  try {
    Common::authen_get_data();
    $data = $_POST["data"];
    $data = json_decode($data);

    $order = new Order();

    $order_type = $data->order_type;
    $cusId = 0;
    if ($order_type == 1) {
      //online
      $customer = new Customer();
      $customer->setName($data->customer_name);
      $customer->setPhone($data->phone_number);
      $customer->setEmail($data->email);
      $customer->setAddress($data->address);
      $customer->setCity_id($data->cityId);
      $customer->setDistrict_id($data->districtId);
      $customer->setVillage_id($data->villageId);
      if ($data->customer_id > 0) {
        $customer->setId($data->customer_id);
        $cusId = $customerDAO->update_customer($customer);
        if (empty($cusId)) {
          throw new Exception("update customer is failure", 1);
        }
      } else {
        $cusId = $customerDAO->save_customer($customer);
        if (empty($cusId)) {
          throw new Exception("Insert customer is failure", 1);
        }
      }
      $order->setBill_of_lading_no($data->bill_of_lading_no);
      $order->setShipping_fee($data->shipping_fee);
      $order->setShipping($data->shipping);
      $order->setShipping_unit($data->shipping_unit);
    }
    $order->setTotal_reduce(null);
    $order->setTotal_reduce_percent(null);
    $order->setDiscount($data->discount);
    $order->setTotal_amount($data->total_amount);
    $order->setTotal_checkout($data->total_checkout);
    $order->setCustomer_payment($data->customer_payment);
    $order->setRepay(null);
    $order->setCustomer_id($cusId);
    $order->setType($order_type);
    $order->setStatus($data->order_status);
    $order->setPayment_type($data->payment_type);
    $order->setOrder_date($data->order_date);
    $order->setVoucherValue(0);
    $order->setOrder_date($data->order_date);
    if (isset($data->order_id) && $data->order_id > 0) {
      $order->setId($data->order_id);
      $orderId = $checkoutDAO->updateOrder($order);
      if (!empty($orderId)) {
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
      if (!empty($details[$i]->price)) {
        $price = $details[$i]->price;
      }
      if (!empty($details[$i]->quantity)) {
        $qty = $details[$i]->quantity;
      }
      $detail = new OrderDetail();
      $detail->setOrder_id($orderId);
      $detail->setProduct_id(empty($details[$i]->product_id) ? 0 : $details[$i]->product_id);
      $detail->setVariant_id(empty($details[$i]->variant_id) ? 0 : $details[$i]->variant_id);
      $detail->setSku(empty($details[$i]->sku) ? 0 : $details[$i]->sku);
      $detail->setPrice(empty($details[$i]->price) ? 0 : $details[$i]->price);
      $detail->setQuantity(empty($details[$i]->quantity) ? 0 : $details[$i]->quantity);
      $detail->setReduce(empty($details[$i]->reduce) ? 0 : $details[$i]->reduce);
      $detail->setReduce_percent(empty($details[$i]->reduce_percent) ? 0 : $details[$i]->reduce_percent);
      $lastId = $checkoutDAO->saveOrderDetail($detail);
      if (empty($lastId)) {
        throw new Exception("Insert order detail is failure", 1);
      }
    }
    $response["order_id"] = $orderId;
    echo json_encode($response);
  } catch (Exception $e) {
    $db->rollback();
    throw new Exception($e);
  }
  // all Ok
  $db->commit();
}

function get_details($details, $orderId, $productType)
{
  $detailsObj = array();
  for ($i = 0; $i < count($details); $i++) {
    $price = 0;
    $qty = 0;
    $reduce = 0;
    $reduce_percent = 0;

    if (!empty($details[$i]->getProduct_id())) {
      $product_id = $details[$i]->getProduct_id();
    } else {
      throw new Exception("Product_Id is null");
    }
    if (!empty($details[$i]->getVariant_id())) {
      $variant_id = $details[$i]->getVariant_id();
    } else {
      throw new Exception("Variant_id is null");
    }
    if (!empty($details[$i]->getSku())) {
      $sku = $details[$i]->getSku();
    } else {
      throw new Exception("SKU is null");
    }
    if (!empty($details[$i]->getPrice())) {
      $price = $details[$i]->getPrice();
    }
    if (!empty($details[$i]->getQuantity())) {
      $qty = $details[$i]->getQuantity();
    }
    if (!empty($details[$i]->getReduce())) {
      $reduce = $details[$i]->getReduce();
    }
    if (!empty($details[$i]->getReduce_percent())) {
      $reduce_percent = $details[$i]->getReduce_percent();
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
    $detail->setProductName($details[$i]->getProductName());
    array_push($detailsObj, $detail);
  }
  return $detailsObj;
}
