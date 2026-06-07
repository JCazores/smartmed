<?php
if(!defined('DB_SERVER')){
    require_once("../initialize.php");
}
class DBConnection{
    public $conn;
    
    public function __construct(){
        if (!isset($this->conn)) {
            $this->conn = new mysqli();
            $this->conn->real_connect(
                DB_SERVER,
                DB_USERNAME,
                DB_PASSWORD,
                DB_NAME,
                DB_PORT,
                null,
                MYSQLI_CLIENT_SSL
            );
            
            if ($this->conn->connect_error) {
                echo 'Cannot connect to database server: ' . $this->conn->connect_error;
                exit;
            }            
        }    
    }
    public function __destruct(){
        $this->conn->close();
    }
}
?>