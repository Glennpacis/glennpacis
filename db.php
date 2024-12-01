<?php
$host = 'localhost'; // Change if necessary
$user = 'root'; // Your database username
$pass = ''; // Your database password
$db = 'car services appointment'; // Your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>