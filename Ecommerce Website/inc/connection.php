<?php include "dbinfo.inc"; ?>

<?php

$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
if (!$connection) {
    die(mysqli_error($connection));
}

VerifyCategoryTable($connection, DB_DATABASE);
VerifyBrandTable($connection, DB_DATABASE);

?>

<?php

function VerifyCategoryTable($connection, $dbName)
{
    if (!TableExists("category", $connection, $dbName)) {
        $query = "CREATE TABLE category (
Id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Name VARCHAR(100)
)";

        if (!mysqli_query($connection, $query))
            echo ("<p>Error creating table.</p>");
    }
}

function VerifyBrandTable($connection, $dbName)
{
    if (!TableExists("brand", $connection, $dbName)) {
        $query = "CREATE TABLE brand (
Id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
Name VARCHAR(100)
)";

        if (!mysqli_query($connection, $query))
            echo ("<p>Error creating table.</p>");
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

    if (mysqli_num_rows($checktable) > 0)
        return true;

    return false;
}

?>