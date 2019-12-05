<?php
// require "../../common/cities/Zone.php";

class CheckoutDAO {
    private $conn;

    function get_info_total_checkout($start_date, $end_date) {
        try {
            $sql = "select 
                        sum(tmp.total_checkout) as total_checkout, count(tmp.type) as count_type, tmp.type,
                        tmp.payment_type
                    from (
                        SELECT distinct A.id, A.total_checkout AS total_checkout,
                              A.type,  A.payment_type
                        FROM smi_orders A
                            LEFT JOIN smi_order_detail B ON A.id = B.order_id
                            LEFT JOIN smi_customers C ON A.customer_id = C.id
                            LEFT JOIN smi_variations E ON B.variant_id = E.id
                            LEFT JOIN smi_products D ON E.product_id = D.id
                        where DATE(created_date) between DATE('".$start_date."') and DATE('".$end_date."')
                        and A.deleted = 0
                        ) tmp
                    group by
                        tmp.type,
                        tmp.payment_type
                    order by 
                        tmp.type";
            $result = mysqli_query($this->conn,$sql);
            $data = array();        
            $total_checkout = 0;
            $count_total = 0;
            $total_on_shop = 0;
            $total_online = 0;
            $count_on_shop = 0;
            $count_online = 0;
            $total_cash = 0;
            $total_transfer = 0;
            foreach($result as $k => $row) {
                $total_checkout += $row["total_checkout"];
                if($row["type"] == 0) {
                    $total_on_shop += $row["total_checkout"];
                    $count_on_shop += $row["count_type"];
                } else if($row["type"] == 1) {
                    $total_online += $row["total_checkout"];
                    $count_online += $row["count_type"];
                }
                if($row["payment_type"] == 0) {
                    $total_cash += $row["total_checkout"];
                } else if($row["payment_type"] == 1) {
                    $total_transfer += $row["total_checkout"];
                } 
            }
            $count_total = $count_on_shop + $count_online;
            $arr = array();
            $arr["total_checkout"] = number_format($total_checkout);
            $arr["count_total"] = $count_total;
            $arr["total_on_shop"] = number_format($total_on_shop);
            $arr["count_on_shop"] = $count_on_shop;
            $arr["total_online"] = number_format($total_online);
            $arr["count_online"] = $count_online;
            $arr["total_cash"] = number_format($total_cash);
            $arr["total_transfer"] = number_format($total_transfer);
            return $arr;

        } catch(Exception $e)
        {
            throw new Exception($e);
        }
    }

    function delete_order($order_id)
    {
        try {
            $sql = "update smi_orders set deleted = 1, updated_date = NOW() WHERE id = ".$order_id;
            $result = mysqli_query($this->conn,$sql); 
            if(!$result){
                throw new Exception(mysql_error());
            }
        } catch(Exception $e)
        {
            throw new Exception($e);
        }
    }

    function find_all_order_by_date()
    {
        try {
            $sql = "select  
                        DATE(A.created_date) as date,
                        sum(A.total_amount) as total_amount,
                        sum(C.profit) as total_profit
                    from smi_orders A left join smi_order_detail B on A.id = B.order_id
                    inner join smi_variations C on B.variant_id = C.id
                    group by
                        DATE(A.created_date)
                    order by
                        DATE(A.created_date) desc";
            $result = mysqli_query($this->conn,$sql);
            $data = array();        
            foreach($result as $k => $row) {
                $order = array(
                        'date' => date_format(date_create($row["date"]),"d/m/Y"),
                        'total_amount' => number_format($row["total_amount"]),
                        'total_profit' => number_format($row["total_profit"])
                    );
                array_push($data, $order);
            }
            $arr = array();
            $arr["data"] = $data;
            return $arr;
        } catch(Exception $e)
        {
            throw new Exception($e);
        }
    }

    // function find_all_2($start_date, $end_date)
    // {
    //     $sql = "select 
    //                 A.id as order_id,
    //                 A.total_checkout,
    //                 A.created_date,
    //                 A.type,
    //                 A.payment_type
    //             from smi_orders A 
    //             where 
    //                 DATE(created_date) between DATE('".$start_date."') and DATE('".$end_date."')
    //                 and A.deleted = 0
    //             order by A.created_date desc";
    //     $result = mysqli_query($this->conn,$sql);
    //     $data = array();     
    //     foreach($result as $k => $row) {
    //         $order = array(
    //                 'order_id' => $row["order_id"],
    //                 'total_checkout' => number_format($row["total_checkout"]),
    //                 'created_date' => date_format(date_create($row["created_date"]),"d/m/Y H:i:s"),
    //                 'type' => $row["type"],
    //                 'payment_type' => $row["payment_type"]
    //             );
    //         array_push($data, $order);
    //     }
    //     $arr = array();
    //     $arr["data"] = $data;
    //     return $arr;
    // }

    // function get_order_detail_by_order_id($order_id)
    // {
    //     $sql = "select 
    //                 A.sku, B.name, A.quantity, A.price, A.reduce, A.quantity*A.price as 'total'
    //             from smi_order_detail A
    //             inner join smi_products B on A.product_id = B.id
    //             where order_id = ".$order_id;
    //     $result = mysqli_query($this->conn,$sql);
    //     $data = array();     
    //     foreach($result as $k => $row) {
    //         $detail = array(
    //                 'sku' => $row["sku"],
    //                 'name' => $row["name"],
    //                 'quantity' => $row["quantity"],
    //                 'price' => number_format($row["price"]),
    //                 'reduce' => number_format($row["reduce"]),
    //                 'total' => number_format($row["total"])
    //             );
    //         array_push($data, $detail);
    //     }
    //     $arr = array();
    //     $arr["data"] = $data;
    //     return $arr;
    // }

    // function get_customer_by_order_id()
    // {
    //     $zone = new Zone();
    //     $sql = "select 
    //                 C.id as customer_id,
    //                 C.name as customer_name,
    //                 C.phone,
    //                 C.address,
    //                 C.city_id,
    //                 C.district_id,
    //                 C.village_id
    //             from smi_order_detail A
    //             inner join smi_products B on A.product_id = B.id
    //             where order_id = ".$order_id;
    //     $result = mysqli_query($this->conn,$sql);
    //     $data = array();     
    //     foreach($result as $k => $row) {
    //         $address = $this->get_address($row);
    //         $customer = array(
    //                         'customer_id' => $row["customer_id"],
    //                         'customer_name' => $row["customer_name"],
    //                         'phone' => $row["phone"],
    //                         'address' => $address
    //                     );
    //         array_push($data, $customer);
    //     }
    //     $arr = array();
    //     $arr["data"] = $data;
    //     return $arr;
    // }

    // find all order 
    function find_all($start_date, $end_date)
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
                        B.reduce,
                        A.payment_type
                    from smi_orders A 
                        left join smi_order_detail B on A.id = B.order_id
                        left join smi_customers C on A.customer_id = C.id
                        left join smi_variations E on B.variant_id = E.id
                        left join smi_products D on E.product_id = D.id
                    where 
                        DATE(created_date) between DATE('".$start_date."') and DATE('".$end_date."')
                        and A.deleted = 0
                    order by A.created_date desc";
            $result = mysqli_query($this->conn,$sql);
            $data = array();        
            $order_id = 0;
            $i = 0;
            foreach($result as $k => $row) {
                if($order_id != $row["order_id"])
                {
                    $address = $this->get_address($row);
                    $order = array(
                            'order_id' => $row["order_id"],
                            'customer_name' => $row["customer_name"],
                            'phone' => $row["phone"],
                            'address' => $address,
                            'shipping' => number_format($row["shipping"]),
                            'discount' => number_format($row["discount"]),
                            'total_checkout' => number_format($row["total_checkout"]),
                            'created_date' => date_format(date_create($row["created_date"]),"d/m/Y H:i:s"),
                            'type' => $row["type"],
                            'status' => $row["status"],
                            'payment_type' => $row["payment_type"],
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
                    `payment_type`,
                    `repay`,
                    `customer_id`,
                    `type`,
                    `bill_of_lading_no`,
                    `shipping_fee`,
                    `shipping`,
                    `shipping_unit`,
                    `status`,
                    `order_date`,
                    `created_date`) 
                VALUES (".
                    $order->getTotal_reduce().",".
                    $order->getTotal_reduce_percent().",".
                    $order->getDiscount().",".
                    $order->getTotal_amount().",".
                    $order->getTotal_checkout().",".
                    $order->getCustomer_payment().",".
                    $order->getPayment_type().",".
                    $order->getRepay().",".
                    $order->getCustomer_id().",".
                    $order->getType().",".
                    $order->getBill_of_lading_no().",".
                    $order->getShipping_fee().",".
                    $order->getShipping().",".
                    $order->getShipping_unit().",".
                    $order->getStatus().",".
                    "NOW(),".
                    "NOW())";
                $result = mysqli_query($this->conn,$sql); 
                if(!$result){
                    throw new Exception(mysql_error());
                }
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
                    // echo $sql;
                $result = mysqli_query($this->conn,$sql); 
                if(!$result){
                    throw new Exception(mysql_error());
                }
                $lastid = mysqli_insert_id($this->conn); 
                return $lastid;
        } catch(Exception $e)
        {
            throw new Exception($e);
        }   
    }

    function get_data_print_receipt($order_id)
    {
        try {
            $sql = "select 
                        A.bill_of_lading_no as bill,
                        B.name,
                        B.phone,
                        B.address,
                        B.city_id,
                        B.district_id,
                        B.village_id
                    FROM 
                    smi_orders A inner join smi_customers B on A.customer_id = B.id
                    WHERE A.id = ".$order_id;
            $result = mysqli_query($this->conn,$sql);
            $data = array();    
            foreach($result as $k => $row) {
                $address = $this->get_address($row);
                $order = array(
                        'bill' => $row["bill"],
                        'name' => $row["name"],
                        'phone' => $row["phone"],
                        'address' => $address,
                        'phone' => $row["phone"]
                    );
                array_push($data, $order);
            }
            return $data;
        } catch(Exception $e)
        {
            throw new Exception($e);
        }
    }

    function get_address($row) {
        $zone = new Zone();
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
                        return $address;
                    }
                }
            }
        }
        return "";
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
