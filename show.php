<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeCenter'])) {
    $conn = new mysqli("localhost", "root", "", "abcdefghiqw");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $centerToRemove = $_POST['centerToRemove'];
    $sql = "SELECT cname, whs, whe FROM add_vacc where cname='$centerToRemove'";

    $result = $conn->query($sql);
    $num_rows = mysqli_num_rows($result);
    echo "<table border=1>";
    echo "<tr><th>Center Name</th><th>WHS</th><th>WHE</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>" . $row['cname'] . "</td><td>" . $row['whs'] . "</td><td>" . $row['whe'] . "</td></tr>";
    }
    echo "</table>";
/*    if ($result->num_rows > 0) {
        $dosageDetails = array();
        while ($row = $result->fetch_assoc()) {
            $dosageDetails[] = $row;
        }
        $encodedDosageDetails = json_encode($dosageDetails);
    } else {
        echo 'No dosage details found';
    }

    header('Content-Type: application/json');
    echo json_encode($dosageDetails);*/
    exit();
    $conn->close();
}

?>