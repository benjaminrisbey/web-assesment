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

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$ventId = (int)$_GET['id'];


$pdo = getDbConnection();

$stmt = $pdo->prepare('SELECT id, name FROM vents WHERE id = ?');
$stmt->execute([$ventId]);
$vent = $stmt->fetch();

if (!$vent) {
    header('Location: index.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $scientificName = trim($_POST['scientific_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $imageUrl = trim($_POST['image_url'] ?? '');

    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($scientificName)) {
        $errors[] = "Scientific name is required.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO fauna (vent_id, name, scientific_name, description, image_url) VALUES (:vent_id, :name, :scientific_name, :description, :image_url)");
        $stmt->execute([
            ':vent_id' => $ventId,
            ':name' => $name,
            ':scientific_name' => $scientificName,
            ':description' => $description,
            ':image_url' => $imageUrl,
        ]);
        header("Location: vent.php?id=$ventId");
        exit;
    }
}

require_once 'includes/header.php';

?>

<h2>Add Fauna <?php echo htmlspecialchars($vent['name']); ?></h2>

<div class="vent-details">
    <form action="add_fauna.php?id=<?php echo $ventId; ?>" method="post">
        <h3>Name</h3>
        <input type="text" id="name" name="name" required>

        <h3>Scientific Name</h3>
        <input type="text" id="scientific_name" name="scientific_name" required>

        <h3>Description</h3>
        <textarea id="description" name="description"></textarea>

        <h3>Image URL</h3>
        <input type="url" id="image_url" name="image_url">

        <button type="submit">Add Fauna</button>
  </form>
</div>


<?php require_once 'includes/footer.php'; ?> 
