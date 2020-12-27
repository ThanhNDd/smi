<?php

class CheckoutDAO
{
    private $conn;

    function find_order_by_order_id($orderId)
    {
        try {
            $sql = "select * from smi_orders where id = $orderId";
            $result = mysqli_query($this->conn, $sql);
            while ($obj = mysqli_fetch_object($result, "Order")) {
                return $obj;
            }
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param $orderId
     * @return array
     * @throws Exception
     */
    function find_order_detail_by_order_id($orderId)
    {
        try {
            $sql = "select 
                        a.order_id,
                        a.product_id,
                        a.variant_id,
                        a.sku,
                        b.name,
                        a.quantity,
                        a.price,
                        a.reduce,
                        a.reduce_percent,
                        a.type
                    from smi_order_detail a inner join smi_products b on a.product_id = b.id where a.order_id = $orderId";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $detail = new OrderDetail();
                $detail->setOrder_id($row["order_id"]);
                $detail->setProduct_id($row["product_id"]);
                $detail->setVariant_id($row["variant_id"]);
                $detail->setSku($row["sku"]);
                $detail->setProductName($row["name"]);
                $detail->setPrice($row["price"]);
                $detail->setQuantity($row["quantity"]);
                $detail->setReduce($row["reduce"]);
                $detail->setReduce_percent($row["reduce_percent"]);
                $detail->setType($row["type"]);
                array_push($data, $detail);
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_by_id($order_id)
    {
        try {
            // 1 - online
//            if ($order_type == 1) {
            $sql = "select 
                        a.id as order_id,
                        a.total_reduce,
                        a.bill_of_lading_no,
                        a.shipping_fee,
                        a.shipping_unit,
                        c.id as customer_id,
                        c.name as customerName,
                        c.phone,
                        c.email,
                        c.city_id,
                        c.district_id,
                        c.village_id,
                        c.address,
                        b.id as order_detail_id,
                        b.product_id,
                        b.variant_id,
                        b.sku,
                        b.reduce,
                        d.name as product_name,
                        b.quantity,
                        b.price,
                        a.total_amount,
                        a.shipping,
                        a.discount,
                        a.total_checkout,
                        a.payment_type,
                        e.size,
                        e.color,
                        e.profit,
                        a.order_date,
                        a.source,
                        a.wallet,
                        w.saved,
                        a.customer_payment as payment,
                        a.repay,
                        a.transfer_to_wallet,
                        a.type as order_type,
                        b.type as product_type
                    from smi_orders a left join smi_order_detail b on a.id = b.order_id
                    left join smi_customers c on a.customer_id = c.id
                    left join smi_variations e on b.sku = e.sku
                    left join smi_products d on e.product_id = d.id
                    left join smi_wallet w on a.id = w.order_id
                    where a.id = " . $order_id;


//            } else if ($order_type == 0) {
//                // on shop
//                $sql = "select
//                            a.id as order_id,
//                            b.id as order_detail_id,
//                            b.product_id,
//                            b.variant_id,
//                            b.sku,
//                            b.reduce,
//                            d.name as product_name,
//                            b.quantity,
//                            b.price,
//                            a.total_amount,
//                            a.discount,
//                            a.total_checkout,
//                            a.payment_type,
//                            a.total_reduce,
//                            a.customer_payment,
//                            a.repay,
//                            a.repay_type,
//                            e.size,
//                            e.color,
//                            e.profit,
//                            a.order_date,
//                            a.source,
//                            a.customer_id
//                        from smi_orders a left join smi_order_detail b on a.id = b.order_id
//                        left join smi_variations e on b.sku = e.sku
//                        left join smi_products d on e.product_id = d.id
//                        where a.id = " . $order_id;
//            } else {
//                throw new Exception("Order Type is null or is invalid: $order_type");
//            }

            $result = mysqli_query($this->conn, $sql);
            $data = array();
            $order_id = 0;
            $i = 0;
            foreach ($result as $k => $row) {
                $order_type = $row["order_type"];
                $product_type = $row["product_type"];
                if ($order_id != $row["order_id"]) {
//                    if ($order_type == 1) {
                    $order = array(
                        'order_id' => $row["order_id"],
                        'total_reduce' => $row["total_reduce"],
                        'bill_of_lading_no' => $row["bill_of_lading_no"],
                        'shipping_fee' => number_format($row["shipping_fee"]),
                        'shipping_unit' => $row["shipping_unit"],
                        'customer_id' => $row["customer_id"],
                        'customerName' => $row["customerName"],
                        'phone' => $row["phone"],
                        'email' => $row["email"],
                        'city_id' => $row["city_id"],
                        'district_id' => $row["district_id"],
                        'village_id' => $row["village_id"],
                        'address' => $row["address"],
                        'total_amount' => number_format($row["total_amount"]),
                        'shipping' => number_format($row["shipping"]),
                        'discount' => number_format($row["discount"]),
                        'total_checkout' => number_format($row["total_checkout"]),
                        'payment_type' => $row["payment_type"],
                        'order_date' => $row["order_date"],
                        'source' => $row["source"],
                        'wallet' => $row["wallet"],
                        'saved' => $row["saved"],
                        'customer_payment' => number_format($row["payment"]),
                        'repay' => number_format($row["repay"]),
                        'transfer_to_wallet' => $row["transfer_to_wallet"],
                        'details' => array()
                    );
//                    } else {
//                        $order = array(
//                            'order_id' => $row["order_id"],
//                            'total_amount' => number_format($row["total_amount"]),
//                            'discount' => number_format($row["discount"]),
//                            'total_checkout' => number_format($row["total_checkout"]),
//                            'payment_type' => $row["payment_type"],
//                            'total_reduce' => number_format($row["total_reduce"]),
//                            'customer_payment' => number_format($row["customer_payment"]),
//                            'repay' => number_format($row["repay"]),
//                            'repay_type' => $row["repay_type"],
//                            'order_date' => date_format(date_create($row["order_date"]), "d/m/Y"),
//                            'source' => $row["source"],
//                            'customer_id' => $row["customer_id"],
//                            'details' => array()
//                        );
//                    }

                    $qty = $row["quantity"];
                    $price = $row["price"];
                    $reduce = $row["reduce"];
                    $intoMoney = $qty * ($price - $reduce);
                    if ($order_type == 2) {
                        // order exchange
                        if ($product_type == 2) {
                            $detail = array(
                                'order_detail_id' => $row["order_detail_id"],
                                'product_id' => $row["product_id"],
                                'name' => $row["product_name"],
                                'sku' => $row["sku"],
                                'variant_id' => $row["variant_id"],
                                'quantity' => $qty,
                                'retail' => number_format($price),
                                'intoMoney' => number_format($intoMoney),
                                'discount' => number_format($row["reduce"]),
                                'size' => $row["size"],
                                'color' => $row["color"],
                                'profit' => $row["profit"]
                            );
                            array_push($order['details'], $detail);
                            array_push($data, $order);
                        }
                    } else {
                        $detail = array(
                            'order_detail_id' => $row["order_detail_id"],
                            'product_id' => $row["product_id"],
                            'name' => $row["product_name"],
                            'sku' => $row["sku"],
                            'variant_id' => $row["variant_id"],
                            'quantity' => $qty,
                            'retail' => number_format($price),
                            'intoMoney' => number_format($intoMoney),
                            'discount' => number_format($row["reduce"]),
                            'size' => $row["size"],
                            'color' => $row["color"],
                            'profit' => $row["profit"]
                        );
                        array_push($order['details'], $detail);
                        array_push($data, $order);
                    }
                    $order_id = $row["order_id"];
                    $i++;
                } else {
                    $qty = $row["quantity"];
                    $price = $row["price"];
                    $reduce = $row["reduce"];
                    $intoMoney = $qty * ($price - $reduce);
                    if ($order_type == 2) {
                        // order exchange
                        if ($product_type == 2) {
                            $detail = array(
                                'order_detail_id' => $row["order_detail_id"],
                                'product_id' => $row["product_id"],
                                'name' => $row["product_name"],
                                'sku' => $row["sku"],
                                'variant_id' => $row["variant_id"],
                                'quantity' => $qty,
                                'retail' => number_format($price),
                                'intoMoney' => number_format($intoMoney),
                                'discount' => number_format($row["reduce"]),
                                'size' => $row["size"],
                                'color' => $row["color"],
                                'profit' => $row["profit"]
                            );
                            array_push($data[$i - 1]['details'], $detail);
                        }
                    } else {
                        $detail = array(
                            'order_detail_id' => $row["order_detail_id"],
                            'product_id' => $row["product_id"],
                            'name' => $row["product_name"],
                            'sku' => $row["sku"],
                            'variant_id' => $row["variant_id"],
                            'quantity' => $qty,
                            'retail' => number_format($price),
                            'intoMoney' => number_format($intoMoney),
                            'discount' => number_format($row["reduce"]),
                            'size' => $row["size"],
                            'color' => $row["color"],
                            'profit' => $row["profit"]
                        );
                        array_push($data[$i - 1]['details'], $detail);
                    }
                }
            }
            $arr = array();
            $arr["data"] = $data;
            return $arr;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function delete_order($order_id)
    {
        $stmt = $this->getConn()->prepare("update smi_orders set deleted = 1, updated_date = NOW() WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $order_id);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception($this->getConn()->error);
        }
    }

    function update_qty_by_order_id($order_id)
    {
        $stmt = $this->getConn()->prepare("update smi_variations a
                                            INNER JOIN
                                            (SELECT variant_id,
                                                    quantity
                                            FROM smi_order_detail
                                            WHERE order_id = ?) AS b ON a.id = b.variant_id
                                            SET a.quantity = a.quantity + b.quantity");
        if ($stmt) {
            $stmt->bind_param("i", $order_id);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception($this->getConn()->error);
        }
    }

    function delete_order_detail_by_order_id($order_id)
    {
        try {
            $stmt = $this->getConn()->prepare("delete from smi_order_detail where order_id =  ?");
            $stmt->bind_param("i", $order_id);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_all_order_by_date()
    {
        try {
            $sql = "select  
                        DATE(A.order_date) as date,
                        sum(A.total_amount) as total_amount,
                        sum(C.profit) as total_profit
                    from smi_orders A left join smi_order_detail B on A.id = B.order_id
                    inner join smi_variations C on B.variant_id = C.id
                    group by
                        DATE(A.order_date)
                    order by
                        DATE(A.order_date) desc";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $order = array(
                    'date' => date_format(date_create($row["date"]), "d/m/Y"),
                    'total_amount' => number_format($row["total_amount"]),
                    'total_profit' => number_format($row["total_profit"])
                );
                array_push($data, $order);
            }
            $arr = array();
            $arr["data"] = $data;
            return $arr;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

// find all order
    function find_all($start_date, $end_date, $order_id, $customer_id, $sku)
    {
//        try {
        $sql = "select 
                        A.id as order_id,
                        A.total_checkout,
                        A.order_date,
                        A.type as order_type,
                        A.status,
                        A.payment_type,
                        A.payment_exchange_type,
                        A.order_refer,
                        A.source
                    from smi_orders A ";
        if (!empty($sku) && !empty($sku)) {
            $sql .= " left join smi_order_detail B on A.id = B.order_id";
        }
        $sql .= " where 1=1 ";
        if (!empty($sku) && !empty($sku)) {
            $sql .= " and B.sku = $sku ";
        }
        if (!empty($start_date) && !empty($end_date)) {
            $sql .= " and DATE(order_date) between DATE('" . $start_date . "') and DATE('" . $end_date . "')";
        } else if (!empty($order_id)) {
            $sql .= " and A.id = $order_id";
        } else if (!empty($customer_id)) {
            $sql .= " and A.customer_id = $customer_id";
        }
        $sql .= " and A.deleted = 0 order by A.ID desc";
        $result = mysqli_query($this->conn, $sql);
        $arr = array();
        if ($result) {
            $data = array();
            foreach ($result as $k => $row) {
                $order = array(
                    'order_id' => $row["order_id"],
                    'total_checkout' => number_format($row["total_checkout"]),
                    'order_date' => date_format(date_create($row["order_date"]), "d/m/Y H:i:s"),
                    'order_type' => $row["order_type"],
                    'status' => $row["status"],
                    'payment_type' => $row["payment_type"],
                    'payment_exchange_type' => $row["payment_exchange_type"],
                    'order_refer' => $row["order_refer"],
                    'source' => $row["source"]
                );
                array_push($data, $order);
            }

            $arr["data"] = $data;

        }
        return $arr;
//        } catch (Exception $e) {
//            throw new Exception($e);
//        }
    }

    function get_info_total_checkout($start_date, $end_date, $order_id, $customer_id, $sku)
    {
        try {
            $sql = "select tmp.id,
                      tmp.total_checkout as total_checkout, 
                      sum(tmp.profit) - tmp.discount - tmp.shipping_fee - tmp.wallet as total_profit,
                      count(tmp.type) as count_type, 
                      tmp.type,
                      tmp.payment_type,
                      count(tmp.product_id) as product
                    from (
                      SELECT A.id, A.discount, A.shipping_fee,
                            t.p as profit,
                            A.wallet,
							A.type,  A.payment_type,
                            A.total_checkout,
                            D.id as 'product_id'
                      FROM smi_orders A
                        LEFT JOIN smi_order_detail B ON A.id = B.order_id
                        LEFT JOIN smi_customers C ON A.customer_id = C.id
                        LEFT JOIN smi_variations E ON B.variant_id = E.id
                        LEFT JOIN smi_products D ON E.product_id = D.id
                            LEFT JOIN (select B.id,
                            case B.type
                            when 1 then sum(0 - (B.profit - B.reduce) * B.quantity) 
                            when 3 then sum(0 - (B.profit - B.reduce) * B.quantity) 
                            else sum((B.profit - B.reduce) * B.quantity) 
                            end as p
                            from smi_orders A
                        LEFT JOIN smi_order_detail B ON A.id = B.order_id
                            LEFT JOIN smi_variations E ON B.variant_id = E.id
                        LEFT JOIN smi_products D ON E.product_id = D.id 
                            where 1=1";
            if (!empty($start_date) && !empty($end_date)) {
                $sql .= " and DATE(order_date) between DATE('" . $start_date . "') and DATE('" . $end_date . "')";
            } else if (!empty($order_id)) {
                $sql .= " and A.id = $order_id";
            } else if (!empty($customer_id)) {
                $sql .= " and A.customer_id = $customer_id";
            } else if (!empty($sku)) {
                $sql .= " and B.sku = $sku";
            }
            $sql .= " and A.deleted = 0
                            group by B.id,B.type) as t on t.id = B.id
                      where 1=1";
            if (!empty($start_date) && !empty($end_date)) {
                $sql .= " and DATE(order_date) between DATE('" . $start_date . "') and DATE('" . $end_date . "')";
            } else if (!empty($order_id)) {
                $sql .= " and A.id = $order_id";
            } else if (!empty($customer_id)) {
                $sql .= " and A.customer_id = $customer_id";
            } else if (!empty($sku)) {
                $sql .= " and B.sku = $sku";
            }
            $sql .= " and A.deleted = 0
                      ) tmp
                    group by
						tmp.id,
                      tmp.type,
                      tmp.payment_type
                    order by 
                      tmp.type";

//                    echo $sql;

            $result = mysqli_query($this->conn, $sql);
            $total_checkout = 0;
            $total_on_shop = 0;
            $total_online = 0;
            $count_on_shop = 0;
            $count_online = 0;
            $count_exchange = 0;
            $total_exchange = 0;
            $total_cash = 0;
            $total_transfer = 0;
            $total_profit = 0;
            $total_product = 0;
            $total_product_on_shop = 0;
            $total_product_online = 0;
            $total_product_exchange = 0;
            foreach ($result as $k => $row) {
                $total_checkout += $row["total_checkout"];
                $total_profit += $row["total_profit"];
                if ($row["type"] == 0) {
                    $total_on_shop += $row["total_checkout"];
                    $count_on_shop++;
                    $total_product += $row["product"];
                    $total_product_on_shop += $row["product"];
                } else if ($row["type"] == 1) {
                    $total_online += $row["total_checkout"];
                    $count_online++;
                    $total_product += $row["product"];
                    $total_product_online += $row["product"];
                } else if ($row["type"] == 2) {
                    $total_exchange += $row["total_checkout"];
                    $count_exchange++;
                    $total_product += $row["product"];
                    $total_product_exchange += $row["product"];
                }
                if ($row["payment_type"] == 0) {
                    $total_cash += $row["total_checkout"];
                } else if ($row["payment_type"] == 1) {
                    $total_transfer += $row["total_checkout"];
                }
            }
            $count_total = $count_on_shop + $count_online + $count_exchange;
            $arr = array();
            $arr["total_checkout"] = number_format($total_checkout);
            $arr["count_total"] = $count_total;
            $arr["total_on_shop"] = number_format($total_on_shop);
            $arr["count_on_shop"] = $count_on_shop;
            $arr["total_online"] = number_format($total_online);
            $arr["count_online"] = $count_online;
            $arr["total_exchange"] = number_format($total_exchange);
            $arr["count_exchange"] = $count_exchange;
            $arr["total_cash"] = number_format($total_cash);
            $arr["total_transfer"] = number_format($total_transfer);
            $arr["total_profit"] = number_format($total_profit);
            $arr["total_product"] = number_format($total_product);
            $arr["total_product_on_shop"] = number_format($total_product_on_shop);
            $arr["total_product_online"] = number_format($total_product_online);
            $arr["total_product_exchange"] = number_format($total_product_exchange);
            return $arr;

        } catch (Exception $e) {
            throw new Exception($e);
        }
    }


    function find_detail($order_id)
    {
        try {
            $sql = "select 
                        A.id as order_id,
                        C.id as customer_id,
                        C.name as customer_name,
                        C.phone,
                        C.email,
                        C.full_address,
                        C.address,
                        C.city_id,
                        C.district_id,
                        C.village_id,
                        A.shipping,
                        A.shipping_fee,
                        A.discount,
                        A.wallet,
                        A.total_amount,
                        A.total_checkout,
                        A.order_date,
                        A.type as order_type,
                        A.status,
                        A.total_reduce,
                        A.voucher_code,
                        D.id as product_id,
                        D.name as product_name,
                        E.sku,
                        E.id as variant_id,
                        B.quantity,
                        B.price,
                        B.reduce,
                        E.size,
                        E.color,
                        A.payment_type,
                        B.profit,
                        B.type as product_type,
                        E.updated_qty
                    from smi_orders A 
                        left join smi_order_detail B on A.id = B.order_id
                        left join smi_customers C on A.customer_id = C.id
                        left join smi_variations E on B.sku = E.sku
                        left join smi_products D on E.product_id = D.id
                    where A.deleted = 0 and A.id = " . $order_id . "
                    order by B.type";

            $result = mysqli_query($this->conn, $sql);
            $data = array();
            $order_id = 0;
            $i = 0;
            foreach ($result as $k => $row) {
                if ($order_id != $row["order_id"]) {
//                    $address = $this->get_address($row);
                    $order = array(
                        'order_id' => $row["order_id"],
                        'customer_id' => $row["customer_id"],
                        'customer_name' => $row["customer_name"],
                        'phone' => $row["phone"],
                        'address' => $row["full_address"],
                        'shipping' => number_format($row["shipping"]),
                        'shipping_fee' => number_format($row["shipping_fee"]),
                        'discount' => number_format($row["discount"]),
                        'wallet' => number_format($row["wallet"]),
                        'total_amount' => number_format($row["total_amount"]),
                        'total_checkout' => number_format($row["total_checkout"]),
                        'total_reduce' => number_format($row["total_reduce"]),
                        'order_date' => date_format(date_create($row["order_date"]), "d/m/Y H:i:s"),
                        'order_type' => $row["order_type"],
                        'status' => $row["status"],
                        'payment_type' => $row["payment_type"],
                        'voucher_code' => $row["voucher_code"],
                        'details' => array()
                    );
                    $qty = $row["quantity"];
                    $price = $row["price"];
                    $reduce = $row["reduce"];
                    $intoMoney = $qty * ($price - $reduce);
                    $detail = array(
                        'product_id' => $row["product_id"],
                        'product_name' => $row["product_name"],
                        'sku' => $row["sku"],
                        'variant_id' => $row["variant_id"],
                        'size' => $row["size"],
                        'color' => $row["color"],
                        'quantity' => $qty,
                        'price' => number_format($price),
                        'reduce' => number_format($qty * $reduce),
                        'intoMoney' => number_format($intoMoney),
                        'profit' => number_format(($row["profit"] - $reduce) * $qty),
                        'product_type' => $row["product_type"],
                        'updated_qty' => $row["updated_qty"]
                    );
                    array_push($order['details'], $detail);
                    array_push($data, $order);
                    $order_id = $row["order_id"];
                    $i++;
                } else {
                    $qty = $row["quantity"];
                    $price = $row["price"];
                    $reduce = $row["reduce"];
                    $intoMoney = $qty * $price - $reduce;
                    $detail = array(
                        'product_id' => $row["product_id"],
                        'product_name' => $row["product_name"],
                        'sku' => $row["sku"],
                        'variant_id' => $row["variant_id"],
                        'size' => $row["size"],
                        'color' => $row["color"],
                        'quantity' => $qty,
                        'price' => number_format($price),
                        'reduce' => number_format($qty * $reduce),
                        'intoMoney' => number_format($intoMoney),
                        'profit' => number_format(($row["profit"] - $reduce) * $qty),
                        'product_type' => $row["product_type"],
                        'updated_qty' => $row["updated_qty"]
                    );
                    array_push($data[$i - 1]['details'], $detail);
                }
            }
            $arr = array();
            $arr["data"] = $data;
            return $arr;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

//    function find_all_2($start_date, $end_date)
//    {
//        try {
//            $sql = "select
//                        A.id as order_id,
//                        C.id as customer_id,
//                        C.name as customer_name,
//                        C.phone,
//                        C.email,
//                        C.address,
//                        C.city_id,
//                        C.district_id,
//                        C.village_id,
//                        A.shipping,
//                        A.discount,
//                        case when A.total_reduce is not null then A.total_amount - A.total_reduce else A.total_amount end as 'total_checkout',
//                        A.order_date,
//                        A.type,
//                        A.status,
//                        A.total_reduce,
//                        A.voucher_code,
//                        D.id as product_id,
//                        D.name as product_name,
//                        E.sku,
//                        E.id as variant_id,
//                        B.quantity,
//                        B.price,
//                        B.reduce,
//                        E.size,
//                        E.color,
//                        A.payment_type,
//                        D.profit
//                    from smi_orders A
//                        left join smi_order_detail B on A.id = B.order_id
//                        left join smi_customers C on A.customer_id = C.id
//                        left join smi_variations E on B.variant_id = E.id
//                        left join smi_products D on E.product_id = D.id
//                    where
//                        DATE(order_date) between DATE('" . $start_date . "') and DATE('" . $end_date . "')
//                        and A.deleted = 0
//                    order by A.ID desc";
//            $result = mysqli_query($this->conn, $sql);
//            $data = array();
//            $order_id = 0;
//            $i = 0;
//            foreach ($result as $k => $row) {
//                if ($order_id != $row["order_id"]) {
//                    $address = $this->get_address($row);
//                    $order = array(
//                        'order_id' => $row["order_id"],
//                        'customer_id' => $row["customer_id"],
//                        'customer_name' => $row["customer_name"],
//                        'phone' => $row["phone"],
//                        'address' => $address,
//                        'shipping' => number_format($row["shipping"]),
//                        'discount' => number_format($row["discount"]),
//                        'total_checkout' => number_format($row["total_checkout"]),
//                        'total_reduce' => number_format($row["total_reduce"]),
//                        'order_date' => date_format(date_create($row["order_date"]), "d/m/Y H:i:s"),
//                        'type' => $row["type"],
//                        'status' => $row["status"],
//                        'payment_type' => $row["payment_type"],
//                        'voucher_code' => $row["voucher_code"],
//                        'details' => array()
//                    );
//                    $qty = $row["quantity"];
//                    $price = $row["price"];
//                    $reduce = $row["reduce"];
//                    $intoMoney = $qty * ($price - $reduce);
//                    $detail = array(
//                        'product_id' => $row["product_id"],
//                        'product_name' => $row["product_name"],
//                        'sku' => $row["sku"],
//                        'variant_id' => $row["variant_id"],
//                        'size' => $row["size"],
//                        'color' => $row["color"],
//                        'quantity' => $qty,
//                        'price' => number_format($price),
//                        'reduce' => number_format($qty * $reduce),
//                        'intoMoney' => number_format($intoMoney),
//                        'profit' => number_format($row["profit"] * $qty - $reduce)
//                    );
//                    array_push($order['details'], $detail);
//                    array_push($data, $order);
//                    $order_id = $row["order_id"];
//                    $i++;
//                } else {
//                    $qty = $row["quantity"];
//                    $price = $row["price"];
//                    $reduce = $row["reduce"];
//                    $intoMoney = $qty * $price - $reduce;
//                    $detail = array(
//                        'product_id' => $row["product_id"],
//                        'product_name' => $row["product_name"],
//                        'sku' => $row["sku"],
//                        'variant_id' => $row["variant_id"],
//                        'size' => $row["size"],
//                        'color' => $row["color"],
//                        'quantity' => $qty,
//                        'price' => number_format($price),
//                        'reduce' => number_format($qty * $reduce),
//                        'intoMoney' => number_format($intoMoney),
//                        'profit' => number_format($row["profit"] * $qty - $reduce)
//                    );
//                    array_push($data[$i - 1]['details'], $detail);
//                }
//            }
//            $arr = array();
//            $arr["data"] = $data;
//            return $arr;
//        } catch (Exception $e) {
//            throw new Exception($e);
//        }
//    }

    function saveOrder(Order $order)
    {
        try {
            $total_reduce = $order->getTotal_reduce();
            $total_reduce_percent = $order->getTotal_reduce_percent();
            $discount = $order->getDiscount();
            $wallet = $order->getWallet();
            $total_amount = $order->getTotal_amount();
            $total_checkout = $order->getTotal_checkout();
            $customer_payment = $order->getCustomer_payment();
            $repay = $order->getRepay();
            $transfer_to_wallet = $order->getTransferToWallet();
//            $repayType = $order->getRepayType();
            $customer_id = $order->getCustomer_id();
            $type = $order->getType();
            $bill = $order->getBill_of_lading_no();
            $shipping_fee = $order->getShipping_fee();
            $shipping = $order->getShipping();
            $shipping_unit = $order->getShipping_unit();
            $status = $order->getStatus();
            $payment_type = $order->getPayment_type();
            $voucher_code = $order->getVoucherCode();
            $voucher_value = $order->getVoucherValue();
            $orderRefer = $order->getOrderRefer();
            $paymentExchangeType = $order->getPaymentExchangeType();
            $source = $order->getSource();
            $orderDate = $order->getOrder_date();
            $stmt = $this->getConn()->prepare("insert into smi_orders (
                    `total_reduce`,
                    `total_reduce_percent`,
                    `discount`,
                    `wallet`,
                    `total_amount`,
                    `total_checkout`,
                    `customer_payment`,
                    `payment_type`,
                    `repay`,
                    `transfer_to_wallet`,
                    `customer_id`,
                    `type`,
                    `bill_of_lading_no`,
                    `shipping_fee`,
                    `shipping`,
                    `shipping_unit`,
                    `status`,
                    `voucher_code`,
                    `voucher_value`,
                    `order_refer`,
                    `payment_exchange_type`,
                    `source`,
                    `order_date`,
                    `created_date`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,NOW())");
            $stmt->bind_param("dddddddiddiisddsisdiiis", $total_reduce, $total_reduce_percent, $discount, $wallet, $total_amount,
                $total_checkout, $customer_payment, $payment_type, $repay, $transfer_to_wallet, $customer_id, $type, $bill, $shipping_fee,
                $shipping, $shipping_unit, $status, $voucher_code, $voucher_value, $orderRefer, $paymentExchangeType, $source, $orderDate);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $lastid = mysqli_insert_id($this->conn);
            return $lastid;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function updateOrder(Order $order)
    {
        try {
            $total_reduce = $order->getTotal_reduce();
            $total_reduce_percent = $order->getTotal_reduce_percent();
            $discount = $order->getDiscount();
            $total_amount = $order->getTotal_amount();
            $total_checkout = $order->getTotal_checkout();
            $customer_payment = $order->getCustomer_payment();
            $repay = $order->getRepay();
            $customer_id = $order->getCustomer_id();
            $type = $order->getType();
            $bill = $order->getBill_of_lading_no();
            $shipping_fee = $order->getShipping_fee();
            $shipping = $order->getShipping();
            $shipping_unit = $order->getShipping_unit();
            $status = $order->getStatus();
            $payment_type = $order->getPayment_type();
            $order_date = $order->getOrder_date();
//            if (!empty($order->getOrder_date())) {
//                $date = $order->getOrder_date();
//                $date = str_replace('/', '-', $date);
//                $date .= date("H:i:s");
//                $order_date = date('Y-m-d H:i:s', strtotime($date));
//            }
            $source = $order->getSource();
            $id = $order->getId();
            $stmt = $this->getConn()->prepare("update `smi_orders` SET `total_reduce` = ?, `total_reduce_percent` = ?, `discount` = ?, `total_amount` = ?, `total_checkout` = ?, `customer_payment` = ?, `repay` = ?, `customer_id` = ?, `type` = ?, `bill_of_lading_no` = ?, `shipping_fee` = ?, `shipping` = ?, `shipping_unit` = ?, `status` = ?, `updated_date` = NOW(), `deleted` = b'0', `payment_type` = ?, `order_date` = ?, `source` = ? WHERE `id` = ?");
            $stmt->bind_param("dddddddiisddsiisis", $total_reduce, $total_reduce_percent, $discount, $total_amount, $total_checkout, $customer_payment, $repay, $customer_id, $type, $bill, $shipping_fee, $shipping, $shipping_unit, $status, $payment_type, $order_date, $source, $id);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
            return $id;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function saveOrderDetail(OrderDetail $detail)
    {
        try {
            $order_id = $detail->getOrder_id();
            $product_id = $detail->getProduct_id();
            $variant_id = $detail->getVariant_id();
            $sku = $detail->getSku();
            $price = $detail->getPrice();
            $qty = $detail->getQuantity();
            $reduce = $detail->getReduce();
            $reduce_percent = $detail->getReduce_percent();
            $reduce_type = $detail->getReduceType();
            $type = $detail->getType();
            $profit = $detail->getProfit();
            $stmt = $this->getConn()->prepare("insert into smi_order_detail (
                    `order_id`,
                    `product_id`,
                    `variant_id`,
                    `sku`,
                    `price`,
                    `quantity`,
                    `reduce`,
                    `reduce_percent`,
                    `reduce_type`,
                    `type`,
                    `profit`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiisdidiiid", $order_id, $product_id, $variant_id, $sku, $price, $qty, $reduce, $reduce_percent, $reduce_type, $type, $profit);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
            $lastid = mysqli_insert_id($this->conn);
            return $lastid;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function updateOrderDetail(OrderDetail $detail)
    {
        try {
            $order_id = $detail->getOrder_id();
            $product_id = $detail->getProduct_id();
            $variant_id = $detail->getVariant_id();
            $sku = $detail->getSku();
            $price = $detail->getPrice();
            $qty = $detail->getQuantity();
            $reduce = $detail->getReduce();
            $reduce_percent = $detail->getReduce_percent();
            $reduce_type = $detail->getReduceType();
            $type = $detail->getType();
            $profit = $detail->getProfit();
            $id = $detail->getId();
            $stmt = $this->getConn()->prepare("update `smi_order_detail`
                    SET `order_id` = ?, `product_id` = ?, `variant_id` = ?,
                    `sku` = ?, `price` = ?, `quantity` = ?, `reduce` = ?, `reduce_percent` = ?, `reduce_type` = ?, `profit` = ? WHERE `id` = ?");
            $stmt->bind_param("iiisdiddidi", $order_id, $product_id, $variant_id, $sku, $price, $qty, $reduce, $type, $reduce_percent, $reduce_type, $profit, $id);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
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
                        B.full_address,
                        A.shipping_unit
                    FROM 
                    smi_orders A inner join smi_customers B on A.customer_id = B.id
                    WHERE A.id = " . $order_id;
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
//                $address = $this->get_address($row);
                $order = array(
                    'bill' => $row["bill"],
                    'name' => $row["name"],
                    'phone' => $row["phone"],
                    'address' => $row["full_address"],
                    'shipping_unit' => $row["shipping_unit"],
                );
                array_push($data, $order);
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function get_address($row)
    {
        $zone = new Zone();
        $cityId = $row["city_id"];
        $cityName = $zone->get_name_city($cityId);
        $districtId = $row["district_id"];
        $districtName = $zone->get_name_district($districtId);
        $villageId = $row["village_id"];
        $villageName = $zone->get_name_village($villageId);
        if (!empty($row["address"])) {
            $address = $row["address"];
            if (!empty($villageName)) {
                $address .= ", " . $villageName;
                if (!empty($districtName)) {
                    $address .= ", " . $districtName;
                    if (!empty($cityName)) {
                        $address .= ", " . $cityName;
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
