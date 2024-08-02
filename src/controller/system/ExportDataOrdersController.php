<?php
include("../../common/DBConnection.php");
include("../../dao/ExportDataOrdersDAO.php");
// include("../../dao/ExportDataCustomersDAO.php");
// include("../../dao/ExportDataWalletDAO.php");

$db = new DBConnect();

$exportDataDAO = new ExportDataOrdersDAO($db);
// $walletDAO = new ExportDataWalletDAO($db);
$token = $exportDataDAO->getToken();

if (isset($_POST["method"]) && $_POST["method"] == "getToken") {
    // $token = $exportDataDAO->getToken();
  global $token;
    echo json_encode($token);
}

if (isset($_GET["method"]) && $_GET["method"] == "fetchOrders") {
    $orders = $exportDataDAO->fetchOrders();
    $arr = array();
    $arr["data"] = $orders;
    echo json_encode($arr);
  // echo "string";
}


if (isset($_POST["method"]) && $_POST["method"] == "exportOrders") {
  try {
    $orderIds = isset($_POST["orderIds"]) ? $_POST["orderIds"] : array();

    $numberOrders = 0;
    $numberOrdersProcessed = 0;
    $result = processExportOrders($orderIds,$numberOrders, $numberOrdersProcessed);
    // echo json_encode($numberOrdersProcessed."/".$numberOrders);

    $response = array();
    $response["numberOrdersProcessed"] = $numberOrdersProcessed;
    $response["numberOrders"] = $numberOrders;
    echo json_encode($response);

    // $orders = $exportDataDAO->getOrders($orderIds);
    // if(count($orders) > 0) {
    //   $token = $exportDataDAO->getToken();
    //   foreach ($orders as $key => $order) {
    //     // store Order
    //     $data = $exportDataDAO->getData($order);
    //     $result = array();
    //     $result["orderId"] = $order["id"];
    //     if(!empty($data)) {
    //       $result["data"] = $exportDataDAO->store($token, $data);
    //       $exportDataDAO->updateSyncDate($order["id"]);
    //     }

    //     array_push($response["data"], $data);
    //     array_push($response["result"], $result);
    //   }
    // }
    // echo json_encode($response);
  } catch (Exception $ex) {
    $db->rollback();
    echo $ex->getMessage();
  }
  $db->commit();
}

function  processExportOrders($orderIds, &$numberOrders, &$numberOrdersProcessed) {
  global $exportDataDAO;
  global $token;

  $data = $exportDataDAO->getOrders($orderIds);
  if(count($data) > 0) {
    foreach ($data as $key => $order) {
      $orderData = $exportDataDAO->getData($order);
      // return $orderData;
      if(count($orderData) > 0) {
        $result = $exportDataDAO->store($token, $orderData);
        // var_dump($result);
        if(!empty($result->order_id)) {
          $exportDataDAO->updateSyncDate($order["id"]);  
          $numberOrdersProcessed++;
        }  
      }
      $numberOrders++;
    }
    if(empty($orderIds)) {
      processExportOrders($orderIds, $numberOrders, $numberOrdersProcessed);
    }
    // return $response;
  } 
  // else {
  //   return $response;
  // }
  
}


