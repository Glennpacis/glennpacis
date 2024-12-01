<?php
require 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<div class='notification is-success'>User  deleted successfully!</div>";
    } else {
        echo "<div class='notification is-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
</head>
<body>
    <div class="columns">
        <div class="column is-one-fifth">
            <aside class="menu">
                <p class="menu-label">Admin Menu</p>
                <ul class="menu-list">
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="create.php">Create User</a></li>
                    <li><a href="read.php">View Users</a></li>
                </ul>
            </aside>
        </div>
        <div class="column">
            <h1 class="title">Delete User</h1>
            <p class="notification is-warning">Are you sure you want to delete this user?</p>
            <div class="control">
                <a class="button is-danger" href="read.php">Cancel</a>
                <a class="button is-primary" href="read.php">Go Back to Users List</a>
            </div>
        </div>
    </div>
</body>
</html>