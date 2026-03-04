<?php

/**
 * Hydrothermal Vent Database - Home Page
 * Displays a list of all hydrothermal vents
 *
 * SET08101 Web Technologies Coursework Starter Code
 */

require_once 'includes/db.php';

$pageTitle = 'All Vents';

// Fetch all vents from the database
$pdo = getDbConnection();
$stmt = $pdo->query('SELECT id, name, location, type, depth_metres, discovery_year FROM vents ORDER BY name');
$vents = $stmt->fetchAll();

require_once 'includes/header.php';
?>
<div class="page-header">
  <h2>Hydrothermal Vents</h2>
  <p>Explore our database of hydrothermal vents from the Western Pacific region.</p>
</div>

<input type="text" id="search-input" placeholder="Search vents by name or location..." class="search-input" auto-focus>

<?php if (empty($vents)) : ?>
  <p>No vents found in the database.</p>
<?php else : ?>
  <div class="vent-cards-conatiner">
    <?php foreach ($vents as $vent) : ?>
      <div class="vent-card">
        <h3><?php echo e($vent['name']); ?></h3>
        <hr>
        <p><strong>Location:</strong> <?php echo e($vent['location']); ?></p>
        <p><strong>Type:</strong> <?php echo e($vent['type']); ?></p>
        <p><strong>Depth:</strong> <?php echo e($vent['depth_metres']); ?> m</p>
        <p><strong>Discovered:</strong> <?php echo e($vent['discovery_year']); ?></p>
        <button class="view-details-btn" onclick="window.location.href='vent.php?id=<?php echo e($vent['id']); ?>'">View Details</button>
      </div>
    <?php endforeach; ?>
</div>
<?php endif;  ?>



<?php require_once 'includes/footer.php'; ?>
