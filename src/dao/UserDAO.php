<?php

class UserDAO
{
    private $conn;

    function getAllStaff()
    {
        try {
            $sql = "SELECT username, display_name FROM smi_user";
            $result = mysqli_query($this->conn, $sql);
            $data = array();
            foreach ($result as $k => $row) {
                $user = array(
                    'username' => $row["username"],
                    'display_name' => $row["display_name"]
                );
                array_push($data, $user);
            }
            return $data;
        } catch (Exception $e) {
            throw new Exception("getAllStaff >> " . $e);
        }
    }

    function find_user($username, $password)
    {
        try {
            $sql = "SELECT * FROM smi_user WHERE username = '$username'";
            $result = mysqli_query($this->conn, $sql);
            $user = mysqli_fetch_array($result);
            $pwd =  $user['password'];
            // $pwd = mysqli_fetch_array($pwd)['password'];
            if($pwd == null) {
              return "error";
            }
            
            $check = crypt($password, $pwd);
            if (hash_equals($check, $pwd)) {
                Common::set_cookie(1, $user);
                // echo 'set cookie';
                return "success";
            } else {
                return "error";
            }
        } catch (Exception $e) {
            throw new Exception("find_user >> " . $e);
        }
    }

    function generate_password($password_plain) {
        $salt = strtr(base64_encode(random_bytes(16)), '+', '.');
        $salt = sprintf("$2y$%02d$", 10) . $salt;
        $password = crypt($password_plain, $salt);
        return $password;
    }

    /**
     * @return mixed
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * @param mixed $conn
     */
    public function setConn($conn): void
    {
        $this->conn = $conn;
    }


}
