<?php
class DBConnect {
    private $db = "cudwlevvhosting_admin";
    private $host = "127.0.0.1";
    private $user = "cudwlevvhosting_smi";
    private $pass = "xqjxERUWQ6F2S7r";
    private $conn;

    // private $db = "smi_admin";
    // private $host = "localhost";
    // private $user = "root";
    // private $pass = "";
    // private $conn;

    function DBConnect()
    {
        $this->conn = $this->open_connection();
    }

    /**
     * Open connection to database
     */
    function open_connection()
    {
        try {
            $conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
            mysqli_set_charset($conn, 'UTF8');
        } catch(Exception $ex) {
            die("connection failure: ".$this->conn->connect_error);
        }
        return $this->conn = $conn;
    }

    /**
     * Close connection to database
     */
    function close_connection()
    {
        try {
            if($this->conn != null)
            {
                mysqli_close($this->conn);
            }
        } catch(Exception $e)
        {
            die("close connection is error excetion: ".$e->getMessage());
        }
    }
    
    function execute_query($sql)
    {
        try {
            $result = mysqli_query($this->conn, $sql);
        } catch(Exception $e)
        {
            throw new Exception("Execute mysqli query error exception: ".$e);
        } finally
        {
            $this->close_connection();
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