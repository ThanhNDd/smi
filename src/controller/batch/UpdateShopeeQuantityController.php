<?php
include("../../common/common.php");
include("../../common/DBConnection.php");
include_once('Classes/PHPExcel.php');
include("../../dao/CheckoutDAO.php");
include("../../dao/CustomerDAO.php");
include("../../dao/ProductDAO.php");
include("../../common/cities/Zone.php");

$db = new DBConnect();
$customerDAO = new CustomerDAO($db);
$checkoutDAO = new CheckoutDAO($db);
$productDAO = new ProductDAO($db);


if (isset($_POST) && !empty($_FILES['file'])) {
    $file_info = $_FILES["fileToUpload"]["name"];
    $file_directory = __DIR__."/uploads/";
    $ext = pathinfo($file_info, PATHINFO_EXTENSION);
    $new_file_name = "update_shopee_qty_".date("dmYhis").".". $ext;
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_directory . $new_file_name);
    $file_type  = PHPExcel_IOFactory::identify($file_directory . $new_file_name);
    $objReader  = PHPExcel_IOFactory::createReader($file_type);
    $objPHPExcel = $objReader->load($file_directory . $new_file_name);

    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
 
    // Lấy tổng số cột của file, trong trường hợp này là 4 dòng
    $highestColumn = $sheet->getHighestColumn();

    $start_row = 5;
    $skus = [];
    for ($row =  $start_row; $row <= $highestRow; $row++){
        $sku = $sheet->getCell('F' . $row)->getValue();
        if(!empty($sku)) {
            array_push($skus, $sku);
        }
    }
    $data = [];
    $arrays = array_chunk($skus, 50);
    for($i=0; $i<count($arrays); $i++) {
        $s = implode(",", $arrays[$i]);
        $quantities = $productDAO->find_by_sku($s);
        array_push($data, $quantities);
    }

    // for($i=0; $i<count($data); $i++) {
        
    // }

    echo json_encode($data);
}