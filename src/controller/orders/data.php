<?php

// require '../../common/WooAPI.php';
require '../../common/cities/Zone.php';

/**
* Construtor connect to API woocomerce
*/
// $api = new WooAPI();
// $woocommerce = $api->connect();

$zone = new Zone();

/**
*	get data to generate select2 combobox
*/
if(isset($_GET["orders"]) && $_GET["orders"]=="loadDataCity")   {
	echo $zone->get_list_city();
}

if(isset($_GET["orders"]) && $_GET["orders"]=="loadDataDistrict") {
	if(isset($_GET["cityId"])) {
		$cityId = $_GET["cityId"];
		echo $zone->get_list_district($cityId);
	} else {
		die();
	}
}
if(isset($_GET["orders"]) && $_GET["orders"]=="loadDataVillage") {
	if(isset($_GET["districtId"])) {
		$districtId = $_GET["districtId"];
		echo $zone->get_list_village($districtId);
	} else {
		die();
	}
}
/**
*	update data orders action
*/
if(isset($_GET["orders"]) && $_GET["orders"]=="update")   {
	/**
	* Call api get all orders
	*/
	// $orders = $woocommerce->get('orders');

	echo json_encode("");

	/**
	* Define array to store data
	*/
	$json_data = array();

	/**
	* Put data into json
	*/
	for($i=0; $i<count($orders); $i++)
	{
		// print_r(json_encode($orders[$i]));
		$products = array();
		$line_items = $orders[$i]->line_items;
		for($j=0; $j<count($line_items); $j++)
		{
			$product = array(
		        'product_id' => $line_items[$j]->product_id,
		        'variation_id' => $line_items[$j]->variation_id,
		        'name' => $line_items[$j]->name,
		        'quantity' => $line_items[$j]->quantity,
		        'price' => number_format($line_items[$j]->price),
		        'total' => number_format($line_items[$j]->total)
		    );
	        array_push($products, $product);
		}
		$date = date_create($orders[$i]->date_created);
		$order = array(
	        'order_id' => $orders[$i]->id,
	        'status' => $orders[$i]->status,
	        'total' => number_format($orders[$i]->total),
			'first_name' => $orders[$i]->billing->first_name,
			'last_name' => $orders[$i]->billing->last_name,
			'address' => $orders[$i]->billing->address_1,
			'city' => $zone->get_name_city($orders[$i]->billing->state),
			'district' => $zone->get_name_district($orders[$i]->billing->city),
			'village' => $zone->get_name_village($orders[$i]->billing->address_2),
			'email' => $orders[$i]->billing->email,
			'phone' => $orders[$i]->billing->phone,
	        'payment_method' => $orders[$i]->payment_method,
	        'payment_method_title' => $orders[$i]->payment_method_title,
	        'products' => $products,
	        'shipping' => $orders[$i]->shipping_lines != null ? number_format($orders[$i]->shipping_lines[0]->total) : 0,
	    	'date_created' => date_format($date,"d/m/Y H:i:s"),
	    	'fee' => $orders[$i]->fee_lines != null ? number_format($orders[$i]->fee_lines[0]->total) : 0
	    );
	    array_push($json_data, $order);
	}
	$arr = array();
	$arr["data"] = $json_data;
	// print_r(json_encode($arr));
	$contents = json_encode($arr, JSON_PRETTY_PRINT);
	file_put_contents("orders.json", "");
	file_put_contents("orders.json", $contents);
}


