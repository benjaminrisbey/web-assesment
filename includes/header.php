<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($pageTitle) ? e($pageTitle) . ' - ' : ''; ?>Hydrothermal Vent Database</title>
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/variables.css">
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/vents.css">
  <link rel="stylesheet" href="css/map.css">
  <link rel="stylesheet" href="css/contact.css">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/vent.css">
  <script src="js/nav.js" defer></script>
  <script src="js/vent.js" defer></script>
  <script src="js/form.js" defer></script>
  <script src="js/search.js" defer></script>
  <script src="https://kit.fontawesome.com/83971882ba.js" crossorigin="anonymous"></script>
  

  <!-- Students: Add your CSS stylesheet link here -->
</head>

<body>
  <header>
    <h1><a href="index.php">Hydrothermal Vents Database</a></h1>
    <div id="navigation" class="overlay">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <nav>
        <a href="index.php">Home</a>
        <a href="vents.php">Vents</a>
        <a href="map.php">Map</a>
        <a href="contact.php">Contact</a>
      <a href="profile.php"><i class="fa-solid fa-user"></i></a>
        <!-- Students: Add more navigation links here -->
      </nav>
    </div>
    <div class="header-icons">
      <span onclick="openNav()"><i class="fa-solid fa-bars"></i></span>
  </div>
    <?php session_start(); ?>

  </header>
  <main>
