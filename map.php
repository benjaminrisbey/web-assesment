<?php

/**
 * Hydrothermal Vent Database - Home Page
 * Displays a list of all hydrothermal vents
 *
 * SET08101 Web Technologies Coursework Starter Code
 */

require_once 'includes/db.php';

$pageTitle = 'Vents Map';

require_once 'includes/header.php';
?>

<h2>Hydrothermal Vents Map</h2>
<div class="map-container">
  <img src="images/vents_map.png" alt="Distribution of hydrothermal vent fields" class="map-image">
  <p class="attribution">
    <br>
    Image by <a href="https://commons.wikimedia.org/wiki/File:Distribution_of_hydrothermal_vent_fields.png" target="_blank" rel="noopener">DeDuijn</a>,
    licensed under <a href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank" rel="noopener">CC BY-SA 4.0</a>, via Wikimedia Commons
  </p>
</div>
<?php require_once 'includes/footer.php'; ?>
