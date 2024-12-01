<?php
require 'db.php';

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Read Users</title>
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
                    <li><a href="archive.php">Archived Users</a></li>
                </ul>
            </aside>
        </div>
        <div class="column">
            <h1 class="title">Users List</h1>
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
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <a class="button is-small is-info" href="update.php?id=<?php echo $user['id']; ?>">Edit</a>
                                <a class="button is-small is-danger" href="archives.php?id=<?php echo $user['id']; ?>">Archive</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <a class="button is-primary" href="create.php">Create New User</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>