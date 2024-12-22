<?php
$servername = "localhost";
$username = "Danial"; // default username for XAMPP or WAMP
$password = "Danial11"; // default password for XAMPP or WAMP
$dbname = "Lab_5b"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
