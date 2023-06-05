<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['createdb'])) {
    $servername = "localhost";
    $username = "root";
$password = "";
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$dbName = "abcdefghiqw";
$sql_create_db = "CREATE DATABASE $dbName";
$conn->query($sql_create_db);
$conn->select_db($dbName);

$sql_create_table = "CREATE TABLE add_vacc(
    cname VARCHAR(50) NOT NULL,
    whs TIME NOT NULL,
    whe TIME NOT NULL,
    loc VARCHAR(50) NOT NULL,
    cno INT(10) NOT NULL,
    email VARCHAR(50) NOT NULL,
    cd1 INT(11) NOT NULL,
    cd2 INT(11) NOT NULL
    )";
$conn->query($sql_create_table);
$sql="CREATE TABLE slots (
    date DATE,
    aadhar INT(12)
)";
$conn->query($sql);
$sqll="CREATE TABLE users (
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL
)";
$conn->query($sqll);
$conn->close();
}?>