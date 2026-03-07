<?php

/**
 * Hydrothermal Vent Database - Login Page
 */

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

require_once 'includes/db.php';

$pageTitle = 'Profile';

require_once 'includes/header.php';

?>

<h2>Profile</h2>
<a href="logout.php">Logout</a>


<?php require_once 'includes/footer.php'; ?>
