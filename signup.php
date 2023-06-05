<?php
$mysqli = new mysqli("localhost", "root", "", "abcdefghiqwf");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password=$_POST["password"];
    $query = "SELECT * FROM users WHERE username = '$email' AND password = '$password'";
    $result = $mysqli->query($query);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 1) {
        echo "The values are in the same row.";
    } 
    else {
        $insert_query = "INSERT INTO users (username,password) VALUES ('$email', '$password')";
        $insert_result = $mysqli->query($insert_query);
        echo "INSERT";
    }
}
?>