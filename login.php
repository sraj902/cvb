<?php
$mysqli = new mysqli("localhost", "root", "", "abcdefghiqwf");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password=$_POST["password"];
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $mysqli->query($query);
    $role=$_POST['role'];
    if($role==='user'){
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['role'] = 'user';
        $_SESSION['username'] = $username;
        header('Location: new.php');
        exit();
      } else {
        // Invalid credentials
        $_SESSION['error'] = 'Invalid username or password';
        header('Location: signup.php'); 
        exit();
      }}
      else if($role==='admin'){
        if ($username==='admin' && $password===123) {
            $_SESSION['role'] = 'admin';
            $_SESSION['username'] = $username;
            header('Location: admin.php'); 
            exit();
          } else {
            $_SESSION['error'] = 'Invalid username or password';
            header('Location: admin.php');
            exit();
          }}
    } else {
      header('Location: admin.php');
      exit();
    }

?>