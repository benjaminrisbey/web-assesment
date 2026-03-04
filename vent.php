<?php
/**
 * Hydrothermal Vent Database - Single Vent Page
 * Displays details of a single vent
 *
 * SET08101 Web Technologies Coursework Starter Code
 */

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
$fauna = $stmt->fetchAll();

// If vent not found, redirect to home
if (!$vent) {
    header('Location: index.php');
    exit;
}

$pageTitle = $vent['name'];

require_once 'includes/header.php';
?>


<h2><?php echo e($vent['name']); ?></h2>
<div class="vent-details-container">
  <button class="vent-btn" onclick="window.location.href='index.php'"><i class="fa-solid fa-arrow-left"></i> Back to Vents</button>
  <div class="vent-details">
    <h3>Location</h3>
    <p><?php echo e($vent['location']); ?></p>
    <h3>Type</h3>
    <p><?php echo e($vent['type']); ?></p>
    <h3>Depth</h3>
    <p><?php echo e($vent['depth_metres']); ?> metres</p>
    <h3>Discovery Year</h3>
    <p><?php echo e($vent['discovery_year']); ?></p>
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
