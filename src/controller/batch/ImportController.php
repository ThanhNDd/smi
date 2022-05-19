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
    $new_file_name = date("dmY").".". $ext;
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $file_directory . $new_file_name);
    $file_type  = PHPExcel_IOFactory::identify($file_directory . $new_file_name);
    $objReader  = PHPExcel_IOFactory::createReader($file_type);
    $objPHPExcel = $objReader->load($file_directory . $new_file_name);

    $sheet = $objPHPExcel->getSheet(0);
    $highestRow = $sheet->getHighestRow();
 
    // Lấy tổng số cột của file, trong trường hợp này là 4 dòng
    $highestColumn = $sheet->getHighestColumn();

    $start_row = 2;
    $orderId = null;
    $data = [];
    $rowIndex = 0;
    $shopeeOrderIds = [];
    $phones = [];
    $index = 1;


    $orderError = [];
    $availableOrder = [];
    $existedOrder = [];

    $isOrderError = false;
    $isOrderAvailable = false;
    $isOrderExisted = false;
    
    for ($row =  $start_row; $row <= $highestRow; $row++){
        if($sheet->getCell('A' . $row)->getValue() != null) {
            $productName = $sheet->getCell('O' . $row)->getValue();
            if($orderId == $sheet->getCell('A' . $row)->getValue()) {
                // $rowData = $data[$rowIndex -1];
                $variant = [];
                $sku = $sheet->getCell('S' . $row)->getValue();
                if(empty($sku)) {
                    $data[$rowIndex -1]["orderError"] = false;
                    $data[$rowIndex -1]["isNotExistProduct"] = intval($data[$rowIndex -1]["isNotExistProduct"]) + 1;
                    $variant["product_id"] = null;
                    $variant["variant_id"] = null;
                    $variant["sku"] = null;
                    $variant["product_name"] = null;
                    $variant["reduce"] = 0;
                    $variant["reduce_percent"] = null;
                    $variant["reduce_type"] = null;
                    $variant["product_exchange"] = null;
                    $variant["profit"] = null;
                    $variant["name"] = $sheet->getCell('T' . $row)->getValue();
                    $variant["price"] = intval($sheet->getCell('Y' . $row)->getValue());
                    $variant["quantity"] = $sheet->getCell('Z' . $row)->getValue();
                } else {
                    $variation = $productDAO->find_by_sku($sku);
                    if(empty($variation)) {
                        $data[$rowIndex -1]["orderError"] = false;
                        $data[$rowIndex -1]["isNotExistProduct"] = intval($data[$rowIndex -1]["isNotExistProduct"]) + 1;
                        $variant["product_id"] = null;
                        $variant["variant_id"] = null;
                        $variant["product_name"] = $productName;
                        $variant["reduce"] = 0;
                        $variant["reduce_percent"] = null;
                        $variant["reduce_type"] = null;
                        $variant["product_exchange"] = null;
                        $variant["profit"] = null;
                        $variant["sku"] = $sheet->getCell('S' . $row)->getValue();
                        $variant["name"] = $sheet->getCell('T' . $row)->getValue();
                        $variant["price"] = intval($sheet->getCell('Y' . $row)->getValue());
                        $variant["quantity"] = $sheet->getCell('Z' . $row)->getValue();
                    } else {
                        $variation = $variation[0];
                        $productName = $variation["name"];
                        $variant["product_id"] = $variation["product_id"];
                        $variant["variant_id"] = $variation["variant_id"];
                        $variant["product_name"] = $variation["name"];
                        $variant["reduce"] = intval(str_replace(",","",$variation["retail"])) - intval($sheet->getCell('Y' . $row)->getValue());
                        $variant["reduce_percent"] = null;
                        $variant["reduce_type"] = null;
                        $variant["product_exchange"] = null;
                        $variant["profit"] = intval(str_replace(",","",$variation["profit"]));
                        $variant["sku"] = $sheet->getCell('S' . $row)->getValue();
                        $variant["name"] = $sheet->getCell('T' . $row)->getValue();
                        $variant["price"] = intval(str_replace(",","",$variation["retail"]));
                        $variant["quantity"] = $sheet->getCell('Z' . $row)->getValue();
                    }
                }
                $data[$rowIndex -1]["quantity"] = intval($data[$rowIndex -1]["quantity"]) + intval($sheet->getCell('Z' . $row)->getValue());
                $data[$rowIndex -1]['description'] .= $index.". ".$productName.",".$sheet->getCell('T' . $row)->getValue(). PHP_EOL;
                // array_push($data[$rowIndex -1]['description'], $description);
                $data[$rowIndex - 1]["total_reduce"] = intval($data[$rowIndex - 1]["total_reduce"]) + intval($variant["reduce"]);
                $totalAmount = intval($sheet->getCell('AB' . $row)->getValue());
                $data[$rowIndex - 1]["total_amount"] =  intval($data[$rowIndex - 1]["total_amount"]) + intval($sheet->getCell('Y' . $row)->getValue()) + intval($variant["reduce"]); 
                $data[$rowIndex - 1]["total_checkout"] = intval($data[$rowIndex - 1]["total_amount"]) - intval($data[$rowIndex - 1]["total_reduce"]);
                array_push($data[$rowIndex - 1]['products'], $variant);
                $index++;

            } else {
                $shopeeFee = intval($sheet->getCell('AS' . $row)->getValue());
                $paymentFee = intval($sheet->getCell('AU' . $row)->getValue());
                $voucherShop = intval($sheet->getCell('AC' . $row)->getValue());
                $totalFee = $shopeeFee + $paymentFee + $voucherShop;
                // $totalAmount = intval($sheet->getCell('AB' . $row)->getValue());

                $cityName = $sheet->getCell('AZ' . $row)->getValue();
                $districtName = $sheet->getCell('BA' . $row)->getValue();
                $villageName = $sheet->getCell('BB' . $row)->getValue();

                $zone = new Zone();
                $cityId = $zone->getCityIdByName($cityName);
                $districtId = $zone->getDistrictIdByName($districtName);
                $villageId = $zone->getWardIdByName($villageName);

                $rowData = [];
                $rowData["order_id"] = null;
                $rowData["order_type"] = 1;
                $rowData["source"] = 3;
                $rowData["order_status"] = 13;
                $rowData["wallet"] = 0;
                $rowData["shipping_fee"] = 0;
                $rowData["shipping"] = 0;
                $rowData["payment_type"] = 1;
                $rowData["shopee_order_id"] = $sheet->getCell('A' . $row)->getValue();
                $rowData["order_date"] = $sheet->getCell('C' . $row)->getValue();
                $rowData["bill_of_lading_no"] = $sheet->getCell('F' . $row)->getValue();
                $rowData["shipping_unit"] = getShippingUnit($sheet->getCell('F' . $row)->getValue());
                $rowData["shippingUnit"] = $sheet->getCell('G' . $row)->getValue();
                $rowData["productName"] = $sheet->getCell('O' . $row)->getValue();   
                $rowData["shopeeFee"] = $sheet->getCell('AS' . $row)->getValue();
                $rowData["paymentFee"] = $sheet->getCell('AU' . $row)->getValue();
                $rowData["discount"] = $rowData["total_reduce"] =  $totalFee;
                $rowData["account"] = $sheet->getCell('AW' . $row)->getValue();

                $customerPhone = formatPhone($sheet->getCell('AY' . $row)->getValue());
                $customer = $customerDAO->find_customer($customerPhone, 'phone');

                $rowData["customer_id"] = empty($customer) ? null : $customer->id;
                $rowData["customerName"] = $sheet->getCell('AX' . $row)->getValue();
                $rowData["customerPhone"] = $customerPhone;
                $rowData["cityId"] = $cityId;
                $rowData["cityName"] = $cityName;
                $rowData["districtId"] = $districtId;
                $rowData["districtName"] = $districtName;
                $rowData["villageId"] = $villageId;
                $rowData["villageName"] = $villageName;

                $address = [];
                $arr = explode(",",$sheet->getCell('BC' . $row)->getValue());
                for($i=0; $i<count($arr)-3; $i++) {
                    array_push($address, $arr[$i]);
                }
                $rowData["address"] = implode(",",$address);
                $rowData["fullAddress"] = implode(",",$address).", ".$villageName.", ".$districtName.", ".$cityName;
                $rowData["fullAddressShopee"] = $sheet->getCell('BC' . $row)->getValue();
                // $rowData["description"] = [];
                if(empty($cityId) || empty($districtId) || empty($villageId)) {
                    $rowData["orderError"] = false;
                }
                $rowData["quantity"] = intval($sheet->getCell('Z' . $row)->getValue());
                $rowData["isNotExistProduct"] = 0;


                $index = 1;
                // array_push($rowData['description'], $description);
                $variant = [];
                $sku = $sheet->getCell('S' . $row)->getValue();
                if(empty($sku)) {
                    $rowData["orderError"] = false;
                    $rowData["isNotExistProduct"] = intval($rowData["isNotExistProduct"]) + 1;
                    $variant["product_id"] = null;
                    $variant["variant_id"] = null;
                    $variant["sku"] = null;
                    $variant["product_name"] = null;
                    $variant["reduce"] = 0;
                    $variant["reduce_percent"] = null;
                    $variant["reduce_type"] = null;
                    $variant["product_exchange"] = null;
                    $variant["profit"] = null;
                    $variant["name"] = $sheet->getCell('T' . $row)->getValue();
                    $variant["price"] = intval($sheet->getCell('Y' . $row)->getValue());
                    $variant["quantity"] = $sheet->getCell('Z' . $row)->getValue();

                } else {
                    $variation = $productDAO->find_by_sku($sku);
                    if(empty($variation)) {
                        $rowData["orderError"] = false;
                        $rowData["isNotExistProduct"] = intval($rowData["isNotExistProduct"]) + 1;
                        $variant["product_id"] = null;
                        $variant["variant_id"] = null;
                        $variant["product_name"] = $productName;
                        $variant["reduce"] = 0;
                        $variant["reduce_percent"] = null;
                        $variant["reduce_type"] = null;
                        $variant["product_exchange"] = null;
                        $variant["profit"] = null;
                        $variant["sku"] = $sheet->getCell('S' . $row)->getValue();
                        $variant["name"] = $sheet->getCell('T' . $row)->getValue();
                        $variant["price"] = intval($sheet->getCell('Y' . $row)->getValue());
                        $variant["quantity"] = $sheet->getCell('Z' . $row)->getValue();
                    } else {
                        $variation = $variation[0];
                        $productName = $variation["name"];
                        $variant["product_id"] = $variation["product_id"];
                        $variant["variant_id"] = $variation["variant_id"];
                        $variant["product_name"] = $productName;
                        $variant["reduce"] = intval(str_replace(",","",$variation["retail"])) - intval($sheet->getCell('Y' . $row)->getValue());
                        $variant["reduce_percent"] = null;
                        $variant["reduce_type"] = null;
                        $variant["product_exchange"] = null;
                        $variant["profit"] = intval(str_replace(",","",$variation["profit"]));
                        $variant["sku"] = $sheet->getCell('S' . $row)->getValue();
                        $variant["name"] = $sheet->getCell('T' . $row)->getValue();
                        $variant["price"] = intval(str_replace(",","",$variation["retail"]));
                        $variant["quantity"] = $sheet->getCell('Z' . $row)->getValue();
                    }
                }
                $rowData["description"] = $index.". ".$productName.",".$sheet->getCell('T' . $row)->getValue(). PHP_EOL;
                $rowData["total_reduce"] = intval($rowData["total_reduce"]) + intval($variant["reduce"]);
                $rowData["total_amount"] = intval($sheet->getCell('Y' . $row)->getValue()) + intval($variant["reduce"]);  
                $rowData["total_checkout"] = intval($rowData["total_amount"]) - intval($rowData["total_reduce"]);
                $rowData["products"] = [];
                array_push($rowData['products'], $variant);
                array_push($shopeeOrderIds, $sheet->getCell('A' . $row)->getValue());
                array_push($phones, $sheet->getCell('AY' . $row)->getValue());
                array_push($data, $rowData);
                $rowIndex++;
                $index++;
            }   
            $orderId = $sheet->getCell('A' . $row)->getValue();
        }
    }

    $customers = $customerDAO->find_by_phone("'".implode("','",$phones)."'");
    if(!empty($customers)) {
        foreach ($customers as $key => $value) {
            foreach ($data as $k => $v) {
                if($value["phone"] == $v["customerPhone"]) {
                    $data[$k]["existedCustomer"] = true;
                    $data[$k]["customer_id"] = $value["id"];
                    $data[$k]["fullAddressExisted"] = $value["full_address"];
                }
            }
        }
    }

    $orders = $checkoutDAO->findOrderShopee("'".implode("','",$shopeeOrderIds)."'");
    if(!empty($orders)) {
        foreach ($orders as $key => $value) {
            foreach ($data as $k => $v) {
                if($value["shopee_order_id"] == $v["shopee_order_id"]) {
                    $data[$k]["order_id"] = $value["id"];
                    $data[$k]["existedOrder"] = true;
                    $data[$k]["availableOrder"] = false;
                }
            }
        }
    }
    
    
    echo json_encode($data);
}

function formatPhone($phone) {
    if(substr($phone,0, 2) == 84) {
        $phone = str_replace("84","0",$phone);
    } 
    return $phone;
}

function getShippingUnit($billCode) {
    $shippingUnit = "";
    if(substr($billCode,0, 3) == "SPX") {
      $shippingUnit = "SPXEXPRESS";
    } else if(substr($billCode,0, 3) == "SPE") {
      $shippingUnit = "NINJAVAN";
    } else if(substr($billCode,0, 2) == "GA") {
      $shippingUnit = "GHN";
    }
    return $shippingUnit;
  }