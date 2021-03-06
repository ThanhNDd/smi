<?php
// require '../../common/WooAPI.php';
require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../dao/CommonDAO.php");
include("../../dao/ProductDAO.php");
include("../../dao/CheckoutDAO.php");
include("../../dao/CustomerDAO.php");
include("../../dao/WalletDAO.php");
include("../../common/cities/Zone.php");
include("../../model/Order/Order.php");
include("../../model/Order/OrderDetail.php");
include("../../model/Order/OrderLogs.php");
include("../../model/Customer/Customer.php");
include("../../model/Wallet/Wallet.php");
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

$walletDAO = new WalletDAO();
$walletDAO->setConn($db->getConn());

$zone = new Zone();

if (isset($_POST["method"]) && $_POST["method"] == "update_print") {
  try {
    Common::authen_get_data();
    $orderId = $_POST["order_id"];
    if(!empty($orderId)) {
      $checkoutDAO->update_print($orderId);
    }
    echo json_encode("success");
  } catch (Exception $ex) {
    $db->rollback();
    echo $ex->getMessage();
  }
  $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "update_status_by_bills") {
  try {
    Common::authen_get_data();
    $bills = $_POST["bills"];
    if(!empty($bills)) {
      $bills = substr($bills,1, -1);
      $checkoutDAO->update_success_by_bills($bills);
    }
    echo json_encode("success");
  } catch (Exception $ex) {
    $db->rollback();
    echo $ex->getMessage();
  }
  $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "count_all_status") {
  try {
    Common::authen_get_data();
    $count_all_status = $checkoutDAO->count_status('','');
    echo json_encode($count_all_status);
  } catch (Exception $ex) {
    echo $ex;
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "count_status") {
  try {
    Common::authen_get_data();
    $start_date = '';
    $end_date = '';
    if(isset($_POST["start_date"]) && isset($_POST["end_date"])) {
      $start_date = $_POST["start_date"];
      $end_date = $_POST["end_date"];
    }
    $count_status = $checkoutDAO->count_status($start_date, $end_date);
    echo json_encode($count_status);
  } catch (Exception $ex) {
    echo $ex;
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "update_description") {
  try {
    Common::authen_get_data();
    $order_id = $_POST["order_id"];
    $content_description= $_POST["content_description"];
    $checkoutDAO->update_description($order_id, $content_description);

    echo json_encode("success");
  } catch (Exception $ex) {
    $db->rollback();
    echo $ex->getMessage();
  }
  $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "update_delivery_date") {
  try {
    Common::authen_get_data();
    $order_id = $_POST["order_id"];
    $delivery_date = $_POST["delivery_date"];
    $checkoutDAO->update_delivery_date($order_id, $delivery_date);

    //update Order Logs
    $orderLogs = new OrderLogs();
    $orderLogs->setOrderId($order_id);
    if(empty($delivery_date)) {
      $orderLogs->setAction("Xoá ngày hẹn giao hàng");
    } else {
      $orderLogs->setAction("Cập nhật ngày hẹn giao hàng");
    }

    try {
      $checkoutDAO->saveOrderLogs($orderLogs);
    } catch (Exception $e) {
      echo $e->getMessage();
    }

    echo json_encode("success");
  } catch (Exception $ex) {
    $db->rollback();
    echo $ex->getMessage();
  }
  $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "update_bill") {
  try {
    Common::authen_get_data();
    $order_id = $_POST["order_id"];
    $status = $_POST["status"];
    $bill_no = $_POST["bill_no"];
    $shipping_fee = $_POST["shipping_fee"];
    $checkoutDAO->update_bill($order_id, $status, $bill_no, $shipping_fee);

    //update Order Logs
    $orderLogs = new OrderLogs();
    $orderLogs->setOrderId($order_id);
    $orderLogs->setAction("Cập nhật mã vận đơn");
    try {
      $checkoutDAO->saveOrderLogs($orderLogs);
    } catch (Exception $e) {
      echo $e->getMessage();
    }

    echo json_encode("success");
  } catch (Exception $ex) {
    $db->rollback();
    echo $ex->getMessage();
  }
  $db->commit();
}


if (isset($_POST["method"]) && $_POST["method"] == "update_status") {
    try {
        Common::authen_get_data();
        $order_id = $_POST["order_id"];
        $status = $_POST["status"];
        $delivery_date = isset($_POST["delivery_date"]) ? $_POST["delivery_date"] : null;
        $checkoutDAO->update_status($order_id, $status, $delivery_date);

        // update Order Logs
        switch ($status) {
          case 0:
            $text_status = 'CHƯA XỬ LÝ';
            break;
          case 1:
            $text_status = 'ĐÃ GÓI HÀNG';
            break;
          case 2:
            $text_status = 'ĐÃ GIAO';
            break;
          case 3:
            $text_status = 'HOÀN THÀNH';
            break;
          case 4:
            $text_status = 'ĐỔI SIZE';
            break;
          case 5:
            $text_status = 'CHUYỂN HOÀN';
            break;
          case 6:
            $text_status = 'HUỶ';
            break;
          case 7:
            $text_status = 'GIAO HÀNG SAU';
            break;
          case 8:
            $text_status = 'ĐỢI HÀNG VỀ';
            break;
          case 9:
            $text_status = 'CHỜ DUYỆT HOÀN';
            break;
          case 10:
            $text_status = 'ĐÃ DUYỆT HOÀN';
            break;
          case 11:
            $text_status = 'CHỜ ĐỔI SIZE';
            break;
          case 12:
            $text_status = 'ĐÃ ĐỔI SIZE';
            break;
          default:
            $text_status = '';
        }
      if(!strrpos($order_id, ',', 0)) {
        $orderLogs = new OrderLogs();
        $orderLogs->setOrderId($order_id);
        $orderLogs->setAction("Cập nhật trạng thái thành ".$text_status);
        try {
          $checkoutDAO->saveOrderLogs($orderLogs);
        } catch (Exception $e) {
          echo $e->getMessage();
        }
      } else {
        $orderIds = explode(",", $order_id);
        for($i=0; $i<count($orderIds); $i++) {
          $orderLogs = new OrderLogs();
          $orderLogs->setOrderId($orderIds[$i]);
          $orderLogs->setAction("Cập nhật trạng thái thành " . $text_status);
          try {
            $checkoutDAO->saveOrderLogs($orderLogs);
          } catch (Exception $e) {
            echo $e->getMessage();
          }
        }
      }
        echo json_encode("success");
    } catch (Exception $ex) {
        $db->rollback();
        echo $ex->getMessage();
    }
    $db->commit();
}


if (isset($_POST["method"]) && $_POST["method"] == "print_receipt") {
    try {
        Common::authen_get_data();
        $order_id = $_POST["order_id"];
        $type = $_POST["type"];
        $order = new Order();
        if ($type == 1) {
            // print receipt online
            $print_receipt = new PrintReceiptOnline();
            $receipt = $checkoutDAO->get_data_print_receipt($order_id);
            $filename = $print_receipt->print($receipt);
        } else if ($type == 0) {
            // on shop
            $order = $checkoutDAO->find_order_by_order_id($order_id);
            $details = $checkoutDAO->find_order_detail_by_order_id($order_id);
            $customer_id = $order->getCustomer_id();
            $customer_name = '';
            if(!empty($customer_id)) {
                $customer = $customerDAO->find_by_id($customer_id);
                if(!empty($customer)) {
                    $customer_name = $customer[0]["name"];
                }
            }
            $wallet_saved = 0;
            $wallet = $walletDAO->findWalletByOrderId($order_id);
            if(!empty($wallet)) {
                $wallet_saved = $wallet->getSaved();
            }
            $order->setCustomerName($customer_name);
            $order->setPointSave($wallet_saved);
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
            $return_products = [];
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
                } else if ($type == 3) {
                    // return product
                    array_push($return_products, $details[$i]);
                }
            }
//            print_r($curr_products);
            $curr_arr = get_details($curr_products, $order_id, 1); // product exchange
//            if (count($curr_arr) <= 0) {
//                throw new Exception("Have no product!!");
//            }
            $exchange_arr = get_details($exchange_products, $order_id, 2);// new product of exchange
//            if (count($exchange_arr) <= 0) {
//                throw new Exception("Have no product exchange!!");
//            }
            $return_arr = get_details($return_products, $order_id, 3);// product return
            $add_new_arr = get_details($add_new_products, $order_id, 0); // add new product
            $customer_id = $order->getCustomer_id();
            $customer_name = '';
            if(!empty($customer_id)) {
                $customer = $customerDAO->find_by_id($customer_id);
                if(!empty($customer)) {
                    $customer_name = $customer[0]["name"];
                }
            }
            $wallet_saved = 0;
            $wallet = $walletDAO->findWalletByOrderId($order_id);
            if(!empty($wallet)) {
                $wallet_saved = $wallet->getSaved();
            }
            $order->setCustomerName($customer_name);
            $order->setPointSave($wallet_saved);
            $printer = new PrinterReceiptExchange();
            $filename = $printer->print($order, $exchange_arr, $curr_arr, $add_new_arr, $return_arr);
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
//        $order_type = $_POST["order_type"];
        $order = $checkoutDAO->find_by_id($order_id);
        echo json_encode($order);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}


if (isset($_POST["method"]) && $_POST["method"] == "delete_order") {

    try {
        Common::authen_get_data();
        $order_id = $_POST["order_id"];
        // update quantity of product will be deleted
        $checkoutDAO->update_qty_by_order_id($order_id);
        // detele status order. Status Deleted = 1
        $checkoutDAO->delete_order($order_id);
        $walletDAO->delete_wallet_by_order($order_id);

        //update Order Logs
        $orderLogs = new OrderLogs();
        $orderLogs->setOrderId($order_id);
        $orderLogs->setAction("Xoá đơn hàng");
        try {
          $checkoutDAO->saveOrderLogs($orderLogs);
        } catch (Exception $e) {
          echo $e->getMessage();
        }

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
//    Common::authen_get_data();
        echo $zone->get_list_city();
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}

if (isset($_GET["orders"]) && $_GET["orders"] == "loadDataDistrict") {
    try {
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

if (isset($_GET["method"]) && $_GET["method"] == "get_info_total_checkout") {
    try {
        Common::authen_get_data();
        $start_date = '';
        $end_date = '';
        if(isset($_GET["start_date"]) && isset($_GET["end_date"])) {
            $start_date = $_GET["start_date"];
            $end_date = $_GET["end_date"];
        }
        $order_id = '';
        if(isset($_GET["order_id"])) {
            $order_id = $_GET["order_id"];
        }
        $customer_id = '';
        if(isset($_GET["phone"])) {
            $phone = $_GET["phone"];
            $customer = $customerDAO->find_by_phone($phone);
            if(!empty($customer)) {
                $customer_id = $customer[0]["id"];
            } else {
                echo json_encode(array());
                return;
            }
        }
        if(isset($_GET["customer_id"])) {
            $customer_id = $_GET["customer_id"];
        }
        $sku = '';
        if(isset($_GET["sku"])) {
            $sku = $_GET["sku"];
        }
        $type = '';
        if(isset($_GET["type"])) {
          $type = $_GET["type"];
        }
        $status = '';
        if(isset($_GET["status"])) {
          $status = $_GET['status'];
        }
        $bill = '';
        if(isset($_GET["bill"])) {
          $bill = $_GET['bill'];
        }
        $info_total = $checkoutDAO->get_info_total_checkout($start_date, $end_date, $order_id, $customer_id, $sku, $type, $status, $bill);
        echo json_encode($info_total);
    } catch (Exception $ex) {
       echo $ex;
    }
}

if (isset($_GET["method"]) && $_GET["method"] == "find_all") {
    try {
        Common::authen_get_data();
        $start_date = '';
        $end_date = '';
        if(isset($_GET["start_date"]) && isset($_GET["end_date"])) {
            $start_date = $_GET["start_date"];
            $end_date = $_GET["end_date"];
        }
        $order_id = '';
        if(isset($_GET["order_id"])) {
            $order_id = $_GET["order_id"];
        }
        $customer_id = '';
        if(isset($_GET["phone"])) {
            $phone = $_GET["phone"];
            $customer = $customerDAO->find_by_phone($phone);
            if(!empty($customer)) {
                $customer_id = $customer[0]["id"];
            } else {
                $arr = array();
                $arr["data"] = [];
                echo json_encode($arr);
                return;
            }
        }
        $sku = '';
        if(isset($_GET["sku"])) {
            $sku = $_GET["sku"];
        }
//        $customer_id = '';
        if(isset($_GET["customer_id"])) {
            $customer_id = $_GET["customer_id"];
        }
        $type = '';
        if(isset($_GET["type"])) {
          $type = $_GET["type"];
        }
        $status = '';
        if(isset($_GET["status"])) {
          $status = $_GET['status'];
        }
        $bill = '';
        if(isset($_GET["bill"])) {
          $bill = $_GET['bill'];
        }
        $orders = $checkoutDAO->find_all($start_date, $end_date, $order_id, $customer_id, $sku, $type, $status, $bill);
        echo json_encode($orders);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
if (isset($_POST["method"]) && $_POST["method"] == "find_detail") {
    try {
        Common::authen_get_data();
        $order_id = $_POST["order_id"];
        $orders = $checkoutDAO->find_detail($order_id);
        $order_logs = $checkoutDAO->find_order_logs_by_id($order_id);
        $arr = array();
        $arr["orders"] = $orders;
        $arr["order_logs"] = $order_logs;
        echo json_encode($arr);
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

        $message_log = 'Tạo mới đơn hàng';

        $order = new Order();
        $order_type = $data->order_type;
        $cusId = $data->customer_id;
        $total_checkout = $data->total_checkout;
        $total_reduce = 0;
        $total_reduce_percent = 0;
        if (!empty($data->total_reduce)) {
            $total_reduce = $data->total_reduce;
            $total_reduce_percent = round($total_reduce * 100 / $total_checkout);
        }
//        if ($order_type == 1) {
            //online
        $bill_of_lading_no = $data->bill_of_lading_no;
            $order->setBill_of_lading_no($data->bill_of_lading_no);
            $order->setShipping_fee($data->shipping_fee);
            $order->setShipping($data->shipping);
            $order->setShipping_unit($data->shipping_unit);
//        }

        $order->setTotal_amount($data->total_amount);
        $order->setTotal_reduce($total_reduce);
        $order->setTotal_reduce_percent($total_reduce_percent);
        $order->setDiscount($data->discount);
        $order->setWallet($data->wallet);
        $order->setTotal_checkout($data->total_checkout);
        $order->setCustomer_payment($data->customer_payment);
        $order->setPayment_type($data->payment_type);
        $order->setRepay($data->repay);
        $order->setTransferToWallet($data->transfer_to_wallet);
        $order->setCustomer_id($cusId);
        $order->setType($order_type);
        $order->setStatus($data->order_status);
        $order->setPayment_type($data->payment_type);
        $order->setVoucherValue(0);
        $order->setOrder_date($data->order_date);
        $order->setDeliveryDate($data->delivery_date);
        $order->setSource($data->source);
        $order->setDescription($data->description);
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
            $detail->setProduct_id(empty($details[$i]->product_id) ? 0 : $details[$i]->product_id);
            $detail->setVariant_id(empty($details[$i]->variant_id) ? 0 : $details[$i]->variant_id);
            $detail->setSku(empty($details[$i]->sku) ? 0 : $details[$i]->sku);
            $detail->setPrice(empty($details[$i]->price) ? 0 : $details[$i]->price);
            $detail->setQuantity(empty($details[$i]->quantity) ? 0 : $details[$i]->quantity);
            $detail->setReduce(empty($details[$i]->reduce) ? 0 : $details[$i]->reduce);
            $detail->setReduce_percent(empty($details[$i]->reduce_percent) ? 0 : $details[$i]->reduce_percent);
            $detail->setReduceType($reduce_type);
            $detail->setProfit($details[$i]->profit);
            $lastId = $checkoutDAO->saveOrderDetail($detail);
            if (empty($lastId)) {
                throw new Exception("Insert order detail is failure", 1);
            }
            if (!empty($details[$i]->sku)) {
                $productDAO->update_qty_variation_by_sku((int)$details[$i]->sku, (int)$qty, 1);
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

        $response["order_id"] = $orderId;
        echo json_encode($response);
//        echo "===============\n";
    } catch (Exception $e) {
        $db->rollback();
        echo $e->getMessage();
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
