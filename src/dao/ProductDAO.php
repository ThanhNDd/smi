<?php

class ProductDAO {
    private $conn;

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
                        B.sku in (".$skus.")
                    order by 
                        A.id, B.id, B.color, B.size";
            $result = mysqli_query($this->conn,$sql);    
            $data = array();        
            foreach($result as $k => $row) {
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
        } catch(Exception $e)
        {
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
            $result = mysqli_query($this->conn,$sql);    
            $data = array();        
            $product = array(
                    'product_id' => '',
                    'id' => '-1',
                    'text' => '',
                    'price' => ''
                );
            array_push($data, $product);
            foreach($result as $k => $row) {
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
        } catch(Exception $e)
        {
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
                           B.sku
                    FROM smi_products A
                    LEFT JOIN smi_variations B ON A.id = B.product_id
                    WHERE A.id = ".$id;
            $result = mysqli_query($this->conn,$sql);    
            $data = array();                 
            $product_id = 0;
            $i = 0;
            foreach($result as $k => $row) {
                if($product_id != $row["product_id"])
                {
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
                        'variations' => array()
                    );
                    $variation = array(
                        'id' => $row["variant_id"],
                        'size' => $row["size"],
                        'color' => $row["color"],
                        'quantity' => $row["quantity"],
                        'sku' => $row["sku"],
                        'product_id' => $row["product_id"]
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
                        'product_id' => $row["product_id"]
                    );
                    array_push($data[$i-1]['variations'],  $variation);
                }
            }
            $arr = array();
            $arr["data"] = $data;
            // print_r($arr);
            return $arr;
        } catch(Exception $e)
        {
            throw new Exception($e);
        }
    }

    function find_all()
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
                        A.discount
                    from 
                        smi_products A left join smi_variations B on A.id = B.product_id     
                    order by A.created_at desc, A.id, B.id, B.color, B.size";
            $result = mysqli_query($this->conn,$sql);    
            $data = array();                 
            $product_id = 0;
            $i = 0;
            foreach($result as $k => $row) {
                if($product_id != $row["product_id"])
                {
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
                        'created_at' => date_format(date_create($row["created_at"]),"d/m/Y"),
                        'variations' => array()
                    );
                    $variation = array(
                        'id' => $row["variant_id"],
                        'size' => $row["size"],
                        'color' => $row["color"],
                        'quantity' => $row["quantity"],
                        'sku' => $row["sku"],
                        'product_id' => $row["product_id"]
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
                        'product_id' => $row["product_id"]
                    );
                    array_push($data[$i-1]['variations'],  $variation);
                }
            }
            $arr = array();
            $arr["data"] = $data;
            // print_r($arr);
            return $arr;
        } catch(Exception $e)
        {
            echo "Open connection database is error exception >> ".$e->getMessage();
        }
    }

    function delete_product($product_id)
    {
    	try {
            $sql = "delete from smi_products where id = ".$product_id;
            mysqli_query($this->conn,$sql); 
        } catch(Exception $e)
        {
            echo "Open connection database is error exception >> ".$e->getMessage();
        }   
    }

    function update_product(Product $product)
    {
        try {
            $sql = "update smi_products
                    SET name = ".$product->getName().",
                        image = ".$product->getImage().",
                        LINK = ".$product->getLink().",
                        price = ".$product->getPrice().",
                        fee_transport = ".$product->getFee_transport().",
                        profit = ".$product->getProfit().",
                        retail = ".$product->getRetail().",
                        percent = ".$product->getPercent().",
                        TYPE = ".$product->getType().",
                        category_id = ".$product->getCategory_id().",
                        updated_at = NOW()
                    WHERE id = ".$product->getId();
            mysqli_query($this->conn,$sql); 
        } catch(Exception $e)
        {
            echo $e->getMessage();
        }   
    }

    function update_discount($discount, $product_id)
    {
        try {
            $stmt = $this->getConn()->prepare("update smi_products SET discount = ? where id = ?");
            $stmt->bind_param("ii", $discount, $product_id);
            $stmt->execute();
            $nrows = $stmt->affected_rows;
            if (!$nrows) {
                throw new Exception("Update discount has failure!!!");
            }
        } catch(Exception $e)
        {
            throw new Exception($e);
        }
    }

    function update_variation($sku, $color, $size, $qty)
    {
    	try {
            $sql = "update smi_variations set color = \"".$color."\", size = \"".$size."\", quantity = ".$qty." where sku = ".$sku;
            mysqli_query($this->conn,$sql); 
        } catch(Exception $e)
        {
            throw new Exception("update_variation >> ".$e);
        }   
    }

    function delete_variation($sku)
    {
    	try {
            $sql = "delete from smi_variations where sku = ".$sku;
            mysqli_query($this->conn,$sql); 
        } catch(Exception $e)
        {
            echo "delete_variation >> ".$e->getMessage();
        }   
    }

    function save_product(Product $product)
    {
    	try {
            $sql = "INSERT INTO smi_products (
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
                    `created_at`) 
                VALUES (".
                    $product->getName().",".
                    $product->getImage().",".
                    $product->getLink().",".
                    $product->getPrice().",".
                    $product->getFee_transport().",".
                    $product->getProfit().",".
                    $product->getRetail().",".
                    $product->getPercent().",".
                    $product->getType().",".
                    $product->getCategory_id().
                    ", NOW())";
            mysqli_query($this->conn,$sql); 
            $lastid = mysqli_insert_id($this->conn); 
            return $lastid;
        } catch(Exception $e)
        {
            throw new Exception($e);
        }   
    }

    function save_variations(Array $variations)
    {
    	try {
            $sql = "INSERT INTO smi_variations (
                `product_id`,
                `size`,
                `color`,
                `quantity`,
                `sku`,
                `created_at`) 
            VALUES ";
            for($i=0; $i < count($variations); $i++)
            {
                $sql .= "(".
                    $variations[$i]->getProduct_id().",".
                    $variations[$i]->getSize().",".
                    $variations[$i]->getColor().",".
                    $variations[$i]->getQuantity().",".
                    $variations[$i]->getSku()."".
                    ",NOW()),";
            }    
            $sql = substr($sql, 0, -1);      
            mysqli_query($this->conn,$sql); 
            $lastid = mysqli_insert_id($this->conn); 
            return $lastid;
        } catch(Exception $e)
        {
            echo "Open connection database is error exception >> ".$e->getMessage();
        }   
    }

    function find_by_sku($sku)
    {
        try {
            $sql = "select 
                        A.id as product_id, 
                        B.id as variant_id,  
                        A.name , 
                        A.retail, 
                        B.size, 
                        B.color, 
                        B.quantity, 
                        B.sku,
                        A.discount,
                        A.price 
                    from 
                        smi_products A left join smi_variations B on A.id = B.product_id 
                        where B.sku = ".$sku."
                        order by A.id, B.id, B.color, B.size";
            $result = mysqli_query($this->conn,$sql);    
            $data = array();
            if(!empty($result)) {
                foreach($result as $k => $row) {
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
        } catch(Exception $e)
        {
            echo "Open connection database is error exception >> ".$e->getMessage();
        }
    }

    function update_quantity_by_sku($sku, $qty)
    {
        try {
            $sql = "update smi_variations set quantity = (select case when quantity > 0 then quantity - ".$qty." else 0 end from smi_variations where sku = ".$sku.") where sku = ".$sku;
            mysqli_query($this->conn,$sql); 
        } catch(Exception $e)
        {
            throw new Exception("update_quantity_by_sku >> ".$e);
        }   
    }

    function find_variation_by_product_id($product_id)
    {
        try {
            $sql = "select `id`, `product_id`, `size`, `color`, `quantity`, `sku`, `created_at`, `updated_at` from smi_variations where product_id = ".$product_id;
            $result = mysqli_query($this->conn,$sql); 

            return $result;
        } catch(Exception $e)
        {
            throw new Exception("find_variation_by_product_id >> ".$e);
        }   
    }

    function find_variation_by_sku($sku)
    {
        try {
            $sql = "select `id`, `product_id`, `size`, `color`, `quantity`, `sku`, `created_at`, `updated_at` from smi_variations where sku = ".$sku;
            $result = mysqli_query($this->conn,$sql);
            return $result;
        } catch(Exception $e)
        {
            throw new Exception("find_variation_by_sku >> ".$e);
        }
    }

    function update_qty_variation_by_sku($sku) {
        try {
            $stmt = $this->getConn()->prepare("update smi_variations set quantity = quantity + 1 where sku = ?");
            $stmt->bind_param("s", $sku);
            $stmt->execute();
            $nrows = $stmt->affected_rows;
            if(!$nrows) {
                throw new Exception("Update Qty for variations has failure");
            }
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
