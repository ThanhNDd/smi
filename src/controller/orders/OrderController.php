<?php
// require '../../common/WooAPI.php';
include("../../common/DBConnection.php");
include("../../dao/ProductDAO.php");
include("../../dao/CheckoutDAO.php");
include("../../dao/CustomerDAO.php");
include("../../common/cities/Zone.php");
include("../../model/Order/Order.php");
include("../../model/Order/OrderDetail.php");
include("../../model/Customer/Customer.php");
include("PrintReceiptOnline.php");

/**
* Construtor connect to API woocomerce
*/
// $api = new WooAPI();
// $woocommerce = $api->connect();

$db = new DBConnect();
$productDAO = new ProductDAO();
$productDAO->setConn($db->getConn());

$checkoutDAO = new CheckoutDAO();
$checkoutDAO->setConn($db->getConn());

$customerDAO = new CustomerDAO();
$customerDAO->setConn($db->getConn());

$zone = new Zone();

$print_receipt = new PrintReceiptOnline();
if(isset($_POST["method"]) && $_POST["method"]=="print_receipt")   {
    $order_id = $_POST["order_id"];
    try 
    {
        $receipt = $checkoutDAO->get_data_print_receipt($order_id);
		//echo json_encode($receipt);
        $filename = $print_receipt->print($receipt);
        $response_array['fileName'] = $filename;
        echo json_encode($response_array);
    } catch(Exception $ex)
    {
        throw new Exception($ex);
    }
}

if(isset($_POST["method"]) && $_POST["method"]=="get_info_total_checkout")   {
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    try 
    {
        $info_total = $checkoutDAO->get_info_total_checkout($start_date, $end_date);
        echo json_encode($info_total);
    } catch(Exception $ex)
    {
        throw new Exception($ex);
    }
}

if(isset($_POST["method"]) && $_POST["method"]=="delete_order")   {
    $order_id = $_POST["order_id"];
    try 
    {
        $checkoutDAO->delete_order($order_id);
		$repsonse =  "success";
		echo json_encode($repsonse);
    } catch(Exception $ex)
    {
        throw new Exception($ex);
    }
    
}

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
// if(isset($_GET["method"]) && $_GET["method"]=="find_all_order_by_date")   {
	
// 	try {
// 		$orders = $checkoutDAO->find_all_order_by_date();
// 		echo json_encode($orders);
// 	} catch(Exception $e)
// 	{
// 		throw new Exception($e);
// 	}
// }
if(isset($_GET["method"]) && $_GET["method"]=="find_all")   {
	$start_date = $_GET["start_date"];
	$end_date = $_GET["end_date"];
	try {
		$orders = $checkoutDAO->find_all($start_date, $end_date);
		echo json_encode($orders);
	} catch(Exception $e)
	{
		throw new Exception($e);
	}
}
if(isset($_GET["method"]) && $_GET["method"]=="get_order_detail_by_order_id")   {
	$order_id = $_GET["order_id"];
	try {
		$orders = $checkoutDAO->get_order_detail_by_order_id($order_id);
		echo json_encode($orders);
	} catch(Exception $e)
	{
		throw new Exception($e);
	}
}

if(isset($_POST["method"]) && $_POST["method"]=="find_product_by_sku")   {
	
	try {
		$sku = $_POST["sku"];
		$products = $productDAO->find_by_sku($sku);
		echo json_encode($products);
	} catch(Exception $e)
	{
		throw new Exception($e);
	}
}
if(isset($_POST["method"]) && $_POST["method"]=="find_products")   {
	try {
		$products = $productDAO->find_all_for_select2();
		echo json_encode($products);
	} catch(Exception $e)
	{
		throw new Exception($e);
	}
}

if(isset($_POST["orders"]) && $_POST["orders"]=="new")   {
	/**
	* Call api get all orders
	*/
	// $orders = $woocommerce->get('orders');
	try {
		$data = $_POST["data"];
		$data = json_decode($data);

		$customer = new Customer();
		$customer->setName($data->customerName);
		$customer->setPhone($data->phoneNumber);
		$customer->setEmail($data->email);
		$customer->setAddress($data->address);
		$customer->setCity_id($data->cityId);
		$customer->setDistrict_id($data->districtId);
		$customer->setVillage_id($data->villageId);
		$cusId = $customerDAO->save_customer($customer);
		if(empty($cusId))
		{
			throw new Exception("Insert customer is failure", 1);
		}

		$order = new Order();
		$order->setTotal_reduce(null);
		$order->setTotal_reduce_percent(null);
		$order->setDiscount($data->discount);
		$order->setTotal_amount($data->total_amount);
		$order->setTotal_checkout($data->total_checkout);
		$order->setCustomer_payment(null);
		$order->setRepay(null);
		$order->setCustomer_id($cusId);
		$order->setType(1); // online order
		$order->setBill_of_lading_no($data->bill_of_lading_no);
		$order->setShipping_fee($data->shipping_fee);
		$order->setShipping($data->shipping);
		$order->setShipping_unit($data->shipping_unit);
		$order->setStatus(1); // processing
		$order->setDeleted(0);
		$order->setPayment_type(1);// transfer type
		$orderId = $checkoutDAO->saveOrder($order);
		if(empty($orderId))
		{
			throw new Exception("Insert order is failure", 1);
		}
		$order->setId($orderId);
		$details = $data->products;
		for($i=0; $i<count($details); $i++)
		{
			$price = 0;
			$qty = 0;
			if(!empty($details[$i]->price))
			{
				$price = $details[$i]->price;
			}
			if(!empty($details[$i]->quantity))
			{
				$qty = $details[$i]->quantity;
			}
			$detail = new OrderDetail();
			$detail->setOrder_id($orderId);
			$detail->setProduct_id(empty($details[$i]->product_id) ? 0 : $details[$i]->product_id);
			$detail->setVariant_id(empty($details[$i]->variant_id) ? 0 : $details[$i]->variant_id);
			$detail->setSku(empty($details[$i]->sku) ? 0 : $details[$i]->sku);
			// $detail->setProduct_name(empty($details[$i]->product_name) ? "" : $details[$i]->product_name);
			$detail->setPrice(empty($details[$i]->price) ? 0 : $details[$i]->price);
			$detail->setQuantity(empty($details[$i]->quantity) ? 0 : $details[$i]->quantity);
			$detail->setReduce(empty($details[$i]->reduce) ? 0 : $details[$i]->reduce);
			$detail->setReduce_percent(empty($details[$i]->reduce_percent) ? 0 : $details[$i]->reduce_percent);
			$lastId = $checkoutDAO->saveOrderDetail($detail);    
			if(empty($lastId))
			{
				throw new Exception("Insert order detail is failure", 1);
			}
		}
		$repsonse =  "success";
		echo json_encode($repsonse);
	} catch(Exception $e)
	{
		throw new Exception($e);
	}
	
	

	//	create array to store order information
	// $arr = array();
	// $arr["payment_method"] = "cod";
	// $arr["payment_method_title"] = "Trả tiền mặt khi nhận hàng";
	// $arr["set_paid"] = true;

	// // create array to store shipping address and billing address
	// $address = array();
	// $address["first_name"] = $data->customerName;
	// $address["last_name"] = "";
	// $address["company"] = "";
	// $address["address_1"] = $data->add;
	// $address["state"] = $data->cityId;
	// $address["city"] = $data->districtId;
	// $address["address_2"] = $data->villageId;;
	// $address["postcode"] = "";
	// $address["country"] = "VN";

	// // asign shipping address
	// $arr["shipping"] = $address;

	// $address["email"] = $data->email;
	// $address["phone"] = $data->phoneNumber;
	
	// // asign billing address
	// $arr["billing"] = $address;
	
	// // create array to store products information
	// $arr_products = array();
	// $products = $data->products;
	// for($i=0; $i<count($products); $i++)
	// {
	// 	$prod = array();
	// 	$prod["product_id"] = (int) $products[$i]->prodId;
	// 	$prod["variation_id"] = (int) $products[$i]->variantId;
	// 	$prod["quantity"] = (int) $products[$i]->qty;
	// 	array_push($arr_products, $prod);
	// }
	// $arr["line_items"] = $arr_products;
	
	// $arr_shipping = array();
	// $shipping = array();
	// $shipping['method_id'] = 'flat_rate';
	// $shipping['method_title'] = 'Flat Rate';
	// $shipping['total'] = (int) $data->shipping;
	// array_push($arr_shipping, $shipping);
	// $arr["shipping_lines"] = $arr_shipping;
	
	// $reduce = (int) $data->reduce;
	// $reduce = 0 - $reduce;

	// $arr_fee = array();
	// $fee = array();
	// $fee['name'] = 'Phí';
	// $fee['amount'] = $reduce;
	// $fee['total'] = $reduce;
	// array_push($arr_fee, $fee);
	// $arr["fee_lines"] = $arr_fee;
	
	// $repsonse = $woocommerce->post('orders', $arr);
	// $repsonse =  "success";
	// echo json_encode($repsonse);
}

