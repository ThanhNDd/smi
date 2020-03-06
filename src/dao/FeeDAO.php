<?php

class FeeDAO
{
    private $conn;

    function get_total_fee($start_date = '', $end_date = '')
    {
        try {
            $sql = "select sum(amount) as amount, type 
                    from smi_fees where DATE(fee_date) between DATE('" . $start_date . "') and DATE('" . $end_date . "')
                    group by type";
            $result = mysqli_query($this->conn, $sql);
            $total_fixed_fee = 0;
            $total_variable_fee = 0;
            $total_home_fee = 0;
            foreach ($result as $k => $row) {
                if ($row["type"] == 0) {
                    $total_variable_fee += $row["amount"];
                } else if ($row["type"] == 1) {
                    $total_fixed_fee += $row["amount"];
                } else if ($row["type"] == 2) {
                    $total_home_fee += $row["amount"];
                }
            }
            $arr = array();
            $total_fee = $total_fixed_fee + $total_variable_fee;
            $arr["total_fee"] = number_format($total_fee);
            $arr["total_fixed_fee"] = number_format($total_fixed_fee);
            $arr["total_variable_fee"] = number_format($total_variable_fee);
            $arr["total_home_fee"] = number_format($total_home_fee);
            return $arr;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function find_fee($id = 0, $start_date = '', $end_date = '')
    {
        try {
            $sql = "select * from smi_fees where 1=1 ";
            if(!empty($id)) {
                $sql .= " and id = $id";
            }
            if(!empty($start_date) && !empty($end_date)) {
                $sql .= " and DATE(fee_date) between DATE('" . $start_date . "') and DATE('" . $end_date . "')";
            }
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            $no = 1;
            foreach ($result as $k => $row) {
                $fee = array(
                    'no' => $no,
                    'id' => $row["id"],
                    'fee_date' => date_format(date_create($row["fee_date"]), "d/m/Y"),
                    'reason' => $row["reason"],
                    'amount' => number_format($row["amount"]),
                    'type' => $row["type"],
                    'created_date' => date_format(date_create($row["created_date"]), "d/m/Y"),
                    'updated_date' => date_format(date_create($row["updated_date"]), "d/m/Y")
                );
                array_push($data, $fee);
                $no++;
            }
            $arr = array();
            $arr["data"] = $data;
            return $arr;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function save_or_update_fee(Fee $fee)
    {
        $id = $fee->getId();
        $reason = $fee->getReason();
        $amount = $fee->getAmount();
        $type = $fee->getType();
        $fee_date = $fee->getFeeDate();
        if(!empty($fee->getFeeDate())) {
            $date = $fee->getFeeDate();
            $date = str_replace('/', '-', $date);
            $fee_date = date('Y-m-d H:i:s', strtotime($date));
        }
        try {
            if(empty($id)) {
                $stmt = $this->getConn()->prepare("INSERT INTO smi_fees (`fee_date`,`reason`,`amount`,`type`, `created_date`) VALUES (?,?,?,?,NOW())");
                $stmt->bind_param("ssdi", $fee_date, $reason, $amount, $type);
            } else {
                $stmt = $this->getConn()->prepare("UPDATE smi_fees SET `fee_date` = ? ,`reason` = ? ,`amount` = ?,`type` = ?, `updated_date` = NOW() where id = ?");
                $stmt->bind_param("ssdii", $fee_date, $reason, $amount, $type, $id);
            }
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    function delete_fee($id)
    {
        try {
            $stmt = $this->getConn()->prepare("DELETE FROM `smi_fees` WHERE `id` = ?");
            $stmt->bind_param("i", $id);
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
