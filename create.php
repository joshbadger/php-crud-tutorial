<?php
  $page_title = "Create a New Product";
  include_once 'header.php';

  include_once 'config/database.php';

  $database = new Database();
  $db = $database->getConnection();
?>

<?php
  if($_POST){
    //create a new empty object
    include_once 'models/product.php';
    $product = new Product($db);

    //set properties
    $product->name = $_POST['name'];
    $product->price = $_POST['price'];
    $product->description = $_POST['description'];
    $product->category_id = $_POST['category_id'];

    //create product and alert user
    if($product->create()){
      echo "<div class=\"alert alert-success alert-dismissable\">";
          echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
          echo "Product was created.";
      echo "</div>";
    }
    else{
      echo "<div class=\"alert alert-danger alert-dismissable\">";
          echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
          echo "Unable to create product.";
      echo "</div>";
    }
  }
?>

<div class='right-button-margin'>
  <a href='index.php' class='btn btn-default pull-right'>Show Products</a>
</div>

<form action='create.php' method='post'>

  <table class='table table-hover table-responsive table-bordered'>

    <tr>
      <td>Name</td>
      <td><input type='text' name='name' class='form-control' required></td>
    </tr>

    <tr>
      <td>Price</td>
      <td><input type='text' name='price' class='form-control' required></td>
    </tr>

    <tr>
      <td>Description</td>
      <td><textarea name='description' class='form-control'></textarea></td>
    </tr>

    <tr>
      <td>Category</td>
      <td>
        <?php
          //read categories from DB
          include_once 'models/category.php';

          $category = new Category($db);
          $stmt = $category->read();
          //put them in a dropdown
          echo "<select class='form-control' name='category_id'>";
            echo "<option>Select category...</option>";

            while($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
              extract($row_category);
              echo "<option value='{$id}'>{$name}</option>";
            }
          echo "</select>";
        ?>
      </td>
    </tr>

    <tr>
      <td></td>
      <td>
          <button type="submit" class="btn btn-primary">Create</button>
      </td>
    </tr>

  </table>
</form>

<?php include_once 'footer.php'; ?>
