<?php

/**
 * Hydrothermal Vent Database - Home Page
 * Displays a list of all hydrothermal vents
 *
 * SET08101 Web Technologies Coursework Starter Code
 */

require_once 'includes/db.php';

$pageTitle = 'All Vents';

$sort = $_GET['sort'] ?? '';
$typeFilter = $_GET['type'] ?? '';


// Explode sort
$sortParts = explode('-', $sort);
$sortType = $sortParts[0] ?? '';
$sortDirection = $sortParts[1] ?? '';

// Allowed columns and directions to prevent SQL injection
$allowedSorts = [
    'name' => 'name',
    'depth' => 'depth_metres',
    'discovery' => 'discovery_year',
    'type' => 'type'
];
$allowedDirections = [
    'asc' => 'ASC',
    'desc' => 'DESC'
];

$sortColumn = $allowedSorts[$sortType] ?? 'name';
$sortDir = $allowedDirections[strtolower($sortDirection)] ?? 'ASC';

$sql = "SELECT id, name, location, type, depth_metres, discovery_year FROM vents";
$params = [];

if ($typeFilter) {
    $sql .= " WHERE type = :type";
    $params['type'] = $typeFilter;
}

$sql .= " ORDER BY $sortColumn $sortDir";

// Execute safely
$pdo = getDbConnection();
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$vents = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Fetch distinct types for the dropdown
$stmt2 = $pdo->query("SELECT DISTINCT type FROM vents");
$types = $stmt2->fetchAll(PDO::FETCH_ASSOC);

require_once 'includes/header.php';
?>
<div class="page-header">
  <h2>Hydrothermal Vents</h2>
  <p>Explore our database of hydrothermal vents from the Western Pacific region.</p>
</div>
<div class="search-and-filters">
  <input type="text" id="search-input" placeholder="Search vents by name or location..." class="search-input" auto-focus>
  <form class="filters" method="GET">
    <!-- Sort Dropdown -->
    <select name="sort" id="sort-filter" class="filter-dropdown" onchange="this.form.submit()">
        <option value="">Sort By</option>
        <option value="name-asc" <?php if ($sort === 'name-asc') echo 'selected'; ?>>Name A–Z</option>
        <option value="name-desc" <?php if ($sort === 'name-desc') echo 'selected'; ?>>Name Z–A</option>
        <option value="depth-asc" <?php if ($sort === 'depth-asc') echo 'selected'; ?>>Depth (Shallow → Deep)</option>
        <option value="depth-desc" <?php if ($sort === 'depth-desc') echo 'selected'; ?>>Depth (Deep → Shallow)</option>
        <option value="discovery-asc" <?php if ($sort === 'discovery-asc') echo 'selected'; ?>>Discovered (Old → New)</option>
        <option value="discovery-desc" <?php if ($sort === 'discovery-desc') echo 'selected'; ?>>Discovered (New → Old)</option>
    </select>

    <!-- Type Filter -->
    <select name="type" id="type-filter" class="filter-dropdown" onchange="this.form.submit()">
        <option value="">None</option>
        <?php foreach ($types as $typeItem) : ?>
            <option value="<?php echo htmlspecialchars($typeItem['type']); ?>"
                <?php if ($typeFilter === $typeItem['type']) echo 'selected'; ?>>
                <?php echo htmlspecialchars($typeItem['type']); ?>
            </option>
        <?php endforeach; ?>
    </select>
  </form>
</div>

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
