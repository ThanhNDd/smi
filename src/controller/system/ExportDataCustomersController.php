<?php
include("../../common/DBConnection.php");
include("../../dao/ExportDataCustomersDAO.php");

$db = new DBConnect();

$exportDataDAO = new ExportDataCustomersDAO($db);

if (isset($_POST["method"]) && $_POST["method"] == "getToken") {
    $token = $exportDataDAO->getToken();
    echo json_encode($token);
}

if (isset($_GET["method"]) && $_GET["method"] == "fetchData") {
    $data = $exportDataDAO->fetchData();
    $arr = array();
    $arr["data"] = $data;
    echo json_encode($arr);
}


if (isset($_POST["method"]) && $_POST["method"] == "exportData") {
  try {
    $ids = isset($_POST["ids"]) ? $_POST["ids"] : array();

    $response = array();
    $response["data"] = array();
    $response["result"] = array();

    $customers = $exportDataDAO->getDataByIds($ids);
    if(count($customers) > 0) {
      $token = $exportDataDAO->getToken();
      foreach ($customers as $key => $customer) {
        $data = $exportDataDAO->getData($customer);
        $result = $exportDataDAO->store($token, $data);
        $exportDataDAO->updateSyncDate($customer["id"]);
        
        array_push($response["data"], $data);
        array_push($response["result"], $result);
      }
    }
    echo json_encode($response);
  } catch (Exception $ex) {
    $db->rollback();
    echo $ex->getMessage();
  }
  $db->commit();
}

