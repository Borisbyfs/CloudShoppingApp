<?php
include('../includes/connection.php');
include('../functions/common.php');
if (isset($_POST['register_user'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $image = $_FILES['image']['name'];
    $tmpimage = $_FILES['image']['tmp_name'];
    $password = $_POST['password'];
    $hash_password=password_hash($password, PASSWORD_DEFAULT);
    $confirmpassword = $_POST['confirmpassword'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $userip = getIPAddress();

    $select_query = "select * from `usertable` where Username='$username' or Email='$email'";
    $select_result = mysqli_query($connection, $select_query);
    $numRows = mysqli_num_rows($select_result);
    if ($numRows > 0){
        echo "<script>alert('Username or email already exists!')</script>";
    } else if ($password != $confirmpassword) {
        echo "<script>alert('Passwords do not match!')</script>";
    } else {
        if ($username=='' or $email=='' or $image=='' or $password=='' or $confirmpassword=='' or $address =='' or $mobile ==''){
            echo "<script>alert('Required field is empty!')</script>";
            exit();
        } else {
            move_uploaded_file($tmpimage, "./user_images/$image");
            $insert_query = "insert into `usertable` (Username,Email,Password,Image,IpAddress,Address,Mobile) values ('$username', '$email', '$hash_password', '$image', '$userip', '$address', '$mobile')";
            $insert_result = mysqli_query($connection, $insert_query);
            if ($insert_result){
                echo "<script>alert('Registration successful!')</script>";
                #echo "<script>window.open('user_login.php','_self')</script>";
            } else {
                die(mysqli_error($connection));
            }

            $select_cart_items = "select * from `cartdetails` where IpAddress='$userip'";
            $result_cart = mysqli_query($connection, $select_cart_items);
            $numCartRows = mysqli_num_rows($result_cart);
            if ($numCartRows > 0){
                $_SESSION['username'] = $username;
                echo "<script>alert('You have items in your cart.')</script>";
                echo "<script>window.open('checkout.php','_self')</script>";
            } else {
                echo "<script>window.open('../index.php','_self')</script>";
            }
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
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">New User Registration</h1>
        <!-- form -->
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Username -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username", id="username" class="form-control" placeholder="Enter username" autocomplete="off" required="required">
            </div>
            <!-- Email -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email", id="email" class="form-control" placeholder="Enter email" autocomplete="off" required="required">
            </div>
            <!-- Image -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="image" class="form-label">Image</label>
                <input type="file" name="image", id="image" class="form-control" required="required">
            </div>
            <!-- Password -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password", id="password" class="form-control" placeholder="Enter password" autocomplete="off" required="required">
            </div>
            <!-- Confirm Password -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="confirmpassword" class="form-label">Confirm Password</label>
                <input type="password" name="confirmpassword", id="confirmpassword" class="form-control" placeholder="Confirm password" autocomplete="off" required="required">
            </div>
            <!-- Address -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="address" class="form-label">Home Address</label>
                <input type="text" name="address", id="address" class="form-control" placeholder="Enter home address" autocomplete="off" required="required">
            </div>
            <!-- Mobile -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="mobile" class="form-label">Mobile Phone</label>
                <input type="text" name="mobile", id="mobile" class="form-control" placeholder="Enter mobile phone" autocomplete="off" required="required">
            </div>
            <!-- Submit -->
            <div class="form-outline mb-4 w-50 m-auto text-center">
                <input type="submit" name="register_user" class="btn btn-info mb-3 px-3" value="Register">
                <p class="small fw-bold">Already have an account? <a href="user_login.php">Login</a></p>
            </div>
        </form>
    </div>
    <!-- BootStrap JS Link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>