<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo "<div class='notification is-success'>User  created successfully!</div>";
    } else {
        echo "
        <div class='notification is-danger'>
            <button class='delete'></button>
            <strong>Error!</strong> There was a problem creating the user.
            <br>
            <small>" . htmlspecialchars($stmt->error) . "</small>
        </div>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
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
            <h1 class="title">Create User</h1>
            <form method="POST">
                <div class="field">
                    <label class="label">Username</label>
                    <div class="control">
                        <input class="input" type="text" name="username" placeholder="Username" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Password</label>
                    <div class="control">
                        <input class="input" type="password" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="input" type="email" name="email" placeholder="Email" required>
                    </div>
                </div>
                <div class="control">
                    <button class="button is-primary" type="submit">Create User</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>