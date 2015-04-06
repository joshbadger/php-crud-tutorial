<?php
  class Product{

    //db and table name
    private $conn;
    private $table_name = 'products';

    //object properties
    public $id;
    public $name;
    public $price;
    public $description;
    public $category_id;
    public $timestamp;

    public function __construct($db){
      $this->conn = $db;
    }

    function create(){
      $this->getTimestamp();

      $query = "INSERT INTO $this->table_name SET name =?, price = ?, description = ?, category_id = ?, created = ?";

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(1, $this->name);
      $stmt->bindParam(2, $this->price);
      $stmt->bindParam(3, $this->description);
      $stmt->bindParam(4, $this->category_id);
      $stmt->bindParam(5, $this->timestamp);

      if($stmt->execute()){
        return true;
      }else{
        return false;
      }
    }

    function update(){
      $query = "UPDATE $this->table_name SET name = :name, price = :price, description = :description, category_id = :category_id WHERE id = :id";
      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':price', $this->price);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':category_id', $this->category_id);
      $stmt->bindParam(':id', $this->id);

      if($stmt->execute()){
        return true;
      }else{
        return false;
      }
    }

    function delete(){
      $query = "DELETE FROM $this->table_name WHERE id = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1,$this->id);

      if ($stmt->execute()){
        return true;
      } else {
        return false;
      }
    }

    function getTimestamp(){
      date_default_timezone_set('Asia/Manila');
      $this->timestamp = date('Y-m-d H:i:s');
    }

    function readAll(){
      $query = "SELECT id, name, description, price, category_id FROM $this->table_name";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;
    }

    function readOne(){
      $query = "SELECT name, price, description, category_id FROM $this->table_name WHERE id = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->name = $row['name'];
      $this->price = $row['price'];
      $this->description = $row['description'];
      $this->category_id = $row['category_id'];
    }
  }
?>
