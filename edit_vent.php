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

// Validate the vent ID parameter
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$ventId = (int)$_GET['id'];
$pdo = getDbConnection();

// Fetch the vent details
$stmt = $pdo->prepare('SELECT id, name, location, type, depth_metres, discovery_year FROM vents WHERE id = ?');
$stmt->execute([$ventId]);
$vent = $stmt->fetch();

$stmt = $pdo->prepare('SELECT id, name, scientific_name, description, image_url FROM fauna WHERE vent_id = ?');
$stmt->execute([$ventId]);
$fauna = $stmt->fetchAll(PDO::FETCH_ASSOC);

// If vent not found, redirect to home
if (!$vent) {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if ($_POST['action'] === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM vents WHERE id = :id");
        $stmt->execute([':id' => $ventId]);
        $stmt = $pdo->prepare("DELETE FROM fauna WHERE vent_id = :vent_id");
        $stmt->execute([':vent_id' => $ventId]);
        header("Location: index.php");
        exit;
    } else {
        $name = $_POST['name'] ?? '';
        $location = $_POST['location'] ?? '';
        $type = $_POST['type'] ?? '';
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
        if (empty($depth) || !is_numeric($depth) || $depth < 0) {
            $errors[] = "Depth must be a non-negative number.";
        }
        if (empty($year) || !is_numeric($year) || $year < 0) {
            $errors[] = "Discovery year must be a non-negative number.";
        }
        if (empty($errors)) {
            $stmt = $pdo->prepare("UPDATE vents SET name = :name, location = :location, type = :type, depth_metres = :depth, discovery_year = :year WHERE id = :id");
            $stmt-> execute([
                ':name' => $name,
                ':location' => $location,
                ':type' => $type,
                ':depth' => $depth,
                ':year' => $year,
                ':id' => $ventId
            ]);
            header("Location: vent.php?id=$ventId");
            exit;
        }
    }
}

require_once 'includes/header.php';
?>


<h2>Edit <?php echo e($vent['name']); ?></h2>
<div class="vent-details-container">
  <button class="vent-btn" onclick="window.location.href='index.php'"><i class="fa-solid fa-arrow-left"></i> Back to Vents</button>
  <div class="vent-details">
    <form id="edit-vent-form" method="POST" action="edit_vent.php?id=<?= e($vent['id']) ?>">
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
      <button name="action" id="delete-vent-btn" class="vent-btn delete-btn" value="delete" >Delete Vent</button>
    </form>
  </div>

  <button class="view-details-btn vent-btn" onclick="window.location.href='add_fauna.php?id=<?php echo e($vent['id']); ?>'">Add new Fauna</button>
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
      <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) : ?>
        <button class="view-details-btn" onclick="window.location.href='edit_fauna.php?id=<?php echo e($animal['id']); ?>'">Edit</button>
      <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>
