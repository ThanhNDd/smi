<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
include("../../common/DBConnection.php");
include("../../dao/WebhookDAO.php");
include("../../dao/ProductDAO.php");


function sendMsg() {
	    $db = new DBConnect();
	    $webhookDAO = new WebhookDAO($db);
	try {
		$orderId= $webhookDAO->checkNewRecord();
		if($orderId) {
			$webhookDAO->update($orderId);
		} 
		echo "data: {$orderId}\n\n";
	  	ob_flush();
  		flush();
  	} catch (Exception $ex) {
	    $db->rollback();
	}
	$db->commit();
}

sendMsg();



