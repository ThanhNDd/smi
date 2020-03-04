<?php

class VoucherDAO
{
    private $conn;

    function find_all()
    {
        try {
            $sql = "SELECT @rownum := @rownum + 1 AS no,
                        `smi_voucher`.`id`,
                        `smi_voucher`.`code`,
                        `smi_voucher`.`value`,
                        `smi_voucher`.`type`,
                        `smi_voucher`.`start_date`,
                        `smi_voucher`.`expired_date`,
                        `smi_voucher`.`status`,
                        `smi_voucher`.`created_date`
                    FROM smi_voucher, (SELECT @rownum := 0) r";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $item => $row) {
                $voucher = array(
                    'no' => $row["no"],
                    'id' => $row["id"],
                    'code' => $row["code"],
                    'value' => $row['value'],
                    'type' => $row['type'],
                    'start_date' => $row['start_date'],
                    'expired_date' => $row['expired_date'],
                    'status' => $row['status'],
                    'created_date' => $row['created_date']
                );
                array_push($data, $voucher);
            }
            $arr = array();
            $arr['data'] = $data;
            return $arr;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param $id
     * @return array
     * @throws Exception
     */
    function find_by_id($id)
    {
        try {
            $sql = "SELECT 
                        `smi_voucher`.`id`,
                        `smi_voucher`.`code`,
                        `smi_voucher`.`value`,
                        `smi_voucher`.`type`,
                        `smi_voucher`.`start_date`,
                        `smi_voucher`.`expired_date`,
                        `smi_voucher`.`status`,
                        `smi_voucher`.`created_date`
                    FROM smi_voucher 
                    where id = '" . $id . "'";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $item => $row) {
                $voucher = array(
                    'id' => $row["id"],
                    'code' => $row["code"],
                    'value' => $row['value'],
                    'type' => $row['type'],
                    'start_date' => $row['start_date'],
                    'expired_date' => $row['expired_date'],
                    'status' => $row['status'],
                    'created_date' => $row['created_date']
                );
                array_push($data, $voucher);
            }
            $arr = array();
            $arr['data'] = $data;
            return $arr;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param $voucher_code
     * @return array
     * @throws Exception
     */
    function find_by_code($voucher_code)
    {
        try {
            $sql = "SELECT 
                        code, 
                        value, 
                        type, 
                        status,
                        case when DATE(NOW()) between DATE(start_date) and DATE(expired_date) then 'success' else 'expired' end as valid_date
                    FROM smi_voucher 
                    where code = '" . $voucher_code . "'";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $item => $row) {
                $voucher = array(
                    'code' => $row["code"],
                    'value' => $row['value'],
                    'type' => $row['type'],
                    'status' => $row['status'],
                    'valid_date' => $row['valid_date']
                );
                array_push($data, $voucher);
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param Voucher $voucher
     * @return int|string
     * @throws Exception
     */
    function save_voucher(Voucher $voucher)
    {
        try {
            $code = $voucher->getCode();
            $value = $voucher->getValue();
            $type = $voucher->getType();
            $startDate = $voucher->getStartDate();
            $expiredDate = $voucher->getExpiredDate();
            $status = $voucher->getStatus();
            $stmt = $this->getConn()->prepare("insert into `smi_voucher`
                (`code`,`value`,`type`,`start_date`,`expired_date`,`status`,`created_date`)
                VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("sidssd", $code, $value, $type, date('Y/m/d H:i:s', strtotime($startDate)), date('Y/m/d H:i:s', strtotime($expiredDate)), $status);
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

    /**
     * @param Voucher $voucher
     * @return mixed
     * @throws Exception
     */
    function update_voucher(Voucher $voucher)
    {
        try {
            $code = $voucher->getCode();
            $value = $voucher->getValue();
            $type = $voucher->getType();
            $startDate = $voucher->getStartDate();
            $expiredDate = $voucher->getExpiredDate();
            $status = $voucher->getStatus();
            $stmt = $this->getConn()->prepare("insert into `smi_voucher`
                (`code`,`value`,`type`,`start_date`,`expired_date`,`status`,`updated_date`)
                VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("sidssd", $code, $value, $type, date('Y/m/d H:i:s', strtotime($startDate)), date('Y/m/d H:i:s', strtotime($expiredDate)), $status);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    /**
     * @param $id
     * @throws Exception
     */
    function del_voucher($id)
    {
        try {
            $stmt = $this->getConn()->prepare("DELETE FROM `smi_voucher` WHERE id = ?");
            $stmt->bind_param("i", $id);
            if(!$stmt->execute()) {
                throw new Exception($stmt->error);
            }
            $stmt->close();
        } catch (Exception $e) {
            throw new Exception($e);
        }
    }
    function update_status($value, $status, $type = 0)
    {
        try {
            if($type == 1) {
                // update by code
                $sql = "UPDATE `smi_voucher` SET `status` = ?, updated_date = NOW() WHERE `code` = ?";
            } else {
                $sql = "UPDATE `smi_voucher` SET `status` = ?, updated_date = NOW() WHERE `id` = ?";
            }
            $stmt = $this->getConn()->prepare($sql);
            if($type == 1) {
                // update by code
                $stmt->bind_param("is", $status, $value);
            } else {
                $stmt->bind_param("ii", $status, $value);
            }
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