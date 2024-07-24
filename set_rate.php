<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php?redirect=set_rate.php");
    exit;
}

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

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rate = $_POST['rate'];

    // Prepare and execute SQL statement to update the exchange rate
    $sql = "INSERT INTO exchange_rate (rate) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("d", $rate);

    if ($stmt->execute()) {
        $message = "Exchange rate updated successfully.";
    } else {
        $message = "Error updating exchange rate: " . $conn->error;
    }

    $stmt->close();
}

// Fetch the current exchange rate
$sql = "SELECT rate FROM exchange_rate ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$current_rate = $result->fetch_assoc()['rate'];

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set Exchange Rate</title>
</head>
<body>
    <h2>Set Exchange Rate</h2>
    <form action="set_rate.php" method="post">
        <label for="rate">Exchange Rate (RMB to ZMW):</label>
        <input type="text" id="rate" name="rate" value="<?php echo $current_rate; ?>" required>
        <button type="submit">Set Rate</button>
    </form>
    <p><?php echo $message; ?></p>
    <a href="index.php"><button type="button">Home</button></a>
    <a href="logout.php"><button type="button">Logout</button></a>
</body>
</html>
