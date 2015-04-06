<?php
  $page_title = "Update Product";
  include_once 'header.php';

  //get ID of product being edited
  $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID');

  //include db and objects
  include_once 'config/database.php';
  include_once 'models/product.php';

  //get db connection
  $database = new Database();
  $db = $database->getConnection();

  //prepare product object
  $product = new Product($db);

  //set ID property of product to be edited
  $product->id = $id;

  //read the details of the product
  $product->readOne();

  if($_POST){
    //set product property values
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->description = $_POST['description'];

    //update product
    if($product->update()){
      echo "<div class=\"alert alert-success alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "Product was updated.";
      echo "</div>";
    }else{
      echo "<div class=\"alert alert-danger alert-dismissable\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
        echo "Unable to update product.";
      echo "</div>";
    }

  }
?>

<div class='right-button-margin'>
  <a href='index.php' class='btn btn-default pull-right'>Show Products</a>
</div>


<form action="update.php?id=<?php echo $id; ?>" method="post">
  <table class='table table-hover table-responsive table-bordered'>

        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value='<?php echo $product->name; ?>' class='form-control' required></td>
        </tr>

        <tr>
            <td>Price</td>
            <td><input type='text' name='price' value='<?php echo $product->price; ?>' class='form-control' required></td>
        </tr>

        <tr>
            <td>Description</td>
            <td><textarea name='description' class='form-control'><?php echo $product->description; ?></textarea></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>

    </table>
</form>

<?php include_once 'footer.php' ?>
