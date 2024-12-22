<?php
session_start();
include('Database.php');

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    // If not logged in, redirect to login page
    header("Location: index.php");
    exit();
}

// Query to fetch all users from the database
$sql = "SELECT id, matric_number, name, role FROM users";
$result = $conn->query($sql);

// Handle user deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM users WHERE id = '$delete_id'";

    if ($conn->query($delete_sql) === TRUE) {
        $_SESSION['success'] = "User deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting user: " . $conn->error;
    }

    header("Location: user.php");
    exit();
}

// Handle user update
if (isset($_POST['update_id'])) {
    $update_id = $_POST['update_id'];
    $updated_name = $_POST['updated_name'];
    $updated_role = $_POST['updated_role'];

    $update_sql = "UPDATE users SET name = '$updated_name', role = '$updated_role' WHERE id = '$update_id'";

    if ($conn->query($update_sql) === TRUE) {
        $_SESSION['success'] = "User updated successfully.";
    } else {
        $_SESSION['error'] = "Error updating user: " . $conn->error;
    }

    header("Location: user.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>All Registered Users</h2>

        <?php
        if (isset($_SESSION['error'])) {
            echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['success'])) {
            echo '<p style="color: green;">' . $_SESSION['success'] . '</p>';
            unset($_SESSION['success']);
        }
        ?>

        <table>
            <thead>
                <tr>
                    <th>Matric Number</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any users
                if ($result->num_rows > 0) {
                    // Loop through the results and display each user in a table row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['matric_number']) . "</td>
                                <td>" . htmlspecialchars($row['name']) . "</td>
                                <td>" . htmlspecialchars($row['role']) . "</td>
                                <td>
                                    <a href='#' onclick='showUpdateForm(" . $row['id'] . ", \"" . addslashes($row['name']) . "\", \"" . addslashes($row['role']) . "\")'>Update</a> |
                                    <a href='user.php?delete_id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Update User Form (Initially hidden) -->
        <div id="updateForm" style="display: none;">
            <h3>Update User</h3>
            <form method="POST" action="user.php">
                <input type="hidden" name="update_id" id="update_id">
                <label for="updated_name">Name:</label>
                <input type="text" name="updated_name" id="updated_name" required><br>

                <label for="updated_role">Role:</label>
                <select name="updated_role" id="updated_role" required>
                    <option value="student">Student</option>
                    <option value="lecturer">Lecturer</option>
                </select><br>

                <button type="submit">Update</button>
                <button type="button" onclick="cancelUpdate()">Cancel</button>
            </form>
        </div>

        <br>
        <a href="logout.php">Logout</a>
    </div>

    <script>
        function showUpdateForm(id, name, role) {
            // Set form values
            document.getElementById("update_id").value = id;
            document.getElementById("updated_name").value = name;
            document.getElementById("updated_role").value = role;

            // Show the update form
            document.getElementById("updateForm").style.display = "block";
        }

        function cancelUpdate() {
            // Hide the update form
            document.getElementById("updateForm").style.display = "none";
        }
    </script>
</body>
</html>
