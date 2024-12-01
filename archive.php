<?php
require 'db.php';

// Archive a user
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the update statement to archive the user
    $stmt = $conn->prepare("UPDATE users SET archived = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<div class='notification is-success'>User  archived successfully!</div>";
    } else {
        echo "<div class='notification is-danger'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// Fetch archived users
$stmt = $conn->prepare("SELECT id, username, email FROM users WHERE archived = 1");
$stmt->execute();
$result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Archived Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
</head>
<body>
    <div class="columns">
        <div class="column is-one-fifth">
            <aside class="menu">
                <p class="menu-label">Admin Menu</p>
                <ul class="menu-list">
                    <li><a href="create.php">Create User</a></li>
                    <li><a href="read.php">View Users</a></li>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="archive.php">Archived Users</a></li>
                </ul>
            </aside>
        </div>
        <div class="column">
            <h1 class="title">Archived Users</h1>
            <?php if ($result->num_rows > 0): ?>
                <table class="table is-striped is-fullwidth">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <a class="button is-small is-info" href="restore.php?id=<?php echo $user['id']; ?>">Restore</a>
                                    <a class="button is-small is-danger" href="delete.php?id=<?php echo $user['id']; ?>">Delete Permanently</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="notification is-warning">No archived users found.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>