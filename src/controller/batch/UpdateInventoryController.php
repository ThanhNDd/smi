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
    
    $lazada_file_name = "pricestock";
    $shopee_file_name = "mass_update_sales_info";
    $detect = strpos($file_info,$lazada_file_name);
    if($detect === false) {
      $detect = strpos($file_info,$shopee_file_name);
      if($detect === false) {
        echo "Unknown file";
      } else {
        // var_dump("Shopee file");
        // create file template to insert new quantiy
        $templateFile = __DIR__."/template/shopeeTemplate.xlsx";
        // $exportFileName = "/uploads/shopee_update_qty".date("dmYhis").".xlsx";
        $exportFileName = "/uploads/$file_info";
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

        $start_row = 7;
        for ($row = $start_row; $row <= $highestRow; $row++){
          $sku = $sheet->getCell("F" . $row)->getValue();
          if(empty($sku)) {
            $sku = $sheet->getCell("E" . $row)->getValue();
          }
          $quantity = 0;
          if(!empty($sku)) {
            $response = $product_dao->get_quantity_by_sku($sku);
            $quantity = $response["quantity"];
            if(!$quantity || $quantity < 0) {
              $quantity = 0;
            }
          }
          $templateSheet->getCell('A' . $row)->setValue($sheet->getCell("A" . $row)->getValue());
          $templateSheet->getStyle('A' . $row)->getAlignment()->setWrapText(false);
          $templateSheet->getCell('B' . $row)->setValue($sheet->getCell("B" . $row)->getValue());
          $templateSheet->getStyle('B' . $row)->getAlignment()->setWrapText(false);
          $templateSheet->getCell('C' . $row)->setValue($sheet->getCell("C" . $row)->getValue());
          $templateSheet->getStyle('C' . $row)->getAlignment()->setWrapText(false);
          $templateSheet->getCell('D' . $row)->setValue($sheet->getCell("D" . $row)->getValue());
          $templateSheet->getStyle('D' . $row)->getAlignment()->setWrapText(false);
          $templateSheet->getCell('E' . $row)->setValue($sheet->getCell("E" . $row)->getValue());
          $templateSheet->getStyle('E' . $row)->getAlignment()->setWrapText(false);
          $templateSheet->getCell('F' . $row)->setValue($sheet->getCell("F" . $row)->getValue());
          $templateSheet->getStyle('F' . $row)->getAlignment()->setWrapText(false);
          $templateSheet->getCell('G' . $row)->setValue($sheet->getCell("G" . $row)->getValue());
          $templateSheet->getStyle('G' . $row)->getAlignment()->setWrapText(false);
          $templateSheet->getCell('H' . $row)->setValue($quantity);
          $templateSheet->getStyle('H' . $row)->getAlignment()->setWrapText(false);
          if(empty($sheet->getCell("A" . $row)->getValue())) {
            break;
          }
        }
      }
    } else {
      // var_dump("lazada file");
      // create file template to insert new quantiy
      $templateFile = __DIR__."/template/lazadaTemplate.xlsx";
      $exportFileName = "/uploads/lazada_update_qty_".date("dmYhis").".xlsx";
      $exportPathFile = __DIR__.$exportFileName;
      $templateFileType = PHPExcel_IOFactory::identify($templateFile);
      $templateReader = PHPExcel_IOFactory::createReader($templateFileType);
      $templatePHPExcel = $templateReader->load($templateFile);
      $templateSheet = $templatePHPExcel->setActiveSheetIndex(0);

      // read file
      $lazad_file = $file_directory . "lzd_file_".date("dmYhis").".". $ext;
      move_uploaded_file($tmp_name, $lazad_file);
      $file_type  = PHPExcel_IOFactory::identify($lazad_file);
      $objReader  = PHPExcel_IOFactory::createReader($file_type);
      $objPHPExcel = $objReader->load($lazad_file);

      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestRow();
      $highestColumn = $sheet->getHighestColumn();
      $columnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

      $start_row = 5;
      for ($row = $start_row; $row <= $highestRow; $row++){
          $sku = $sheet->getCell("L" . $row)->getValue();
          $start_date = date("Y-m-d h:i:s");
          $end_date = date('Y-m-d h:m:i', strtotime('+1 year'));
          $retail_price = "";
          $quantity = 0;
          if(!empty($sku)) {
            $check_sku = strpos($sku,"-");
            if($check_sku > 0) {
              $arr = explode("-", $sku);
              $sku = $arr[0];
            }
            // var_dump("sku: $sku");
            $response = $product_dao->get_quantity_by_sku($sku);
            $quantity = $response["quantity"];
            // var_dump("quantity: $quantity");
            if(!$quantity || $quantity < 0) {
              $quantity = 0;
            }
            $retail_price = $response["retail"];
          }
          if(empty($retail_price)) {
            $retail_price = $sheet->getCell("H" . $row)->getValue();
          }

          $templateSheet->getCell('A' . $row)->setValue($sheet->getCell("A" . $row)->getValue());
          $templateSheet->getCell('B' . $row)->setValue($sheet->getCell("B" . $row)->getValue());
          $templateSheet->getCell('C' . $row)->setValue($sheet->getCell("C" . $row)->getValue());
          $templateSheet->getCell('D' . $row)->setValue($sheet->getCell("D" . $row)->getValue());
          $templateSheet->getCell('E' . $row)->setValue($sheet->getCell("E" . $row)->getValue());
          $templateSheet->getCell('F' . $row)->setValue($sheet->getCell("F" . $row)->getValue());
          $templateSheet->getCell('G' . $row)->setValue($sheet->getCell("G" . $row)->getValue());
          $templateSheet->getCell('H' . $row)->setValue($retail_price);
          $templateSheet->getCell('I' . $row)->setValue($start_date);
          $templateSheet->getCell('J' . $row)->setValue($end_date);
          $templateSheet->getCell('K' . $row)->setValue($sheet->getCell("K" . $row)->getValue());
          $templateSheet->getCell('L' . $row)->setValue($sheet->getCell("L" . $row)->getValue());
          $templateSheet->getCell('M' . $row)->setValue($quantity);
          $templateSheet->getCell('N' . $row)->setValue($sheet->getCell("N" . $row)->getValue());
          $templateSheet->getCell('O' . $row)->setValue($sheet->getCell("O" . $row)->getValue());
          if(empty($sheet->getCell("A" . $row)->getValue())) {
            break;
          }

      } 
    }
    
    // Write the file
    $objWriter = PHPExcel_IOFactory::createWriter($templatePHPExcel, $templateFileType);
    $objWriter->save($exportPathFile);

    $filePath = Common::path()."src/controller/batch/".$exportFileName;
    echo json_encode($filePath);

  } catch (Exception $e) {
    $db->rollback();
    echo $e->getMessage();
  }

}


