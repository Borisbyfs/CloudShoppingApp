<?php
include_once('../includes/connection.php');
include_once('../functions/common.php');

if (isset($_POST['login_user'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $userip = getIPAddress();

    if ($username=='' or $password==''){
        echo "<script>alert('Required field is empty!')</script>";
        exit();
    } else {
        $select_query = "select * from `usertable` where Username='$username'";
        $select_result = mysqli_query($connection, $select_query);
        $numRows = mysqli_num_rows($select_result);
        $rowData = mysqli_fetch_assoc($select_result);
        if ($numRows > 0){
            $passwordHash = $rowData['Password'];
            
            if (password_verify($password, $passwordHash)){
                $_SESSION['username'] = $username;
                echo "<script>alert('Login Successful!')</script>";
                #echo "<script>alert(".$_SESSION['username'].")</script";
                $cart_query = "select * from `cartdetails` where IpAddress='$userip'";
                $cart_result = mysqli_query($connection,$cart_query);
                $cart_rows = mysqli_num_rows($cart_result);
                if ($cart_rows > 0){
                    echo "<script>window.open('../payment.php','_self')</script>";
                } else {
                    echo "<script>window.open('../index.php','_self')</script>";
                }
                

                
            } else {
                echo "<script>alert('Invalid Password!')</script>";
            }
        } else {
            echo "<script>alert('Invalid Username!')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce Website - User Registration</title>
    <!-- BootStrap CSS Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS Style -->
    <link rel="stylesheet" href="../style.css">
    <style>
        body{
            overflow-x:hidden;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Login to Slimerch</h1>
        <!-- form -->
        <form action="" method="post">
            <!-- Username -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username", id="username" class="form-control" placeholder="Enter username" autocomplete="off" required="required">
            </div>
            <!-- Password -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password", id="password" class="form-control" placeholder="Enter password" autocomplete="off" required="required">
            </div>
            <!-- Submit -->
            <div class="form-outline mb-4 w-50 m-auto text-center">
                <input type="submit" name="login_user" class="btn btn-info mb-3 px-3" value="Login">
                <p class="small fw-bold">Don't have an account? <a href="user_registration.php">Register</a></p>
            </div>
        </form>
    </div>
    <!-- BootStrap JS Link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>