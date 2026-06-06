<?php
if(!defined('DB_SERVER')){
    require_once("../initialize.php");
}
class DBConnection{
    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    private $port = DB_PORT;
    
    public $conn;
    
    public function __construct(){
        if (!isset($this->conn)) {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $this->conn = new mysqli();
            $this->conn->real_connect(
                $this->host,
                $this->username,
                $this->password,
                $this->database,
                $this->port,
                null,
                MYSQLI_CLIENT_SSL
            );
            
            if (!$this->conn) {
                echo 'Cannot connect to database server';
                exit;
            }            
        }    
    }
    public function __destruct(){
        $this->conn->close();
    }
}
?>