<?php

class CustomerDAO {
    private $conn;
    
    function save_customer(Customer $customer)
    {
    	try {
            $sql = "INSERT INTO `smi_customers`
                    (`name`,
                    `phone`,
                    `email`,
                    `address`,
                    `village_id`,
                    `district_id`,
                    `city_id`,
                    `created_at`)
                    VALUES
                    (".
                    $customer->getName().",".
                    $customer->getPhone().",".
                    $customer->getEmail().",".
                    $customer->getAddress().",".
                    $customer->getVillage_id().",".
                    $customer->getDistrict_id().",".
                    $customer->getCity_id().
                    ", NOW())";
                mysqli_query($this->conn,$sql); 
                $lastid = mysqli_insert_id($this->conn); 
                return $lastid;
        } catch(Exception $e)
        {
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