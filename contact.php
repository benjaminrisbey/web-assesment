<?php

require_once 'includes/db.php';

$pageTitle = 'All Vents';

// Fetch all vents from the database
$pdo = getDbConnection();
$stmt = $pdo->query('SELECT id, name, location, type, depth_metres, discovery_year FROM vents ORDER BY name');
$vents = $stmt->fetchAll();

require_once 'includes/header.php';
?>

<h2>Hydrothermal Vents</h2>

<p>Explore our database of hydrothermal vents from the Western Pacific region.</p>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        !empty($_POST['name'])
        && !empty($_POST['email'])
        && !empty($_POST['message'])
    ) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $message = $_POST["message"];


        $to = "benrisbey@gmail.com";
        $subject = "New Contact Form Submission";
        $body = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\nMessage: {$message}";
        $headers = "From: {$email}";


        if (mail($to, $subject, $body, $headers)) {
            echo "Message sent successfully!";
        } else {
            echo "Failed to send message.";
        }
    }
}
?>

<form id="contact-form" method="POST" action="sendmail.php">
  <div class="form-row form-error" style="display:none;"></div>
  <div class="form-row">
    <label for="contact-form-name">Name:</label>
    <input id="contact-form-name" class="form-input" type="text" name="name" required>
  </div>
  <div class="form-row">
    <label for="contact-form-email">Email:</label>
    <input id="contact-form-email" class="form-input" type="email" name="email" required>
  </div>
  <div class="form-row">
    <label for="contact-form-phone">Phone:</label>
    <input id="contact-form-phone" class="form-input" type="tel" name="phone">
  </div>
  <div class="form-row">
    <label for="contact-form-message">Message:</label>
    <textarea id="contact-form-message" class="form-input" name="message" required></textarea>
  </div>
  <button type="submit">Submit</button>
</form>

<?php require_once 'includes/footer.php'; ?>
