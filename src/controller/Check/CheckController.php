<?php
require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../model/Check/Check.php");
include("../../model/Check/CheckDetail.php");
include("../../model/Check/ResultCheck.php");
include("../../model/Fee/Fee.php");
include("../../dao/CheckDAO.php");
include("../../dao/ProductDAO.php");
include_once('../Classes/PHPExcel.php');

$db = new DBConnect();

$dao = new CheckDAO($db);
// $dao->setConn($db->getConn());

$product_dao = new ProductDAO($db);
// $product_dao->setConn($db->getConn());


if (isset($_POST) && !empty($_FILES['file'])) {
  try {
    $file_info = $_FILES["fileToUpload"]["name"];
    $file_directory = __DIR__."/uploads/";
    $ext = pathinfo($file_info, PATHINFO_EXTENSION);
    $new_file_name = date("dmYhis").".". $ext;
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_directory . $new_file_name);  
    $file_type  = PHPExcel_IOFactory::identify($file_directory . $new_file_name);
    $objReader  = PHPExcel_IOFactory::createReader($file_type);
    $objPHPExcel = $objReader->load($file_directory . $new_file_name);

    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    $columnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

    // backup quantity
    $product_dao->update_quantity_backup();
    // set all current quantity to zero
    $product_dao->reset_quantity();
    // set all product is stock
    $product_dao->restore_stock();

    $total_sku = 0;
    $updated_sku = 0;
    $sku_update_failed = [];

    for ($col = 1; $col <= $columnIndex; $col++){
      $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($col - 1);
      for ($row = 1; $row <= $highestRow; $row++){
        $sku = $sheet->getCell($adjustedColumn . $row)->getValue();
        if(empty($sku)) {
          break;
        }
        $total_sku++;
        $result = $product_dao->update_quantity_for_check(1, $sku);
        if($result > 0 ) {
          $updated_sku++;
        } else {
          array_push($sku_update_failed, $sku);
        }
      }
    }

    // set all product is stock
    $product_dao->restore_stock();
    // update out of stock
    $product_id = -1; // all product
    $status = 1; // out of stock
    $product_dao->update_stock($status, $product_id);


    $data = [];
    $data["total_sku"] = $total_sku;
    $data["updated_sku"] = $updated_sku;
    $data["sku_update_failed"] = $sku_update_failed;

    $db->commit();

    echo json_encode($data);

  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }

}

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
