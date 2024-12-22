<?php
session_start();
include('Database.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $matric_number = $_POST['matric_number'];
    $password = $_POST['password'];

    // Escape user inputs to prevent SQL injection
    $matric_number = $conn->real_escape_string($matric_number);
    $password = $conn->real_escape_string($password);

    // Query to check if the matric_number and password match any user
    $sql = "SELECT * FROM users WHERE matric_number = '$matric_number'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the password matches
        if (password_verify($password, $row['password'])) {
            // Password is correct, start the session
            $_SESSION['logged_in'] = true;
            $_SESSION['matric_number'] = $row['matric_number']; // Store matric number in session
            $_SESSION['role'] = $row['role']; // Store role in session

            // Redirect to the user page after successful login
            header("Location: user.php");
            exit();
        } else {
            // Password is incorrect
            $_SESSION['error'] = "Incorrect password. Please try again.";
            header("Location: index.php");
            exit();
        }
    } else {
        // Matric number not found
        $_SESSION['error'] = "Matric number not found. Please register.";
        header("Location: index.php");
        exit();
    }
}
?>
