<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

const PENDING = 0;
const PACKED = 1;
const DELIVERED = 2;
const SUCCESS = 3;
const _EXCHANGE = 4;
const _RETURN = 5;
const CANCEL = 6;
const APPOINTMENT = 7;
const WAIT = 8;
const WAITING_RETURN = 9;
const RETURNED = 10;
const WAITING_EXCHANGE = 11;
const EXCHANGING = 12;
const CREATED_BILL = 13;
const FOLLOWING = 15;

class CheckoutDAO
{
    private $conn;

    function __construct($db) {
        $this->conn = $db->getConn();
    } 

    function update_new_customer_id($old_id, $new_id) {
        try {
            $sql = "UPDATE `smi_orders` SET `new_customer_id`= ?  WHERE `customer_id` = ?";    
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bind_param("ii", $new_id, $old_id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_new_product_id_order_detail_by_sku($sku, $new_product_id, $new_sku) {
        try {
            $sql = "UPDATE `smi_order_detail` SET `new_product_id`= ?, `new_sku`= ? WHERE `sku` = ?";    
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bind_param("iis", $new_product_id, $new_sku, $sku);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_all_order_online() {
        try {
            $sql = "SELECT * FROM `smi_orders` WHERE source <> 0 and deleted = 0 ORDER BY `smi_orders`.`id` ASC";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    $order = array(
                        'order_id' => $row["id"]
                    );
                    array_push($data, $order);
                }
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function update_new_order_id($old_id, $new_id) {
        try {
            $sql = "UPDATE `smi_orders` SET `order_id`= ?  WHERE `id` = ?";    
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bind_param("ii", $new_id, $old_id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_new_order_id_order_detail($old_order_id, $new_order_id) {
        try {
            $sql = "UPDATE `smi_order_detail` SET `new_order_id`= ?  WHERE `order_id` = ?";    
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bind_param("ii", $new_order_id, $old_order_id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_new_order_id_order_logs($old_order_id, $new_order_id) {
        try {
            $sql = "UPDATE `smi_order_logs` SET `new_order_id`= ?  WHERE `order_id` = ?";    
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bind_param("ii", $new_order_id, $old_order_id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }


    function find_all_order_details($source) {
        try {
            $sql = "SELECT b.*
                    FROM `smi_orders` a
                    LEFT JOIN smi_order_detail b ON a.order_id = b.order_id
                    WHERE a.source <> $source
                    GROUP BY `b`.`sku`";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    if(!empty($row["sku"])) {
                        $order_detail = array(
                            'detail_id' => $row["id"],
                            'sku' => $row["sku"],
                            'updated_id' => $row["updated_id"]
                        );
                        array_push($data, $order_detail);
                    }
                }
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function update_sku_order_detail($old_sku, $new_sku) {
        try {
            $sql = "UPDATE `smi_order_detail` SET `sku`= ?  WHERE `sku` = ?";    
            $stmt = $this->getConn()->prepare($sql);
            $stmt->bind_param("ss", $new_sku, $old_sku);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_customer_id($order_id, $customer_id) {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_orders` SET `customer_id`= ?, `updated_id`= true  WHERE `id` = ?");
            $stmt->bind_param("ii", $customer_id, $order_id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_order_by_customer($customer_id) {
        try {
            $sql = "SELECT * FROM `smi_orders` WHERE customer_id = $customer_id";
            $result = mysqli_query($this->conn, $sql);
            // $row = $result->fetch_row();
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    $order = array(
                        'id' => $row["id"],
                        'order_id' => $row["order_id"],
                        'customer_id' => $row["customer_id"]
                    );
                    array_push($data, $order);
                }
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function find_all_orders() {
        try {
            $sql = "SELECT * FROM `smi_orders` where source <> 0";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    $order = array(
                        'id' => $row["id"],
                        'order_id' => $row["order_id"],
                        'updated_id' => $row["updated_id"] == 0 ? false : true
                    );
                    array_push($data, $order);
                }
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function find_order_details($order_id) {
        try {
            $sql = "SELECT * FROM `smi_order_detail` WHERE order_id = $order_id";
            $result = mysqli_query($this->conn, $sql);
            // $row = $result->fetch_row();
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    $order_detail = array(
                        'id' => $row["id"],
                        'order_id' => $row["order_id"],
                        'sku' => $row["sku"],
                        'product_id' => $row["product_id"],
                        'variant_id' => $row["variant_id"],
                        'updated_id' => $row["updated_id"]
                    );
                    array_push($data, $order_detail);
                }
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function find_order_logs($order_id) {
        try {
            $sql = "SELECT * FROM `smi_order_logs` WHERE order_id = $order_id AND `updated_id` = false";
            $result = mysqli_query($this->conn, $sql);
            // $row = $result->fetch_row();
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    $order_detail = array(
                        'id' => $row["id"],
                        'order_id' => $row["order_id"],
                        'updated_id' => $row["updated_id"]
                    );
                    array_push($data, $order_detail);
                }
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function update_order_logs($id, $order_id) {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_order_logs` SET `order_id`= ?, `updated_id`= true  WHERE `id` = ?");
            $stmt->bind_param("ii", $order_id, $id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_order_wallets($order_id) {
        try {
            $sql = "SELECT * FROM `smi_wallet` WHERE order_id = $order_id";
            $result = mysqli_query($this->conn, $sql);
            // $row = $result->fetch_row();
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    $order_detail = array(
                        'id' => $row["id"],
                        'order_id' => $row["order_id"],
                        'updated_id' => $row["updated_id"]
                    );
                    array_push($data, $order_detail);
                }
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function update_order_wallets($id, $order_id) {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_wallet` SET `order_id`= ?, `updated_id`= true  WHERE `id` = ?");
            $stmt->bind_param("ii", $order_id, $id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_customer_wallet($customer_id) {
        try {
            $sql = "SELECT * FROM `smi_wallet` WHERE customer_id = $customer_id";
            $result = mysqli_query($this->conn, $sql);
            // $row = $result->fetch_row();
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    $order_detail = array(
                        'id' => $row["id"],
                        'customer_id' => $row["customer_id"],
                        'updated_id' => $row["updated_id"]
                    );
                    array_push($data, $order_detail);
                }
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function update_customer_wallet($id, $customer_id) {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_wallet` SET `customer_id`= ?, `updated_id`= true  WHERE `id` = ?");
            $stmt->bind_param("ii", $customer_id, $id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_order_id($id, $order_id) {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_orders` SET `order_id`= ?, `updated_id`= true  WHERE `id` = ?");
            $stmt->bind_param("ii", $order_id, $id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update_order_detail($id, $order_id) {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_order_detail` SET `order_id`= ?, `updated_id`= true WHERE id = ?");
            $stmt->bind_param("ii", $order_id, $id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_order($order_id) {
        try {
            $sql = "SELECT * FROM `smi_orders` WHERE id = $order_id";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    $order = array(
                        'id' => $row["id"],
                        'updated_id' => $row["updated_id"]
                    );
                    array_push($data, $order);
                }
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function find_order_detail_by_variant_id($variant_id) {
        try {
            $sql = "SELECT * FROM `smi_order_detail` WHERE variant_id = $variant_id";
            $result = mysqli_query($this->conn, $sql);
            // $row = $result->fetch_row();
            $data = array();
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    $order_detail = array(
                        'id' => $row["id"],
                        'order_id' => $row["order_id"],
                        'updated_id' => $row["updated_id"]
                    );
                    array_push($data, $order_detail);
                }
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function getTotalShippingUnit($status)
    {
        try {
            $sql = "SELECT `shipping_unit`,
                            count(*) AS total
                    FROM `smi_orders`
                    WHERE `type` = 1
                      AND `status` in ($status)
                      AND `deleted` = 0
                    GROUP BY `shipping_unit`";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $total = array(
                    'shipping_unit' => $row["shipping_unit"],
                    'total' => $row["total"]
                );
                array_push($data, $total);
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function checkExistOrderShopee($shopeeOrderId)
    {
        try {
            $sql = "select count(*) as orderNumber from smi_orders where shopee_order_id = '$shopeeOrderId' and deleted = false";
            $result = mysqli_query($this->conn, $sql);
            $orderNumber = 0;
            $row = $result -> fetch_assoc();
            $orderNumber = $row["orderNumber"];
            // Free result set
            $result -> free_result();
            return $orderNumber;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }
    
    function findOrderShopee($shopeeOrderIds)
    {
        try {
            $sql = "select * from smi_orders where shopee_order_id in ($shopeeOrderIds)";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $order = array(
                    'id' => $row["id"],
                    'shopee_order_id' => $row["shopee_order_id"]
                );
                array_push($data, $order);
            }
            return $data;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }


    function update_print($id)
    {
      $stmt = $this->getConn()->prepare("update smi_orders set is_print = true where id in ($id)");
      if ($stmt) {
        if (!$stmt->execute()) {
          throw new Exception($stmt->error);
        }
        $stmt->close();
      } else {
        throw new Exception($this->getConn()->error);
      }
    }

  function update_success_by_bills($bills)
  {
    $stmt = $this->getConn()->prepare("update smi_orders set status = 3 where bill_of_lading_no in ($bills)");
    if ($stmt) {
//      $stmt->bind_param("s", $bills);
      if (!$stmt->execute()) {
        throw new Exception($stmt->error);
      }
      $stmt->close();
    } else {
      throw new Exception($this->getConn()->error);
    }
  }

  function update_description($order_id, $content_description)
  {
    if(empty($delivery_date)) {
      $delivery_date = null;
    }
    $stmt = $this->getConn()->prepare("update smi_orders set description = ?, updated_date = NOW() WHERE id = ?");
    if ($stmt) {
      $stmt->bind_param("si", $content_description, $order_id);
      if (!$stmt->execute()) {
        throw new Exception($stmt->error);
      }
      $stmt->close();
    } else {
      throw new Exception($this->getConn()->error);
    }
  }

  function update_delivery_date($order_id, $delivery_date)
  {
    if(empty($delivery_date)) {
      $delivery_date = null;
    }
    $stmt = $this->getConn()->prepare("update smi_orders set delivery_date = ?, updated_date = NOW() WHERE id = ?");
    if ($stmt) {
      $stmt->bind_param("si", $delivery_date, $order_id);
      if (!$stmt->execute()) {
        throw new Exception($stmt->error);
      }
      $stmt->close();
    } else {
      throw new Exception($this->getConn()->error);
    }
  }

    function update_bill($order_id, $status, $bill_no, $shipping_fee, $estimated_delivery, $shipping_unit)
    {
      $stmt = $this->getConn()->prepare("update smi_orders set status = ?, bill_of_lading_no = ?, shipping_fee = ?, estimated_delivery = ?, shipping_unit = ?, total_checkout = total_checkout - shipping_fee, delivery_date = NOW(),updated_date = NOW() WHERE id = ?");
      if ($stmt) {
        $stmt->bind_param("isddsi", $status, $bill_no, $shipping_fee, $estimated_delivery, $shipping_unit, $order_id);
        if (!$stmt->execute()) {
          throw new Exception($stmt->error);
        }
        $stmt->close();


      } else {
        throw new Exception($this->getConn()->error);
      }
    }

    function update_status($order_id, $status, $appointment_delivery_date)
    {
        $sql = "update smi_orders set status = ?";
        if(!empty($appointment_delivery_date)) {
            $sql .= " ,appointment_delivery_date = '$appointment_delivery_date'";
        }
        $sql .= " ,updated_date = NOW() WHERE id in ($order_id)";
        $stmt = $this->getConn()->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $status);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception($this->getConn()->error);
        }
    }

    function update_payment_type($order_id, $payment_type)
    {
        $sql = "update smi_orders set payment_type = ?, updated_date = NOW() WHERE id in ($order_id)";
        $stmt = $this->getConn()->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $payment_type);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception($this->getConn()->error);
        }
    }

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

  function find_order_logs_by_id($orderId)
  {
    try {
      $sql = "select * from smi_order_logs where order_id = $orderId";
      $result = mysqli_query($this->conn, $sql);
      $data = array();
      foreach ($result as $k => $row) {
        $orderLogs = array(
          'id' => $row["order_id"],
          'order_id' => $row["order_id"],
          'action' => $row["action"],
          'created_by' => $row["created_by"],
          'created_date' => date_format(date_create($row["created_date"]), "d/m/Y"),
          'created_time' => date_format(date_create($row["created_date"]), "h:i A")
        );
        array_push($data, $orderLogs);
      }
      return $data;
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
                    from smi_order_detail a inner join smi_products b on a.product_id = b.id 
                    where a.order_id = $orderId";
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
            $sql = "select 
                        a.id as order_id,
                        a.total_reduce,
                        a.bill_of_lading_no,
                        a.shipping_fee,
                        a.shipping_unit,
                        a.total_amount,
                        a.shipping,
                        a.discount,
                        a.total_checkout,
                        a.COD as cod,
                        a.payment_type,
                        a.order_date,
                        a.source,
                        a.shopee_order_id,
                        a.wallet,
                        a.customer_payment as payment,
                        a.repay,
                        a.transfer_to_wallet,
                        a.type as order_type,
                        a.status,
                        a.description,
                        b.id as order_detail_id,
                        b.product_id,
                        b.variant_id,
                        b.sku,
                        b.reduce,
                        b.quantity,
                        b.price,
                        b.type as product_type,
                        c.id as customer_id,
                        c.name as customerName,
                        c.phone,
                        c.email,
                        c.city_id,
                        c.district_id,
                        c.village_id,
                        c.address,
                        d.name as product_name,
                        e.size,
                        e.color,
                        e.profit,
                        e.image,
                        w.saved
                    from smi_orders a left join smi_order_detail b on a.id = b.order_id
                    left join smi_customers c on a.customer_id = c.id
                    left join smi_variations e on b.sku = e.sku
                    left join smi_products d on e.product_id = d.id
                    left join smi_wallet w on a.id = w.order_id
                    where a.id = $order_id";

            $result = mysqli_query($this->conn, $sql);
            $data = array();
            $order_id = 0;
            $i = 0;
            foreach ($result as $k => $row) {
                $order_type = $row["order_type"];
                $product_type = $row["product_type"];
                if ($order_id != $row["order_id"]) {
                    $order = array(
                        'order_id' => $row["order_id"],
                        'order_type' => $row["order_type"],
                        'status' => $row["status"],
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
                        'cod' => number_format($row["cod"]),
                        'payment_type' => $row["payment_type"],
                        'order_date' => $row["order_date"],
                        'source' => $row["source"],
                        'shopee_order_id' => $row["shopee_order_id"],
                        'wallet' => $row["wallet"],
                        'saved' => $row["saved"],
                        'customer_payment' => number_format($row["payment"]),
                        'repay' => number_format($row["repay"]),
                        'transfer_to_wallet' => $row["transfer_to_wallet"],
                        'description' => $row["description"],
                        'details' => array()
                    );

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
                                'image' => $row["image"],
                                'variant_id' => $row["variant_id"],
                                'qty' => $qty,
                                'retail' => number_format($price),
                                'intoMoney' => number_format($intoMoney),
                                'discount' => number_format($row["reduce"]),
                                'size' => $row["size"],
                                'color' => $row["color"],
                                'profit' => $row["profit"]
                            );
                            array_push($order['details'], $detail);
                        }
                        // array_push($data, $order);
                    } else {
                        $detail = array(
                            'order_detail_id' => $row["order_detail_id"],
                            'product_id' => $row["product_id"],
                            'name' => $row["product_name"],
                            'sku' => $row["sku"],
                            'image' => $row["image"],
                            'variant_id' => $row["variant_id"],
                            'qty' => $qty,
                            'retail' => number_format($price),
                            'intoMoney' => number_format($intoMoney),
                            'discount' => number_format($row["reduce"]),
                            'size' => $row["size"],
                            'color' => $row["color"],
                            'profit' => $row["profit"]
                        );
                        array_push($order['details'], $detail);
                        // array_push($data, $order);
                    }
                    array_push($data, $order);
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
                                'image' => $row["image"],
                                'variant_id' => $row["variant_id"],
                                'qty' => $qty,
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
                            'image' => $row["image"],
                            'variant_id' => $row["variant_id"],
                            'qty' => $qty,
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

    function find_all($start_date, $end_date, $order_id, $customer_id, $sku, $type, $status, $bill, $shipping_unit)
    {
        $sql = "select 
                        A.id,
                        sum(B.quantity) as quantity,
                        A.total_amount + A.shipping - A.total_reduce as total_amount,
                        A.total_checkout,
                        A.cod,
                        A.order_date,
                        A.appointment_delivery_date,
                        A.type as order_type,
                        A.status,
                        A.payment_type,
                        A.payment_exchange_type,
                        A.order_refer,
                        A.source,
                        A.description,
                        A.shipping_unit,
                        A.shipping_fee,
                        A.estimated_delivery,
                        A.bill_of_lading_no,
                        A.utm_source,
                        A.shopee_order_id,
                        A.is_print";
        // if(isset($type) && $type == 1) {// online order
          $sql .= " ,C.id as customer_id,
                    C.name as customer_name,
                    C.phone as customer_phone,
                    C.full_address as customer_address,
                    C.facebook,
                    C.link_fb";
        // }
        $sql .= " from smi_orders A  left join smi_order_detail B on A.id = B.order_id ";
        // if(isset($type) && $type == 1) {// online order
          $sql .= " left join smi_customers C on A.customer_id = C.id";
        // }
        $sql .= " where 1=1 ";
        if (isset($sku) && !empty($sku)) {
            $sql .= " and B.sku = $sku ";
        }
        if (isset($start_date) && !empty($start_date) && isset($end_date) && !empty($end_date)) {
            $sql .= " and DATE(order_date) between DATE('" . $start_date . "') and DATE('" . $end_date . "')";
        } 
        if (isset($order_id) && !empty($order_id)) {
            $sql .= " and A.id = $order_id";
        }
        if (isset($customer_id) && !empty($customer_id)) {
            $sql .= " and A.customer_id = $customer_id";
        } 
        if (isset($bill) && !empty($bill)) {
          $sql .= " and A.bill_of_lading_no = '$bill'";
        }
        if(isset($type) && !empty($type)) {
          $sql .= " and A.type = $type"; // ONLINE
        } else {
            $sql .= " and A.type in (0,2)";// SHOP
        }

        if (isset($shipping_unit) && !empty($shipping_unit)) {
          $sql .= " and A.shipping_unit = '$shipping_unit'";
        }

        if(isset($status) && $status != '' && $status != -1) {
            $sql .= " and A.status in ($status)";
        } else {
          // $sql .= " and A.status in (0,1,2,3,13)";
        }
        $sql .= " and A.deleted = 0 
                  GROUP by A.id,
                        A.total_checkout,
                        A.order_date,
                        A.appointment_delivery_date,
                        A.type,
                        A.status,
                        A.payment_type,
                        A.payment_exchange_type,
                        A.order_refer,
                        A.source,
                        A.description,
                        A.shipping_unit,
                        A.shipping_fee,
                        A.estimated_delivery,
                        A.bill_of_lading_no,
                        A.shopee_order_id
                  order by A.order_date desc, A.updated_date desc";

// var_dump($sql);


        $result = mysqli_query($this->conn, $sql);

        $arr = array();
        $data = array();
        if ($result) {

            foreach ($result as $k => $row) {
                $customer_name = '';
                $customer_phone = '';
                $customer_address = '';
                // if(isset($type) && $type == 1) {
                  $customer_id = $row["customer_id"];
                  $customer_name = $row["customer_name"];
                  $customer_phone = $row["customer_phone"];
                  $customer_address = $row["customer_address"];
                  $facebook = $row["facebook"];
                  $link_fb = $row["link_fb"];
                // }

                $order = array(
                    'order_id' => $row["id"],
                    'quantity' => $row["quantity"],
                    'total_amount' => number_format($row["total_amount"]),
                    'total_checkout' => number_format($row["total_checkout"]),
                    'cod' => number_format($row["cod"]),
                    'order_date' => date_format(date_create($row["order_date"]), "d/m/Y H:i:s"),
                    'appointment_delivery_date' => !empty($row["appointment_delivery_date"]) ? date_format(date_create($row["appointment_delivery_date"]), "d/m/Y") : '',
                    'delivery_date' => !empty($row["delivery_date"]) ? date_format(date_create($row["delivery_date"]), "d/m/Y") : '',
                    'order_type' => $row["order_type"],
                    'status' => $row["status"],
                    'payment_type' => $row["payment_type"],
                    'payment_exchange_type' => $row["payment_exchange_type"],
                    'order_refer' => $row["order_refer"],
                    'source' => $row["source"],
                    'shopee_order_id' => $row["shopee_order_id"],
                    'utm_source' => $row["utm_source"],
                    'description' => $row["description"],
                    'shipping_unit' => $row["shipping_unit"],
                    'shipping_fee' => $row["shipping_fee"],
                    'estimated_delivery' => $row["estimated_delivery"],
                    'bill_of_lading_no' => $row["bill_of_lading_no"],
                    'customer_id' => $customer_id,
                    'customer_name' => $customer_name,
                    'customer_phone' => $customer_phone,
                    'customer_address' => $customer_address,
                    'is_print' => $row["is_print"],
                );
                array_push($data, $order);
            }


        }
      $arr["data"] = $data;
        return $arr;
//        } catch (Exception $e) {
//            throw new Exception($e);
//        }
    }
    function get_info_total_checkout($start_date, $end_date, $order_id, $customer_id, $sku, $type, $status, $bill)
    {
        try {
            // $sql = "select tmp.id,
            //           tmp.total_checkout as total_checkout, 
            //           tmp.total_amount + case when tmp.shipping is null then 0 else sum(tmp.shipping) end - tmp.discount as total_amount, 
            //           (case when tmp.profit is null then 0 else sum(tmp.profit) end)  + 
            //           (case when tmp.shipping is null then 0 else sum(tmp.shipping) end) - tmp.discount - tmp.shipping_fee - tmp.wallet as total_profit,
            //           count(tmp.type) as count_type, 
            //           tmp.type,
            //           tmp.source,
            //           tmp.payment_type,
            //           count(tmp.product_id) as product
            //         from (
            //           SELECT A.id, A.discount, A.shipping_fee, 
            //             case when A.shipping is NULL then 0 else A.shipping end as shipping,
            //                 t.p as profit,
            //                 A.wallet,
            //                 A.type,  A.payment_type,
            //                 A.source,
            //                 A.total_checkout,
            //                 A.total_amount,
            //                 D.id as product_id
            //           FROM smi_orders A
            //             LEFT JOIN smi_order_detail B ON A.id = B.order_id
            //             LEFT JOIN smi_customers C ON A.customer_id = C.id
            //             LEFT JOIN smi_products D ON D.id = B.product_id
            //                 LEFT JOIN (select B.id,
            //                 case B.type
            //                 when 1 then sum(0 - (B.profit * B.quantity) - B.reduce) 
            //                 when 3 then sum(0 - (B.profit * B.quantity) - B.reduce) 
            //                 else sum((B.profit * B.quantity) - B.reduce) 
            //                 end as p
            //                 from smi_orders A
            //             LEFT JOIN smi_order_detail B ON A.id = B.order_id
            //             LEFT JOIN smi_products D ON D.id = B.product_id 
            //                 where 1=1 ";

       // comment date 2024-03-01    
            // $sql = "select tmp.id,
            //           tmp.total_checkout as total_checkout, 
            //           tmp.total_amount + case when tmp.shipping is null then 0 else sum(tmp.shipping) end - tmp.discount as total_amount, 
            //           (case when tmp.profit is null then 0 else sum(tmp.profit) end)  + 
            //           (case when tmp.shipping is null then 0 else sum(tmp.shipping) end) - tmp.discount - tmp.shipping_fee - tmp.wallet as total_profit,
            //           count(tmp.type) as count_type, 
            //           tmp.type,
            //           tmp.source,
            //           tmp.payment_type,
            //           count(tmp.product_id) as product
            //         from (
            //           SELECT A.id, A.discount, A.shipping_fee, 
            //             case when A.shipping is NULL then 0 else A.shipping end as shipping,
            //                 t.p as profit,
            //                 A.wallet,
            //                 A.type,  A.payment_type,
            //                 A.source,
            //                 A.total_checkout,
            //                 A.total_amount,
            //                 D.id as product_id
            //           FROM smi_orders A
            //             LEFT JOIN smi_order_detail B ON A.id = B.order_id
            //             LEFT JOIN smi_customers C ON A.customer_id = C.id
            //             LEFT JOIN smi_products D ON D.id = B.product_id
            //                 LEFT JOIN (select B.id,
            //                 case B.type
            //                 when 1 then sum(0 - (B.profit * B.quantity))
            //                 when 3 then sum(0 - (B.profit * B.quantity)) 
            //                 else sum(B.profit * B.quantity) 
            //                 end as p
            //                 from smi_orders A
            //             LEFT JOIN smi_order_detail B ON A.id = B.order_id
            //             LEFT JOIN smi_products D ON D.id = B.product_id 
            //                 where 1=1 ";
        // end comment date 2024-03-01
            $sql = "select tmp.id,
                      tmp.total_checkout as total_checkout, 
                      tmp.total_amount + case when tmp.shipping is null then 0 else sum(tmp.shipping) end - tmp.discount as total_amount, 
                      (case when tmp.profit is null then 0 else sum(tmp.profit) end)  + 
                      (case when tmp.shipping is null then 0 else sum(tmp.shipping) end) - tmp.total_reduce - tmp.shipping_fee as total_profit,
                      count(tmp.type) as count_type, 
                      tmp.type,
                      tmp.source,
                      tmp.payment_type,
                      count(tmp.product_id) as product
                    from (
                      SELECT A.id, A.total_reduce, A.discount, A.shipping_fee, 
                        case when A.shipping is NULL then 0 else A.shipping end as shipping,
                            t.p as profit,
                            A.wallet,
                            A.type,  A.payment_type,
                            A.source,
                            A.total_checkout,
                            A.total_amount,
                            D.id as product_id
                      FROM smi_orders A
                        LEFT JOIN smi_order_detail B ON A.id = B.order_id
                        LEFT JOIN smi_customers C ON A.customer_id = C.id
                        LEFT JOIN smi_products D ON D.id = B.product_id
                            LEFT JOIN (select B.id,
                            case B.type
                            when 1 then sum(0 - B.profit)
                            when 3 then sum(0 - B.profit) 
                            else sum(B.profit) 
                            end as p
                            from smi_orders A
                        LEFT JOIN smi_order_detail B ON A.id = B.order_id
                        LEFT JOIN smi_products D ON D.id = B.product_id 
                            where 1=1 ";
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
                      where 1=1 ";
            // if(isset($type) && $type != 1) {
            //   $sql .= "and A.status in (3,6)";
            // }
            if (!empty($start_date) && !empty($end_date)) {
                $sql .= " and DATE(order_date) between DATE('" . $start_date . "') and DATE('" . $end_date . "')";
            } else if (!empty($order_id)) {
                $sql .= " and A.id = $order_id";
            } else if (!empty($customer_id)) {
                $sql .= " and A.customer_id = $customer_id";
            } else if (!empty($sku)) {
                $sql .= " and B.sku = $sku";
            }
            if(isset($type) && !empty($type)) {
              $sql .= " and A.type = $type"; // ONLINE
            } else {
                 $sql .= " and A.type in (0,2)";// SHOP
            }
            if(isset($status) && $status != '' && $status != -1) {
                $sql .= " and A.status in ($status)";
            } else if(isset($type) && !empty($type) && $type != 1) {
              $sql .= "and A.status in (3,6)";
            } else {
              $sql .= " and A.status in (0,1,2,3,13,6,15)";
            }
            $sql .= "  and A.deleted = 0) tmp
                    group by
                      tmp.id,
                      tmp.type,
                      tmp.payment_type
                    order by 
                      tmp.type";

                    // echo $sql;

            $result = mysqli_query($this->conn, $sql);
            $total_amount = 0;
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

            $total_on_facebook = 0;
            $total_on_shopee = 0;
            $total_on_zalo = 0;
            $total_on_website = 0;
            $total_on_lazada = 0;
            $total_on_tiki = 0;

            $count_on_facebook = 0;
            $count_on_shopee = 0;
            $count_on_website = 0;
            $count_on_lazada = 0;
            $count_on_zalo = 0;
            $count_on_tiki = 0;

            $total_product_on_facebook = 0;
            $total_product_on_website = 0;
            $total_product_on_lazada = 0;
            $total_product_on_shopee = 0;
            $total_product_on_zalo = 0;
            $total_product_on_tiki = 0;

            $total_profit_on_facebook = 0;
            $total_profit_on_shopee = 0;
            $total_profit_on_website = 0;
            $total_profit_on_lazada = 0;
            $total_profit_on_zalo = 0;
            $total_profit_on_tiki = 0;

            foreach ($result as $k => $row) {
                $total_amount += $row["total_amount"];
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
                if ($row["source"] == 1) {
                  //website
                  $total_on_website += $row["total_checkout"];
                  $count_on_website++;
                  $total_product_on_website += $row["product"];
                  $total_profit_on_website += $row["total_profit"];
                } else if ($row["source"] == 2 || $row["source"] == 4) {
                  // facebook
                  $total_on_facebook += $row["total_checkout"];
                  $count_on_facebook++;
                  $total_product_on_facebook += $row["product"];
                  $total_profit_on_facebook += $row["total_profit"];
                } else if ($row["source"] == 3) {
                  // shopee
                  $total_on_shopee += $row["total_checkout"];
                  $count_on_shopee++;
                  $total_product_on_shopee += $row["product"];
                  $total_profit_on_shopee += $row["total_profit"];
                } else if ($row["source"] == 5) {
                  // lazada
                  $total_on_lazada += $row["total_checkout"];
                  $count_on_lazada++;
                  $total_product_on_lazada += $row["product"];
                  $total_profit_on_lazada += $row["total_profit"];
                } else if ($row["source"] == 6) {
                  // zalo
                  $total_on_zalo += $row["total_checkout"];
                  $count_on_zalo++;
                  $total_product_on_zalo += $row["product"];
                  $total_profit_on_zalo += $row["total_profit"];
                } else if ($row["source"] == 7) {
                  // tiki
                  $total_on_tiki += $row["total_checkout"];
                  $count_on_tiki++;
                  $total_product_on_tiki += $row["product"];
                  $total_profit_on_tiki += $row["total_profit"];
                }
            }
            $count_total = $count_on_shop + $count_online + $count_exchange;
            $arr = array();
            $arr["total_amount"] = number_format($total_amount);
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

            $arr["total_on_facebook"] = number_format($total_on_facebook);
            $arr["total_on_shopee"] = number_format($total_on_shopee);
            $arr["total_on_website"] = number_format($total_on_website);
            $arr["total_on_lazada"] = number_format($total_on_lazada);
            $arr["total_on_zalo"] = number_format($total_on_zalo);
            $arr["total_on_tiki"] = number_format($total_on_tiki);

            $arr["count_on_website"] = $count_on_website;
            $arr["count_on_facebook"] = $count_on_facebook;
            $arr["count_on_shopee"] = $count_on_shopee;
            $arr["count_on_lazada"] = $count_on_lazada;
            $arr["count_on_zalo"] = $count_on_zalo;
            $arr["count_on_tiki"] = $count_on_tiki;

            $arr["total_product_on_shopee"] = number_format($total_product_on_shopee);
            $arr["total_product_on_website"] = number_format($total_product_on_website);
            $arr["total_product_on_facebook"] = number_format($total_product_on_facebook);
            $arr["total_product_on_lazada"] = number_format($total_product_on_lazada);
            $arr["total_product_on_zalo"] = number_format($total_product_on_zalo);
            $arr["total_product_on_tiki"] = number_format($total_product_on_tiki);

            $arr["total_profit_on_facebook"] = number_format($total_profit_on_facebook);
            $arr["total_profit_on_shopee"] = number_format($total_profit_on_shopee);
            $arr["total_profit_on_website"] = number_format($total_profit_on_website);
            $arr["total_profit_on_lazada"] = number_format($total_profit_on_lazada);
            $arr["total_profit_on_zalo"] = number_format($total_profit_on_zalo);
            $arr["total_profit_on_tiki"] = number_format($total_profit_on_tiki);
            return $arr;

        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function get_info_total_checkout2($start_date, $end_date, $order_id, $customer_id, $sku, $type, $status, $bill)
    {
        try {
            $sql = "SELECT tmp.order_id,
                           tmp.total_checkout AS total_checkout,
                           tmp.total_amount + CASE
                                                  WHEN tmp.shipping IS NULL THEN 0
                                                  ELSE sum(tmp.shipping)
                                              END - tmp.discount AS total_amount,
                                                    (CASE
                                                         WHEN tmp.profit IS NULL THEN 0
                                                         ELSE sum(tmp.profit)
                                                     END) + (CASE
                                                                 WHEN tmp.shipping IS NULL THEN 0
                                                                 ELSE sum(tmp.shipping)
                                                             END) - tmp.discount - tmp.shipping_fee - tmp.wallet AS total_profit,
                                                    count(tmp.type) AS count_type,
                            tmp.type,
                            tmp.source,
                            tmp.payment_type,
                            count(tmp.product_id) AS product
                    FROM (
                    SELECT A.order_id,
                           A.discount,
                           A.shipping_fee,
                           A.shipping,
                           t.p AS profit,
                           A.wallet,
                           A.type,
                           A.payment_type,
                           A.source,
                           A.total_checkout,
                           A.total_amount,
                           D.product_id
                    FROM smi_orders A
                    LEFT JOIN smi_order_detail B ON A.order_id = B.order_id
                    LEFT JOIN smi_customers C ON A.customer_id = C.customer_id
                    -- LEFT JOIN smi_variations E ON B.variant_id = E.id
                    LEFT JOIN smi_products D ON B.product_id = D.product_id
                    LEFT JOIN (
                    SELECT B.id,
                           CASE B.type
                               WHEN 1 THEN sum(0 - (B.profit - B.reduce) * B.quantity)
                               WHEN 3 THEN sum(0 - (B.profit - B.reduce) * B.quantity)
                               ELSE sum((B.profit - B.reduce) * B.quantity)
                           END AS p
                    FROM smi_orders A
                    LEFT JOIN smi_order_detail B ON A.order_id = B.order_id
                    -- LEFT JOIN smi_variations E ON B.variant_id = E.id
                    LEFT JOIN smi_products D ON B.product_id = D.product_id
                    WHERE 1=1 ";
            if (!empty($start_date) && !empty($end_date)) {
                $sql .= " and DATE(order_date) between DATE('" . $start_date . "') and DATE('" . $end_date . "')";
            } else if (!empty($order_id)) {
                $sql .= " and A.order_id = $order_id";
            } else if (!empty($customer_id)) {
                $sql .= " and A.customer_id = $customer_id";
            } else if (!empty($sku)) {
                $sql .= " and B.sku = $sku";
            }
            $sql .= " and A.deleted = 0
                            group by B.id,B.type) as t on t.id = B.id
                      where 1=1 ";
            if(isset($type) && $type != 1) {
              $sql .= "and A.status in (3,6)";
            }
            if (!empty($start_date) && !empty($end_date)) {
                $sql .= " and DATE(order_date) between DATE('" . $start_date . "') and DATE('" . $end_date . "')";
            } else if (!empty($order_id)) {
                $sql .= " and A.id = $order_id";
            } else if (!empty($customer_id)) {
                $sql .= " and A.customer_id = $customer_id";
            } else if (!empty($sku)) {
                $sql .= " and B.sku = $sku";
            }
            if(isset($type) && !empty($type)) {
              $sql .= " and A.type = $type";
            }
            if(isset($status) && $status != '' && $status != -1) {
                $sql .= " and A.status in ($status)";
            } else {
              $sql .= " and A.status in (0,1,2,3,13)";
            }
            $sql .= "  and A.deleted = 0) tmp
                    group by
                      tmp.order_id,
                      tmp.type,
                      tmp.payment_type
                    order by 
                      tmp.type";

                   // echo $sql;

            $result = mysqli_query($this->conn, $sql);
            $total_amount = 0;
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

            $total_on_facebook = 0;
            $total_on_shopee = 0;
            $total_on_zalo = 0;
            $total_on_website = 0;
            $total_on_lazada = 0;
            $total_on_tiki = 0;

            $count_on_facebook = 0;
            $count_on_shopee = 0;
            $count_on_website = 0;
            $count_on_lazada = 0;
            $count_on_zalo = 0;
            $count_on_tiki = 0;

            $total_product_on_facebook = 0;
            $total_product_on_website = 0;
            $total_product_on_lazada = 0;
            $total_product_on_shopee = 0;
            $total_product_on_zalo = 0;
            $total_product_on_tiki = 0;

            $total_profit_on_facebook = 0;
            $total_profit_on_shopee = 0;
            $total_profit_on_website = 0;
            $total_profit_on_lazada = 0;
            $total_profit_on_zalo = 0;
            $total_profit_on_tiki = 0;

            foreach ($result as $k => $row) {
                $total_amount += $row["total_amount"];
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
                if ($row["source"] == 1) {
                  //website
                  $total_on_website += $row["total_checkout"];
                  $count_on_website++;
                  $total_product_on_website += $row["product"];
                  $total_profit_on_website += $row["total_profit"];
                } else if ($row["source"] == 2 || $row["source"] == 4) {
                  // facebook
                  $total_on_facebook += $row["total_checkout"];
                  $count_on_facebook++;
                  $total_product_on_facebook += $row["product"];
                  $total_profit_on_facebook += $row["total_profit"];
                } else if ($row["source"] == 3) {
                  // shopee
                  $total_on_shopee += $row["total_checkout"];
                  $count_on_shopee++;
                  $total_product_on_shopee += $row["product"];
                  $total_profit_on_shopee += $row["total_profit"];
                } else if ($row["source"] == 5) {
                  // lazada
                  $total_on_lazada += $row["total_checkout"];
                  $count_on_lazada++;
                  $total_product_on_lazada += $row["product"];
                  $total_profit_on_lazada += $row["total_profit"];
                } else if ($row["source"] == 6) {
                  // zalo
                  $total_on_zalo += $row["total_checkout"];
                  $count_on_zalo++;
                  $total_product_on_zalo += $row["product"];
                  $total_profit_on_zalo += $row["total_profit"];
                } else if ($row["source"] == 7) {
                  // tiki
                  $total_on_tiki += $row["total_checkout"];
                  $count_on_tiki++;
                  $total_product_on_tiki += $row["product"];
                  $total_profit_on_tiki += $row["total_profit"];
                }
            }
            $count_total = $count_on_shop + $count_online + $count_exchange;
            $arr = array();
            $arr["total_amount"] = number_format($total_amount);
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

            $arr["total_on_facebook"] = number_format($total_on_facebook);
            $arr["total_on_shopee"] = number_format($total_on_shopee);
            $arr["total_on_website"] = number_format($total_on_website);
            $arr["total_on_lazada"] = number_format($total_on_lazada);
            $arr["total_on_zalo"] = number_format($total_on_zalo);
            $arr["total_on_tiki"] = number_format($total_on_tiki);

            $arr["count_on_website"] = $count_on_website;
            $arr["count_on_facebook"] = $count_on_facebook;
            $arr["count_on_shopee"] = $count_on_shopee;
            $arr["count_on_lazada"] = $count_on_lazada;
            $arr["count_on_zalo"] = $count_on_zalo;
            $arr["count_on_tiki"] = $count_on_tiki;

            $arr["total_product_on_shopee"] = number_format($total_product_on_shopee);
            $arr["total_product_on_website"] = number_format($total_product_on_website);
            $arr["total_product_on_facebook"] = number_format($total_product_on_facebook);
            $arr["total_product_on_lazada"] = number_format($total_product_on_lazada);
            $arr["total_product_on_zalo"] = number_format($total_product_on_zalo);
            $arr["total_product_on_tiki"] = number_format($total_product_on_tiki);

            $arr["total_profit_on_facebook"] = number_format($total_profit_on_facebook);
            $arr["total_profit_on_shopee"] = number_format($total_profit_on_shopee);
            $arr["total_profit_on_website"] = number_format($total_profit_on_website);
            $arr["total_profit_on_lazada"] = number_format($total_profit_on_lazada);
            $arr["total_profit_on_zalo"] = number_format($total_profit_on_zalo);
            $arr["total_profit_on_tiki"] = number_format($total_profit_on_tiki);
            return $arr;

        } catch (Exception $e) {
            throw new Exception($e);
        }
    }



  function count_status($start_date, $end_date)
  {
    try {
      $sql = "SELECT status, count(status) as c FROM `smi_orders` where deleted = 0 ";
      if(!empty($start_date) && !empty($end_date)) {
        $sql .= " and DATE(order_date) between DATE('" . $start_date . "') and DATE('" . $end_date . "') ";
      }
      $sql .= " and type = 1
                and status in (0, 1, 2, 7, 8, 9, 10, 11, 12, 13, 15)
                group by status";

    //  echo $sql;

      $result = mysqli_query($this->conn, $sql);
      $pending = 0;
      $packed = 0;
      $delivered = 0;
      $success = 0;
      $exchange = 0;
      $return = 0;
      $cancel = 0;
      $appointment = 0;
      $wating = 0;
      $created_bill = 0;
      $following = 0;
      foreach ($result as $k => $row) {
        switch($row["status"]) {
          case PENDING:
            $pending += $row["c"];
            break;
          case PACKED:
            $packed += $row["c"];
            break;
          case DELIVERED:
            $delivered += $row["c"];
            break;
          case SUCCESS:
            $success += $row["c"];
            break;
          case _EXCHANGE:
          case WAITING_RETURN:
          case WAITING_EXCHANGE:
          case EXCHANGING:
            $exchange += $row["c"];
            break;
          case _RETURN:
          case RETURNED:
            $return += $row["c"];
            break;
          case CANCEL:
            $cancel += $row["c"];
            break;
          case APPOINTMENT:
            $appointment += $row["c"];
            break;
          case WAIT:
            $wating += $row["c"];
            break;
          case CREATED_BILL:
            $created_bill += $row["c"];
            break;
          case FOLLOWING:
              $following += $row["c"];
              break;
        }
      }
      $count_total = $pending + $packed + $delivered + $success + $exchange + $return + $cancel + $appointment + $wating + $created_bill + $following;
      $arr = array();
      $arr["count_total"] = $count_total;
      $arr["pending"] = $pending;
      $arr["packed"] = $packed;
      $arr["delivered"] = $delivered;
      $arr["success"] = $success;
      $arr["exchange"] = $exchange;
      $arr["return"] = $return;
      $arr["cancel"] = $cancel;
      $arr["appointment"] = $appointment;
      $arr["wating"] = $wating;
      $arr["created_bill"] = $created_bill;
      $arr["following"] = $following;
      return $arr;

    } catch (Exception $e) {
      echo $e->getMessage();
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
                        C.facebook,
                        C.link_fb,
                        A.shipping,
                        A.shipping_fee,
                        A.discount,
                        A.wallet,
                        A.total_amount,
                        A.total_checkout,
                        A.customer_payment,
                        A.order_date,
                        A.type as order_type,
                        A.status,
                        A.total_reduce,
                        A.voucher_code,
                        A.source,
                        A.created_by,
                        D.id as product_id,
                        D.name as product_name,
                        E.sku,
                        E.id as variant_id,
                        B.quantity,
                        B.price,
                        B.reduce,
                        E.image,
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

                    // echo $sql;

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
                        'facebook' => $row["facebook"],
                        'link_fb' => $row["link_fb"],
                        'shipping' => number_format($row["shipping"]),
                        'shipping_fee' => number_format($row["shipping_fee"]),
                        'discount' => number_format($row["discount"]),
                        'wallet' => number_format($row["wallet"]),
                        'total_amount' => number_format($row["total_amount"]),
                        'total_checkout' => number_format($row["total_checkout"]),
                        'total_reduce' => number_format($row["total_reduce"]),
                        'customer_payment' => number_format($row["customer_payment"]),
                        'order_date' => date_format(date_create($row["order_date"]), "d/m/Y H:i:s"),
                        'order_type' => $row["order_type"],
                        'status' => $row["status"],
                        'payment_type' => $row["payment_type"],
                        'voucher_code' => $row["voucher_code"],
                        'product_name' => $row["product_name"],
                        'source' => $row["source"],
                        'created_by' => $row["created_by"],
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
                        'image' => $row["image"],
                        'quantity' => $qty,
                        'price' => number_format($price),
                        'reduce' => number_format($qty * $reduce),
                        'intoMoney' => number_format($intoMoney),
                        'profit' => number_format($row["profit"]),
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
                        'image' => $row["image"],
                        'quantity' => $qty,
                        'price' => number_format($price),
                        'reduce' => number_format($qty * $reduce),
                        'intoMoney' => number_format($intoMoney),
                        'profit' => number_format($row["profit"]),
                        'product_type' => $row["product_type"],
                        'updated_qty' => $row["updated_qty"]
                    );
                    array_push($data[$i - 1]['details'], $detail);
                }
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function saveOrder(Order $order)
    {
        try {
            $shopee_order_id = $order->getShopee_order_id() ?? 0;
            $total_reduce = $order->getTotal_reduce();
            $total_reduce_percent = $order->getTotal_reduce_percent();
            $discount = $order->getDiscount();
            $wallet = $order->getWallet();
            $total_amount = $order->getTotal_amount();
            $total_checkout = $order->getTotal_checkout();
            $cod = $order->getCod() ?? 0;
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
            $appointment_delivery_date = $order->getAppointmentDeliveryDate();
            if(empty($appointment_delivery_date)) {
              $appointment_delivery_date = null;
            }
            $orderDate = $order->getOrder_date();
            $deliveryDate = $order->getDeliveryDate();
            if(empty($deliveryDate)) {
              $deliveryDate = null;
            }
            $description = $order->getDescription();
            if(empty($description)) {
              $description = null;
            }
            $createdBy = $order->getCreatedBy();
            $stmt = $this->getConn()->prepare("insert into smi_orders (
                    `shopee_order_id`,
                    `total_reduce`,
                    `total_reduce_percent`,
                    `discount`,
                    `wallet`,
                    `total_amount`,
                    `total_checkout`,
                    `cod`,
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
                    `appointment_delivery_date`,    
                    `order_date`,
                    `delivery_date`,
                    `description`,
                    `created_by`,
                    `created_date`,
                    `updated_date`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->bind_param("sddddddddiddiisddsisdiiisssss", $shopee_order_id, $total_reduce, $total_reduce_percent, $discount, $wallet, $total_amount,
                $total_checkout, $cod, $customer_payment, $payment_type, $repay, $transfer_to_wallet, $customer_id, $type, $bill, $shipping_fee,
                $shipping, $shipping_unit, $status, $voucher_code, $voucher_value, $orderRefer, $paymentExchangeType, $source, $appointment_delivery_date, $orderDate, $deliveryDate, $description, $createdBy);
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
            $cod = $order->getCod();
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
            $source = $order->getSource();
            $delivery_date = $order->getDeliveryDate();
            if(empty($delivery_date)) {
              $delivery_date = null;
            }
            $appointment_delivery_date = $order->getAppointmentDeliveryDate();
            if(empty($appointment_delivery_date)) {
              $appointment_delivery_date = null;
            }
            $description = $order->getDescription();
            $createdBy = $order->getCreatedBy();
            $id = $order->getId();
            $stmt = $this->getConn()->prepare("update `smi_orders` SET `total_reduce` = ?, `total_reduce_percent` = ?, 
                            `discount` = ?, `total_amount` = ?, `total_checkout` = ?, `COD` = ?, `customer_payment` = ?, `repay` = ?, 
                            `customer_id` = ?, `type` = ?, `bill_of_lading_no` = ?, `shipping_fee` = ?, `shipping` = ?, 
                            `shipping_unit` = ?, `status` = ?, `updated_date` = NOW(), `deleted` = b'0', `payment_type` = ?, 
                            `order_date` = ?, `source` = ?, `appointment_delivery_date` = ?, `delivery_date` = ?, `description` = ?, `created_by` = ? WHERE `id` = ?");
            $stmt->bind_param("ddddddddiisddsiisissssi", $total_reduce, $total_reduce_percent, $discount, $total_amount,
              $total_checkout, $cod, $customer_payment, $repay, $customer_id, $type, $bill, $shipping_fee, $shipping,
              $shipping_unit, $status, $payment_type, $order_date, $source, $appointment_delivery_date, $delivery_date, $description, $createdBy, $id);
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

    function get_data_print_receipt($order_ids)
    {
        try {
            $sql = "select 
                        A.bill_of_lading_no as bill,
                        B.name as customer_name,
                        B.phone,
                        B.full_address,
                        A.shipping_unit,
                        E.name,
                        D.color, D.size,
                        C.quantity,
                        A.source
                    FROM 
                    smi_orders A inner join smi_customers B on A.customer_id = B.id
                    left join smi_order_detail C on A.id = C.order_id
                    inner join smi_variations D on C.sku = D.sku
                    inner join smi_products E on C.product_id = E.id
                    WHERE A.id in ($order_ids)
                    order by A.created_date desc";

// echo $sql;

            $result = mysqli_query($this->conn, $sql);
            $data = array();
            $bill = "";
            $details = array();
            $i = 0;
            foreach ($result as $k => $row) {
              if($bill != $row["bill"]) {
                $order = array(
                    'bill' => $row["bill"],
                    'customer_name' => $row["customer_name"],
                    'phone' => $row["phone"],
                    'address' => $row["full_address"],
                    'shipping_unit' => $row["shipping_unit"],
                    'source' => $row["source"],
                    'details' => array()
                );
                $detail = array(
                  'name' => $row['name'],
                  'color' => $row['color'],
                  'size' => $row['size'],
                  'quantity' => $row['quantity']
                );
                array_push($order['details'], $detail);
                array_push($data, $order);
                $bill = $row['bill'];
                $i++;
              } else {
                $detail = array(
                  'name' => $row['name'],
                  'color' => $row['color'],
                  'size' => $row['size'],
                  'quantity' => $row['quantity']
                );
                array_push($data[$i - 1]['details'], $detail);
              }
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

  function saveOrderLogs(OrderLogs $orderLogs)
  {
    try {
      $order_id = $orderLogs->getOrderId();
      $action = $orderLogs->getAction();
      $createdBy = $orderLogs->getCreatedBy() ? $orderLogs->getCreatedBy() : ($_COOKIE["acc"] ?? "unknown");
      $stmt = $this->getConn()->prepare("INSERT INTO `smi_order_logs`(`order_id`, `action`,`created_by`, `created_date`, `updated_date`) 
                                            VALUES (?, ?, ?, NOW(),NOW())");
      $stmt->bind_param("iss", $order_id, $action, $createdBy);
      if (!$stmt->execute()) {
        throw new Exception($stmt->error);
      }
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
