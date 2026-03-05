<?php

require_once 'includes/db.php';

$pageTitle = 'All Vents';

require_once 'includes/header.php';
?>

<h2>Contact US</h2>


<?php
$inputs = [];
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Name
    $inputs["name"] = trim($_POST["name"] ?? "");
    if ($inputs["name"] === "") {
        $errors[] = "Name is required.";
    }

    // Email
    $inputs["email"] = trim($_POST["email"] ?? "");
    if ($inputs["email"] === "") {
        $errors[] = "Email is required.";
    } elseif (!filter_var($inputs["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Phone (optional)
    $inputs["phone"] = trim($_POST["phone"] ?? "");

    // Message
    $inputs["message"] = trim($_POST["message"] ?? "");
    if ($inputs["message"] === "") {
        $errors[] = "Message is required.";
    }

    // If no errors, mark success
    if (empty($errors)) {
        $success = true;
    }
}
?>

<?php if (!empty($errors)) : ?>
    <div class="form-error">
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

  <?php if ($success) : ?>
    <div id="alert" class="alert success">
      <span id="alert-text" class="alert-text">Message Sent</span>
    </div>
<?php endif; ?>

<?php if (!$success) : ?>
  <form id="contact-form" action="contact.php" method="post">
      <div class="form-group">
          <label for="name">Name *</label>
          <input type="text" id="name" name="name"
                required minlength="2" placeholder="Your name">
          <span class="error-message"></span>
      </div>

      <div class="form-group">
          <label for="email">Email *</label>
          <input type="email" id="email" name="email"
                required placeholder="your@email.com">
          <span class="error-message"></span>
      </div>

      <div class="form-group">
          <label for="phone">Phone</label>
          <input type="tel" id="phone" name="phone"
                pattern="[0-9]{11}" placeholder="01onal1234567">
          <span class="error-message"></span>
      </div>

      <div class="form-group">
          <label for="message">Message *</label>
          <textarea id="message" name="message"
                    required minlength="10" placeholder="Your message..."></textarea>
          <span class="error-message"></span>
      </div>

      <button id="contact-btn" type="submit">Send Message</button>
  </form>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
