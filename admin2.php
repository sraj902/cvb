<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addCenter'])) {
    $conn = new mysqli("localhost", "root", "", "abcdefghiqw");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
        $cname = $_POST['cname'];
        $whs = $_POST['whs'];
        $whe = $_POST['whe'];
        $loc = $_POST['loc'];
        $cno = $_POST['cno'];
        $email = $_POST['email'];
        $cd1=$_POST['cd1'];
        $cd2=$_POST['cd2'];
        $add="INSERT INTO add_vacc(cname,whs,whe,loc,cno,email,cd1,cd2) VALUES('$cname','$whs','$whe','$loc','$cno','$email','$cd1','$cd2')";
        $conn->query($add);
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeCenter'])) {
    $conn = new mysqli("localhost", "root", "", "abcdefghiqw");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $centerToRemove = $_POST['centerToRemove'];
    $sql = "DELETE FROM add_vacc WHERE cname = '$centerToRemove'";
    $conn->query($sql);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="admin.js"></script>
</head>
<body>
    <div class="container">
        <h1>Welcome, Admin</h1>
       <!-- <button id="createdb" onclick="createdb()">Create DB</button>-->
        <button id="addCenterButton" onclick="showAddCenterForm()">Add Vaccination Center</button>
        <button id="getDosageButton" onclick="getDosageDetails()">Get Dosage Details</button>
        <button id="removeCenterButton" onclick="showRemoveCenterForm()">Remove Vaccination Center</button>
        <button id="logoutButton" onclick="logout()">Logout</button>
    </div>
    <div id="addCenterForm" class="container hidden">
    <h2>Add Vaccination Center</h2>
    <form id="addCenterForm" method="POST" action="">
        <label>Center Name : </label><input type="text" name="cname" placeholder="Center Name" required><br>
        <label>Working Hours (Start time) : </label><input type="time" name="whs" placeholder="Working Hours Start" required><br>
        <label>Working Hours (End time) : </label><input type="time" name="whe" placeholder="Working Hours End" required><br>
        <label>Centre Location : </label><input type="text" name="loc" placeholder="Location" required><br>
        <label>Center Mobile Number : </label><input type="tel" name="cno" placeholder="Contact Number" required><br>
        <label>Email ID : </label><input type="email" name="email" placeholder="Email ID" required><br>
        <label>Dosage 1 Count :</label><input type="number" name="cd1" placeholder="Count of Dosage 1" required><br>
        <label>Dosage 2 Count : </label><input type="number" name="cd2" placeholder="Count of Dosage 2" required>
        <button type="submit" name="addCenter"">Add Center</button>
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
        <h2>Remove Vaccination Center</h2>
        <form id="removeCenterForm" method="POST" action="">

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
            <button type="submit" name="removeCenter">Remove Center</button>
        </form>
    </div>
</body>
</html>
