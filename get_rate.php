<?php
// Database connection details
$servername = "localhost";
$dbusername = "root"; // Change if needed
$dbpassword = ""; // Change if needed
$dbname = "userdb";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the current exchange rate
$sql = "SELECT rate FROM exchange_rate ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $rate = $result->fetch_assoc()['rate'];
    echo json_encode(['rate' => $rate]);
} else {
    echo json_encode(['rate' => null]);
}

$conn->close();
?>
