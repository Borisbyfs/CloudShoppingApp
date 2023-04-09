<?php
@session_start();

function getProducts($displayAll = false){
    global $connection;
    $select_query = "select * from `product` order by Name limit 0,9";
    if ($displayAll){
        $select_query = "select * from `product` order by Name";
    }
    if (isset($_GET['category'])){
        $category_id = $_GET['category'];
        $select_query = "select * from `product` where CategoryId=$category_id order by Name";
    } else if (isset($_GET['brand'])){
        $brand_id = $_GET['brand'];
        $select_query = "select * from `product` where BrandId=$brand_id order by Name";
    } else if (isset($_GET['search_data'])){
        $search_keyword = $_GET['search_data'];
        $select_query = "select * from `product` where Keywords like '%$search_keyword%'";
    }
    $select_result = mysqli_query($connection, $select_query);
    $numRows = mysqli_num_rows($select_result);
    if (isset($_GET['category'])){
        if ($numRows==0){
            echo "<h2 class='text-center text-danger'>No stock for this category.</h2>";
        }
    } else if (isset($_GET['brand'])){
        if ($numRows==0){
            echo "<h2 class='text-center text-danger'>No stock for this brand.</h2>";
        }
    } else if (isset($_GET['search_data'])){
        if ($numRows==0){
            $search_keyword = $_GET['search_data'];
            echo "<h2 class='text-center text-danger'>No results found for '$search_keyword'.</h2>";
        } else {
            echo "<h2 class='text-center'>$numRows results found for '$search_keyword'.</h2>";
        }
    }else {
        if ($numRows==0){
            echo "<h2 class='text-center text-danger'>No stock left.</h2>";
        }
    }
    while($row = mysqli_fetch_assoc($select_result)){
        $id = $row['Id'];
        $name = $row['Name'];
        $description = $row['Description'];
        $keywords = $row['Keywords'];
        $image = $row['Image'];
        $price = $row['Price'];
        $brand_id = $row['BrandId'];
        $category_id = $row['CategoryId'];
        #<a href='#' class='btn btn-secondary'>View more</a>
        echo " <div class='col-md-4 mb-2'>
        <div class='card'>
            <img src='./admin/product_images/$image' class='card-img-top' alt='$name'>
            <div class='card-body'>
                <h5 class='card-title'>$name</h5>
                <p class='card-text'>$description</p>
                <p class='card-text'>Price: $$price/-</p>
                <a href='index.php?add_to_cart=$id' class='btn btn-info'>Add To Cart</a>
            </div>
        </div>
        </div>";
    }
}

function getBrands(){
    global $connection;
    $select_brands = "select * from `brand`";
    $result_brands = mysqli_query($connection, $select_brands);
    while($row_data = mysqli_fetch_assoc($result_brands)){
        $brand_title = $row_data['Name'];
        $brand_id = $row_data['Id'];
        echo " <li class='nav-item'>
        <a href='index.php?brand=$brand_id' class='nav-link text-light'>$brand_title</a>
        </li>";
    }
}

function getCategories(){
    global $connection;
    $select_categories = "select * from `category`";
    $result_categories = mysqli_query($connection, $select_categories);
    while($row_data = mysqli_fetch_assoc($result_categories)){
        $category_title = $row_data['Name'];
        $category_id = $row_data['Id'];
        echo "<li class='nav-item'>
        <a href='index.php?category=$category_id' class='nav-link text-light'>$category_title</a>
        </li>";
    }
}

function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    //whether ip is from the proxy  
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
    //whether ip is from the remote address  
    else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  

function cart() {
    if (isset($_GET['add_to_cart'])){
        global $connection;
        $ip = getIPAddress();
        $productId = $_GET['add_to_cart'];
        $select_query = "select * from `cartdetails` where IpAddress='$ip' and ProductId=$productId";
        $select_result = mysqli_query($connection, $select_query);
        $numRows = mysqli_num_rows($select_result);
        if ($numRows > 0){
            $increment_query="update `cartdetails` set Quantity = Quantity + 1 where IpAddress='$ip' and ProductId=$productId";
            $increment_result = mysqli_query($connection, $increment_query);
            echo "<script>alert('Product added to cart!')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        } else {
            $insert_query="insert into `cartdetails` (IpAddress,ProductId,Quantity) values ('$ip', $productId, 1)";
            $insert_result = mysqli_query($connection, $insert_query);
            echo "<script>alert('Product added to cart!')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        }

    }
}

function getNumberOfCartItems(){
    global $connection;
    $ip = getIPAddress();
    $select_query = "select * from `cartdetails` where IpAddress='$ip'";
    $select_result = mysqli_query($connection, $select_query);
    $numRows = mysqli_num_rows($select_result);
    $totalQuantity = 0;
    if ($numRows > 0){
        while($row_data = mysqli_fetch_assoc($select_result)){
            $quantity = $row_data['Quantity'];
            $totalQuantity += $quantity;
        }
        echo "<sup>$totalQuantity</sup>";
    }
}

function getTotalPrice(){
    global $connection;
    $ip = getIPAddress();
    $select_query = "select * from `cartdetails` where IpAddress='$ip'";
    $select_result = mysqli_query($connection, $select_query);
    $numRows = mysqli_num_rows($select_result);
    $totalPrice = 0;
    if ($numRows > 0){
        while($row_data = mysqli_fetch_array($select_result)){
            $productId = $row_data['ProductId'];
            $quantity = $row_data['Quantity'];
            $select_query_price = "select * from `product` where Id=$productId";
            $select_price_result = mysqli_query($connection, $select_query_price);
            while ($row_product_price = mysqli_fetch_array($select_price_result)){
                $product_price = array($row_product_price['Price'] * $quantity);
                $product_values = array_sum($product_price);
                $totalPrice += $product_values;
            }
        }
    }
    return $totalPrice;
}

function updateCart(){
    if (isset($_POST['update_cart'])){
        global $connection;
        $ip = getIPAddress();
        $newQuantity = $_POST['quantity'];
        $productId = $_POST['productId'];
        $update_query = "update `cartdetails` set Quantity=$newQuantity where IpAddress='$ip' and ProductId=$productId";
        $update_result = mysqli_query($connection, $update_query);
        #if ($update_result){
            #echo "<script>alert('Product quantity updated!')</script>";
        #}
    }
    if (isset($_POST['remove_cart']) && isset($_POST['removeitem'])){
        global $connection;
        $ip = getIPAddress();
        foreach($_POST['removeitem'] as $remove_id){
            $delete_query = "delete from `cartdetails` where IpAddress='$ip' and ProductId=$remove_id";
            $delete_result = mysqli_query($connection, $delete_query);
            if ($delete_result){
                echo "<script>alert('Product removed from cart!')</script>";
                echo "<script>window.open('cart.php','_self')</script>";
            }
        }
    }
}

?>