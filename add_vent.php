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

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $depth = $_POST['depth'] ?? '';
    $year = $_POST['discovery_year'] ?? '';

    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($location)) {
        $errors[] = "Location is required.";
    }
    if (empty($type)) {
        $errors[] = "Type is required.";
    }
    if (empty($depth) || !is_numeric($depth) || $depth <= 0) {
        $errors[] = "Depth must be a positive number.";
    }
    if (empty($year) || !is_numeric($year) || $year < 0) {
        $errors[] = "Discovery year must be a non-negative number";
    }

    if (empty($errors)) {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("INSERT INTO vents (name, location, type, depth_metres, discovery_year) VALUES (:name, :location, :type, :depth, :year)");
        $stmt->execute([
            ':name' => $name,
            ':location' => $location,
            ':type' => $type,
            ':depth' => $depth,
            ':year' => $year,
        ]);
        $newVentId = $pdo->lastInsertId();
        header("Location: vent.php?id=$newVentId");
        exit;
    }
}

require_once 'includes/header.php';
?>


<h2>Add New Vent</h2>
<div class="vent-details-container">
  <button class="vent-btn" onclick="window.location.href='index.php'"><i class="fa-solid fa-arrow-left"></i> Back to Vents</button>
  <div class="vent-details">
    <form id="add-vent-form" method="POST" action="">
      <h3>Name</h3>
      <input name="name" type="text" id="name-input" value="<?php echo e($vent['name']); ?>" class="edit-input">
      <h3>Location</h3>
      <input name="location" type="text" id="location-input" value="<?php echo e($vent['location']); ?>" class="edit-input">
      <h3>Type</h3>
      <input name="type" type="text" id="type-input" value="<?php echo e($vent['type']); ?>" class="edit-input">
      <h3>Depth (meters)</h3>
      <input name="depth" type="number" id="depth-input" value="<?php echo e($vent['depth_metres']); ?>" class="edit-input">
      <h3>Discovery Year</h3>
      <input name="discovery_year" type="number" id="discovery-year-input" value="<?php echo e($vent['discovery_year']); ?>" class="edit-input">
      <button id="save-vent-btn" class="vent-btn">Save Changes</button>
    </form>
    </div>

  <?php if (empty($fauna)) : ?>
    <p>No fauna found for this vent.</p>
  <?php else : ?>
  <button id="toggle-fauna-btn" class="vent-btn" >Show Fauna</button>
  <?php endif; ?>


  <div id="fauna-details" class="hidden">
    <?php foreach ($fauna as $animal) : ?>
    <div class="fauna-card">
      <h3>Name</h3>
      <p><?php echo e($animal['name']); ?></p>
      <h3>Scientific Name</h3>
      <p><?php echo e($animal['scientific_name']); ?></p>
      <h3>Description</h3>
      <p><?php echo e($animal['description']); ?></p>
      <h3>Image</h3>
      <img src="<?php echo e($animal['image_url']); ?>" alt="<?php echo e($animal['name']); ?>">
    </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
