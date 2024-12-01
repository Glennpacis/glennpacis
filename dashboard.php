<?php
require 'db.php';

// Fetch the total number of users
$result = $conn->query("SELECT COUNT(*) as total FROM users");
$totalUsers = $result->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
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
                    <li><a href="archives.php">Archived Users</a></li>
                    <li><a href="login.php">Log In</a></li>
                </ul>
            </aside>
        </div>
        <div class="column">
            <h1 class="title">Dashboard</h1>
            <div class="notification is-info">
                <h2 class="subtitle">Welcome to the Admin Dashboard</h2>
                <p>Total Users: <strong><?php echo $totalUsers; ?></strong></p>
            </div>
            <div class="buttons">
                <a class="button is-primary" href="create.php">Create New User</a>
                <a class="button is-info" href="read.php">View Users</a>
            </div>
        </div>
    </div>
</body>
</html>