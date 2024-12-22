<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>

        <?php
        if (isset($_SESSION['error'])) {
            echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        ?>

        <form action="register_process.php" method="POST">
            <label for="matric_number">Matric Number:</label>
            <input type="text" name="matric_number" required><br>

            <label for="name">Name:</label>
            <input type="text" name="name" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <label for="role">Role:</label>
            <select name="role" required>
                <option value="student">Student</option>
                <option value="lecturer">Lecturer</option>
            </select><br>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
