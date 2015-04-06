<?php
  $page_title = 'Products';
  include_once 'header.php';
  include_once 'config/database.php';
  include_once 'models/product.php';
  include_once 'models/category.php';
?>

<?php
  // page given in URL parameter, default page is one
  $page = isset($_GET['page']) ? $_GET['page'] : 1;

  // set number of records per page
  $records_per_page = 3;

  // calculate for the query LIMIT clause
  $from_record_num = ($records_per_page * $page) - $records_per_page;

  $database = new Database();
  $db = $database->getConnection();

  $product = new Product($db);

  //query products
  $stmt = $product->readAll();
  $num = $stmt->rowCount();

  //display products
  if($num > 0){
    $category = new Category($db);
    echo "<table class='table table-hover table-responsive table-bordered'>";
      echo "<tr>";
        echo "<th>Product</th>";
        echo "<th>Price</th>";
        echo "<th>Description</th>";
        echo "<th>Category</th>";
        echo "<th></th>";
      echo "</tr>";

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);

        echo "<tr>";
          echo "<td>{$name}</td>";
          echo "<td>{$price}</td>";
          echo "<td>{$description}</td>";
          echo "<td>";
            $category->id = $category_id;
            $category->readName();
            echo $category->name;
          echo "</td>";

          echo "<td>";
              // edit and delete button will be here
            echo "<a href='update.php?id={$id}' class='btn btn-default left-margin'>Edit</a>";
            echo "<a delete-id='{$id}' class='btn btn-default delete-object'>Delete</a>";
          echo "</td>";

        echo "</tr>";
      }

    echo "</table>";

  }else{
    echo "<div>No products found.</div>";
  }
?>

<div class='right-button-margin'>
  <a href='create.php' class='btn btn-default pull-right'>Create Product</a>
</div>

<script>
  $(document).on('click', '.delete-object', function(){

      var id = $(this).attr('delete-id');
      var q = confirm("Are you sure?");

      if (q == true){

        $.post('delete.php', {
            object_id: id
        }, function(data){
            location.reload();
        }).fail(function() {
            alert('Unable to delete.');
        });

      }
      return false;
  });
</script>

<?php include_once 'footer.php' ?>
