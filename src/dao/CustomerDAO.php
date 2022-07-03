<?php

class CustomerDAO
{
    private $conn;

    function __construct($db) {
        $this->conn = $db->getConn();
    } 

    function findCustomerByPhone($phone) {
        try {
            $sql = "SELECT id,
                            name,
                            city_id,
                            district_id,
                            village_id,
                            address,
                            full_address,
                            facebook,
                            link_fb
                    FROM smi_customers
                    WHERE phone = '$phone'
                    LIMIT 1";
            $result = mysqli_query($this->conn, $sql);
            while ($obj = $result -> fetch_object()) {
                return $obj;
            }
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function save_customer(Customer $customer)
    {
        try {
            $avatar = $customer->getAvatar() ?? null;
            $name = $customer->getName();
            $phone = $customer->getPhone();
            $email = $customer->getEmail() ?? null;
            $facebook = $customer->getFacebook() ?? null;
            $linkFB = $customer->getLinkFb() ?? null;
            $birthday = $customer->getBirthday() ?? null;
            $address = $customer->getAddress();
            $village_id = $customer->getVillageId();
            $district_id = $customer->getDistrictId();
            $city_id = $customer->getCityId();
            $full_address = $customer->getFullAddress();
            if(empty($full_address)) {
                $full_address = $this->generate_full_address($city_id, $district_id, $village_id, $address);
            }
            if (!empty($birthday)) {
                $date = str_replace('/', '-', $birthday);
                $birthday = date('Y-m-d H:i:s', strtotime($date));
            } else {
                $birthday = null;
            }
            $stmt = $this->getConn()->prepare("insert into `smi_customers`
                    (`avatar`,`name`, `phone`, `email`,`facebook`,`link_fb`, `birthday`, `address`, `village_id`, `district_id`, `city_id`, `full_address`, `created_at`, `updated_at`)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->bind_param("ssssssssiiis", $avatar, $name, $phone, $email, $facebook, $linkFB, $birthday, $address, $village_id, $district_id, $city_id, $full_address);
            if (!$stmt->execute()) {
                echo $stmt->error;
                throw new Exception($stmt->error);
            }
            $stmt->close();
            $lastid = mysqli_insert_id($this->conn);
            return $lastid;
        } catch (Exception $e) {
            echo $e;
            throw new Exception($e);
        }
    }

    function update_customer(Customer $customer)
    {
        try {
            $id = $customer->getId();
            $avatar = $customer->getAvatar() ?? null;
            $name = $customer->getName();
            $phone = $customer->getPhone();
            $email = $customer->getEmail() ?? null;
            $facebook = $customer->getFacebook() ?? null;
            $linkFB = $customer->getLinkFb() ?? null;
            $birthday = $customer->getBirthday() ?? null;
            $address = $customer->getAddress();
            $village_id = $customer->getVillageId();
            $district_id = $customer->getDistrictId();
            $city_id = $customer->getCityId();
            $full_address = $customer->getFullAddress();
            if(empty($full_address)) {
                $full_address = $this->generate_full_address($city_id, $district_id, $village_id, $address);
            }
            if (!empty($birthday)) {
                $birthday = str_replace('/', '-', $birthday);
                $birthday = date('Y-m-d H:i:s', strtotime($birthday));
            } else {
                $birthday = null;
            }
            // $full_address = $this->generate_full_address($city_id, $district_id, $village_id, $address);
            $stmt = $this->getConn()->prepare("update `smi_customers` SET `name` = ?, `phone` = ?, `email` = ?, `address` = ?, `village_id` = ?, `district_id` = ?, `city_id` = ?, `full_address` = ?, `facebook` = ?, `avatar` = ?, `link_fb` = ?, `birthday` = ?, `updated_at` = NOW() WHERE `id` =  ?");
            $stmt->bind_param("ssssiiisssssi", $name, $phone, $email, $address, $village_id, $district_id, $city_id, $full_address, $facebook, $avatar, $linkFB, $birthday, $id);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_all($customer_id, $phone)
    {
        try {
            $sql = "select * from smi_customers where 1=1";
            if(!empty($customer_id)) {
                $sql .= " and id = $customer_id";
            }
            if(!empty($phone)) {
                $sql .= " and phone = '$phone'";
            }
            $sql .= " order by created_at desc";
//            echo $sql;
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $customer = array(
                    'id' => $row["id"],
                    'avatar' => $row["avatar"],
                    'name' => $row["name"],
                    'phone' => $row["phone"],
                    'email' => $row["email"],
                    'facebook' => $row["facebook"],
                    'link_fb' => $row["link_fb"],
                    'address' => $row["full_address"],
                    'birthday' => $row["birthday"] ? date_format(date_create($row["birthday"]), "d/m/Y") : '',
                    'purchased' => $row["purchased"],
                    'active' => $row["active"],
                    'is_add_zalo' => $row["is_add_zalo"],
                    'created_at' => date_format(date_create($row["created_at"]), "d/m/Y H:i:s"),
                );
                array_push($data, $customer);
            }
            $arr = array();
            $arr["data"] = $data;
            return $arr;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

//    function update_full_address($data)
//    {
//        try {
//            $stmt = null;
//            for($i=0; $i<count($data); $i++) {
//                $address = $data[$i]["address"];
//                $id = $data[$i]["id"];
//                $stmt = $this->getConn()->prepare("update `smi_customers` SET `full_address` = ? WHERE `id` =  ?");
//                $stmt->bind_param("si", $address, $id);
//                $exe = $stmt->execute();
//                if (!$exe) {
//                    throw new Exception($stmt->error);
//                }
//                $this->getConn()->commit();
//            }
//            if($stmt != null) {
//                $stmt->close();
//            }
//        } catch (Exception $e) {
//            $this->getConn()->rollback();
//            throw new Exception($e);
//        }
//    }

    function find_customers_for_suggestion()
    {
        try {
            $sql = "select id, name, phone from smi_customers where active = 1";
            $result = mysqli_query($this->conn, $sql);
            $data = array();

            foreach ($result as $k => $row) {
                $arr = array();
                $data["customer"] = array();
                $customer = array(
                    'id' => $row["id"],
                    'name' => $row["name"],
                    'phone' => $row["phone"]
                );
                $arr["customer"] = $customer;
                array_push($data, $arr);
            }
            $arr = array();
            $arr["customers"] = $data;
            return $arr;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function find_by_id($id)
    {
        try {
            $sql = "select * from smi_customers where id = $id";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $customer = array(
                    'id' => $row["id"],
                    'avatar' => $row["avatar"],
                    'name' => $row["name"],
                    'phone' => $row["phone"],
                    'email' => $row["email"],
                    'facebook' => $row["facebook"],
                    'link_fb' => $row["link_fb"],
                    'address' => $row["address"],
                    'full_address' => $row["address"],
                    'village_id' => $row["village_id"],
                    'district_id' => $row["district_id"],
                    'city_id' => $row["city_id"],
                    'birthday' => $row["birthday"] ? date_format(date_create($row["birthday"]), "d/m/Y") : ''
                );
                array_push($data, $customer);
            }
//      $arr = array();
//      $arr["data"] = $data;
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    

    function find_by_phone($phones)
    {
        try {
            $sql = "select * from smi_customers where phone in ($phones)";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $customer = array(
                    'id' => $row["id"],
                    'avatar' => $row["avatar"],
                    'name' => $row["name"],
                    'phone' => $row["phone"],
                    'email' => $row["email"],
                    'facebook' => $row["facebook"],
                    'link_fb' => $row["link_fb"],
                    'full_address' => $row["full_address"],
                    'address' => $row["address"],
                    'village_id' => $row["village_id"],
                    'district_id' => $row["district_id"],
                    'city_id' => $row["city_id"],
                    'birthday' => $row["birthday"] ? date_format(date_create($row["birthday"]), "d/m/Y") : ''
                );
                array_push($data, $customer);
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function generate_full_address($cityId, $districtId, $villageId, $address) {
        $data = array();
        $data["city_id"] = $cityId;
        $data["district_id"] = $districtId;
        $data["village_id"] = $villageId;
        $data["address"] = $address;
        return $this->get_address($data);
    }

    function get_address($row)
    {
        $zone = new Zone();
        $cityId = $row["city_id"];
        $cityName = $zone->get_name_city($cityId);
        $districtId = $row["district_id"];
        $districtName = $zone->get_name_district($districtId);
        $villageId = $row["village_id"];
        $villageName = $zone->get_name_village($villageId);
        if (!empty($row["address"])) {
            $address = $row["address"];
            if (!empty($villageName)) {
                $address .= ", " . $villageName;
                if (!empty($districtName)) {
                    $address .= ", " . $districtName;
                    if (!empty($cityName)) {
                        $address .= ", " . $cityName;
                        return $address;
                    }
                }
            }
        }
        return "";
    }

    function check_exist($value, $type)
    {
        try {
            $isExist = false;
            $where = '1=1';
            if ($type == 'phone') {
                $where .= " and phone = '$value' ";
            } else if ($type == 'email') {
                $where .= " and email = '$value' ";
            }
            $sql = "select count(*) as c from smi_customers where $where";
            $result = mysqli_query($this->conn, $sql);
            $count = 0;
            foreach ($result as $k => $row) {
                $count = $row["c"];
            }
            if ($count > 0) {
                $isExist = true;
            }
            return $isExist;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function find_customer($value, $type)
    {
        try {
            $where = '1=1';
            if ($type == 'phone') {
                $where .= " and phone = '$value' ";
            } else if ($type == 'email') {
                $where .= " and email = '$value' ";
            }
            
            $sql = "select * from smi_customers where $where limit 1";
            $result = mysqli_query($this->conn, $sql);
            while ($obj = $result -> fetch_object()) {
                return $obj;
            }
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function active_customer($id, $status)
    {
        try {
            $stmt = $this->getConn()->prepare("update smi_customers SET active = ? WHERE id = ?");
            $stmt->bind_param("ii", $status, $id);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
    function add_zalo($id, $status)
    {
        try {
            $stmt = $this->getConn()->prepare("update smi_customers SET is_add_zalo = ? WHERE id = ?");
            if($stmt) {
                $stmt->bind_param("ii", $status, $id);
                $result = $stmt->execute();
                if (!$result) {
                    throw new Exception($stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception($stmt->error);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
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
