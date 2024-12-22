<?php
session_start();
include('Database.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $matric_number = $_POST['matric_number'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Check if the matric number already exists
    $sql = "SELECT * FROM users WHERE matric_number = '$matric_number'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Matric number already exists. Please use a different one.";
        header("Location: register.php");
        exit();
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database
        $sql = "INSERT INTO users (matric_number, name, password, role) VALUES ('$matric_number', '$name', '$hashed_password', '$role')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "Registration successful! You can now log in.";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Error: " . $conn->error;
            header("Location: register.php");
            exit();
        }
    }
}
?>
