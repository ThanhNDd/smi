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
    $new_file_name = date("dmYhis").".". $ext;
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_directory . $new_file_name);
    $file_type  = PHPExcel_IOFactory::identify($file_directory . $new_file_name);
    $objReader  = PHPExcel_IOFactory::createReader($file_type);
    $objPHPExcel = $objReader->load($file_directory . $new_file_name);

    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
 
    // Lấy tổng số cột của file, trong trường hợp này là 4 dòng
    $highestColumn = $sheet->getHighestColumn();
    $columnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

    $data = [];
    $col1 = $sheet->getCell("A1")->getValue();
    if($col1 == "STT") {
        //giao hàng nhanh
        $orderIdColIndex = null;
        $billCodeColIndex = null;
        $shippingFeeColIndex = null;
        for ($i = 1; $i <= $columnIndex; $i++){
            $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($i - 1);
            $cellValue = $sheet->getCell($adjustedColumn. "1")->getValue();
            if($cellValue == 'Mã đơn hàng riêng') {
                $orderIdColIndex = $adjustedColumn;
            } else if($cellValue == 'Mã đơn hàng') {
                $billCodeColIndex = $adjustedColumn;
            }  else if($cellValue == 'Tổng phí dịch vụ') {
                $shippingFeeColIndex = $adjustedColumn;
            } 
        }
        $start_row = 2;
        for ($row =  $start_row; $row <= $highestRow; $row++){
            $order = [];        
            $order["order_id"] = $sheet->getCell($orderIdColIndex . $row)->getValue();
            $order["bill_no"] = $sheet->getCell($billCodeColIndex . $row)->getValue();
            $order["shipping_fee"] = $sheet->getCell($shippingFeeColIndex . $row)->getValue();
            $order["shipping_unit"] = "GHN";
            $order["estimated_delivery"] = "3";
            $order["status"] = "13";// Đã tạo đơn
            array_push($data, $order);
        }
    } else {
        // J&T Express
        $orderIdColIndex = null;
        $billCodeColIndex = null;
        $shippingFeeColIndex = null;
        for ($i = 1; $i <= $columnIndex; $i++){
            $adjustedColumn = PHPExcel_Cell::stringFromColumnIndex($i - 1);
            $cellValue = $sheet->getCell($adjustedColumn. "1")->getValue();
            if($cellValue == 'Mã đơn KH') {
                $orderIdColIndex = $adjustedColumn;
            } else if($cellValue == 'Mã vận đơn') {
                $billCodeColIndex = $adjustedColumn;
            }  else if($cellValue == 'Vận phí') {
                $shippingFeeColIndex = $adjustedColumn;
            } 
        }

        $start_row = 2;
        for ($row =  $start_row; $row <= $highestRow; $row++){
            $order = [];
            $order["order_id"] = $sheet->getCell($orderIdColIndex . $row)->getValue()->getPlainText();
            $order["bill_no"] = $sheet->getCell($billCodeColIndex . $row)->getValue()->getPlainText();
            $order["shipping_fee"] = $sheet->getCell($shippingFeeColIndex . $row)->getValue()->getPlainText();
            $order["shipping_unit"] = "J&T";
            $order["estimated_delivery"] = "1";
            $order["status"] = "13";// Đã tạo đơn
            array_push($data, $order);
        }
    }
    
    echo json_encode($data);
}