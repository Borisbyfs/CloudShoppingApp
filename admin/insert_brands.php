<?php
include('../inc/connection.php');
if(isset($_POST['insert_brand'])){
    $brand_title = $_POST['brand_title'];

    // Select data from database
    $select_query="select * from `brand` where Name='$brand_title'";
    $resultSelect = mysqli_query($connection, $select_query);
    $number = mysqli_num_rows($resultSelect);
    if ($number > 0){
        echo "<script>alert('This brand already exists!')</script>";
    } else {
        $insert_query="insert into `brand` (Name) values ('$brand_title')";
        $result = mysqli_query($connection, $insert_query);
        if ($result){
            echo "<script>alert('Brand inserted successfully!')</script>";
        }
    }
}
?>

<h2 class="text-center">Insert Brand</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1">
            <i class="fa-solid fa-receipt"></i>
        </span>
        <input type="text" class="form-control" name="brand_title" placeholder="Insert Brands" aria-label="Brands" aria-describedby="basic-addon1">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_brand" value="Insert">
    </div>
</form>