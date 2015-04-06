<?php
  class Database{

    private $host = "127.0.0.1";
    private $port = "8889";
    private $db_name = "crud_tutorial";
    private $username = "root";
    private $password = "";
    public $conn;

    function getConnection(){
      $this->conn = null;

      try{
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name;port=$this->port", $this->username, $this->password);
      }catch(PDOException $exception){
        echo "Connection error: " . $exception->getMessage();
      }

      return $this->conn;
    }
  }
?>
