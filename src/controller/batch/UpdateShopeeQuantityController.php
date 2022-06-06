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

    $filename = "shopeeTemplate.xlsx";
    $templateExportFile = __DIR__."/template/".$filename;
	$exportFile = "/export/".$filename;
	$exportPathFile = __DIR__.$exportFile;
	$exportFileType = PHPExcel_IOFactory::identify($templateExportFile);
	$exportFileReader = PHPExcel_IOFactory::createReader($exportFileType);
	$exportFileObj = $exportFileReader->load($templateExportFile);
	$exportsheet = $exportFileObj->setActiveSheetIndex(0);

    $data = [];
    $start_row = 5;
    $skus = [];
    $num_row = 5;
    for ($row =  $start_row; $row <= $highestRow; $row++){
        $sku = $sheet->getCell('F' . $row)->getValue();
        if(!empty($sku)) {
            array_push($skus, $sku);
        } else {
            if(count($skus) > 0) {
                $s = implode(",", $skus);
                $quantities = $productDAO->findProductForShopee($s);
                foreach ($quantities as $key => $value) {
                    array_push($data, $value["quantity"]);
                    $exportsheet->getCell('I' . $num_row)->setValue($value["quantity"]);
                    $num_row++;
                }
                $skus = [];
            }
            $exportsheet->getCell('I' . $num_row)->setValue("");
            $num_row++;
            array_push($data, "");
        }
        
    }

  
    // Write the file
	$objWriter = PHPExcel_IOFactory::createWriter($exportFileObj, $exportFileType);
	$objWriter->save($exportPathFile);

	$filePath = Common::path()."src/controller/batch".$exportFile;
	echo json_encode($filePath);
}