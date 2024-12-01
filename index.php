<?php
session_start();
require 'db.php'; // Include your database connection file

// Initialize variables
$cars = [];
$message = "";

// Fetch cars from the database
$stmt = $conn->prepare("SELECT id, make, model, year FROM cars");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $cars[] = $row;
}

$stmt->close();

// Handle form submission to add a new car
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO cars (make, model, year) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $make, $model, $year);

    if ($stmt->execute()) {
        $message = "Car added successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    header("Location: index.php"); // Redirect to the same page to avoid form resubmission
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.3/css/bulma.min.css">
</head>
<body>
<div class="columns">
        <div class="column is-one-fifth">
            <aside class="menu">
                <p class="menu-label">Admin Menu</p>
                <ul class="menu-list">
                    <li><a href="index.php">Dashboard</a></li>
                    <li><a href="logout.php">Log-Out</a></li>
                    </ul>
            </aside>
        </div>
    <section class="section">
        <div class="container">
            <h1 class="title">Cars Dashboard</h1>

            <?php if (!empty($message)): ?>
                <div class="notification is-success">
                    <button class="delete"></button>
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <h2 class="subtitle">Add a New Car</h2>
            <form action="index.php" method="POST">
                <div class="field">
                    <label class="label">Make</label>
                    <div class="control">
                        <input class="input" type="text" name="make" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Model</label>
                    <div class="control">
                        <input class="input" type="text" name="model" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Year</label>
                    <div class="control">
                        <input class="input" type="number" name="year" required>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-primary" type="submit">Add Car</button>
                    </div>
                </div>
            </form>

            <h2 class="subtitle">Car List</h2>
            <table class="table is-striped is-fullwidth">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Make</th>
                        <th>Model</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cars as $car): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($car['id']); ?></td>
                            <td><?php echo htmlspecialchars($car['make']); ?></td>
                            <td><?php echo htmlspecialchars($car['model']); ?></td>
                            <td><?php echo htmlspecialchars($car['year']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Get all delete buttons
            const deleteButtons = document.querySelectorAll('.delete');

            // Add a click event to each delete button
            deleteButtons.forEach(button => {
                button.addEventListener('click', () => {
                    button.parentElement.style.display = 'none';
                });
            });
        });
    </script>
</body>
</html>