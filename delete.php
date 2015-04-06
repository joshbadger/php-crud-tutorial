<?php
  if($_POST){

    //include db and model
    include_once 'config/database.php';
    include_once 'models/product.php';

    //get db connection
    $database = new Database();
    $db = $database->getConnection();

    //prepare product object
    $product = new Product($db);

    //set product to be deleted
    $product->id = $_POST['object_id'];

    //delete the product
    if($product->delete()){
      echo 'Product was deleted.';
    } else {
      echo 'Unable to delete product.';
    }
  }
?>
