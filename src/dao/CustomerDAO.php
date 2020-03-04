<?php

class CustomerDAO
{
    private $conn;

    function save_customer(Customer $customer)
    {
        try {
            $name = $customer->getName();
            $phone = $customer->getPhone();
            $email = $customer->getEmail();
            $address = $customer->getAddress();
            $village_id = $customer->getVillage_id();
            $district_id = $customer->getDistrict_id();
            $city_id = $customer->getCity_id();
            $stmt = $this->getConn()->prepare("insert into `smi_customers`
                    (`name`, `phone`, `email`, `address`, `village_id`, `district_id`, `city_id`, `created_at`)
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssssiii", $name, $phone, $email, $address, $village_id, $district_id, $city_id);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
            $lastid = mysqli_insert_id($this->conn);
            return $lastid;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_customer(Customer $customer)
    {
        try {
            $name = $customer->getName();
            $phone = $customer->getPhone();
            $email = $customer->getEmail();
            $address = $customer->getAddress();
            $village_id = $customer->getVillage_id();
            $district_id = $customer->getDistrict_id();
            $city_id = $customer->getCity_id();
            $id = $customer->getId();
            $stmt = $this->getConn()->prepare("update `smi_customers` SET `name` = ?, `phone` = ?, `email` = ?, `address` = ?, `village_id` = ?, `district_id` = ?, `city_id` = ?, `updated_at` = NOW() WHERE `id` =  ?");
            $stmt->bind_param("ssssiiii", $name, $phone, $email, $address, $village_id, $district_id, $city_id, $id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
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