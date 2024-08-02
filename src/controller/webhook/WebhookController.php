<?php
include("../../common/DBConnection.php");
include("../../dao/WebhookDAO.php");

$db = new DBConnect();
$webhookDAO = new WebhookDAO($db);

// https://api.vietqr.io/image/970436-0451000374835-9I3y28K.jpg?accountName=NGUYEN%20DUY%20THANH&amount=50000&addInfo=HKPOD12345VCB50000

$request = json_decode(file_get_contents('php://input'), true);
if($request){
	$orderId = null;
	try {
		$content = $request["content"];
		if(empty($content)) {
			http_response_code(500);
			echo json_encode(['success'=>FALSE, 'message' => 'No data']);
		    die();	
		}

		$index = strpos($content, "HKPOD");
		$data = substr($content,$index);
		$data = str_replace("HKPOD","",$data);

		$orderId = null;
		$amount = null;
		$bank = null;
		if(strpos($data, "VCB") !== false) {
			$split = explode("VCB",$data);
		    $orderId = $split[0];
		    $amount = $split[1];
		    $bank = "VCB";
		} else if(strpos($data, "VIB") !== false) {
			$split = explode("VIB",$data);
		    $orderId = $split[0];
		    $amount = $split[1];
		    $bank = "VIB";
		} else if(strpos($data, "TP") !== false) {
			$split = explode("TP",$data);
		    $orderId = $split[0];
		    $amount = $split[1];
		    $bank = "TP";
		}
		$data = array();
		$data["content"] = $content;
		$data["orderId"] = $orderId;
		$data["amount"] = $amount;
		$data["bank"] = $bank;

		$webhookDAO->store($data);

		http_response_code(200);
		echo json_encode(['success'=>TRUE]);

	} catch (Exception $ex) {
	    $db->rollback();
	    // echo $ex->getMessage();
	    http_response_code(500);
		echo json_encode(['success'=>FALSE, 'message' => $ex->getMessage()]);
	    die();	
	}
	$db->commit();
} else {
	echo json_encode(['success'=>FALSE, 'message' => 'No data']);
    die();	
}
