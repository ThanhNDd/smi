<?php 
include("../../common/common.php");
include("../../common/DBConnection.php");
include_once('Classes/PHPExcel.php');

if (isset($_POST["method"]) && $_POST["method"] == "exportOrderJT") {

	$data = $_POST["data"];

	$templateFile = __DIR__."/template/JnT_template.xlsx";
	$exportFile = "/export/JnTExpress.xlsx";
	$exportPathFile = __DIR__.$exportFile;

	$fileType = PHPExcel_IOFactory::identify($templateFile);
	// Read the file
	$objReader = PHPExcel_IOFactory::createReader($fileType);
	$objPHPExcel = $objReader->load($templateFile);

	// Change the file
	$sheet = $objPHPExcel->setActiveSheetIndex(0);
	$highestRow = $sheet->getHighestRow();
	$start_row = 10;
	for ($i = 0; $i < count($data); $i++){
		$order_value = "";
		$payment_type = intval($data[$i]["payment_type"]);
		if($payment_type == 0) {
			$total_checkout = str_replace(",", "", $data[$i]["total_checkout"]);
		} else {
			$total_checkout = 0;
			$order_value = str_replace(",", "", $data[$i]["total_checkout"]);
		}
		$sheet->getCell('A' . $start_row)->setValue($data[$i]["order_id"]);
		$sheet->getCell('B' . $start_row)->setValue($data[$i]["customer_name"]);
		$sheet->getCell('C' . $start_row)->setValue($data[$i]["customer_phone"]);
		$sheet->getCell('D' . $start_row)->setValue($data[$i]["address"]);
		$sheet->getCell('E' . $start_row)->setValue($data[$i]["city"]);
		$sheet->getCell('F' . $start_row)->setValue($data[$i]["district"]);
		$sheet->getCell('G' . $start_row)->setValue($data[$i]["village"]);
		$sheet->getCell('H' . $start_row)->setValue($data[$i]["description"]);
		$sheet->getCell('I' . $start_row)->setValue("Hàng hóa");
		$sheet->getCell('J' . $start_row)->setValue("0.5");
		$sheet->getCell('K' . $start_row)->setValue("1");
		$sheet->getCell('L' . $start_row)->setValue($order_value);
		$sheet->getCell('M' . $start_row)->setValue($total_checkout);
		$sheet->getCell('N' . $start_row)->setValue("");
		$sheet->getCell('O' . $start_row)->setValue("x");
		$sheet->getCell('P' . $start_row)->setValue("x");
		$sheet->getCell('Q' . $start_row)->setValue("EXPRESS");
		$sheet->getCell('R' . $start_row)->setValue("PP_PM");
		$sheet->getCell('S' . $start_row)->setValue("Cho khách xem và thử hàng;Không giao được liên hệ SĐT shop, không tự ý chuyển hoàn;");
		$start_row++;
	}

	// Write the file
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
	$objWriter->save($exportPathFile);

	$filePath = Common::path()."src/controller/batch".$exportFile;
	echo json_encode($filePath);

}

if (isset($_POST["method"]) && $_POST["method"] == "exportOrderGHN") {

	$data = $_POST["data"];

	$templateFile = __DIR__."/template/GHN_template.xlsx";
	$exportFile = "/export/GHNExpress.xlsx";
	$exportPathFile = __DIR__.$exportFile;

	$fileType = PHPExcel_IOFactory::identify($templateFile);
	// Read the file
	$objReader = PHPExcel_IOFactory::createReader($fileType);
	$objPHPExcel = $objReader->load($templateFile);

	// Change the file
	$sheet = $objPHPExcel->setActiveSheetIndex(0);
	$highestRow = $sheet->getHighestRow();
	$start_row = 5;
	for ($i = 0; $i < count($data); $i++){
		$order_value = "";
		$payment_type = intval($data[$i]["payment_type"]);
		if($payment_type == 0) {
			$total_checkout = str_replace(",", "", $data[$i]["total_checkout"]);
			$cod = str_replace(",", "", $data[$i]["cod"]);
		} else {
			$total_checkout = 0;
			$order_value = str_replace(",", "", $data[$i]["total_checkout"]);
			$cod = 0;
		}

		$total_amount = str_replace(",", "", $data[$i]["total_amount"]);

		$sheet->getCell('A' . $start_row)->setValue($data[$i]["customer_name"]);
		$sheet->getCell('B' . $start_row)->setValue($data[$i]["customer_phone"]);
		$sheet->getCell('C' . $start_row)->setValue($data[$i]["customer_address"]);
		$sheet->getCell('D' . $start_row)->setValue(2);
		$sheet->getCell('E' . $start_row)->setValue($cod);
		$sheet->getCell('F' . $start_row)->setValue(2);
		$sheet->getCell('G' . $start_row)->setValue($data[$i]["mass"]);
		$sheet->getCell('H' . $start_row)->setValue(10);
		$sheet->getCell('I' . $start_row)->setValue(10);
		$sheet->getCell('J' . $start_row)->setValue(10);
		$sheet->getCell('K' . $start_row)->setValue("x");
		$sheet->getCell('L' . $start_row)->setValue($total_amount);
		$sheet->getCell('M' . $start_row)->setValue("x");
		$sheet->getCell('N' . $start_row)->setValue("");
		$sheet->getCell('O' . $start_row)->setValue($data[$i]["order_id"]);
		$sheet->getCell('P' . $start_row)->setValue($data[$i]["description"]);
		$sheet->getCell('Q' . $start_row)->setValue("Cho khách xem và thử hàng;Không giao được liên hệ SĐT shop, không tự ý chuyển hoàn;");
		$sheet->getCell('R' . $start_row)->setValue($data[$i]["time"]);
		$sheet->getCell('S' . $start_row)->setValue("30000");
		$start_row++;
	}

	// Write the file
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $fileType);
	$objWriter->save($exportPathFile);

	$filePath = Common::path()."src/controller/batch".$exportFile;
	echo json_encode($filePath);

}