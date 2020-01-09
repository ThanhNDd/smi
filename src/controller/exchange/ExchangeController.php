<?php
include("../../common/DBConnection.php");
include("../../dao/CheckoutDAO.php");

$db = new DBConnect();

$checkoutDAO = new CheckoutDAO();
$checkoutDAO->setConn($db->getConn());

if(isset($_POST["method"]) && $_POST["method"]=="find_order")   {
    $order_id = $_POST["orderId"];
    try
    {
        $order = $checkoutDAO->find_by_id($order_id, 0);
        echo json_encode($order);
    } catch(Exception $ex)
    {
        throw new Exception($ex);
    }
}