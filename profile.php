<?php

/**
 * Hydrothermal Vent Database - Home Page
 * Displays a list of all hydrothermal vents
 *
 * SET08101 Web Technologies Coursework Starter Code
 */

require_once 'includes/db.php';

$pageTitle = 'Vents Map';

// Fetch all vents from the database
$pdo = getDbConnection();


require_once 'includes/header.php';
?>

<form method="post" action="profile.php">
    <h2>Login</h2>
    <label for="username">Username </label>
    <input type="text" id="username" name="username" required>

    <label for="password">Passowrd </label>
    <input type="password" id="password" name="password" required>

    <button type="submit">Login</button>
  <button type="submit">Register</button>
</form>

<?php require_once 'includes/footer.php'; ?>
