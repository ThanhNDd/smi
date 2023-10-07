<?php
$root = dirname(__FILE__, 3);
require_once($root."/common/common.php");
include($root."/common/DBConnection.php");
include($root."/dao/ProductDAO.php");
include_once('Classes/PHPExcel.php');

$db = new DBConnect();

$product_dao = new ProductDAO($db);

if (isset($_POST) && !empty($_FILES['file'])) {
  try {
    $file_info = $_FILES["fileToUpload"]["name"];
    $file_directory = __DIR__."/uploads/";
    $ext = pathinfo($file_info, PATHINFO_EXTENSION);
    $tmp_name = $_FILES["fileToUpload"]["tmp_name"];
    
    // create file template to insert new quantiy
    $templateFile = __DIR__."/template/shopeeTemplate.xlsx";
    $exportFileName = "/uploads/mass_update_shopee".date("dmYhis").".xlsx";
    $exportPathFile = __DIR__.$exportFileName;
    $templateFileType = PHPExcel_IOFactory::identify($templateFile);
    $templateReader = PHPExcel_IOFactory::createReader($templateFileType);
    $templatePHPExcel = $templateReader->load($templateFile);
    $templateSheet = $templatePHPExcel->setActiveSheetIndex(0);

    // read file
    $shopee_file = $file_directory . "shopee_root_file_".date("dmYhis").".". $ext;
    move_uploaded_file($tmp_name, $shopee_file);
    $file_type  = PHPExcel_IOFactory::identify($shopee_file);
    $objReader  = PHPExcel_IOFactory::createReader($file_type);
    $objPHPExcel = $objReader->load($shopee_file);

    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();
    $columnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

    $start_row = 5;
    for ($row = $start_row; $row <= $highestRow; $row++){
      $sku = $sheet->getCell("F" . $row)->getValue();
      if(empty($sku)) {
        $sku = $sheet->getCell("E" . $row)->getValue();
      }
      $quantity = 0;
      if(!empty($sku)) {
        $quantity = $product_dao->get_quantity_by_sku($sku);
        if(!$quantity) {
          $quantity = 0;
        }
      }
      $templateSheet->getCell('A' . $row)->setValue($sheet->getCell("A" . $row)->getValue());
      $templateSheet->getCell('B' . $row)->setValue($sheet->getCell("B" . $row)->getValue());
      $templateSheet->getCell('C' . $row)->setValue($sheet->getCell("C" . $row)->getValue());
      $templateSheet->getCell('D' . $row)->setValue($sheet->getCell("D" . $row)->getValue());
      $templateSheet->getCell('E' . $row)->setValue($sheet->getCell("E" . $row)->getValue());
      $templateSheet->getCell('F' . $row)->setValue($sheet->getCell("F" . $row)->getValue());
      $templateSheet->getCell('G' . $row)->setValue($sheet->getCell("G" . $row)->getValue());
      $templateSheet->getCell('H' . $row)->setValue($quantity);
      if(empty($sheet->getCell("A" . $row)->getValue())) {
        break;
      }
    }
    // // Write the file
    $objWriter = PHPExcel_IOFactory::createWriter($templatePHPExcel, $templateFileType);
    $objWriter->save($exportPathFile);

    $filePath = Common::path()."src/controller/batch/".$exportFileName;
    echo json_encode($filePath);

  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }

}


