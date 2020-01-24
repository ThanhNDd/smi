<?php

class CheckDAO
{
    private $conn;

    function update_qty_variations()
    {
        try {
            $stmt = $this->getConn()->prepare("update smi_variations a
                INNER JOIN (SELECT sku, quantity FROM smi_check_detail) AS b ON a.sku = b.sku
                SET a.quantity = b.quantity");
            $stmt->execute();
            print_r($this->getConn()->error);
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function save_check(Check $check)
    {
        try {
            $status = $check->getStatus();
            $total_products = $check->getTotalProducts();
            $products_checked = $check->getProductsChecked();
            $total_money = $check->getTotalMoney();
            $money_checked = $check->getMoneyChecked();
            $finished_date = $check->getFinishedDate();
            $seq = $this->get_seq();

            $stmt = $this->getConn()->prepare("INSERT INTO `smi_check`
                (`seq`,
                `status`,
                `total_products`,
                `products_checked`,
                `start_date`,
                `finished_date`,
                `total_money`,
                `money_checked`,
                `created_date`)
                VALUES
                (?, ?, ?, ?, NOW(), ?, ?, ?, NOW())");
            $stmt->bind_param("iiiisdd", $seq, $status, $total_products, $products_checked, $finished_date, $total_money, $money_checked);
            $stmt->execute();
            print_r($this->getConn()->error);
            $nrows = $stmt->affected_rows;
            if (!$nrows) {
                throw new Exception("save_check has failure");
            }
            $lastid = mysqli_insert_id($this->conn);
            $data = array();
            $data["checkId"] = $lastid;
            $data["seq"] = $seq;
            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function get_seq() {
        try {
            $sql = "select (case when max(seq) is null then 1 else max(seq) + 1 end) as seq from smi_check";
            $result = mysqli_query($this->conn, $sql);
            $row = $result->fetch_assoc();
            $seq = $row['seq'];
            return $seq;
        } catch (Exception $e) {
            throw new Exception("get_seq >> " . $e);
        }
    }

    function save_check_detail(CheckDetail $checkDetail)
    {
        try {
            $check_id = $checkDetail->getCheckId();
            $seq = $checkDetail->getSeq();
            $product_id = $checkDetail->getProductId();
            $variation_id = $checkDetail->getVariationId();
            $sku = $checkDetail->getSku();
            $qty = $checkDetail->getQuantity();
            $size = $checkDetail->getSize();
            $color = $checkDetail->getColor();
            $name = $checkDetail->getName();
            $price = $checkDetail->getPrice();

            $stmt = $this->getConn()->prepare("INSERT INTO smi_check_detail (`check_id`,`seq`,`product_id`,`variation_id`,`sku`,`quantity`,`size`,`color`,`name`,`price`,`created_date`) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,NOW())");
            $stmt->bind_param("iiiisisssd", $check_id, $seq, $product_id, $variation_id, $sku, $qty, $size, $color, $name, $price);
            $stmt->execute();
            print_r($this->getConn()->error);
            $nrows = $stmt->affected_rows;
            if (!$nrows) {
                throw new Exception("save_check_detail has failure");
            }
            $lastid = mysqli_insert_id($this->conn);
            return $lastid;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_qty_by_sku($sku)
    {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_check_detail` SET `quantity` = `quantity` + 1 WHERE `sku` = ?");
            $stmt->bind_param("i", $sku);
            $stmt->execute();
            $nrows = $stmt->affected_rows;
            if (!$nrows) {
                throw new Exception("update_qty_by_sku has failure");
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_status($id, $status)
    {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_check` SET `status` = ? WHERE `id` = ?");
            $stmt->bind_param("ii", $id, $status);
            $stmt->execute();
            $nrows = $stmt->affected_rows;
            if (!$nrows) {
                throw new Exception("update_status has failure");
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function onchange_qty($sku, $qty, $seq)
    {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_check_detail` SET `quantity` = ? WHERE `seq` = ? and `sku` = ?");
            $stmt->bind_param("iis", $qty, $seq, $sku);
            $stmt->execute();

            $nrows = $stmt->affected_rows;
            if (!$nrows) {
                throw new Exception("onchange_qty has failure");
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function delete_product($seq, $sku)
    {
        try {
            $stmt = $this->getConn()->prepare("DELETE FROM `smi_check_detail` WHERE `seq` = ? and `sku` = ?");
            $stmt->bind_param("is", $seq, $sku);
            $stmt->execute();
            $nrows = $stmt->affected_rows;
            if (!$nrows) {
                throw new Exception("delete_product has failure");
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function checking_finish(Check $check)
    {
        $id = $check->getId();
        $status = $check->getStatus();
        $product_checked = $check->getProductsChecked();
        $money_checked = $check->getMoneyChecked();

        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_check`
                SET
                `status` = ?,
                `products_checked` = ?,
                `finished_date` = NOW(),
                `money_checked` = ?,
                `updated_date` = NOW()
                WHERE `id` = ?");
            $stmt->bind_param("iidi", $status, $product_checked, $money_checked, $id);
            $stmt->execute();
            print_r($this->getConn()->error);
            $nrows = $stmt->affected_rows;
            if (!$nrows) {
                throw new Exception("checking_finish has failure");
            }
            $this->update_qty_variations();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function is_exist_sku($sku)
    {
        try {
            $sql = "select count(*) as count from smi_check_detail where sku = $sku";
            $result = mysqli_query($this->conn, $sql);
            $row = $result->fetch_assoc();
            $count = $row['count'];
            return $count;
        } catch (Exception $e) {
            throw new Exception("find_variation_by_sku >> " . $e);
        }
    }

    function check_exists_checking()
    {
        try {
            $sql = "select count(*) as checking from smi_check where status = 0";
            $result = mysqli_query($this->conn, $sql);
            $row = $result->fetch_assoc();
            $checking = (int)$row['checking'];
            return $checking;
        } catch (Exception $e) {
            throw new Exception("check_exists_checking >> " . $e);
        }
    }

    function get_status($seq)
    {
        try {
            $sql = "select status from smi_check where seq = $seq";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $status = $row["status"];
                array_push($data, $status);
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception("check_exists_checking >> " . $e);
        }
    }

    function find_all()
    {
        try {
            $sql = "select * from smi_check";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $product = array(
                    'seq' => $row["seq"],
                    'id' => $row["id"],
                    'status' => $row["status"],
                    'total_products' => $row["total_products"],
                    'products_checked' => $row["products_checked"],
                    'start_date' => date_format(date_create($row["start_date"]), "d/m/Y"),
                    'finished_date' => date_format(date_create($row["finished_date"]), "d/m/Y"),
                    'total_money' => number_format($row["total_money"]),
                    'money_checked' => number_format($row["money_checked"]),
                    'created_date' => date_format(date_create($row["created_date"]), "d/m/Y"),
                    'updated_date' => date_format(date_create($row["updated_date"]), "d/m/Y")
                );
                array_push($data, $product);
            }
            $arr = array();
            $arr["data"] = $data;
            return $arr;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function find_detail($seq)
    {
        try {
            $sql = "select * from smi_check_detail where seq = $seq";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            if($result->num_rows > 0){
                foreach ($result as $k => $row) {
                    $check = array(
                        'id' => $row["id"],
                        'seq' => $row["seq"],
                        'check_id' => $row["check_id"],
                        'product_id' => $row["product_id"],
                        'variation_id' => $row["variation_id"],
                        'sku' => $row["sku"],
                        'quantity' => $row["quantity"],
                        'size' => $row["size"],
                        'color' => $row["color"],
                        'name' => $row["name"],
                        'price' => $row["price"],
                        'created_date' => date_format(date_create($row["created_date"]), "d/m/Y"),
                    );
                    array_push($data, $check);
                }
            }
            $arr = array();
            $arr["data"] = $data;
            return $arr;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
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
