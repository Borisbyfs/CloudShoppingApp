<?php
include_once('../includes/connection.php');
include_once('../functions/common.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecommerce Website</title>
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
          <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../display_all_products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="user_registration.php">Register</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../cart.php"><i class="fa-sharp fa-solid fa-cart-shopping"></i>
        <?php
            getNumberOfCartItems();
        ?>
        </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Total Price:$<?php echo getTotalPrice(); ?>/-</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
        <input type="submit" class="btn btn-outline-light" value="Search">
      </form>
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
    <h3 class="text-center">Checkout</h3>
    <p class="text-center">Choose your payment method</p>
</div>

<div class="row px-1">
    <div class="class col-md-12">
        <div class="row">
            <?php
                if (!isset($_SESSION['username'])){
                    include('user_login.php');
                } else {
                    include('../payment.php');
                }
            ?>
        </div>
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
