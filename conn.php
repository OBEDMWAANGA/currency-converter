<?php
// Connect to MySQL
$servername = "localhost";
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "userdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hash the password
$hashed_password = password_hash("pass", PASSWORD_DEFAULT);

// Insert a test user
$sql = "INSERT INTO users (username, password) VALUES ('obby', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "New user created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
