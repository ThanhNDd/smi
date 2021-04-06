<?php

class CheckDAO
{
    private $conn;

    function reviews_check()
    {
      try {
        $sql = "SELECT c.id,
                       b.image,
                       c.name,
                       b.color,
                       b.size,
                       a.sku,
                       count(a.sku) AS qty,
                       b.price,
                       count(a.sku) * b.price AS total
                FROM `smi_check_tmp` a
                INNER JOIN smi_variations b ON a.sku = b.sku
                INNER JOIN smi_products c ON b.product_id = c.id
                GROUP BY a.sku
                ORDER BY a.id DESC";
        $result = mysqli_query($this->conn, $sql);
        $data = array();
        $total = 0;
        $total_product = 0;
        foreach ($result as $k => $row) {
          $product = array(
            'product_id' => $row["id"],
            'image' => $row["image"],
            'name' => $row["name"],
            'color' => $row["color"],
            'size' => $row["size"],
            'quantity' => $row["qty"],
            'sku' => $row["sku"],
            'price' => number_format($row["price"]),
            'total' => number_format($row["total"])
          );
          array_push($data, $product);
          $total += $row["total"];
          $total_product++;
        }
        $arr = array();
        $arr["data"] = $data;
        $arr["total"] = number_format($total);
        $arr["total_product"] = number_format($total_product);
        return $arr;
      } catch (Exception $e) {
        echo "Open connection database is error exception >> " . $e->getMessage();
      }
    }

    function checking_finish($seq, $data) {
      try {
        $this->create_backup_table_variations();
        $this->reset_quantity();
        $this->update_all_quantity_by_sku($data);
        $this->update_check($seq);

      } catch (Exception $e) {
        echo $e->getMessage();
      }
    }

    function update_check($seq) {
        $stmt = $this->getConn()->prepare("update smi_check a, (select sum(t.quantity) as qty, sum(t.amount) as amount from (
            select b.quantity, b.price * b.quantity as amount 
            from smi_products a left join smi_variations b on a.id = b.product_id
            where b.quantity > 0) as t) b set a.total_products = b.qty, a.total_money = b.amount, a.finished_date = NOW(), a.updated_date = NOW()
            where a.seq = ?");
        $stmt->bind_param("i", $seq);
        if(!$stmt->execute()) {
          throw new Exception($stmt->error);
        }
        $stmt->close();
    }

    function update_all_quantity_by_sku($data) {
        $d = json_decode($data, TRUE);
        $sku = "";
        $sql = "update `smi_variations` set `quantity` = CASE sku ";
        for($i=0; $i < count($d); $i++) {
          $sql .= " WHEN '".$d[$i]['sku']."' THEN '".$d[$i]['qty']."' \n";
          if($i == count($d) - 1) {
            $sku .= "'".$d[$i]['sku']."'";
          } else {
            $sku .= "'".$d[$i]['sku']."',";
          }
        }
        $sql .= " END WHERE sku in ($sku)";

        $stmt = $this->getConn()->prepare($sql);
        if(!$stmt->execute()) {
          throw new Exception($stmt->error);
        }
        $stmt->close();
    }

    function reset_quantity() {
        $stmt = $this->getConn()->prepare("update smi_variations set quantity = 0");
        if(!$stmt->execute()) {
          throw new Exception($stmt->error);
        }
        $stmt->close();
    }

    function create_backup_table_variations() {
        $table = "smi_variations_bk_".date("Ymdhi");
        $stmt = $this->getConn()->prepare("CREATE TABLE $table AS SELECT * FROM smi_variations");
        if(!$stmt->execute()) {
          throw new Exception($stmt->error);
        }
        $stmt->close();
    }

    function update_qty_variations()
    {
        try {
            $stmt = $this->getConn()->prepare("update smi_variations a
                INNER JOIN (SELECT sku, quantity FROM smi_check_detail) AS b ON a.sku = b.sku
                SET a.quantity = b.quantity");
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
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
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
            $lastid = mysqli_insert_id($this->conn);
            $data = array();
            $data["checkId"] = $lastid;
            $data["seq"] = $seq;
            return $data;
        } catch (Exception $e) {
            echo $e->getMessage();
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
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
            $lastid = mysqli_insert_id($this->conn);
            return $lastid;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function save_check_temp($sku)
    {
        try {
//            $skus = substr($skus, 1, -1);
//            $arr = explode(",", $skus);
            $sql = "INSERT INTO smi_check_tmp (`sku`) VALUES (?)";

//            for($i=0; $i<count($arr); $i++) {
//                if(!empty($arr[$i])) {
//                  if ($i < count($arr) - 1) {
//                    $sql .= "($arr[$i]),";
//                  } else {
//                    $sql .= "($arr[$i])";
//                  }
//                }
//            }
//            echo $sql;
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bind_param("s", $sku);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $lastid = mysqli_insert_id($this->conn);
            $stmt->close();
            return $lastid;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function update_qty_by_sku($sku)
    {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_check_detail` SET `quantity` = `quantity` + 1 WHERE `sku` = ?");
            $stmt->bind_param("i", $sku);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_status($id, $status)
    {
        $stmt = $this->getConn()->prepare("UPDATE `smi_check` SET `status` = ? WHERE `id` = ?");
        $stmt->bind_param("ii", $status, $id);
        if(!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $stmt->close();
    }

    function onchange_qty($sku, $qty, $seq)
    {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_check_detail` SET `quantity` = ? WHERE `seq` = ? and `sku` = ?");
            $stmt->bind_param("iis", $qty, $seq, $sku);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function delete_product($seq, $sku)
    {
        try {
            $stmt = $this->getConn()->prepare("DELETE FROM `smi_check_detail` WHERE `seq` = ? and `sku` = ?");
            $stmt->bind_param("is", $seq, $sku);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
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
            $sql = "select * from smi_check order by created_date desc";
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

    function find_detail()
    {
        try {
            $sql = "select * from smi_check_tmp";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            if($result){
                foreach ($result as $k => $row) {
                    $check = array(
                        'id' => $row["id"],
                        'sku' => $row["sku"]
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
