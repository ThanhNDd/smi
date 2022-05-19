<?php
require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../model/Check/Check.php");
include("../../model/Check/CheckDetail.php");
include("../../model/Check/ResultCheck.php");
include("../../model/Fee/Fee.php");
include("../../dao/CheckDAO.php");
include("../../dao/ProductDAO.php");

$db = new DBConnect();

$dao = new CheckDAO($db);
// $dao->setConn($db->getConn());

$product_dao = new ProductDAO($db);
// $product_dao->setConn($db->getConn());

if (isset($_POST["method"]) && $_POST["method"] == "reviews_check") {
  try {
    Common::authen_get_data();
    $result = $dao->reviews_check();
    echo json_encode($result);
  } catch (Exception $ex) {
    echo $ex->getMessage();
  }
}

/**
 * Count all product of instock
 */
if (isset($_POST["method"]) && $_POST["method"] == "count_all_products") {
  try {
    Common::authen_get_data();
    $result = $product_dao->count_all_product(0);
    $response_array['total'] = $result;
    echo json_encode($response_array);
  } catch (Exception $ex) {
    echo $ex->getMessage();
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "cancel_checking") {
  try {
    Common::authen_get_data();
    $id = $_POST["data"];
    $dao->update_status($id, 2);// cancel status
    echo json_encode('success');
  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }
  $db->commit();

}

if (isset($_GET["method"]) && $_GET["method"] == "findall") {
  try {
    Common::authen_get_data();
    $result = $dao->find_all();
    echo json_encode($result);
  } catch (Exception $ex) {
    throw new Exception($ex);
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "find_detail") {
  try {
    Common::authen_get_data();
    $seq = $_POST["seq"];
    $result = $dao->find_detail();
    echo json_encode($result);
  } catch (Exception $ex) {
    throw new Exception($ex);
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "delete_product") {
  try {
    Common::authen_get_data();
    $seq = $_POST["seq"];
    $sku = $_POST["sku"];
    $result = $dao->delete_product((int)$seq, $sku);
    $response_array['success'] = "successfully";
    echo json_encode($response_array);
  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }
  $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "onchange_qty") {
  try {
    Common::authen_get_data();
    $sku = $_POST["sku"];
    $qty = $_POST["qty"];
    $seq = $_POST["seq"];
    $result = $dao->onchange_qty($sku, (int)$qty, (int)$seq);
    $response_array['success'] = "successfully";
    echo json_encode($response_array);
  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }
  $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "get_status") {
  try {
    Common::authen_get_data();
    $seq = $_POST["seq"];
    $status = $dao->get_status($seq);
    echo json_encode($status);
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "check_exists_checking") {
  try {
    Common::authen_get_data();
    $result = $dao->check_exists_checking();
    echo json_encode($result);
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "checking_finish") {
  try {
    Common::authen_get_data();
    $seq = $_POST['seq'];
    $data = $_POST['data'];
    $dao->checking_finish($seq, $data);
    $response_array['success'] = "successfully";
    echo json_encode($response_array);
  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }
  $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "create_new_check") {
  try {
    Common::authen_get_data();
    $total_products = $_POST["total_products"];
    $total_money = $_POST["total_money"];
    $check = new Check();
    $check->setStatus(0);// checking
    $check->setTotalProducts($total_products);
    $check->setProductsChecked(0);
    $check->setTotalMoney($total_money);
    $check->setMoneyChecked(0);
    $result = $dao->save_check($check);
    $response_array['checkId'] = $result["checkId"];
    $response_array['seq'] = $result["seq"];

    echo json_encode($response_array);
  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }
  $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "save_check_detail") {
  try {
    Common::authen_get_data();
    $data = $_POST["data"];
    $data = json_decode($data);
    $sku = $data->sku;
    $is_exist_sku = $dao->is_exist_sku($sku);
    if (empty($is_exist_sku)) {
      $check_id = $data->check_id;
      $seq = $data->seq;
      $product_id = $data->product_id;
      $variation_id = $data->variation_id;
      $sku = $data->sku;
      $color = $data->color;
      $size = $data->size;
      $qty = $data->quantity;
      $name = $data->name;
      $price = $data->price;

      $checkDetail = new CheckDetail();
      $checkDetail->setCheckId($check_id);
      $checkDetail->setSeq($seq);
      $checkDetail->setProductId($product_id);
      $checkDetail->setVariationId($variation_id);
      $checkDetail->setSku($sku);
      $checkDetail->setQuantity($qty);
      $checkDetail->setSize($size);
      $checkDetail->setColor($color);
      $checkDetail->setName($name);
      $checkDetail->setPrice($price);
      $dao->save_check_detail($checkDetail);
    } else {
      $dao->update_qty_by_sku((int)$sku);
    }
    $response_array['success'] = "successfully";
    echo json_encode($response_array);
  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }
  $db->commit();
}
if (isset($_POST["method"]) && $_POST["method"] == "save_check_tmp") {
    try {
        Common::authen_get_data();
        $sku = $_POST["sku"];
//        if(count($skus) == 0) {
//            throw new Exception("SKU is not empty!!!");
//        }
        $id = $dao->save_check_temp($sku);
        echo $id;
    } catch (Exception $e) {
        $db->rollback();
        echo $e->getMessage();
    }
    $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "save_result_check") {
  try {
    Common::authen_get_data();
    $data = $_POST["data"];
    $data = json_decode($data);
    $total_qty = $data->total_qty;
    $total_money = $data->total_money;
    // update all new qty
    $dao->update_qty_variations();

    // save result check
    $resultCheck = new ResultCheck();
    $resultCheck->setTotalQty($total_qty);
    $resultCheck->setTotalMoney($total_money);
    $dao->save_result_check($resultCheck);

    // return result
    $response_array['success'] = "successfully";
    echo json_encode($response_array);
  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }
  $db->commit();
}
