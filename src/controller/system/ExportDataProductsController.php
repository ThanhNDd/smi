<?php
include("../../common/DBConnection.php");
include("../../dao/ExportDataProductDAO.php");

$db = new DBConnect();

$exportDataDAO = new ExportDataProductDAO($db);

$token = $exportDataDAO->getToken();

if (isset($_POST["method"]) && $_POST["method"] == "getToken") {
    // $token = $exportDataDAO->getToken();
    global $token;
    echo json_encode($token);
}

if (isset($_POST["method"]) && $_POST["method"] == "fetchProducts") {
    $products = $exportDataDAO->fetchProducts();
    echo json_encode($products);
}


if (isset($_POST["method"]) && $_POST["method"] == "exportProducts") {
  try {
    $productIds = isset($_POST["productIds"]) ? $_POST["productIds"] : array();
    $numberProductsCreated = 0;
    processExportProducts($productIds, $numberProductsCreated);
    echo json_encode($numberProductsCreated);

  } catch (Exception $ex) {
    $db->rollback();
    echo $ex->getMessage();
  }
  $db->commit();
}


function  processExportProducts($productIds, &$numberProductsCreated) {
  global $exportDataDAO;
  global $token;

  $data = $exportDataDAO->getProducts($productIds);
  if(count($data) > 0) {
    foreach ($data as $key => $product) {
      $productData = $exportDataDAO->getProductData($product);
      if(count($productData) > 0) {
        $result = $exportDataDAO->createProduct($token, $productData);
        if(!empty($result->product_id)) {
          $exportDataDAO->updateSyncDate($productData["productId"]);  
          $numberProductsCreated++;
        }  
      }
    }
    if(empty($productIds)) {
      processExportProducts($productIds, $numberProductsCreated);
    }
  } 
}
