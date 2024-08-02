<?php
class WebhookDAO
{
    private $conn;

    function __construct($db) {
        $this->conn = $db->getConn();
    } 

    function checkNewRecord() {
        try {
            $orderId = null;
            $sql = "SELECT order_id FROM `smi_webhook` WHERE `updated_at` is null";
            $result = mysqli_query($this->conn, $sql);
            if (!empty($result)) {
                $row = $result->fetch_assoc();
                $orderId = $row['order_id'];
            }
            return $orderId;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function update($orderId) {
        try {
            $stmt = $this->getConn()->prepare("UPDATE `smi_webhook` SET `updated_at`= NOW() WHERE order_id = $orderId");
            $stmt->execute();
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function store($data)
    {
    	try {
    		$content = $data["content"];
    		$orderId = $data["orderId"];
    		$amount = $data["amount"];
    		$bank = $data["bank"];


    		$sql = "INSERT INTO `smi_webhook`(`raw_content`, `order_id`, `amount`, `bank`)
					VALUES (?, ?, ?, ?)";
    		$stmt = $this->getConn()->prepare($sql);
            $stmt->bind_param("siis",$content, $orderId, $amount, $bank);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
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