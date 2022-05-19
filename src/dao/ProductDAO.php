<?php

class ProductDAO
{
    private $conn;

    function __construct($db) {
        $this->conn = $db->getConn();
    } 

    // function findVariantBySku($sku)
    // {
    //     try {
    //         $sql = "SELECT id AS variant_id,
    //                        product_id,
    //                        retail,
    //                        size,
    //                        color,
    //                        sku,
    //                        profit
    //                 FROM smi_variations
    //                 WHERE sku = $sku";
    //         $result = mysqli_query($this->conn, $sql);
    //         $product = null;
    //         if (!empty($result)) {
    //             foreach ($result as $k => $row) {
    //                 $product = array(
    //                     'product_id' => $row["product_id"],
    //                     'variant_id' => $row["variant_id"],
    //                     'price' => $row["retail"],
    //                     'size' => $row["size"],
    //                     'color' => $row["color"],
    //                     'sku' => $row["sku"],
    //                     'profit' => $row["profit"]
    //                 );
    //             }
    //         }
    //         return $product;
    //     } catch (Exception $e) {
    //         echo "Open connection database is error exception >> " . $e->getMessage();
    //     }
    // }

    

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
           $sql = "SELECT sum(t.quantity) AS total_products,
                       sum(t.total) AS total_money
                    FROM
                      (SELECT a.id,
                              a.name,
                              b.quantity,
                              b.price,
                              b.quantity *b.price AS total
                       FROM smi_products a
                       LEFT JOIN smi_variations b ON a.id = b.product_id
                       WHERE a.status = 0
                         AND b.quantity >0) AS t";
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
                        B.retail,
                        B.size,
                        B.color
                    from 
                        smi_products A left join smi_variations B on A.id = B.product_id 
                    where 
                        B.sku in (" . $skus . ")
                    order by 
                        A.id desc, B.sku";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $product = array(
                    'name' => $row["name"],
                    'sku' => $row["sku"],
                    'price' => number_format($row["retail"]),
                    'size' => $row["size"],
                    'color' => $row["color"]
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
                           A.name_for_website,
                           A.image,
                           A.link,
                           A.fee_transport,
                           A.type,
                           A.category_id,
                           A.description,
                           A.material,
                           A.origin,
                           A.short_description,
                           B.id AS variant_id,
                           B.size,
                           B.color,
                           B.quantity,
                           B.sku,
                           B.image as 'image_variation',
                           B.price,
                           B.profit,
                           B.retail,
                           B.percent,
                           B.fee,
                           B.length__,
                           B.weight,
                           B.height,
                           B.age
                    FROM smi_products A
                    LEFT JOIN smi_variations B ON A.id = B.product_id
                    WHERE A.id = " . $id;
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            $product_id = 0;
            $i = 0;
            $colors = array();
            $sizes = array();
            $image_variation = array();
            foreach ($result as $k => $row) {
                if ($product_id != $row["product_id"]) {
                    $product = array(
                        'product_id' => $row["product_id"],
                        'name' => $row["name"],
                        'name_for_website' => $row["name_for_website"],
                        'image' => $row["image"],
                        'link' => $row["link"],
                        'type' => $row["type"],
                        'category_id' => $row["category_id"],
                        'fee_transport' => number_format($row["fee_transport"]),
                        'description' => $row["description"],
                        'material' => $row["material"],
                        'origin' => $row["origin"],
                        'short_description' => $row["short_description"],
                        'sizes' => array(),
                        'colors' => array(),
                        'image_variation' => array(),
                        'variations' => array()
                    );
                    $variation = array(
                        'id' => $row["variant_id"],
                        'size' => $row["size"],
                        'color' => $row["color"],
                        'quantity' => $row["quantity"],
                        'sku' => $row["sku"],
                        'product_id' => $row["product_id"],
                        'image' => $row["image_variation"],
                        'percent' => $row["percent"],
                        'price' => number_format($row["price"]),
                        'retail' => number_format($row["retail"]),
                        'profit' => number_format($row["profit"]),
                        'fee' => number_format($row["fee"]),
                        'length__' => $row["length__"],
                        'weight' => $row["weight"],
                        'height' => $row["height"],
                        'age' => $row["age"]
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
                        'image' => $row["image_variation"],
                        'percent' => $row["percent"],
                        'price' => number_format($row["price"]),
                        'retail' => number_format($row["retail"]),
                        'profit' => number_format($row["profit"]),
                        'fee' => number_format($row["fee"]),
                        'length__' => $row["length__"],
                        'weight' => $row["weight"],
                        'height' => $row["height"],
                        'age' => $row["age"]
                    );
                    array_push($data[$i - 1]['variations'], $variation);
                }
                array_push($colors, $row["color"]);
                array_push($sizes, $row["size"]);
                array_push($image_variation, $row["image_variation"]);
            }
            $data[0]["sizes"] = array_values(array_unique($sizes));
            $data[0]["colors"] = array_values(array_unique($colors));
            $data[0]["image_variation"] = array_values(array_unique($image_variation));
            $arr = array();
            $arr["data"] = $data;
//             print_r($arr);
            return $arr;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_all($status, $operator, $qty, $sku)
    {
        try {
            $sql = "SELECT A.id as product_id, 
                           A.name,
                           A.name_for_website,
                           A.image,
                           B.image as variant_image, 
                           A.link, 
                           MAX(B.retail) as max_retail,
                           MIN(B.retail) as min_retail,
                            A.discount,
                            MAX(B.profit) as max_profit,
                            MIN(B.profit) as min_profit,
                            A.social_publish,
                            A.material,
                            A.origin,
                            A.short_description,
                            A.category_id,
                            A.type,
                            sum(B.quantity) as total_quantity
                    FROM `smi_products` A
                    LEFT JOIN smi_variations B ON A.id = B.product_id
                    where A.status = $status";
            if(!empty($sku)) {
                $sql .= "  and B.sku = $sku";
            }
            $sql .= " GROUP BY A.id,
                             A.name,
                             A.name_for_website,
                             A.image , 
                             A.link , 
                             A.discount,
                              A.profit,
                              A.social_publish,
                              A.material,
                              A.origin,
                              A.short_description,
                              A.category_id,
                              A.type";
            if(!empty($qty) && !empty($operator)) {
                if($operator == "=") {
                    $sql .= " ,B.product_id having sum(B.quantity) = $qty";
                } else if($operator == ">") {
                    $sql .= " ,B.product_id having sum(B.quantity) > $qty";
                } else {
                    $sql .= " ,B.product_id having sum(B.quantity) < $qty";
                }
            }
            $sql .= " ORDER BY A.created_at DESC";

//            echo $sql."\n";

            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $product = array(
                    'product_id' => $row["product_id"],
                    'name' => $row["name"],
                    'name_for_website' => $row["name_for_website"],
                    'image' => $row["image"],
                    'variant_image' => $row["variant_image"],
                    'link' => $row["link"],
                    'retail' => $row["max_retail"] == $row["min_retail"] ? number_format($row['min_retail']) : number_format($row['min_retail'])." - ".number_format($row['max_retail']),
                    'discount' => $row["discount"],
                    'profit' => $row["max_profit"] == $row["min_profit"] ? number_format($row['min_profit']) : number_format($row['min_profit'])." - ".number_format($row['max_profit']),
                    'social_publish' => $row["social_publish"],
                    'material' => $row["material"],
                    'origin' => $row["origin"],
                    'short_description' => $row["short_description"],
                    'category_id' => $row["category_id"],
                    'type' => $row["type"],
                    'total_quantity' => $row["total_quantity"]
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
                    B.id, 
                    B.product_id,
                    B.image, 
                    B.price, 
                    FORMAT(B.retail, 0) as retail,
                    B.profit,
                    B.size,
                    B.color, 
                    B.quantity, 
                    B.sku, 
                    B.updated_qty,
                    B.length__, 
                    B.weight, 
                    B.height, 
                    B.age,
                    B.dimension
                from smi_variations B 
                where B.product_id = $productId 
                order by B.id";
      $result = mysqli_query($this->conn, $sql);
      $data = array();
      $colors = array();
      $color = '';
      $i = 0;
      foreach ($result as $k => $row) {
          if($color != $row["color"]) {
              $color = $row["color"];
              $colors = array();
              $colors = array();
              $variation = array(
                  'id' => $row["id"],
                  'product_id' => $row["product_id"],
                  'image' => $row["image"],
                  'price' => $row["price"],
                  'retail' => $row["retail"],
                  'profit' => $row["profit"],
                  'size' => $row["size"],
                  'color' => $row["color"],
                  'quantity' => $row["quantity"],
                  'sku' => $row["sku"],
                  'updated_qty' => $row["updated_qty"],
                  'length__' => $row["length__"],
                  'weight' => $row["weight"],
                  'height' => $row["height"],
                  'age' => $row["age"],
                  'dimension' => $row["dimension"]
              );
              array_push($colors, $variation);
              array_push($data, $colors);
              $i++;
          } else {
              $variation = array(
                  'id' => $row["id"],
                  'product_id' => $row["product_id"],
                  'image' => $row["image"],
                  'price' => $row["price"],
                  'retail' => $row["retail"],
                  'profit' => $row["profit"],
                  'size' => $row["size"],
                  'color' => $row["color"],
                  'quantity' => $row["quantity"],
                  'sku' => $row["sku"],
                  'updated_qty' => $row["updated_qty"],
                  'length__' => $row["length__"],
                  'weight' => $row["weight"],
                  'height' => $row["height"],
                  'age' => $row["age"],
                  'dimension' => $row["dimension"]
              );
              array_push($data[$i-1], $variation);
          }
      }
      $arr = array();
      $arr["data"] = $data;
      return $arr;
    } catch (Exception $e) {
      echo "Open connection database is error exception >> " . $e->getMessage();
    }
  }

//    function find_detail($productId)
//    {
//        try {
//            $sql = "select
//                        A.id as product_id,
//                        B.id as variant_id,
//                        A.name ,
//                        A.image ,
//                        A.link ,
//                        A.price,
//                        A.fee_transport,
//                        A.retail,
//                        A.profit,
//                        A.short_description,
//                        B.size,
////                        case
////                            when B.size = '3' then concat(B.size, 'm')
////                            when B.size = '6' then concat(B.size, 'm')
////                            when B.size = '9' then concat(B.size, 'm')
////                            when B.size = '60' then concat(B.size, ' cm (3kg-6kg)')
////                            when B.size = '73' then concat(B.size, ' cm (6kg-8kg)')
////                            when B.size = '80' then concat(B.size, ' cm (8kg-10kg)')
////                            when B.size = '90' then concat(B.size, ' cm (11kg-13kg)')
////                            when B.size = '100' then concat(B.size, ' cm (14kg-16kg)')
////                            when B.size = '110' then concat(B.size, ' cm (17kg-18kg)')
////                            when B.size = '120' then concat(B.size, ' cm (19kg-20kg)')
////                            when B.size = '130' then concat(B.size, ' cm (21kg-23kg)')
////                            when B.size = '140' then concat(B.size, ' cm (24kg-27kg)')
////                            when B.size = '150' then concat(B.size, ' cm (28kg-32kg)')
////                            when B.size = '160' then concat(B.size, ' cm (33kg-40kg)')
////                            else concat(B.size)
////                        end as size,
//                        B.color,
//                        B.quantity,
//                        B.sku,
//                        A.created_at,
//                        A.discount,
//                        B.image as 'variation_image',
//                        B.updated_qty
//                    from
//                        smi_products A left join smi_variations B on A.id = B.product_id
//                    where B.product_id = $productId
//                    order by A.created_at desc, A.id, B.id, B.color, B.size";
//            $result = mysqli_query($this->conn, $sql);
//            $data = array();
//            $product_id = 0;
//            $i = 0;
//            foreach ($result as $k => $row) {
//                if ($product_id != $row["product_id"]) {
//                    $product = array(
//                        'product_id' => $row["product_id"],
//                        'name' => $row["name"],
//                        'image' => $row["image"],
//                        'link' => $row["link"],
//                        'price' => number_format($row["price"]),
//                        'fee_transport' => number_format($row["fee_transport"]),
//                        'retail' => number_format($row["retail"]),
//                        'profit' => number_format($row["profit"]),
//                        'discount' => $row["discount"],
//                        'short_description' => $row["short_description"],
//                        'created_at' => date_format(date_create($row["created_at"]), "d/m/Y"),
//                        'variations' => array()
//                    );
//                    $variation = array(
//                        'id' => $row["variant_id"],
//                        'size' => $row["size"],
//                        'color' => $row["color"],
//                        'quantity' => $row["quantity"],
//                        'sku' => $row["sku"],
//                        'product_id' => $row["product_id"],
//                        'image' => $row["variation_image"],
//                        'updated_qty' => $row["updated_qty"]
//                    );
//                    array_push($product['variations'], $variation);
//                    array_push($data, $product);
//                    $product_id = $row["product_id"];
//                    $i++;
//                } else {
//                    $variation = array(
//                        'id' => $row["variant_id"],
//                        'size' => $row["size"],
//                        'color' => $row["color"],
//                        'quantity' => $row["quantity"],
//                        'sku' => $row["sku"],
//                        'product_id' => $row["product_id"],
//                        'image' => $row["variation_image"],
//                      'updated_qty' => $row["updated_qty"]
//                    );
//                    array_push($data[$i - 1]['variations'], $variation);
//                }
//            }
//            $arr = array();
//            $arr["data"] = $data;
//            // print_r($arr);
//            return $arr;
//        } catch (Exception $e) {
//            echo "Open connection database is error exception >> " . $e->getMessage();
//        }
//    }

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
        $sql = "select count(*) as stock from smi_products a left join smi_variations b on a.id = b.product_id
                where a.id = $product_id and b.quantity > 0";
        $result = mysqli_query($this->conn, $sql);
        if($result) {
          $row = $result->fetch_assoc();
          $stock = $row['stock'];
          return $stock;
        } else {
          throw new Exception("error");
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
            if($product_id == -1) {
                $stmt = $this->getConn()->prepare("UPDATE smi_products
                                                    SET status = ?,
                                                        updated_at = NOW()
                                                    WHERE id IN
                                                        (SELECT a.id
                                                         FROM smi_products a
                                                         LEFT JOIN smi_variations b ON a.id = b.product_id
                                                         WHERE a.status = 0
                                                         GROUP BY a.id,
                                                                  a.name
                                                         HAVING sum(b.quantity) = 0)");
                $stmt->bind_param("i", $status);
            } else {
                $stmt = $this->getConn()->prepare("update smi_products SET status = ?, updated_at = NOW() where id = ?");
                $stmt->bind_param("ii", $status, $product_id);
            }
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
            $size = $variation->getSize();
            $color = $variation->getColor();
            $qty = $variation->getQuantity();
            $sku = $variation->getSku();
            $price = $variation->getPrice();
            $retail = $variation->getRetail();
            $profit = $variation->getProfit();
            $percent = $variation->getPercent();
            $image = $variation->getImage();
            $stmt = $this->getConn()->prepare("update smi_variations set size = ?, color = ?, quantity = ?, price = ?, retail = ?, profit = ?, percent = ?, image = ? where sku = ?");
            $stmt->bind_param("ssidddiss", $size, $color, $qty, $price, $retail, $profit, $percent, $image, $sku);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception("update_variation >> " . $e);
        }
    }

    function delete_variation_by_product_id($product_id)
    {
        try {
            $stmt = $this->getConn()->prepare("delete from smi_variations where product_id = ?");
            $stmt->bind_param("i", $product_id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function save_product(Product $product)
    {
        try {
            $name = $product->getName();
            $name_for_website = $product->getNameForWebsite();
            $image = $product->getImage();
            $link = $product->getLink();
            $price = $product->getPrice();
            $fee = $product->getFee_transport();
            $profit = $product->getProfit();
            $retail = $product->getRetail();
            $percent = $product->getPercent();
            $type = $product->getType();
            $cat_id = $product->getCategory_id();
            $social_publish = '{"shopee": 0, "website": 0, "facebook": 0, "lazada": 0, "feature": 0}';
            $description = $product->getDescription();
            $material = $product->getMaterial();
            $origin = $product->getOrigin();
            $short_description = $product->getShortDescription();
            $stmt = $this->getConn()->prepare("INSERT INTO smi_products (
                                `name`,
                                `name_for_website`,
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
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssssddddiiisssis",
                                $name,
                                $name_for_website,
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
            $name_for_website = $product->getNameForWebsite();
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
                name_for_website = ?, 
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
            $stmt->bind_param("ssssddddiiissisi",
                $name,
                $name_for_website,
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
            $product_id = $variation->getProductId();
            $size = $variation->getSize();
            $color = $variation->getColor();
            $qty = $variation->getQuantity();
            $sku = $variation->getSku();
            $price = $variation->getPrice();
            $retail = $variation->getRetail();
            $fee = $variation->getFee();
            $profit = $variation->getProfit();
            $percent = $variation->getPercent();
            $image = $variation->getImage();
            $length__ = $variation->getLength__();
            $height = $variation->getHeight();
            $weight = $variation->getWeight();
            $age = $variation->getAge();
            $dimension = $variation->getDimension();
            $updated_qty = '{"lazada": 0, "shopee": 0}';
            $sql = "INSERT INTO smi_variations (`product_id`, `size`, `color`, `quantity`, `sku`, `price`, `retail`, `fee`, `profit`, `percent`, `image`, `length__`, `height`, `weight`, `age`, `updated_qty`, `dimension`, `created_at`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW())";
            if($stmt = $this->getConn()->prepare($sql)) {
                $stmt->bind_param("issisdddddsssssss", $product_id, $size, $color, $qty, $sku, $price, $retail, $fee, $profit, $percent, $image, $length__, $height, $weight, $age, $updated_qty, $dimension);
                if(!$stmt->execute()) {
                    throw new Exception($stmt->error);
                }
                $stmt->close();
            } else {
                var_dump($this->getConn()->error);
            }
            
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }



    function find_by_sku($sku)
    {
        try {
            $sql = "SELECT A.id AS product_id,
                           B.id AS variant_id,
                           A.name,
                           B.image,
                           B.retail,
                           B.size,
                           B.color,
                           B.quantity,
                           B.sku,
                           A.discount,
                           B.price,
                           B.profit
                    FROM smi_products A
                    LEFT JOIN smi_variations B ON A.id = B.product_id
                    WHERE B.sku in ($sku)
                    ORDER BY A.id,
                             B.id,
                             B.color,
                             B.size";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    $product = array(
                        'product_id' => $row["product_id"],
                        'variant_id' => $row["variant_id"],
                        'retail' => number_format($row["retail"]),
                        'name' => $row["name"],
                        'image' => $row["image"],
                        'size' => $row["size"],
                        'color' => $row["color"],
                        'sku' => $row["sku"],
                        'discount' => $row["discount"],
                        'price' => number_format($row["price"]),
                        'profit' => number_format($row["profit"])
                    );
                    array_push($data, $product);
                }
            }

            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function update_qty_variation_by_sku($sku, $qty = 1, $product_type = 0)
    {
        try {
            if($product_type == 1) {// product exchange
              $stmt = $this->getConn()->prepare("update smi_variations set quantity = quantity + $qty where sku = ?");
              $stmt->bind_param("s", $sku);
            } else {
              $stmt = $this->getConn()->prepare("update smi_variations a, (select case when a.quantity > 0 then a.quantity - ? else 0 end as qty from smi_variations a where a.sku = ?) b set a.quantity = b.qty where sku = ?");
              $stmt->bind_param("iss", $qty, $sku, $sku);

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
          $stmt = $this->getConn()->prepare("update smi_products set social_publish = JSON_SET(`social_publish`, '$.".$type."', ?), `updated_at` = NOW() where id = ?");
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

    function get_colors()
    {
        try {
            $sql = "SELECT distinct color FROM smi_variations where color is not null and color <> ''";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    array_push($data, $row["color"]);
                }
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function get_sizes()
    {
        try {
            $sql = "select distinct `size` from smi_variations where `size` is not null and `size` <> '' order by `size`";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    array_push($data, $row["size"]);
                }
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function get_materials()
    {
        try {
            $sql = "SELECT distinct material FROM smi_products where material is not null and material <> ''";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    array_push($data, $row["material"]);
                }
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }


    function get_data_for_chat_bot()
    {
        try {
            $sql = "SELECT  a.id,
                            a.name,
                            a.image as product_image,
                            b.color,
                            b.retail,
                            b.size,
                            b.image as variation_image,
                            a.description,
                            b.sku
                    FROM smi_products a
                    LEFT JOIN smi_variations b ON a.id = b.product_id
                    WHERE a.id in (1322, 1321, 1320, 1319, 1318, 1317, 1316, 1315)";
            $result = mysqli_query($this->conn, $sql);

            

            $data = array();
            $product_id = 0;
            $i = 0;
            $c = "";
            $retails = array();
            $first_size = "";
            $last_size = "";
            foreach ($result as $k => $row) {
                if ($product_id != $row["id"]) {
                    $product = array(
                        'name' => $row["name"],
                        'description' => $row["description"],
                        "retail" => $row["retail"],
                        "color" => $row["color"],
                        "size" => "first_size - last_size",
                        "slider" => $row["product_image"],
                        'image' => $row["variation_image"],
                        "detail" => array()
                    );
                    $color = array(
                        'sku' => $row["sku"],
                        'size' => $row["size"],
                        'image' => $row["variation_image"],
                        'retail' => number_format($row["retail"]),
                    );
                    $product['detail'][$row["color"]] = array();
                    array_push($product['detail'][$row["color"]], $color);
                    array_push($data, $product);
                    $product_id = $row["id"];
                    $c = $row["color"];
                    $first_size = $row["size"];
                    $retails = array();
                    array_push($retails, $row["retail"]);
                    $i++;




                } else {
                    // print_r($data);
                    
                    $color = array(
                        'sku' => $row["sku"],
                        'size' => $row["size"],
                        'image' => $row["variation_image"],
                        'retail' => number_format($row["retail"]),
                    );
                    if($c != $row["color"]) {
                        // $$data[$i - 1]['detail'][$row["color"]] = $color;
                        $data[$i - 1]['detail'][$row["color"]] = array();
                        array_push($data[$i - 1]['detail'][$row["color"]], $color);

                        $color_product = $data[$i - 1]["color"];
                        $color_product .= ", ".$row["color"];
                        $data[$i - 1]["color"] = $color_product;
                    } else {
                        array_push($data[$i - 1]['detail'][$row["color"]], $color);
                    }

                    $last_size = $row["size"];
                    $data[$i - 1]["size"] = $first_size." - ".$last_size;

                    array_push($retails, $row["retail"]);
                    sort($retails);
                    $retailLength = count($retails);
                    if($retailLength > 1 && $retails[0] != $retails[$retailLength-1]) {
                        $data[$i - 1]["retail"] = number_format($retails[0])." - ".number_format($retails[$retailLength-1]);
                    } else {
                        $data[$i - 1]["retail"] = number_format($retails[0]);
                    }

                    $c = $row["color"];
                }
            }
            $products = array();
            for($i=0; $i<count($data); $i++) {
                $p = array(
                    "title" => $data[$i]["name"],
                    "subtitle" => "Giá: ".$data[$i]["retail"]." VNĐ\nMàu: ".$data[$i]["color"]."\nSize: ".$data[$i]["size"],
                    "image" => $data[$i]["image"]
                );
                $products["product_".($i+1)] = $p;
            }

            $arr = array();
            $arr["data"] = $data;
            $arr["products"] = $products;
            return $arr;
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


// select t.product_id, GROUP_CONCAT(t.color SEPARATOR ', ') as color from ( select product_id, color from smi_variations where product_id = 1 group by color) t group by t.product_id