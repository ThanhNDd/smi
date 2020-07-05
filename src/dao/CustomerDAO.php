<?php

class CustomerDAO
{
    private $conn;

    function save_customer(Customer $customer)
    {
        try {
            $avatar = $customer->getAvatar();
            $name = $customer->getName();
            $phone = $customer->getPhone();
            $email = $customer->getEmail();
            $facebook = $customer->getFacebook();
            $linkFB = $customer->getLinkFb();
            $birthday = $customer->getBirthday();
            $address = $customer->getAddress();
            $village_id = $customer->getVillageId();
            $district_id = $customer->getDistrictId();
            $city_id = $customer->getCityId();
            if(!empty($birthday)) {
              $date = str_replace('/', '-', $birthday);
              $birthday = date('Y-m-d H:i:s', strtotime($date));
            }
            $stmt = $this->getConn()->prepare("insert into `smi_customers`
                    (`avatar`,`name`, `phone`, `email`,`facebook`,`link_fb`, `birthday`, `address`, `village_id`, `district_id`, `city_id`, `created_at`, `updated_at`)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->bind_param("ssssssssiii", $avatar, $name, $phone, $email, $facebook, $linkFB, $birthday, $address, $village_id, $district_id, $city_id);
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
            $avatar = $customer->getAvatar();
            $name = $customer->getName();
            $phone = $customer->getPhone();
            $email = $customer->getEmail();
            $facebook = $customer->getFacebook();
            $linkFB = $customer->getLinkFb();
            $birthday = $customer->getBirthday();
            $address = $customer->getAddress();
            $village_id = $customer->getVillageId();
            $district_id = $customer->getDistrictId();
            $city_id = $customer->getCityId();
            $id = $customer->getId();
            if(!empty($birthday)) {
              $birthday = str_replace('/', '-', $birthday);
              $birthday = date('Y-m-d H:i:s', strtotime($birthday));
            } else {
              $birthday = null;
            }
            $stmt = $this->getConn()->prepare("update `smi_customers` SET `name` = ?, `phone` = ?, `email` = ?, `address` = ?, `village_id` = ?, `district_id` = ?, `city_id` = ?, `facebook` = ?, `avatar` = ?, `link_fb` = ?, `birthday` = ?, `updated_at` = NOW() WHERE `id` =  ?");
            $stmt->bind_param("ssssiiissssi", $name, $phone, $email, $address, $village_id, $district_id, $city_id, $facebook, $avatar, $linkFB, $birthday ,$id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

  function find_all()
  {
    try {
      $sql = "select * from smi_customers order by created_at desc";
      $result = mysqli_query($this->conn, $sql);
      $data = array();
      foreach ($result as $k => $row) {
        $address = $this->get_address($row);
        $customer = array(
          'id' => $row["id"],
          'avatar' => $row["avatar"],
          'name' => $row["name"],
          'phone' => $row["phone"],
          'email' => $row["email"],
          'facebook' => $row["facebook"],
          'link_fb' => $row["link_fb"],
          'address' => $address,
          'birthday' => $row["birthday"] ? date_format(date_create($row["birthday"]), "d/m/Y") : '',
          'purchased' => $row["purchased"],
          'active' => $row["active"],
          'created_at' => date_format(date_create($row["created_at"]), "d/m/Y"),
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
      if($type == 'phone') {
        $where .= " and phone = '$value' ";
      } else if($type == 'email') {
        $where .= " and email = '$value' ";
      }
      $sql = "select count(*) as c from smi_customers where $where";
//      var_dump($sql);
      $result = mysqli_query($this->conn, $sql);
      $count = 0;
      foreach ($result as $k => $row) {
        $count = $row["c"];
      }
      if($count > 0) {
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
            if($type == 'phone') {
                $where .= " and phone = '$value' ";
            } else if($type == 'email') {
                $where .= " and email = '$value' ";
            }
            $sql = "select * from smi_customers where $where limit 1";
            $result = mysqli_query($this->conn, $sql);
            while ($obj = mysqli_fetch_object($result, "Customer")) {
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
      $stmt->bind_param("ii",$status,$id);
      if(!$stmt->execute()) {
        throw new Exception($stmt->error);
      }
      $stmt->close();
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
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
