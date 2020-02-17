<?php


class UserDAO
{
    private $conn;

    function find_user($username, $password)
    {
        try {
            $sql = "SELECT password FROM smi_user WHERE username = '$username'";
            $pwd = mysqli_query($this->conn, $sql);
//            print_r($this->conn->error);
            $pwd = mysqli_fetch_array($pwd)['password'];
            if($pwd == null) {
              return "error";
            }
//            print_r($pwd);
            $check = crypt($password, $pwd);
//            print_r($check);
            if (hash_equals($check, $pwd)) {
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
        $salt = sprintf("$2y$%02d$", 10) . $salt; //$2y$ là thuật toán BlowFish, 10 là độ dài của key mã hóa.
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
