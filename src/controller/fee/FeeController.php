<?php
require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../model/Fee/Fee.php");
include("../../dao/FeeDAO.php");

$db = new DBConnect();

$dao = new FeeDAO();
$dao->setConn($db->getConn());

if (isset($_GET["method"]) && $_GET["method"] == "findall") {
    try {
        Common::authen_get_data();
        $start_date = $_GET["start_date"];
        $end_date = $_GET["end_date"];
        $result = $dao->find_fee(0, $start_date, $end_date);
        echo json_encode($result);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "save_or_update_fee") {
    try {
        Common::authen_get_data();
        $data = $_POST["data"];
        $data = json_decode($data);

        $fee = new Fee();
        $fee->setId($data->id);
        $fee->setFeeDate($data->feeDate);
        $fee->setReason($data->reason);
        $fee->setAmount($data->amount);
        $fee->setType($data->type);
        $dao->save_or_update_fee($fee);
        $response_array['success'] = "successfully";
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        throw new Exception($e);
    }
    $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "delete_fee") {
    try {
        Common::authen_get_data();
        $id = $_POST["id"];
        $dao->delete_fee((int)$id);
        $response_array['success'] = "successfully";
        echo json_encode($response_array);
    } catch (Exception $e) {
        $db->rollback();
        throw new Exception($e);
    }
    $db->commit();
}

if (isset($_POST["method"]) && $_POST["method"] == "edit_fee") {
    try {
        Common::authen_get_data();
        $id = $_POST["id"];
        $result = $dao->find_fee($id);
        echo json_encode($result);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "total_fee") {
    try {
        Common::authen_get_data();
        $start_date = $_POST["start_date"];
        $end_date = $_POST["end_date"];
        $result = $dao->get_total_fee($start_date, $end_date);
        echo json_encode($result);
    } catch (Exception $ex) {
        throw new Exception($ex);
    }
}
