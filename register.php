<?php

/**
 * Hydrothermal Vent Database - Home Page
 * Displays a list of all hydrothermal vents
 *
 * SET08101 Web Technologies Coursework Starter Code
 */

require_once 'includes/db.php';

$pageTitle = 'Vents Map';

// Fetch all vents from the database
$pdo = getDbConnection();


require_once 'includes/header.php';

$username = '';
$password = '';

$usernameError = '';
$passwordError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $usernameError = "Username is required";
    } else {
        $sql = "SELECT id FROM users WHERE username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $paramUsername, PDO::PARAM_STR);
            $paramUsername = trim($_POST["username"]);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $usernameError = "This username is already taken";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            unset($stmt);
        }
    }
    if (empty(trim($_POST["password"]))) {
        $passwordError = "Password is required";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $passwordError = "Password must have at least 6 characters";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($usernameError) && empty($passwordError)) {
        $sql = "INSERT INTO users (username, password_hash) VALUES (:username, :password)";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $paramUsername, PDO::PARAM_STR);
            $stmt->bindParam(":password", $paramPassword, PDO::PARAM_STR);

            $paramUsername = $username;
            $paramPassword = password_hash($password, PASSWORD_DEFAULT);

            if ($stmt->execute()) {
                header("location: register.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }

            unset($stmt);
        }
    }
}


?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <h2>Register</h2>
  <label for="username">Username </label>
  <input type="text" id="username" name="username" required>
  <span><?php echo $usernameError; ?></span>

  <label for="password">Passowrd </label>
  <input type="password" id="password" name="password" required>
  <span><?php echo $passwordError; ?></span>

  <button type="submit">Register</button>
</form>

<a href="login.php">Already have an account? Login here.</a>

<?php require_once 'includes/footer.php'; ?>
