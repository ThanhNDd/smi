<?php


class WalletDAO
{
    private $conn;

    function findWalletByOrderId($orderId)
    {
        try {
            $sql = "select * from smi_wallet where order_id = $orderId and order_deleted = 0";
            $result = mysqli_query($this->conn, $sql);
            while ($obj = mysqli_fetch_object($result, "Wallet")) {
                return $obj;
            }
        } catch (Exception $e) {
            echo $e;
        }
        return null;
    }

    function getBallanceInWallet($customer_id)
    {
        try {
//            $sql = "SELECT CASE
//                               WHEN DATE(created_at) < DATE(NOW()) THEN saved + remain
//                               ELSE remain
//                           END AS POINT
//                    FROM smi_wallet
//                    WHERE customer_id = $customer_id and order_deleted = 0
//                    ORDER BY created_at DESC
//                    LIMIT 1";
            $sql = "SELECT saved+remain+repay as ballance_in_wallet
                    FROM smi_wallet
                    WHERE customer_id = $customer_id and order_deleted = 0
                    ORDER BY created_at DESC
                    LIMIT 1";
            $result = mysqli_query($this->conn, $sql);
            $ballance_in_wallet = 0;
            if (!empty($result)) {
                foreach ($result as $k => $row) {
                    $ballance_in_wallet = $row["ballance_in_wallet"];
                }
            }
            return $ballance_in_wallet;
        } catch (Exception $e) {
            echo "Open connection database is error exception >> " . $e->getMessage();
        }
    }

    function save_wallet(Wallet $wallet)
    {
        try {
            $order_id = $wallet->getOrderId();
            $customer_id = $wallet->getCustomerId();
            $saved = $wallet->getSaved();
            $used = $wallet->getUsed();
            $repay = $wallet->getRepay();
            $remain = $wallet->getRemain();
            $stmt = $this->getConn()->prepare("INSERT INTO `smi_wallet` (`customer_id`, `order_id`, `saved`, `used`, `repay`, `remain`, `created_at`)
                                                VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("iidddd", $customer_id, $order_id, $saved, $used, $repay, $remain);
            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
            $lastid = mysqli_insert_id($this->conn);
            return $lastid;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    function delete_wallet_by_order($order_id)
    {
        $stmt = $this->getConn()->prepare("update `smi_wallet` set `order_deleted` = 1, `updated_at` = NOW() WHERE `order_id` = ?");
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