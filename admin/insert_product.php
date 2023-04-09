<?php
include('../includes/connection.php');
if (isset($_POST['insert_product'])){
    $product_name = $_POST['product_title'];
    $product_description = $_POST['product_description'];
    $product_keyword = $_POST['product_keyword'];
    $product_category = $_POST['product_category'];
    $product_brand = $_POST['product_brand'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_tmp = $_FILES['product_image']['tmp_name'];
    $product_price = $_POST['product_price'];
    $product_status = "true";

    if ($product_name=='' or $product_description=='' or $product_keyword=='' or $product_category=='' or $product_brand=='' or $product_image =='' or $product_price ==''){
        echo "<script>alert('Required field is empty!')</script>";
        exit();
    } else {
        move_uploaded_file($product_image_tmp, "./product_images/$product_image");
        $insert_query = "insert into `product` (Name,Description,Keywords,CategoryId,BrandId,Image,Price,Date,Status) values ('$product_name', '$product_description', '$product_keyword', $product_category, $product_brand, '$product_image', $product_price, NOW(), '$product_status')";
        $insert_result = mysqli_query($connection, $insert_query);
        if ($insert_result){
            echo "<script>alert('Product successfully added!')</script>";
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
    <title>Insert Product</title>
    <!-- BootStrap CSS Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Font Awesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS Style -->
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Insert Product</h1>
        <!-- form -->
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Name -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Product Name</label>
                <input type="text" name="product_title", id="product_title" class="form-control" placeholder="Enter product name" autocomplete="off" required="required">
            </div>
            <!-- Description -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_description" class="form-label">Product Description</label>
                <input type="text" name="product_description", id="product_description" class="form-control" placeholder="Enter product description" autocomplete="off" required="required">
            </div>
            <!-- Keywords -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_keyword" class="form-label">Product Keywords</label>
                <input type="text" name="product_keyword", id="product_keyword" class="form-control" placeholder="Enter product keywords" autocomplete="off" required="required">
            </div>
            <!-- Categories -->
            <div class="form-outline mb-4 w-50 m-auto">
                <select name="product_category" id="product_category" class="form-select">
                    <option value="">Select Category</option>
                    <?php
                        $select_query = "select * from `category`";
                        $select_result = mysqli_query($connection, $select_query);
                        while($row = mysqli_fetch_assoc($select_result)){
                            $category_name = $row['Name'];
                            $category_id = $row['Id'];
                            echo " <option value='$category_id'>$category_name</option>";
                        }
                    ?>
                </select>
            </div>
            <!-- Brands -->
            <div class="form-outline mb-4 w-50 m-auto">
                <select name="product_brand" id="product_brand" class="form-select">
                    <option value="">Select Brand</option>
                    <?php
                        $select_query = "select * from `brand`";
                        $select_result = mysqli_query($connection, $select_query);
                        while($row = mysqli_fetch_assoc($select_result)){
                            $brand_name = $row['Name'];
                            $brand_id = $row['Id'];
                            echo " <option value='$brand_id'>$brand_name</option>";
                        }
                    ?>
                </select>
            </div>
            <!-- Image -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image" class="form-label">Product Image</label>
                <input type="file" name="product_image", id="product_image" class="form-control" required="required">
            </div>
            <!-- Price -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="number" name="product_price", id="product_price" class="form-control" placeholder="Enter product price" autocomplete="off" required="required">
            </div>
            <!-- Submit -->
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="insert_product" class="btn btn-info mb-3 px-3" value="Insert Product">
            </div>
        </form>
    </div>
    <!-- BootStrap JS Link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>