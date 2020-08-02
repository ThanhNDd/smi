<?php

class UserDAO
{
    private $conn;

    function find_user($username, $password)
    {
        try {
            $sql = "SELECT password FROM smi_user WHERE username = '$username'";
            $pwd = mysqli_query($this->conn, $sql);
            $pwd = mysqli_fetch_array($pwd)['password'];
            if($pwd == null) {
              return "error";
            }
            $check = crypt($password, $pwd);
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
