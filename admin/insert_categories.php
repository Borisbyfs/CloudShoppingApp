<?php
include('../inc/connection.php');
if(isset($_POST['insert_cat'])){
    $category_title = $_POST['category_title'];

    // Select data from database
    $select_query="select * from `category` where Name='$category_title'";
    $resultSelect = mysqli_query($connection, $select_query);
    $number = mysqli_num_rows($resultSelect);
    if ($number > 0){
        echo "<script>alert('This category already exists!')</script>";
    } else {
        $insert_query="insert into `category` (Name) values ('$category_title')";
        $result = mysqli_query($connection, $insert_query);
        if ($result){
            echo "<script>alert('Category inserted successfully!')</script>";
        }
    }
}
?>

<h2 class="text-center">Insert Category</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1">
            <i class="fa-solid fa-receipt"></i>
        </span>
        <input type="text" class="form-control" name="category_title" placeholder="Insert Categories" aria-label="Categories" aria-describedby="basic-addon1">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_cat" value="Insert">
    </div>
</form>