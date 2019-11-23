<?php
// require "../../common/cities/Zone.php";

class CheckoutDAO {
    private $conn;

    function find_all()
    {
        $zone = new Zone();
        try {
            $sql = "select 
                        A.id as order_id,
                        C.name as customer_name,
                        C.phone,
                        C.address,
                        C.city_id,
                        C.district_id,
                        C.village_id,
                        A.shipping,
                        A.discount,
                        A.total_checkout,
                        A.created_date,
                        A.type,
                        A.status,
                        D.id as product_id,
                        D.name as product_name,
                        E.sku,
                        E.id as variant_id,
                        B.quantity,
                        B.price,
                        B.reduce
                    from smi_orders A 
                        left join smi_order_detail B on A.id = B.order_id
                        left join smi_customers C on A.customer_id = C.id
                        left join smi_products D on B.product_id = D.id
                        left join smi_variations E on B.variant_id = E.id
                    order by A.created_date desc";
            $result = mysqli_query($this->conn,$sql);
            $data = array();        
            $order_id = 0;
            $i = 0;
            foreach($result as $k => $row) {
                if($order_id != $row["order_id"])
                {
                    $cityId = $row["city_id"];
                    $cityName = $zone->get_name_city($cityId);
                    $districtId = $row["district_id"];
                    $districtName = $zone->get_name_district($districtId);
                    $villageId = $row["village_id"];
                    $villageName = $zone->get_name_village($villageId);
                    $address = "";
                    if(!empty($row["address"]))
                    {
                        $address = $row["address"];
                        if(!empty($villageName))
                        {
                            $address .= ", ".$villageName;
                            if(!empty($districtName))
                            {
                                $address .= ", ".$districtName;
                                if(!empty($cityName))
                                {
                                    $address .= ", ".$cityName;
                                }
                            }
                        }
                    }
                    
                    $order = array(
                            'order_id' => $row["order_id"],
                            'customer_name' => $row["customer_name"],
                            'phone' => $row["phone"],
                            'address' => $address,
                            'shipping' => number_format($row["shipping"]),
                            'discount' => number_format($row["discount"]),
                            'total_checkout' => number_format($row["total_checkout"]),
                            'created_date' => date_format(date_create($row["created_date"]),"d/m/Y h:i:s"),
                            'type' => $row["type"],
                            'status' => $row["status"],
                            'details' => array()
                        );
                    $intoMoney = 0;
                    $qty = $row["quantity"];
                    $price = $row["price"];
                    $reduce = $row["reduce"];
                    $intoMoney = $qty*$price-$reduce;
                    $detail = array(
                        'product_id' => $row["product_id"],
                        'product_name' => $row["product_name"],
                        'sku' => $row["sku"],
                        'variant_id' => $row["variant_id"],
                        'quantity' => $qty,
                        'price' => number_format($price),
                        'reduce' => number_format($reduce),
                        'intoMoney' => number_format($intoMoney),
                    );
                    array_push($order['details'], $detail);
                    array_push($data, $order);
                    $order_id = $row["order_id"];
                    $i++;
                } else {
                    $intoMoney = 0;
                    $qty = $row["quantity"];
                    $price = $row["price"];
                    $reduce = $row["reduce"];
                    $intoMoney = $qty*$price-$reduce;
                    $detail = array(
                        'product_id' => $row["product_id"],
                        'product_name' => $row["product_name"],
                        'sku' => $row["sku"],
                        'variant_id' => $row["variant_id"],
                        'quantity' => $qty,
                        'price' => number_format($price),
                        'reduce' => number_format($reduce),
                        'intoMoney' => number_format($intoMoney),
                    );
                    array_push($data[$i-1]['details'],  $detail);
                }
            }
            $arr = array();
            $arr["data"] = $data;
            return $arr;
        } catch(Exception $e)
        {
            throw new Exception($e);
        }
    }

    function saveOrder(Order $order)
    {
    	try {
            $sql = "insert into smi_orders (
                    `total_reduce`,
                    `total_reduce_percent`,
                    `discount`,
                    `total_amount`,
                    `total_checkout`,
                    `customer_payment`,
                    `repay`,
                    `customer_id`,
                    `type`,
                    `bill_of_lading_no`,
                    `shipping_fee`,
                    `shipping`,
                    `shipping_unit`,
                    `status`,
                    `created_date`) 
                VALUES (".
                    $order->getTotal_reduce().",".
                    $order->getTotal_reduce_percent().",".
                    $order->getDiscount().",".
                    $order->getTotal_amount().",".
                    $order->getTotal_checkout().",".
                    $order->getCustomer_payment().",".
                    $order->getRepay().",".
                    $order->getCustomer_id().",".
                    $order->getType().",".
                    $order->getBill_of_lading_no().",".
                    $order->getShipping_fee().",".
                    $order->getShipping().",".
                    $order->getShipping_unit().",".
                    $order->getStatus().",".
                    "NOW())";
                mysqli_query($this->conn,$sql); 
                $lastid = mysqli_insert_id($this->conn); 
                return $lastid;
        } catch(Exception $e)
        {
            throw new Exception($e);
        }   
    }

    function saveOrderDetail(OrderDetail $detail)
    {
    	try {
            $sql = "insert into smi_order_detail (
                    `order_id`,
                    `product_id`,
                    `variant_id`,
                    `sku`,
                    `price`,
                    `quantity`,
                    `reduce`) 
                VALUES (".
                    $detail->getOrder_id().",".
                    $detail->getProduct_id().",".
                    $detail->getVariant_id().",".
                    $detail->getSku().",".
                    $detail->getPrice().",".
                    $detail->getQuantity().",".
                    $detail->getReduce().")";
            mysqli_query($this->conn,$sql); 
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
