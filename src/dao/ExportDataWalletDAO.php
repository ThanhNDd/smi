<?php

class ExportDataWalletDAO
{
    private $conn;

    const URI_API = "http://localhost:8000/api";

    function __construct($db) {
        $this->conn = $db->getConn();
    } 

    function getWalletData($orderId) {
        $wallet = $this->getWallettByOrderId($orderId);
        $walletData = [];
        if(!empty($wallet)) {
            $walletData = $this->getData($wallet);
        }
        return $walletData;
    }

    function getWallettByOrderId(&$walletData, $orderId)
    {
        try {
            $sql = "SELECT a.`customer_id`,
                           b.`phone`,
                           a.`order_id`,
                           a.`saved`,
                           a.`used`,
                           a.`repay`,
                           a.`remain`,
                           a.`order_deleted`
                    FROM `smi_wallet` a
                    LEFT JOIN smi_customers b ON a.customer_id = b.id 
                    WHERE a.`order_id` = $orderId and  a.`order_deleted` = 0";
            $result = mysqli_query($this->conn, $sql);
            if($result) {
                $row = $result->fetch_assoc();
                if(!empty($row)) {
                    $walletData["customer_id"] = $row["customer_id"];
                    $walletData["customer_phone"] = $row["phone"];
                    $walletData["order_id"] = $row["order_id"];
                    $walletData["customer_id"] = $row["customer_id"];
                    $walletData["customer_id"] = $row["customer_id"];
                    $walletData["customer_id"] = $row["customer_id"];
                    $walletData["customer_id"] = $row["customer_id"];
                    $walletData["customer_id"] = $row["customer_id"];
                    $walletData["customer_id"] = $row["customer_id"];
                }
                
            } else {
              throw new Exception("error");
            }
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function getData($customer) {
        $customerData = [];
        $customerData["customer_id"] = $customer["id"];
        $customerData["name"] = $customer["name"];
        $customerData["phone"] = $customer["phone"];
        $customerData["gender"] = "FEMALE";
        $customerData["email"] = $customer["email"];
        $customerData["facebook_name"] = $customer["facebook"];
        $customerData["facebook_link"] = $customer["link_fb"];
        $customerData["created_at"] = $customer["created_at"];
        $this->setChannelId($customerData, $customer["source_register"]);
        if(!empty($customer["full_address"]) && $customer["full_address"] != "Huyện Quốc Oai, Hà Nội") {
            $this->setAddressData($customerData, $customer);
        } else {
            $customerData["address_data"] = array();
        }
        return $customerData;
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

    function setChannelId(&$customerData, $source) {
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


    function getDataByIds($ids) {
        try {

            if(count($ids) == 0) {
                $sql = "SELECT * FROM `smi_customers` WHERE sync_date is null";
            } else {
                $customerIds = implode(",",$ids);
                $sql = "SELECT * FROM `smi_customers` WHERE id in ($customerIds)";
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

    function fetchData() {
        try {
            $sql = "SELECT `id`, `name`, `phone`, `full_address`, `source_register`, `sync_date`, `created_at` FROM `smi_customers` ORDER BY `created_at` DESC";
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

     function updateSyncDate($id) {

        try {
            $sql = "update smi_customers SET sync_date = NOW() WHERE id = $id";
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
        $url = ExportDataCustomersDAO::URI_API."/customer/customers";
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
        $url = ExportDataCustomersDAO::URI_API."/login";
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