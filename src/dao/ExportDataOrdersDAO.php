<?php
require "../../common/cities/Zone.php";

class ExportDataOrdersDAO
{
    private $conn;

    const PATH_IMAGE = "https://banhang.shopmein.vn/dist/uploads/";
    const URI_API = "http://localhost:8000/api";

    const CHANNEL_STORE = 18;
    const CHANNEL_FACEBOOK = 2;
    const CHANNEL_SHOPEE = 5;
    const CHANNEL_LAZADA = 12;
    const CHANNEL_ZALO = 131;
    const CHANNEL_TIKI = 14;

    function __construct($db) {
        $this->conn = $db->getConn();
    } 

    function getData($order) {
        $orderData = [];
        $orderData["order_id"] = (int) $order["id"];
        $this->setCustomer($orderData, $order);
        $this->setProducts($orderData, $order);
        $this->setChannelId($orderData, $order);
        $this->setReceivingMethod($orderData, $order);
        $this->setStatusId($orderData, $order["status"]);
        $this->setShippingUnit($orderData, $order);
        $this->setWallet($orderData, $order);
        $this->setPaymentMethod($orderData, $order);


        $totalCheckout = (int) $order["total_amount"] - (int) $order["discount"] - (int) $orderData["used_wallet"] - (int) $orderData["total_discount_on_products"] + (int) $order["shipping"];
                      
        $orderData["order_date"] = $order["order_date"];
        $orderData["sub_total"] = (int) $order["total_amount"];
        $orderData["customer_payment"] = (int) $order["customer_payment"] == 0 ? (int) $order["total_checkout"] : (int) $order["customer_payment"];
        $orderData["total_checkout"] = $totalCheckout;
        $orderData["total_shop_received"] = (int) $orderData["total_checkout"] - (int) $order["shipping_fee"];
        $orderData["discount_value"] = $orderData["channel_id"] == ExportDataOrdersDAO::CHANNEL_FACEBOOK ? (int) $order["discount"] : null;
        $orderData["discount_price"] = $orderData["channel_id"] == ExportDataOrdersDAO::CHANNEL_FACEBOOK ? (int) $order["discount"] : null;
        $orderData["discount_type"] =  $orderData["channel_id"] == ExportDataOrdersDAO::CHANNEL_FACEBOOK ? "MONEY" : null;
        $orderData["total_discount"] = $orderData["channel_id"] == ExportDataOrdersDAO::CHANNEL_SHOPEE ? null : (int) $order["total_reduce"]; 
        $orderData["customer_shipping_fee"] = (int) $order["shipping"];
        $orderData["shipping_fee"] = (int) $order["shipping_fee"];
        $orderData["bill_of_lading_no"] = $order["bill_of_lading_no"];
        $orderData["transaction_fee"] = $orderData["channel_id"] == ExportDataOrdersDAO::CHANNEL_SHOPEE ? (int) $order["discount"] : null; 
        $orderData["repay_cash"] = (int) $order["repay"];
        $orderData["allow_accumulate"] = true;
        $orderData["order_type"] = (int) $order["type"] == 2 ? "RESIZE": "ADD_NEW";
        $orderData["note"] = null;
        $orderData["user_id"] = 5;
        $orderData["username"] = "shopmein";
        $orderData["order_id_exchange"] = (int) $order["order_refer"];
        $orderData["total_checkout_order_exchange"] = 0;
        $orderData["created_at"] = $order["created_date"];
         $this->setOrderLogs($orderData, $order["id"]);
        return $orderData;
    }

    function setOrderLogs(&$orderData, $orderId) {
        try {
            $orderLogs = array();
            $sql = "SELECT * FROM `smi_order_logs` WHERE `order_id` = $orderId";
            $result = mysqli_query($this->conn, $sql);
            if($result) {
                foreach ($result as $k => $row) {
                    $action = $row ? $row["action"] : null;
                    $actionType = "EDIT_ORDER";
                    if(!empty($action)) {
                        if(strpos($action, "Tạo mới") !== false) {
                            $actionType = "ADD_NEW_ORDER";
                        }
                    }
                    $logs = array();
                    $logs["order_id"] = $orderId;
                    $logs["action_type"] = $actionType;
                    $logs["action"] = $action;
                    $logs["created_by"] = $row ? $row["created_by"] : null;
                    $logs["created_at"] = $row ? $row["created_date"] : null;
                    array_push($orderLogs, $logs);
                }
            }
            $orderData["orderLogs"] = $orderLogs;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function setWallet(&$orderData, $order) {
        try {
            $customer_id = "";
            $customer_phone = "";
            if(!empty($orderData["customerData"])) {
                $customerData = $orderData["customerData"];
                $customer_id = $customerData["customer_id"];
                $customer_phone = $customerData["customer_phone"];
            }
            $used_wallet = 0;
            $walletData = array();
            $sql = "SELECT * FROM `smi_wallet` WHERE order_id = ".$order["id"];
            $result = mysqli_query($this->conn, $sql);
            if($result) {
                $row = $result->fetch_assoc();
                if(!empty($row)) {
                    $use_accumulated = (int)$order["discount"];
                    $remaining_balance = 0;
                    $transfer_to_wallet = 0;
                    $used_wallet = $row ? (int) $row["used"] : 0;
                    // $saved = $row ? (int) $row["saved"] : 0;
                    $money_accumulated = (int) $orderData["total_checkout_accumulated"] - (int) $used_wallet;
                    $money_accumulated = round(($money_accumulated * 5)/100);
                    $remaining_accumulate = $money_accumulated - $use_accumulated;

                    $walletData["customer_id"] = $customer_id;
                    $walletData["customer_phone"] = $customer_phone;
                    $walletData["previous_period_balance"] = $used_wallet;
                    $walletData["used_wallet"] = $used_wallet;
                    $walletData["remaining_balance"] = $remaining_balance;
                    $walletData["money_accumulated"] = $money_accumulated;
                    $walletData["use_accumulated"] = $use_accumulated;
                    $walletData["remaining_accumulate"] = $remaining_accumulate;
                    $walletData["transfer_to_wallet"] = $transfer_to_wallet;
                    $walletData["transaction_type"] = "ACCUMULATED";
                    $walletData["available_balances"] = (int) $remaining_balance + $remaining_accumulate + $transfer_to_wallet;
                }
            }
            $orderData["walletData"] = $walletData;
            $orderData["used_wallet"] = $used_wallet;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function setProducts(&$orderData, $order)
    {
        $total_profit = 0;
        $totalQuantity = 0;
        $products = array();
        $total_discount_on_products = 0;
        $total_checkout_accumulated = 0;

        $details = $this->getOrderDetails($order["id"]);
        foreach ($details as $key => $d) {
            $subTotal = ((int)$d["price"] - (int)$d["reduce"]) * (int)$d["quantity"];

            $product = array();
            $product["product_id"] = (int) $d["product_id"];
            $product["variant_id"] = (int) $d["variant_id"];
            $product["sku"] = $d["sku"];
            $product["name"] = $d["name"];
            $product["image"] = $d["image"];
            $product["classify"] = $d["classify"];
            $product["quantity"] = (int) $d["quantity"];
            $product["price"] = (int) $d["price"];
            $product["profit"] = (int) $d["profit"];
            $product["discount_price"] = (int) $d["reduce"];
            $product["discount_value"] = (int) $d["reduce"];
            $product["discount_type"] = "MONEY";
            $product["sub_total"] = $subTotal;
            $product["accumulate_points"] = true;
            $product["product_type"] = $this->getProductType($d["type"]);
            array_push($products, $product);

            $total_profit += (int) $d["profit"];
            $totalQuantity += (int) $d["quantity"];
            $total_discount_on_products += (int) $d["reduce"];

            $total_checkout_accumulated += $subTotal;
        }

        // $total_checkout_accumulated -= (int)$order["discount"];
        $orderData["products"] = $products;
        $orderData["total_checkout_accumulated"] = $total_checkout_accumulated;
        $orderData["total_profit"] = $total_profit - (int) $order["total_reduce"] - (int) $order["shipping_fee"];
        $orderData["quantity"] = $totalQuantity;
        $orderData["total_discount_on_products"] = $total_discount_on_products;
    }

    function getProductType($productType) {
        switch($productType) {
            case "0": 
                return "ADD_NEW";
            case "1": 
                return "RESIZE";
            case "2": 
                return "ADD_NEW";
            case "3": 
                return "RETURN";   
            default:
                return "ADD_NEW";   
        }
    }

    function getOrderDetails($orderId) {
        try {
            $data = array();
            $sql = "SELECT a.`order_id`,
                           a.`product_id`,
                           a.`variant_id`,
                           a.`sku`,
                           a.`price`,
                           a.`quantity`,
                           a.`reduce`,
                           a.`type`,
                           a.`profit`,
                           a.`reduce_type`,
                           b.name,
                           c.image,
                           c.image_type,
                           CONCAT(c.color, ',', c.size) AS classify
                    FROM `smi_order_detail` a
                    LEFT JOIN smi_products b ON a.product_id = b.id
                    LEFT JOIN smi_variations c ON a.sku = c.sku
                    WHERE a.order_id = $orderId";
            $result = mysqli_query($this->conn, $sql);
            if($result) {
                foreach ($result as $k => $row) {
                    array_push($data, $row);
                }
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function setShippingUnit(&$orderData, $order) {
        switch($order["shipping_unit"]) {
            case "J&T":
                $orderData["shipping_unit_id"] = 2;//J&T Express
                break;
            case "SPXEXPRESS":
                $orderData["shipping_unit_id"] = 8;//SHOPEE Express
                break;
            case "NINJAVAN":
                $orderData["shipping_unit_id"] = 6;//Ninja Van
                break;
            case "GHN":
                $orderData["shipping_unit_id"] = 5;//Giao Hàng Nhanh
                break;
            case "LEX":
                $orderData["shipping_unit_id"] = 9;//Lazada (LEX)
                break;
            case "TED":
                $orderData["shipping_unit_id"] = 10;//Tiki (TED)
                break;
            case "VTP":
                $orderData["shipping_unit_id"] = 1;//Viettel Post
                break;
            case "GHTK":
                $orderData["shipping_unit_id"] = 4;//Giao Hàng Tiết Kiệm
                break;
            case "VNP":
                $orderData["shipping_unit_id"] = 3;//Việt Nam Post
                break;
            case "VNPN":
                $orderData["shipping_unit_id"] = 3;//Việt Nam Post Nhanh
                break;
            case "BESTEXPRESS":
                $orderData["shipping_unit_id"] = 7;//BEST Express
                break;
            default:
                $orderData["shipping_unit_id"] = "";
                break;
        }
    }

    function setPaymentMethod(&$orderData, $order) {
        // if($order["payment_type"] == "0") {
        //     //CASH
        //     $orderData["payment_method"] = "CASH";
        // } else if($order["payment_type"] == "1") {
        //     //TRANSFER
        //     $orderData["payment_method"] = "TRANSFER";
        // } else if($order["payment_type"] == "2") {
        //     //DEBT
        //     $orderData["payment_method"] = "DEBT";
        // }
        if($order["source"] == "0") {
            $orderData["payment_method"] = "CASH";
        } else  {
            $orderData["payment_method"] = "TRANSFER";
        }
    }

    function setStatusId(&$orderData, $status) {
        switch ($status) {
            case '0' :
                //Chờ tạo đơn
                $orderData["order_status_id"] = 1;
                break;
            case '1':
                $orderData["order_status_id"] = 2;//Đã gói hàng, sẵn sàng giao
                break;
            case '2':
                $orderData["order_status_id"] =  3;//Đã giao
                break;
            case '3':
                $orderData["order_status_id"] =  11;//Hoàn thành
                break;
            case '4':
                $orderData["order_status_id"] =  8;//Đổi size
                break;
            case '5':
                $orderData["order_status_id"] =  10;//Đã chuyển hoàn
                break;
            case '6':
                $orderData["order_status_id"] =  12;//Hủy
                break;
            case '7':
                $orderData["order_status_id"] =  4;//Giao hàng sau
                break;
            case '8':
                $orderData["order_status_id"] =  5;//Đợi hàng về
                break;
            // case '9':
            //     return 15;//Chờ duyệt hoàn
            // case '10':
            //     return '<span class="badge badge-secondary" style="font-weight: normal;">Đã duyệt hoàn</span>';
            // case '11':
            //     return '<span class="badge badge-danger" style="font-weight: normal;">Chờ đổi size</span>';
            // case '12':
            //     return '<span class="badge badge-danger" style="font-weight: normal;">Đã đổi size</span>';
            case '13':
                $orderData["order_status_id"] =  6;//Đã tạo đơn
                break;
            default:
                $orderData["order_status_id"] =  '';
                break;
        }
    }

    function setChannelId(&$orderData, $order) {
        if($order["source"] == "0") {
            $orderData["channel_id"] = ExportDataOrdersDAO::CHANNEL_STORE;
        } else if($order["source"] == "2" || $order["source"] == "4") {
            $orderData["channel_id"] = ExportDataOrdersDAO::CHANNEL_FACEBOOK;
        }else if($order["source"] == "5") {
            $orderData["channel_id"] = ExportDataOrdersDAO::CHANNEL_LAZADA;
        } else if($order["source"] == "6") {
            $orderData["channel_id"] = ExportDataOrdersDAO::CHANNEL_ZALO;
        } else if($order["source"] == "7") {
            $orderData["channel_id"] = ExportDataOrdersDAO::CHANNEL_TIKI;
        } else {
            $orderData["channel_id"] = ExportDataOrdersDAO::CHANNEL_STORE;
        }
    }

    function setReceivingMethod(&$orderData, $order) {
        if($order["source"] == "0") {
            //SHOP
            $orderData["receiving_method"] = "DIRECT";
        } else  {
            $orderData["receiving_method"] = "DELIVERY";
        } 
    }

    function setCustomer(&$orderData, $order) {
        try {
            $row = null;
            $customerData = array();
            $customer_id = $order["customer_id"];
            if(!empty($customer_id)) {
                $sql = "SELECT * FROM `smi_customers` WHERE id = $customer_id";
                $result = mysqli_query($this->conn, $sql);
                if($result) {
                    $row = $result->fetch_assoc();
                    if(!empty($row)) {
                        $customerData["customer_id"] = $row ? (int) $row["id"] : null;
                        $customerData["customer_phone"] = $row ? $row["phone"] : null;
                        $customerData["customer_name"] = $row ? $row["name"] : null;
                        $customerData["customer_gender"] = "FEMALE";
                        $customerData["customer_email"] = null;
                        $customerData["customer_facebook_name"] = $row ? $row["facebook"] : null;
                        $customerData["customer_facebook_link"] = $row ? $row["link_fb"] : null;
                        $customerData["customer_created_at"] = $row ? $row["created_at"] : null;
                        $this->setCustomerChannelId($customerData, $row["source_register"]);
                        if(!empty($row["full_address"]) && $row["full_address"] != "Huyện Quốc Oai, Hà Nội") {
                            $this->setAddressData($customerData, $row);
                        } else {
                            $customerData["address_data"] = array();
                        }
                        $customerData["customer_address"] = $row ? $row["full_address"] : null;
                        $customerData["customer_id_other"] = null;
                        $customerData["customer_phone_other"] = null;
                        $customerData["customer_name_other"] = null;
                        $customerData["customer_address_other"] = null;
                    }
                }
            }
            $orderData["customerData"] = $customerData;
            $orderData["customer_id"] = $row ? (int) $row["id"] : null;
            $orderData["customer_phone"] = $row ? $row["phone"] : null;
            $orderData["customer_name"] = $row ? $row["name"] : null;
            $orderData["customer_address"] = $row ? $row["full_address"] : null;
            $orderData["customer_id_other"] = null;
            $orderData["customer_phone_other"] = null;
            $orderData["customer_name_other"] = null;
            $orderData["customer_address_other"] = null;

        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function setAddressData(&$customerData, $customer) {
      $zone = new Zone();
      $cityName = $zone->get_name_city($customer["city_id"]);
      $districtName = $zone->get_name_district($customer["district_id"]);
      $wardName = $zone->get_name_village($customer["village_id"]);

      $address = [];
      $address["phone"] = $customer["phone"];
      $address["full_address"] = $customer["full_address"];
      $address["city_id"] =  $customer["city_id"];
      $address["city_name"] =  $cityName;
      $address["district_id"] =  $customer["district_id"];
      $address["district_name"] =  $districtName;
      $address["ward_id"] =  $customer["village_id"];
      $address["ward_name"] =  $wardName;
      $address["address"] =  $customer["address"];
      $address["set_default"] =  true;
      $customerData["address_data"] = array();
      array_push($customerData["address_data"], $address);
    }

    function setCustomerChannelId(&$customerData, $source) {
      switch($source) {
        case "0":
          $customerData["channel_id"] = 18;//SHOP
          break;
        case "1":
          $customerData["channel_id"] = 2;//FACEBOOK
          break;
        default:
          $customerData["channel_id"] = 18;
          break;
      }
    }


    function getOrders($ids) {
        try {

            if(count($ids) == 0) {
                $sql = "SELECT * FROM `smi_orders` WHERE sync_date is null and deleted = false ORDER BY created_date DESC LIMIT 0,50";
            } else {
                $orderIds = implode(",",$ids);
                $sql = "SELECT * FROM `smi_orders` WHERE id in ($orderIds)";
            }
            $result = mysqli_query($this->conn, $sql);
            if($result) {
                $data = array();
                foreach ($result as $k => $row) {
                    array_push($data, $row);
                }
                return $data;
            } else {
              throw new Exception("error");
            }
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function fetchOrders() {
        try {
            $sql = "SELECT `id` as order_id, `customer_id`, `order_date`,`source`, `status`,`sync_date` FROM `smi_orders` WHERE deleted = 0 ORDER BY order_date DESC";
            $result = mysqli_query($this->conn, $sql);
            if($result) {
                $data = array();
                foreach ($result as $k => $row) {
                    array_push($data, $row);
                }
                return $data;
            } else {
              throw new Exception("error");
            }
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

     function updateSyncDate($orderId) {

        try {
            $sql = "update smi_orders SET sync_date = NOW() WHERE id = $orderId";
            $stmt = $this->getConn()->prepare($sql);
            $result = $stmt->execute();
            if(!$result) { 
                throw new Exception($stmt->error);
            }
            $stmt->close();
            return $result;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function store($token, $postData)
    {
        $url = ExportDataOrdersDAO::URI_API."/orders";
        $curl = curl_init($url);
        curl_setopt_array($curl, array( 
          CURLOPT_POST => TRUE,
          CURLOPT_RETURNTRANSFER => TRUE,
          CURLOPT_HTTPHEADER => array(
              'Authorization: Bearer '.$token,
              'Content-Type: application/json'
          ),
          CURLOPT_POSTFIELDS => json_encode($postData)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    function getToken()
    {
        $postdata = array(
            'username' => 'shopmein',
            'password' => 'In@682018'
        );
        $url = ExportDataOrdersDAO::URI_API."/login";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if(!empty($json_response)) {
            $response = json_decode($json_response);
            return $response->token;
        }
        return null;
    }

    /**
     * Get the value of conn
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * Set the value of conn
     *
     * @return  self
     */
    public function setConn($conn)
    {
        $this->conn = $conn;

        return $this;
    }

}