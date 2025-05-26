<?php
class Database {
    private $host = "localhost";
    private $db_name = "laced_lifestyle";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            
            if ($this->conn->connect_error) {
                error_log("Database connection failed: " . $this->conn->connect_error);
                return null;
            }
            
            $this->conn->set_charset("utf8");
            return $this->conn;
        } catch(Exception $e) {
            error_log("Database connection error: " . $e->getMessage());
            return null;
        }
    }
}
?> 