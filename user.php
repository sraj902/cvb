<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addCenter'])) {
    $conn = new mysqli("localhost", "root", "", "abcdefghiqw");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Check if the maximum limit of 10 users per day has been reached
    $date = date('Y-m-d');
    $sql = "SELECT COUNT(*) AS total FROM slots WHERE date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $totalUsers = $row['total'];

    if ($totalUsers >= 10) {
        // Maximum limit reached, display a message or take appropriate action
        echo "Sorry, the maximum number of users for today has been reached. Please try again tomorrow.";
    } else {
        // Proceed with the application process
        // Retrieve and sanitize the user input
        $aadhar = $_POST['aadhar'];

        // Insert the user's application into the database
        $sql = "INSERT INTO slots (date, aadhar) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $date, $aadhar);
        
        if ($stmt->execute()) {
            echo "Your application has been submitted successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();

    
    
    $conn->close();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['getDosageDetails'])) {
        $conn = new mysqli("localhost", "root", "", "abcdefghiqw");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT cname, SUM(cd1) AS totalDosage1, SUM(cd2) AS totalDosage2 FROM add_vacc GROUP BY cname";
    
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $dosageDetails = array();
            while ($row = $result->fetch_assoc()) {
                $dosageDetails[] = $row;
            }
            $encodedDosageDetails = json_encode($dosageDetails);
        } else {
            echo 'No dosage details found';
        }
        header('Content-Type: application/json');
        echo json_encode($dosageDetails);
        exit();
        $conn->close();
    }
/*$conn = new mysqli("localhost", "root", "", "yuty");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT DISTINCT cname FROM add_vacc";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $centerOptions = '';
    while ($row = $result->fetch_assoc()) {
        $centerName = $row['cname'];
        $centerOptions .= '<option value="' . $centerName . '">' . $centerName . '</option>';
    }
}
 else {
    $centerOptions = '<option value="">No centers available</option>';
}
$conn->close();*/

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeCenter'])) {

    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="user.js"></script>
</head>
<body>
    <div class="container">
        <h1>Welcome, User</h1>
        <button id="addCenterButton" onclick="showAddCenterForm()">Search Vaccination Center</button>
        <button id="getDosageButton" onclick="getDosageDetails()">Apply</button>
        <button id="removeCenterButton" onclick="showRemoveCenterForm()">Apply for Vaccination</button>
        <button id="logoutButton" onclick="logout()">Logout</button>
    </div>

    <div id="addCenterForm" class="container hidden">
    <h2>Add Vaccination Center</h2>
    <!--<form id="addCenterForm" method="GET" action="">
        <input type="text" name="ccname" placeholder="Center Name" required><br>
        <button id="getDosageButton" onclick="getDosageDetails()">Search</button>
    </form>-->
</div>

<div id="dosageDetails" class="container hidden">
        <h2>Dosage Details</h2>
        <table id="dosageTable">
            <tr>
                <th>Center Name</th>
                <th>totalDosage1</th>
                <th>totalDosage2</th>
            </tr>
        </table>
    </div>

    <div id="removeCenterForm" class="container hidden">
        <h2>Apply Vaccination Center</h2>
        <form id="removeCenterForm" method="POST" action="">
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="text" name="pno" placeholder="Phone Number" required><br>
        <input type="email" name="email" placeholder="Email ID" required><br>
        <input type="text" name="aadhar" placeholder="Aadhar" required>
        <button type="submit" name="addCenter"">Apply</button>
        </form>
    </div>

</body>
</html>
