<?php

/**
 * Hydrothermal Vent Database - Login Page
 */

require_once 'includes/db.php';

$pageTitle = 'Login';

$pdo = getDbConnection();

require_once 'includes/header.php';

$username = '';
$password = '';

$username_err = '';
$password_err = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // If no errors
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password_hash FROM users WHERE username = :username";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $id = $row["id"];
                    $username = $row["username"];
                    $hashed_password = $row["password_hash"];

                    if (password_verify($password, $hashed_password)) {
                        session_start();

                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;

                        header("location: profile.php");
                        exit;
                    } else {
                        $password_err = "The password you entered was not valid.";
                    }
                } else {
                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            unset($stmt);
        }
    }
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
  <h2>Login</h2>

  <label for="username">Username</label>
  <input type="text" id="username" name="username" required>
  <span><?php echo $username_err; ?></span>

  <label for="password">Password</label>
  <input type="password" id="password" name="password" required>
  <span><?php echo $password_err; ?></span>

  <button type="submit">Login</button>
</form>

<a href="register.php">Don't have an account? Register here.</a>
<?php require_once 'includes/footer.php'; ?>

