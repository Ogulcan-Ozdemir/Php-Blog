<?php
$servername = "localhost";
$username = "root";
$password = "your_password";
$dbname="accounts_database";
$con = mysqli_connect($servername, $username, $password);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql_database = "CREATE DATABASE IF NOT EXISTS accounts_database";
if (mysqli_query($con, $sql_database)) {
    // echo "Database created successfully";
} else {
    echo "Error creating database: " . mysqli_error($con);
}


$con_table= mysqli_connect($servername, $username, $password, $dbname);
$sql_table = "CREATE TABLE IF NOT EXISTS Accounts (
id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(30) NOT NULL,
password VARCHAR (10) NOT NULL
)";

if (mysqli_query($con_table, $sql_table)) {
    // echo "Table Accounts created successfully";
} else {
    echo "Error creating table: " . mysqli_error($con_table);
}

mysqli_close($con);
mysqli_close($con_table);
?>
