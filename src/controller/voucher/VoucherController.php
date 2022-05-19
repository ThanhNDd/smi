<?php
require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../dao/VoucherDAO.php");

$db = new DBConnect();

$dao = new VoucherDAO($db);
// $dao->setConn($db->getConn());

if (isset($_POST["method"]) && $_POST["method"] == "update_status") {
  try {
    Common::authen_get_data();
    $voucher_id = $_POST["voucher_id"];
    $status = $_POST["status"];
    $voucher = $dao->update_status((int)$voucher_id, (int)$status, 0);
    echo json_encode($voucher);
  } catch (Exception $e) {
    $db->rollback();
    throw new Exception("Update status voucher error exception: " . $e);
  }
  $db->commit();
}

// if(isset($_POST["method"]) && $_POST["method"]=="active_voucher")   {
//     try {
//         $voucher_id = $_POST["voucher_id"];
//         $voucher = $dao->active_voucher((int)$voucher_id);
//         echo json_encode($voucher);
//     } catch(Exception $e) {
//         $db->rollback();
//         throw new Exception("Active voucher error exception: ".$e);
//     }
//     $db->commit();
// }

if (isset($_POST["type"]) && $_POST["type"] == "del_voucher") {
  try {
    Common::authen_get_data();
    $voucher_id = $_POST["voucher_id"];
    $voucher = $dao->del_voucher($voucher_id);
  } catch (Exception $e) {
    $db->rollback();
    throw new Exception("Delete product error exception: " . $e);
  }
  $db->commit();
}

if (isset($_POST["type"]) && $_POST["type"] == "edit_voucher") {
  try {
    Common::authen_get_data();
    $voucher_id = $_POST["voucher_id"];
    $voucher = $dao->find_by_id($voucher_id);
    echo json_encode($voucher);
  } catch (Exception $e) {
    throw new Exception("Delete product error exception: " . $e);
  }
}

if (isset($_POST["type"]) && $_POST["type"] == "save_voucher") {
  try {
    Common::authen_get_data();
    $code = $_POST["code"];
    $value = $_POST["value"];
    $type = $_POST["type"];
    $startDate = $_POST["startDate"];
    $expiredDate = $_POST["expiredDate"];
    $voucher = new Voucher();
    $voucher->setCode($code);
    $voucher->setValue($value);
    $voucher->setType($type);
    $voucher->setStartDate($startDate);
    $voucher->setExpiredDate($expiredDate);
    $dao->save_voucher($voucher);
    $response_array['success'] = "successfully";
    echo json_encode($response_array);
  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }
  $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "update_voucher") {
  try {
    Common::authen_get_data();
    $id = $_POST["id"];
    $code = $_POST["code"];
    $value = $_POST["value"];
    $type = $_POST["type"];
    $startDate = $_POST["startDate"];
    $expiredDate = $_POST["expiredDate"];

    if (empty($id) || $id == 0) {
      throw new Exception("Voucher Id is empty or equal zero");
    }
    $voucher = new Voucher();
    $voucher->setId($id);
    $voucher->setCode($code);
    $voucher->setValue($value);
    $voucher->setType($type);
    $voucher->setStartDate($startDate);
    $voucher->setExpiredDate($expiredDate);
    $dao->update_voucher($voucher);
    $response_array['success'] = "successfully";
    echo json_encode($response_array);
  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }
  $db->commit();
}


if (isset($_GET["method"]) && $_GET["method"] == "findall") {
  try {
    Common::authen_get_data();
    $lists = $dao->find_all();
    echo json_encode($lists);
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}

if (isset($_POST["method"]) && $_POST["method"] == "find_by_code") {
  try {
    Common::authen_get_data();
    $code = $_POST['code'];
    $data = $dao->find_by_code($code);
    echo json_encode($data);
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}
