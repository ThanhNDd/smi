<?php

class PromotionDAO
{
    private $conn;

    function find_all()
    {
        try {
            $sql = "SELECT * FROM `smi_promotion`";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $promotion = array(
                    'id' => $row["promotion_id"],
                    'name' => $row["name"],
                    'start_date' => $row["start_date"],
                    'end_date' => $row["end_date"],
                    'is_active' => $row["is_active"],
                    'status' => $row["status"],
                    'created_date' => $row["created_date"]
                );
                array_push($data, $promotion);
            }
            $arr = array();
            $arr["data"] = $data;
            return $arr;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function find_detail($promotionId)
    {
        $sql = "SELECT A.id as promotion_id,
                       A.name AS promotion_name,
                       A.start_date,
                       A.end_date,
                       A.status,
                       A.created_date,
                       A.updated_date,
                       B.id as promotion_detail_id,
                       B.sku,
                       B.retail_price,
                       B.sale_price,
                       C.name AS product_name
                FROM smi_promotion A
                LEFT JOIN smi_promotion_detail B ON A.id = B.promotion_id
                INNER JOIN smi_products C ON B.product_id = C.id 
                where A.id = $promotionId";
        $result = mysqli_query($this->conn, $sql);
        if(!$result) {
            throw new Exception("cannot get promotion detail");
        }
        $promotion_detail = array();
        foreach ($result as $k => $row) {
            $detail = array(
                'promotion_id' => $row["promotion_id"],
                'promotion_name' => $row["promotion_name"],
                'start_date' => $row["start_date"],
                'end_date' => $row["end_date"],
                'status' => $row["status"],
                'created_date' => $row["created_date"],
                'updated_date' => $row["updated_date"],
                'promotion_detail_id' => $row["promotion_detail_id"],
                'sku' => $row["sku"],
                'retail_price' => $row["retail_price"],
                'sale_price' => $row["sale_price"],
                'product_name' => $row["product_name"]
            );
            array_push($promotion_detail, $detail);
        }
        $arr = array();
        $arr["data"] = $promotion_detail;
        return $arr;
    }



    function save_promotion(Promotion $promotion)
    {
        try {
            $name = $promotion->getName();
            $start_date = $promotion->getStartDate();
            $end_date = $promotion->getEndDate();
            $stmt = $this->getConn()->prepare("INSERT INTO smi_promotion (
                                `name`,
                                `start_date`,
                                `end_date`) 
                            VALUES (?, ?, ?)");
            $stmt->bind_param("sss",
                $name,
                $start_date,
                $end_date);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
            $lastid = mysqli_insert_id($this->conn);
            return $lastid;
        } catch (Exception $e) {
            echo $e;
        }
    }

    function update_promotion(Promotion $promotion)
    {
        $id = $promotion->getId();
        $name = $promotion->getName();
        $start_date = $promotion->getStartDate();
        $end_date = $promotion->getEndDate();
        $status = $promotion->getStatus();
        $stmt = $this->getConn()->prepare("update smi_promotion SET 
            `name` = ?,
            `start_date` = ?,
            `end_date` = ?,
            `status` = ?,
            `updated_date` = NOW() 
            WHERE `id` = ?");
        $stmt->bind_param("sssii",
            $name,
            $start_date,
            $end_date,
            $status,
            $id);
        if (!$stmt->execute()) {
            echo new Exception($stmt->error);
        }
        $stmt->close();
    }

    function save_promotion_detail(PromotionDetail $promotionDetail)
    {
        $promotion_id = $promotionDetail->getPromotionId();
        $product_id = $promotionDetail->getProductId();
        $variant_id = $promotionDetail->getVariantId();
        $sku = $promotionDetail->getSku();
        $retail_price = $promotionDetail->getRetailPrice();
        $sale_price = $promotionDetail->getSalePrice();
        $stmt = $this->getConn()->prepare("INSERT INTO `smi_promotion_detail`
                                            (`promotion_id`,
                                            `product_id`,
                                            `variant_id`,
                                            `sku`,
                                            `retail_price`,
                                            `sale_price`)
                                            VALUES
                                            ?,
                                            ?,
                                            ?,
                                            ?,
                                            ?,
                                            ?");
        $stmt->bind_param("iiisdd", $promotion_id, $product_id, $variant_id, $sku, $retail_price, $sale_price);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $stmt->close();
    }
    function delete_promotion_detail($promotion_id)
    {
        $stmt = $this->getConn()->prepare("delete from smi_promotion_detail where promotion_id = ?");
        $stmt->bind_param("i", $promotion_id);
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }
        $stmt->close();
    }

    function find_all_products()
    {
        try {
            $sql = "SELECT a.id,
                           json_value(JSON_EXTRACT(a.image, '$[0][0]'), '$.src') AS image,
                           a.name AS product_name,
                           MIN(b.retail) AS min_retail,
                           MAX(b.retail) AS max_retail,
                           sum(b.quantity) AS total_quantity,
                           json_value(a.social_publish, '$.website') AS website
                    FROM smi_products a
                    LEFT JOIN smi_variations b ON a.id = b.product_id
                    WHERE a.status = 0 AND JSON_CONTAINS(a.social_publish, 1, '$.website')
                    GROUP BY a.id
                    ORDER BY a.id DESC";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $product = array(
                    'product_id' => $row["id"],
                    'image' => $row["image"],
                    'product_name' => $row["product_name"],
                    'min_retail' => $row["min_retail"],
                    'max_retail' => $row["max_retail"],
                    'total_quantity' => $row["total_quantity"],
                    'website' => $row["website"]
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

    function find_variations_by_product_id($product_id)
    {
        try {
            $ids = implode(",",$product_id);
            $sql = "SELECT a.id,
                           a.image,
                           b.name,
                           a.sku,
                           a.size,
                           a.color,
                           a.price,
                           a.quantity
                    FROM smi_products b
                    LEFT JOIN smi_variations a ON b.id = a.product_id
                    WHERE b.id in ($ids)
                    ORDER BY b.id DESC";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $product = array(
                    'id' => $row["id"],
                    'image' => $row["image"],
                    'name' => $row["name"],
                    'sku' => $row["sku"],
                    'size' => $row["size"],
                    'color' => $row["color"],
                    'price' => $row["price"],
                    'quantity' => $row["quantity"]
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
