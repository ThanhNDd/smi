<?php
include("../../common/common.php");
include("../../common/DBConnection.php");
include("../../dao/ProductDAO.php");
include("../../dao/CheckoutDAO.php");
include("../../dao/CustomerDAO.php");

$db = new DBConnect();
$checkoutDAO = new CheckoutDAO($db);
$productDAO = new ProductDAO($db);
$customerDAO = new CustomerDAO($db);

if (isset($_POST["method"]) && $_POST["method"] == "refactorID") {
	try {
		$update_type = $_POST["update_type"];
		$limit = 50;

		usleep(100);
		$uniq_id = microtime(true);
		$uniq_id = str_replace('.', '', "$uniq_id");
		$uniq_id = (int) str_pad($uniq_id,14,"0");


		if($update_type == "PRODUCTS") {
			$product_id = $uniq_id;
			var_dump("Generate product_id: ", $product_id);

			// get all products
			$products = $productDAO->find_all_products();
			var_dump("Products length: ", count($products));
			$variants = [];
			foreach($products as $k => $p) {
				// if($k < $limit) {
					$pid = $p["id"];
					// update productID
					// usleep(100);
					// $product_id = microtime(true);
					// $product_id = str_replace('.', '', "$product_id");
					// $product_id = str_pad($product_id,14,"0");

					$product_id++;

					$productDAO->update_product_id($pid, $product_id);
					var_dump("updated product ".$pid." with product_id: ".$product_id);
					
					$productDAO->update_variant_id($pid, $product_id);
				// }
			}
		} else if($update_type == "ORDERS") {
			$order_id = $uniq_id;
			var_dump("Generate order_id: ", $order_id);

			$orders = $checkoutDAO->find_all_orders();
			var_dump("Orders length: ", count($orders));
			foreach($orders as $k => $o) {
				// if($k < $limit) {
					$oid = $o["id"];
					// update orderID
					// usleep(100);
					// $order_id = microtime(true);
					// $order_id = str_replace('.', '', "$order_id");
					// $order_id = str_pad($order_id,14,"0");

					$order_id++;

					$checkoutDAO->update_order_id($oid, $order_id);
					var_dump("updated order ".$oid." with order_id: ".$order_id);

					// get all order detail of OrderID
					$orderDetails = $checkoutDAO->find_order_details($oid);
					foreach($orderDetails as $k => $od) {
						$odid = $od["id"];
						var_dump("updated order detail with order_id = ".$order_id);
						$checkoutDAO->update_order_detail($odid, $order_id);
					}

					// get all order logs by OrderID
					$orderLogs = $checkoutDAO->find_order_logs($oid);
					foreach($orderLogs as $k => $log) {
						$id = $log["id"];
						var_dump("updated order logs ".$id." with order_id = ".$order_id);
						$checkoutDAO->update_order_logs($id, $order_id);
					}

					// get all order wallet by OrderID
					$order_wallets = $checkoutDAO->find_order_wallets($oid);
					foreach($order_wallets as $k => $wallet) {
						$id = $wallet["id"];
						var_dump("updated order wallets ".$id." with order_id = ".$order_id);
						$checkoutDAO->update_order_wallets($id, $order_id);
					}

				// }
			}
		}  else if($update_type == "SKUS") {

			// get all order detail where source == 0 (ONLINE)
			$source = 0;
			$order_details = $checkoutDAO->find_all_order_details($source);
			var_dump("GET ORDER DETAILS by SKU length: ", count($order_details));

			foreach($order_details as $k => $orderDetail) {
				$detail_id = $orderDetail["detail_id"];
				$old_sku = $orderDetail["sku"];
				
				//create new sku
				usleep(100);
				$new_sku = microtime(true);
				$new_sku = str_replace('.', '', "$new_sku");
				$new_sku = (int) str_pad($new_sku,14,"0");

				//1. update table order detail
				var_dump("update Order_Detail old_sku: ".$old_sku." by new_sku: ".$new_sku);
				$checkoutDAO->update_sku_order_detail($old_sku, $new_sku);

				//2. update table variations
				var_dump("update Variantions old_sku: ".$old_sku." by new_sku: ".$new_sku);
				$productDAO->update_sku_variantions($old_sku, $new_sku);
			}

		} else if($update_type == "CUSTOMERS") {
			// usleep(100);
			// $customer_id = microtime(true);
			// $customer_id = str_replace('.', '', "$customer_id");
			// $customer_id = (int) str_pad($customer_id,14,"0");

			$customer_id = $uniq_id;
			var_dump("Generate customer_id: ", $customer_id);


			$customers = $customerDAO->find_customers();
			var_dump("Find all customers");

			foreach($customers as $k => $c) {
				$id = $c["id"];
				// update orderID
				$customer_id++;
				// $customer_id = $c["customer_id"];

				$customerDAO->update_customer_id($id, $customer_id);
				// var_dump("updated customer ".$id." with customer_id: ".$customer_id);

				// get all order detail of OrderID
				$orders = $checkoutDAO->find_order_by_customer($id);
				var_dump("Find all orders by customer_id: ".$id);
				foreach($orders as $k => $o) {
					$order_id = $o["id"];
					$checkoutDAO->update_customer_id($order_id, $customer_id);
					var_dump("updated order ".$order_id." with customer_id: ".$customer_id);
				}

				// get all order wallet of OrderID
				$wallets = $checkoutDAO->find_customer_wallet($id);
				var_dump("Find all wallets by customer_id: ".$id);
				foreach($wallets as $k => $w) {
					$id = $w["id"];
					$checkoutDAO->update_customer_wallet($id, $customer_id);
					var_dump("updated wallets ".$id." with customer_id: ".$customer_id);
				}
			}
		} else if($update_type == "ORDER_ONLINE") {
			$new_order_id = 15000;
			// get all order online
			$orders = $checkoutDAO->find_all_order_online();
			var_dump("get all order online: ".count($orders));
			foreach($orders as $k => $ord) {
				$order_id = $ord["order_id"];
				var_dump("order_id:  ".$order_id);
				//increase order id number
				$new_order_id++;

				var_dump("new_order_id:  ".$new_order_id);

				//update new order_id
				var_dump("update_new_order_id:  ".$new_order_id." by old_order_id: ".$order_id);
				$checkoutDAO->update_new_order_id($order_id, $new_order_id);

				//update order detail
				var_dump("update_new_order_id_order_detail:  ".$new_order_id." by old_order_id: ".$order_id);
				$checkoutDAO->update_new_order_id_order_detail($order_id, $new_order_id);

				//update order logs
				var_dump("update_new_order_id_order_logs:  ".$new_order_id." by old_order_id: ".$order_id);
				$checkoutDAO->update_new_order_id_order_logs($order_id, $new_order_id);
			}

		} else if($update_type == "PRODUCT_ONLINE") {
			$new_product_id = 2120;
			// get all order online
			$products = $productDAO->find_all_products_online();
			var_dump("get all products online: ".count($products));
			foreach($products as $k => $p) {
				$product_id = $p["id"];
				var_dump("product_id:  ".$product_id);
				//increase product id number
				$new_product_id++;

				var_dump("new_product_id:  ".$new_product_id);

				//update new product_id
				var_dump("update_new_product_id:  ".$new_product_id." by old_product_id: ".$product_id);
				$productDAO->update_new_product_id($product_id, $new_product_id);

				//find all variations by old product_id
				$variations = $productDAO->find_variant_by_product_id($product_id);
				var_dump("variations:  ".count($variations));
				$c = 0;
				foreach($variations as $k => $v) {
					$variant_id = $v["id"];
					$sku = $v["sku"];
					if($c < 10) {
						$new_sku = (int) $new_product_id."00".$c;
					} else if($c >= 10 && $c < 100) {
						$new_sku = (int) $new_product_id."0".$c;
					} else {
						$new_sku = (int) $new_product_id.$c;
					}
					//update variations
					var_dump("update_new_product_id_variations:  ".$new_product_id." by old_product_id: ".$product_id);
					var_dump("update_new_sku:  ".$new_product_id." by old_product_id: ".$product_id);
					$productDAO->update_new_product_id_variations($variant_id, $new_product_id, $new_sku);

					// update order detail
					$checkoutDAO->update_new_product_id_order_detail_by_sku($sku, $new_product_id, $new_sku);

					$c++;
				}
				
			}
		} else if($update_type == "CUSTOMER_ONLINE") {
			$new_customer_id = 10200;
			// get all customers online
			$customers = $customerDAO->find_all_customers_online();
			var_dump("get all customers online: ".count($customers));
			foreach($customers as $k => $c) {
				$customer_id = $c["id"];
				var_dump("customer_id:  ".$customer_id);
				//increase new_customer_id number
				$new_customer_id++;

				var_dump("new_customer_id:  ".$new_customer_id);

				//update new product_id
				var_dump("update_new_customer_id:  ".$new_customer_id." by old_customer_id: ".$customer_id);
				$customerDAO->update_new_customer_id($customer_id, $new_customer_id);

				// update customer id in order
				$checkoutDAO->update_new_customer_id($customer_id, $new_customer_id);
				
			}
		}
		echo json_encode("success");
	} catch (Exception $ex) {
        $db->rollback();
        // throw new Exception($ex);
        echo $ex;
    }
    $db->commit();
}