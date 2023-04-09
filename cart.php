<?php
include('./includes/connection.php');
include('./functions/common.php');

cart();
updateCart();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Slimerch Ecommerce - Cart Details</title>
    <!-- BootStrap CSS Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS Style -->
    <link rel="stylesheet" href="style.css">
</head>
  <body>
    <!-- navbar -->
    <div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-info">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><i class="fa-brands fa-shopify"></i></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="display_all_products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="./user/user_registration.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php"><i class="fa-sharp fa-solid fa-cart-shopping"></i>
        <?php
            getNumberOfCartItems();
        ?>
        </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
<ul class="navbar-nav me-auto">
    <li class="nav-item">
      <?php
        if (!isset($_SESSION['username'])){
          echo "<a class='nav-link' href='#'>Welcome Guest</a>";
        } else {
          echo "<a class='nav-link' href='#'>Welcome ".$_SESSION['username']."</a>";
        }
      ?>
        
    </li>
    <li class="nav-item">
      <?php
        if (!isset($_SESSION['username'])){
          echo "<a class='nav-link' href='./user/user_login.php'>Login</a>";
        } else {
          echo "<a class='nav-link' href='./user/logout.php'>Logout</a>";
        }
      ?>
    </li>
</ul>
</nav>

<div class="bg-light">
    <h3 class="text-center">Slimerch Store Page</h3>
    <p class="text-center"> Cart Details</p>
</div>

<div class="container">
    <div class="row">
        <form action="" method="post">
        <table class="table table-bordered text-center">
            
                <?php
                    global $connection;
                    $ip = getIPAddress();
                    $select_query = "select * from `cartdetails` where IpAddress='$ip'";
                    $select_result = mysqli_query($connection, $select_query);
                    $numRows = mysqli_num_rows($select_result);
                    $totalPrice = 0;
                    if ($numRows > 0){
                        echo "<thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Image</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Remove</th>
                                    <th colspan='2'>Actions</th>
                                </tr>
                            </thead>
                            <tbody>";
                        while($row_data = mysqli_fetch_array($select_result)){
                            $productId = $row_data['ProductId'];
                            $quantity = $row_data['Quantity'];
                            $select_query_price = "select * from `product` where Id=$productId";
                            $select_price_result = mysqli_query($connection, $select_query_price);
                            while ($row_product_price = mysqli_fetch_array($select_price_result)){
                                $product_price = array($row_product_price['Price'] * $quantity);
                                $price_table = $row_product_price['Price'] * $quantity;
                                $product_name = $row_product_price['Name'];
                                $product_image = $row_product_price['Image'];
                                $product_values = array_sum($product_price);
                                $totalPrice += $product_values;
                ?>
                <tr>
                    <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                    <td><?php echo $product_name; ?></td>
                    <td><img src="./admin/product_images/<?php echo $product_image; ?>" alt="" class="cart-img"></td>
                    <td><input type="text" name="quantity" id="" value="<?php echo $quantity; ?>" class="form-input w-50"></td>
                    <td>$<?php echo $price_table; ?>/-</td>
                    <td><input type="checkbox" name="removeitem[]" value="<?php echo $productId ?>"></td>
                    <td>
                        <input type="submit" value="Update Cart" class="bg-info px-3 py-2 border-0 mx-3" name="update_cart">
                        <input type="submit" value="Remove" class="bg-info px-3 py-2 border-0 mx-3" name="remove_cart">
                    </td>
                </tr>

                <?php
                            }
                        }

                        echo "</tbody>";
                    } else {
                        echo "<h2 class='text-center text-danger'>Cart is empty</h2>";
                    }
                    
                ?>
           
        </table>
        <div class="d-flex mb-5">
            <?php
                global $connection;
                $ip = getIPAddress();
                $select_query = "select * from `cartdetails` where IpAddress='$ip'";
                $select_result = mysqli_query($connection, $select_query);
                $numRows = mysqli_num_rows($select_result);
                $totalPrice = 0;
                if ($numRows > 0){
                  $totalPrice = getTotalPrice();
                    echo "<h4 class='px-3'>Subtotal: <strong class='text-info'>$$totalPrice/-</strong></h4>
                    <input type='submit' value='Continue Shopping' class='bg-info px-3 py-2 border-0 mx-3' name='continue_shopping'>
                    <input type='submit' value='Checkout' class='bg-info px-3 py-2 border-0 mx-3' name='checkout'>
                    ";
                } else {
                    echo "<input type='submit' value='Continue Shopping' class='bg-info px-3 py-2 border-0 mx-3' name='continue_shopping'>";
                }
                if (isset($_POST['continue_shopping'])){
                    echo "<script>window.open('index.php','_self')</script>";
                }
                else if (isset($_POST['checkout'])){
                    echo "<script>window.open('./user/checkout.php','_self')</script>";
                }
            ?>
        </div>
        </form>
    </div>
</div>


<div class="bg-info p-3 text-center">
    <p>Copyright 2023</p>
</div>
    </div>
    <!-- BootStrap JS Link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
