<?php
require 'db.php';

$id = $_GET['id'];

// Fetch the user data to pre-fill the form
$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET username=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $username, $email, $id);

    if ($stmt->execute()) {
        echo "<div class='notification is-success'>User  updated successfully!</div>";
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
    <title>Update User</title>
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
                </ul>
            </aside>
        </div>
        <div class="column">
            <h1 class="title">Update User</h1>
            <form method="POST">
                <div class="field">
                    <label class="label">Username</label>
                    <div class="control">
                        <input class="input" type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="input" type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                </div>
                <div class="control">
                    <button class="button is-primary" type="submit">Update User</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>