<?php
include("../../common/DBConnection.php");
include("../../dao/VoucherDAO.php");

$db = new DBConnect();

$dao = new VoucherDAO();
$dao->setConn($db->getConn());

if(isset($_POST["method"]) && $_POST["method"]=="update_status")   {
    try {
        $voucher_id = $_POST["voucher_id"];
        $status = $_POST["status"];
        $voucher = $dao->update_status((int)$voucher_id, $status);
        echo json_encode($voucher);
    } catch(Exception $e) {
        $db->rollback();
        throw new Exception("Update status voucher error exception: ".$e);
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

if(isset($_POST["type"]) && $_POST["type"]=="del_voucher")   {
    try {
        $voucher_id = $_POST["voucher_id"];
        $voucher = $dao->del_voucher($voucher_id);
    } catch(Exception $e) {
        $db->rollback();
        throw new Exception("Delete product error exception: ".$e);
    }
    $db->commit();
}

if(isset($_POST["type"]) && $_POST["type"]=="edit_voucher")   {
    $voucher_id = $_POST["voucher_id"];
    $voucher = $dao->find_by_id($voucher_id);
    echo json_encode($voucher);
}

if(isset($_POST["type"]) && $_POST["type"]=="save_voucher")   {
    $code = $_POST["code"];
    $value = $_POST["value"];
    $type = $_POST["type"];
    $startDate = $_POST["startDate"];
    $expiredDate = $_POST["expiredDate"];
    try {
        $voucher = new Voucher();
        $voucher->setCode($code);
        $voucher->setValue($value);
        $voucher->setType($type);
        $voucher->setStartDate($startDate);
        $voucher->setExpiredDate($expiredDate);
        $dao->save_voucher($voucher);
        $response_array['success'] = "successfully";
        echo json_encode($response_array);
    } catch(Exception $e)
    {
        $db->rollback();
        echo $e->getMessage();
    }    
    $db->commit();
}

if(isset($_POST["method"]) && $_POST["method"]=="update_voucher")   {
    $id = $_POST["id"];
    $code = $_POST["code"];
    $value = $_POST["value"];
    $type = $_POST["type"];
    $startDate = $_POST["startDate"];
    $expiredDate = $_POST["expiredDate"];

    if(empty($id) || $id == 0)
    {
        throw new Exception("Voucher Id is empty or equal zero");
    }
    try {
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
    } catch(Exception $e)
    {
        $db->rollback();
        echo $e->getMessage();
    }    
    $db->commit();
}


if(isset($_GET["method"]) && $_GET["method"]=="findall")   {
    try {
        $lists = $dao->find_all();
        echo json_encode($lists);
    } catch(Exception $e)
    {
        echo $e -> getMessage();
    }
}

if(isset($_POST["method"]) && $_POST["method"]=="find_by_code")   {
    try {
        $code = $_POST['code'];
        $data = $dao->find_by_code($code);
        echo json_encode($data);
    } catch(Exception $e)
    {
        echo $e -> getMessage();
    }
}
