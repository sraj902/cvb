<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addCenter'])) {
        $conn = new mysqli("localhost", "root", "", "abcdefghiqw");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $date = date('Y-m-d');
        $aadhar = $_POST['aadhar'];
        $integerInput=$_POST['integerInput'];
        $sql = "SELECT COUNT(*) AS total FROM slots WHERE date = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $totalUsers = $row['total'];
    
        if ($totalUsers < 10) {
            $insertSql = "INSERT INTO slots (date, aadhar) VALUES (?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("ss", $date, $integerInput);
            if ($insertStmt->execute()) {
                echo "Your application has been submitted successfully.";
            } else {
                echo "Error: " . $conn->error;
            }
            $insertStmt->close();
        } else {
            echo "Sorry, the maximum number of users for today has been reached. Please try again tomorrow.";
        }
    
        $stmt->close();
        $conn->close();
    }
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['getDosageDetails'])) {
    $conn = new mysqli("localhost", "root", "", "abcdefghiqw");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT cname, whs, whe FROM add_vacc";

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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeCenter'])) {
    $conn = new mysqli("localhost", "root", "", "abcdefghiqw");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $centerToRemove = $_POST['centerToRemove'];
    $sql = "SELECT cname, whs, whe FROM add_vacc where cname='$centerToRemove'";
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="new.js"></script>
</head>
<body>

    <div class="container">
        <h1>Welcome, User</h1>
        <h1 align="center"> COVID VACCINATION BOOKING </h1>
        <button id="removeCenterButton" onclick="showRemoveCenterForm()">Search Vaccination Center</button>
        <button id="addCenterButton" onclick="showAddCenterForm()">Apply for Vaccination</button>
        <button id="logoutButton" onclick="logout()">Logout</button>
    </div>

    <div id="addCenterForm" class="container hidden">

        <h2>Apply Vaccination Center</h2>
        <form id="addCenterForm" method="POST" action="">
        <label> Name :</label><input type="text" name="name" placeholder="Name" required><br>
        <label> Phone Number :</label><input type="text" name="pno" placeholder="Phone Number" required><br>
        <label> Email Id :</label><input type="email" name="email" placeholder="Email ID" required><br>
        <label> Aadhar :</label><input type="number" name="integerInput" pattern="[0-9]{12}" title="Please enter a 12-digit integer." required><br>
        <!--<input type="text" name="aadhar" placeholder="Aadhar" required>-->
        <button type="submit" name="addCenter"">Apply</button>
        </form>
    </form>
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
        <h2>Search for Vaccination Center</h2>
        <form id="removeCenterForm" method="POST" action="show.php" target="_blank">

        <select id="centerToRemove" name="centerToRemove">
        <?php 
        $conn= new mysqli("localhost", "root", "", "abcdefghiqw");
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
        $conn->close();
        echo $centerOptions; ?>
    </select>
            <button type="submit" name="removeCenter">Show Center</button>
        </form>
    </div>
</body>
</html>
