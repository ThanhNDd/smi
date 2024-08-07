<?php
require_once("../../common/common.php");
include("../../common/DBConnection.php");
include("../../model/Wallet/Wallet.php");
include("../../dao/WalletDAO.php");

$db = new DBConnect();

$dao = new WalletDAO($db);
// $dao->setConn($db->getConn());

if (isset($_POST["method"]) && $_POST["method"] == "get_ballance_in_wallet") {
    try {
        Common::authen_get_data();
        $customer_id = $_POST["customerId"];
        $point = $dao->getBallanceInWallet($customer_id);
        echo $point;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

if (isset($_POST["method"]) && $_POST["method"] == "show_history") {
    try {
        Common::authen_get_data();
        $customer_id = $_POST["customerId"];
        $wallet = $dao->find_by_customer_id($customer_id);
        echo json_encode($wallet);
    } catch (Exception $e) {
        throw new Exception($e);
    }
}