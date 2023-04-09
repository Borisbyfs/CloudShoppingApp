<?php include "dbinfo.inc"; ?>

<?php

$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if (!$connection) {
    die(mysqli_error($connection));
}

$database = mysqli_select_db($connection, DB_DATABASE);

ClearAllTables($connection, DB_DATABASE);
VerifyCategoryTable($connection, DB_DATABASE);
VerifyBrandTable($connection, DB_DATABASE);
VerifyUserTable($connection, DB_DATABASE);
VerifyProductTable($connection, DB_DATABASE);
VerifyCartDetailsTable($connection, DB_DATABASE);

?>

<?php

function ClearAllTables($connection, $dbName)
{
    $query = "DROP TABLE category";
    if (!mysqli_query($connection, $query))
        echo ("<p>Error dropping category table.</p>");


    $query = "DROP TABLE brand";
    if (!mysqli_query($connection, $query))
        echo ("<p>Error dropping brand table.</p>");


    $query = "DROP TABLE usertable";
    if (!mysqli_query($connection, $query))
        echo ("<p>Error dropping user table.</p>");


    $query = "DROP TABLE product";
    if (!mysqli_query($connection, $query))
        echo ("<p>Error dropping product table.</p>");


    $query = "DROP TABLE cartdetails";
    if (!mysqli_query($connection, $query))
        echo ("<p>Error dropping cartdetails table.</p>");

}

function VerifyCategoryTable($connection, $dbName)
{
    if (!TableExists("category", $connection, $dbName)) {
        $query = "CREATE TABLE category (
            Id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(100)
)";

        if (!mysqli_query($connection, $query))
            echo ("<p>Error creating category table.</p>");
    }
}

function VerifyBrandTable($connection, $dbName)
{
    if (!TableExists("brand", $connection, $dbName)) {
        $query = "CREATE TABLE brand (
            Id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(100),
            Address VARCHAR(100),
            Type VARCHAR(100)
)";

        if (!mysqli_query($connection, $query))
            echo ("<p>Error creating brand table.</p>");
    }
}

function VerifyUserTable($connection, $dbName)
{
    if (!TableExists("usertable", $connection, $dbName)) {
        $query = "CREATE TABLE usertable (
            Id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Username VARCHAR(255),
            Email VARCHAR(100),
            Password VARCHAR(255),
            Image VARCHAR(255),
            IpAddress VARCHAR(100),
            Address VARCHAR(255),
            Mobile VARCHAR(100)
)";

        if (!mysqli_query($connection, $query))
            echo ("<p>Error creating user table.</p>");
    }
}

function VerifyProductTable($connection, $dbName)
{
    if (!TableExists("product", $connection, $dbName)) {
        $query = "CREATE TABLE product (
            Id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(100),
            Description VARCHAR(255),
            Keywords VARCHAR(255),
            CategoryId int(11),
            BrandId int(11),
            Image VARCHAR(255),
            Price double,
            Date DATETIME DEFAULT CURRENT_TIMESTAMP,
            Status VARCHAR(100)
)";

        if (!mysqli_query($connection, $query))
            echo ("<p>Error creating product table.</p>");
    }
}

function VerifyCartDetailsTable($connection, $dbName)
{
    if (!TableExists("cartdetails", $connection, $dbName)) {
        $query = "CREATE TABLE cartdetails (
            IpAddress VARCHAR(255),
            ProductId int(11),
            Quantity int(100)
)";

        if (!mysqli_query($connection, $query))
            echo ("<p>Error creating cart details table.</p>");
    }
}

/* Check for the existence of a table. */
function TableExists($tableName, $connection, $dbName)
{
    $t = mysqli_real_escape_string($connection, $tableName);
    $d = mysqli_real_escape_string($connection, $dbName);

    $checktable = mysqli_query(
        $connection,
        "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'"
    );

    if (mysqli_num_rows($checktable) > 0) {
        return true;
    }

    return false;
}

?>