<?php

class CheckDAO {
    private $conn;

    function save_check(Check $check)
    {
    	try {
            $product_id = $check->getProductId();
            $variation_id = $check->getVariationId();
            $sku = $check->getSku();
            $qty = $check->getQuantity();
            $size = $check->getSize();
            $color = $check->getColor();
            $name = $check->getName();
            $price = $check->getPrice();

            $stmt = $this->getConn()->prepare("INSERT INTO smi_check (`product_id`,`variation_id`,`sku`,`quantity`,`size`,`color`,`name`,`price`,`created_date`) VALUES (?,?,?,?,?,?,?,?,NOW())");
            $stmt->bind_param("iiiisssd", $product_id, $variation_id, $sku, $qty, $size, $color, $name, $price);
            $stmt->execute();
            $nrows = $stmt->affected_rows;
            if(!$nrows) {
                throw new Exception("save_check has failure");
            }
            $lastid = mysqli_insert_id($this->conn); 
            return $lastid;
        } catch(Exception $e)
        {
            throw new Exception($e);
        }   
    }

    function save_result_check(ResultCheck $resultCheck)
    {
        try {
            $total_qty = $resultCheck->getTotalQty();
            $total_money = $resultCheck->getTotalMoney();

            $stmt = $this->getConn()->prepare("INSERT INTO smi_result_check (`total_qty`,`total_money`,`check_time`,`created_date`) VALUES (?,?,NOW(),NOW())");
            $stmt->bind_param("id", $total_qty, $total_money);
            $stmt->execute();
            $nrows = $stmt->affected_rows;
            if(!$nrows) {
                throw new Exception("save_check has failure");
            }
            $lastid = mysqli_insert_id($this->conn);
            return $lastid;
        } catch(Exception $e)
        {
            throw new Exception($e);
        }
    }

    function update_qty_by_sku($sku) {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_check` SET `quantity` = `quantity` + 1 WHERE `sku` = ?");
            $stmt->bind_param("i", $sku);
            $stmt->execute();
            $nrows = $stmt->affected_rows;
            if(!$nrows) {
                throw new Exception("update_qty_by_sku has failure");
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_qty_variations() {
        try {
            $stmt = $this->getConn()->prepare("update smi_variations a inner join smi_check b on a.sku = b.sku set a.quantity = b.quantity where a.sku = b.sku");
            $stmt->execute();
            $nrows = $stmt->affected_rows;
            if(!$nrows) {
                throw new Exception("update_qty has failure");
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function is_exist_sku($sku) {
        try {
            $sql = "select count(*) as 'count' from smi_check where sku = ".$sku;
            $result = mysqli_query($this->conn,$sql);
            $count = 0;
            while ($row = $result->fetch_assoc()) {
                 $count = $row["count"];
            }
            return $count;
        } catch(Exception $e)
        {
            throw new Exception("find_variation_by_sku >> ".$e);
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
