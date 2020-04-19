<?php

class ProductDAO
{
    private $conn;

    function get_max_id()
    {
        try {
            $sql = "select max(id) as max_id from smi_products";
            $result = mysqli_query($this->conn, $sql);
            $row = $result->fetch_assoc();
            $max_id = $row['max_id'];
            $max_id++;
            $data = array();
            array_push($data, $max_id);
            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function set_all_quantity_to_zero() {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_variations` SET `quantity`= 0");
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function count_all_product($status)
    {
        try {
            $sql = "SELECT count(tmp.id) AS total_products,
                           sum(tmp.total_price) AS total_money
                    FROM
                      (SELECT a.id,
                              a.price,
                              sum(b.quantity) AS quantity,
                              a.price * sum(b.quantity) AS total_price
                       FROM smi_products a
                       LEFT JOIN smi_variations b ON a.id = b.product_id
                       WHERE a.status = $status
                       GROUP BY a.id,
                                a.price) AS tmp";
            $result = mysqli_query($this->conn, $sql);
            $row = $result->fetch_assoc();
            $total_products = $row['total_products'];
            $total_money = number_format($row['total_money']);
            $data = array();
            array_push($data, $total_products);
            array_push($data, $total_money);
            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function get_data_print_barcode($skus)
    {
        try {
            $sql = "select 
                        A.name ,
                        B.sku,
                        A.retail,
                        B.quantity, 
                        case when B.size ='Free Size' then B.color else concat(B.size,'-',B.color) end as size
                    from 
                        smi_products A left join smi_variations B on A.id = B.product_id 
                    where 
                        B.sku in (" . $skus . ")
                    order by 
                        A.id, B.id, B.color, B.size";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $product = array(
                    'name' => $row["name"],
                    'sku' => $row["sku"],
                    'price' => number_format($row["retail"]),
                    'quantity' => $row["quantity"],
                    'size' => $row["size"]
                );
                array_push($data, $product);
            }
            // $arr = array();
            // $arr["results"] = $data;
            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_all_for_select2()
    {
        try {
            $sql = "select A.id as product_id,  
                        B.id as variation_id, 
                        concat(B.sku,'-',trim(A.name),'-',B.size,'-',B.color) as name, 
                        A.retail 
                    from smi_products A 
                        left join smi_variations B on A.id = B.product_id";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            $product = array(
                'product_id' => '',
                'id' => '-1',
                'text' => '',
                'price' => ''
            );
            array_push($data, $product);
            foreach ($result as $k => $row) {
                $product = array(
                    'product_id' => $row["product_id"],
                    'id' => $row["variation_id"],
                    'text' => $row["name"],
                    'price' => number_format($row["retail"])
                );
                array_push($data, $product);
            }
            $arr = array();
            $arr["results"] = $data;
            return $arr;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_by_id($id)
    {
        try {
            $sql = "select A.id AS product_id,
                           A.name,
                           A.image,
                           A.link,
                           A.price,
                           A.fee_transport,
                           A.profit,
                           A.retail,
                           A.percent,
                           A.type,
                           A.category_id,
                           B.id AS variant_id,
                           B.size,
                           B.color,
                           B.quantity,
                           B.sku,
                           B.image as 'image_variation',
                           A.description,
                           A.material,
                           A.origin,
                           A.short_description
                    FROM smi_products A
                    LEFT JOIN smi_variations B ON A.id = B.product_id
                    WHERE A.id = " . $id;
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            $product_id = 0;
            $i = 0;
            foreach ($result as $k => $row) {
                if ($product_id != $row["product_id"]) {
                    $product = array(
                        'product_id' => $row["product_id"],
                        'name' => $row["name"],
                        'image' => $row["image"],
                        'link' => $row["link"],
                        'type' => $row["type"],
                        'percent' => $row["percent"],
                        'category_id' => $row["category_id"],
                        'price' => number_format($row["price"]),
                        'fee_transport' => number_format($row["fee_transport"]),
                        'retail' => number_format($row["retail"]),
                        'profit' => number_format($row["profit"]),
                        'description' => $row["description"],
                        'material' => $row["material"],
                        'origin' => $row["origin"],
                        'short_description' => $row["short_description"],
                        'variations' => array()
                    );
                    $variation = array(
                        'id' => $row["variant_id"],
                        'size' => $row["size"],
                        'color' => $row["color"],
                        'quantity' => $row["quantity"],
                        'sku' => $row["sku"],
                        'product_id' => $row["product_id"],
                        'image' => $row["image_variation"]
                    );
                    array_push($product['variations'], $variation);
                    array_push($data, $product);
                    $product_id = $row["product_id"];
                    $i++;
                } else {
                    $variation = array(
                        'id' => $row["variant_id"],
                        'size' => $row["size"],
                        'color' => $row["color"],
                        'quantity' => $row["quantity"],
                        'sku' => $row["sku"],
                        'product_id' => $row["product_id"],
                        'image' => $row["image_variation"]
                    );
                    array_push($data[$i - 1]['variations'], $variation);
                }
            }
            $arr = array();
            $arr["data"] = $data;
            // print_r($arr);
            return $arr;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_all($status)
    {
        try {
            $sql = "select 
                        A.id as product_id, 
                        A.name , 
                        A.image , 
                        A.link , 
                        A.retail,
                        A.discount,
                        A.profit,
                        A.social_publish,
                        A.material,
                        A.origin,
                        A.short_description
                    from 
                        smi_products A
                    where
                        A.status = $status
                    order by A.created_at desc, A.id";
            $result = mysqli_query($this->conn, $sql);
//            print_r($this->getConn()->error);
            $data = array();
            foreach ($result as $k => $row) {
                $product = array(
                    'product_id' => $row["product_id"],
                    'name' => $row["name"],
                    'image' => $row["image"],
                    'link' => $row["link"],
                    'retail' => number_format($row["retail"]),
                    'discount' => $row["discount"],
                    'profit' => number_format($row["profit"]),
                    'social_publish' => $row["social_publish"],
                    'material' => $row["material"],
                    'origin' => $row["origin"],
                    'short_description' => $row["short_description"],
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

    function find_detail($productId)
    {
        try {
            $sql = "select 
                        A.id as product_id, 
                        B.id as variant_id,  
                        A.name , 
                        A.image , 
                        A.link , 
                        A.price, 
                        A.fee_transport,
                        A.retail,
                        A.profit,
                        A.short_description,
                        case 
                            when B.size = '3' then concat(B.size, 'm')
                            when B.size = '6' then concat(B.size, 'm')
                            when B.size = '9' then concat(B.size, 'm')
                            when B.size = '60' then concat(B.size, ' cm (3kg-6kg)')
                            when B.size = '73' then concat(B.size, ' cm (6kg-8kg)')
                            when B.size = '80' then concat(B.size, ' cm (8kg-10kg)')
                            when B.size = '90' then concat(B.size, ' cm (11kg-13kg)')
                            when B.size = '100' then concat(B.size, ' cm (14kg-16kg)')
                            when B.size = '110' then concat(B.size, ' cm (17kg-18kg)')
                            when B.size = '120' then concat(B.size, ' cm (19kg-20kg)')
                            when B.size = '130' then concat(B.size, ' cm (21kg-23kg)')
                            when B.size = '140' then concat(B.size, ' cm (24kg-27kg)')
                            when B.size = '150' then concat(B.size, ' cm (28kg-32kg)')
                            when B.size = '160' then concat(B.size, ' cm (33kg-40kg)')
                            else concat(B.size)
                        end as size, 
                        B.color, 
                        B.quantity, 
                        B.sku, 
                        A.created_at,
                        A.discount,
                        B.image as 'variation_image',
                        B.updated_qty
                    from 
                        smi_products A left join smi_variations B on A.id = B.product_id    
                    where B.product_id = $productId 
                    order by A.created_at desc, A.id, B.id, B.color, B.size";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            $product_id = 0;
            $i = 0;
            foreach ($result as $k => $row) {
                if ($product_id != $row["product_id"]) {
                    $product = array(
                        'product_id' => $row["product_id"],
                        'name' => $row["name"],
                        'image' => $row["image"],
                        'link' => $row["link"],
                        'price' => number_format($row["price"]),
                        'fee_transport' => number_format($row["fee_transport"]),
                        'retail' => number_format($row["retail"]),
                        'profit' => number_format($row["profit"]),
                        'discount' => $row["discount"],
                        'short_description' => $row["short_description"],
                        'created_at' => date_format(date_create($row["created_at"]), "d/m/Y"),
                        'variations' => array()
                    );
                    $variation = array(
                        'id' => $row["variant_id"],
                        'size' => $row["size"],
                        'color' => $row["color"],
                        'quantity' => $row["quantity"],
                        'sku' => $row["sku"],
                        'product_id' => $row["product_id"],
                        'image' => $row["variation_image"],
                        'updated_qty' => $row["updated_qty"]
                    );
                    array_push($product['variations'], $variation);
                    array_push($data, $product);
                    $product_id = $row["product_id"];
                    $i++;
                } else {
                    $variation = array(
                        'id' => $row["variant_id"],
                        'size' => $row["size"],
                        'color' => $row["color"],
                        'quantity' => $row["quantity"],
                        'sku' => $row["sku"],
                        'product_id' => $row["product_id"],
                        'image' => $row["variation_image"],
                      'updated_qty' => $row["updated_qty"]
                    );
                    array_push($data[$i - 1]['variations'], $variation);
                }
            }
            $arr = array();
            $arr["data"] = $data;
            // print_r($arr);
            return $arr;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function delete_product($product_id)
    {
        try {
            $stmt = $this->getConn()->prepare("delete from smi_products where id = ?");
            $stmt->bind_param("i", $product_id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception ($e->getMessage());
        }
    }

    function update_discount($discount, $product_id)
    {
        try {
            $stmt = $this->getConn()->prepare("update smi_products SET discount = ? where id = ?");
            $stmt->bind_param("ii", $discount, $product_id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_attr($product_id, $data, $type)
    {
        try {

            if($type == "material") {
                $sql = "update smi_products SET material = ? where id = ?";
            } else {
                $sql = "update smi_products SET origin = ? where id = ?";
            }
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bind_param("ii", $data, $product_id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_discount_all($discount)
    {
        try {
            $stmt = $this->getConn()->prepare("update smi_products SET discount = ?");
            $stmt->bind_param("i", $discount);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function check_stock($product_id)
    {
        try {
            $sql = "select count(*) as stock from smi_products a left join smi_variations b on a.id = b.product_id
                    where a.id = $product_id and b.quantity > 0";
            $result = mysqli_query($this->conn, $sql);
            $row = $result->fetch_assoc();
            $stock = $row['stock'];
            return $stock;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function count_out_of_stock()
    {
        try {
            $sql = "select count(*) as out_of_stock from smi_products where status = 1";
            $result = mysqli_query($this->conn, $sql);
            $row = $result->fetch_assoc();
            $stock = $row['out_of_stock'];
            return $stock;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_stock($status, $product_id)
    {
        try {
            $stmt = $this->getConn()->prepare("update smi_products SET status = ?, updated_at = NOW() where id = ?");
            $stmt->bind_param("ii", $status, $product_id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_variation(Variations $variation)
    {
        try {
            $sku = $variation->getSku();
            $color = $variation->getColor();
            $size = $variation->getSize();
            $qty = $variation->getQuantity();
            $image = $variation->getImage();
            $stmt = $this->getConn()->prepare("update smi_variations set color = ?, size = ?, quantity = ?, image = ? where sku = ?");
            $stmt->bind_param("ssiss", $color, $size, $qty, $image, $sku);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception("update_variation >> " . $e);
        }
    }

//    function delete_variation($sku)
//    {
//        try {
//            $stmt = $this->getConn()->prepare("delete from smi_variations where sku = ?");
//            $stmt->bind_param("s", $sku);
//            if(!$stmt->execute()) {
//                throw new Exception($stmt->error);
//            }
//            $stmt->close();
//        } catch (Exception $e) {
//            throw new Exception($e);
//        }
//    }

    function save_product(Product $product)
    {
        try {
            $name = $product->getName();
            $image = $product->getImage();
            $link = $product->getLink();
            $price = $product->getPrice();
            $fee = $product->getFee_transport();
            $profit = $product->getProfit();
            $retail = $product->getRetail();
            $percent = $product->getPercent();
            $type = $product->getType();
            $cat_id = $product->getCategory_id();
            $social_publish = '{"shopee": 0, "website": 0, "facebook": 0}';
            $description = $product->getDescription();
            $material = $product->getMaterial();
            $origin = $product->getOrigin();
            $short_description = $product->getShortDescription();
            $stmt = $this->getConn()->prepare("INSERT INTO smi_products (
                                `name`,
                                `image`,
                                `link`,
                                `price`,
                                `fee_transport`,
                                `profit`,
                                `retail`,
                                `percent`,
                                `type`,
                                `category_id`,
                                `social_publish`,
                                `description`,
                                `material`,
                                `origin`,
                                `short_description`,
                                `created_at`) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("sssddddiiisiis",
                                $name,
                                $image,
                                $link,
                                $price,
                                $fee,
                                $profit,
                                $retail,
                                $percent,
                                $type,
                                $cat_id,
                                $social_publish,
                                $description,
                                $material,
                                $origin,
                                $short_description);
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

    function update_product(Product $product)
    {
        try {
            $product_id = $product->getId();
            $name = $product->getName();
            $image = $product->getImage();
            $link = $product->getLink();
            $price = $product->getPrice();
            $fee = $product->getFee_transport();
            $profit = $product->getProfit();
            $retail = $product->getRetail();
            $percent = $product->getPercent();
            $type = $product->getType();
            $cat_id = $product->getCategory_id();
            $description = $product->getDescription();
            $material = $product->getMaterial();
            $origin = $product->getOrigin();
            $short_description = $product->getShortDescription();
            $stmt = $this->getConn()->prepare("update smi_products SET 
                name = ?, 
                image = ?, 
                LINK = ?,
                price = ?, 
                fee_transport = ?, 
                profit = ?, 
                retail = ?, 
                percent = ?, 
                TYPE = ?, 
                category_id = ?, 
                description = ?,
                material = ?, 
                origin = ?,  
                short_description = ?,
                updated_at = NOW() 
                WHERE id = ?");
            $stmt->bind_param("sssddddiiisiisi",
                $name,
                $image,
                $link,
                $price,
                $fee,
                $profit,
                $retail,
                $percent,
                $type,
                $cat_id,
                $description,
                $material,
                $origin,
                $short_description,
                $product_id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function save_variation(Variations $variation)
    {
        try {
            $product_id = $variation->getProduct_id();
            $size = $variation->getSize();
            $color = $variation->getColor();
            $qty = $variation->getQuantity();
            $sku = $variation->getSku();
            $updated_qty = '{"lazada": 0, "shopee": 0}';

            $stmt = $this->getConn()->prepare("INSERT INTO smi_variations (`product_id`, `size`, `color`, `quantity`, `sku`, `updated_qty`,`created_at`) VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ississ", $product_id, $size, $color, $qty, $sku, $updated_qty);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function find_by_sku($sku)
    {
        try {
            $sql = "select A.id as product_id, B.id as variant_id, A.name, A.retail, B.size, B.color, B.quantity, B.sku, A.discount, A.price 
                    from smi_products A left join smi_variations B on A.id = B.product_id 
                    where B.sku = " . $sku . "
                    order by A.id, B.id, B.color, B.size";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    $product = array(
                        'product_id' => $row["product_id"],
                        'variant_id' => $row["variant_id"],
                        'retail' => number_format($row["retail"]),
                        'name' => $row["name"],
                        'size' => $row["size"],
                        'color' => $row["color"],
                        'sku' => $row["sku"],
                        'discount' => $row["discount"],
                        'price' => number_format($row["price"])
                    );
                    array_push($data, $product);
                }
            }

            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

   /* function update_quantity_by_sku($sku, $qty)
    {
        try {
            $stmt = $this->getConn()->prepare("update smi_variations set quantity = (select case when quantity > 0 then quantity - $qty else 0 end from smi_variations where sku = $sku) where sku = $sku");
            $stmt->execute();
            $nrows = $stmt->affected_rows;
            if (!$nrows) {
                throw new Exception("Update Qty for variations has failure");
            }
        } catch (Exception $e) {
            throw new Exception("update_quantity_by_sku >> " . $e);
        }
    }*/

    function update_qty_variation_by_sku($sku, $qty = 1, $product_type = 0)
    {
        try {
            if($product_type == 1) {
                $stmt = $this->getConn()->prepare("update smi_variations a, (select case when a.quantity > 0 then a.quantity - $qty else 0 end as qty from smi_variations a where a.sku = $sku) b set a.quantity = b.qty where sku = $sku");
            } else {
                $stmt = $this->getConn()->prepare("update smi_variations set quantity = quantity + $qty where sku = ?");
                $stmt->bind_param("s", $sku);
            }
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_variation_by_product_id($product_id)
    {
        try {
            $sql = "select `id`, `product_id`, `size`, `color`, `quantity`, `sku`, `created_at`, `updated_at` from smi_variations where product_id = " . $product_id;
            $result = mysqli_query($this->conn, $sql);
            return $result;
        } catch (Exception $e) {
            throw new Exception("find_variation_by_product_id >> " . $e);
        }
    }

    function social_publish($product_id, $type, $status)
    {
      try {
          $stmt = $this->getConn()->prepare("update smi_products set social_publish = JSON_SET(social_publish, '$.".$type."', ?) where id = ?");
          $stmt->bind_param("ii", $status, $product_id);
          if(!$stmt->execute()) {
            print_r($this->getConn()->error);
            throw new Exception($stmt->error);
          }
          $stmt->close();
      } catch (Exception $e) {
        throw new Exception($e);
      }
    }

  function updated_qty($sku, $type, $status)
  {
      try {
          $stmt = $this->getConn()->prepare("update smi_variations set updated_qty = JSON_SET(updated_qty, '$.".$type."', ?) where sku = ?");
          $stmt->bind_param("ii", $status, $sku);
          if(!$stmt->execute()) {
            print_r($this->getConn()->error);
            throw new Exception($stmt->error);
          }
          $stmt->close();
      } catch (Exception $e) {
          throw new Exception($e);
      }
  }

//    function find_variation_by_sku($sku)
//    {
//        try {
//            $sql = "select `id`, `product_id`, `size`, `color`, `quantity`, `sku`, `created_at`, `updated_at` from smi_variations where sku = " . $sku;
//            $result = mysqli_query($this->conn, $sql);
//            return $result;
//        } catch (Exception $e) {
//            throw new Exception("find_variation_by_sku >> " . $e);
//        }
//    }
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
