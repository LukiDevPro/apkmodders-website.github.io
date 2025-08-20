<?php
require_once 'config.php';
require_once 'header.php';

$error = '';
$message = '';
$token_is_valid = false;
$token = $_GET['token'] ?? '';

if (empty($token)) {
    $error = "No reset token provided. Please use the link from your email.";
} else {
    $token_hash = hash('sha256', $token);

    // Find the token in the database
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token_hash);
    $stmt->execute();
    $result = $stmt->get_result();
    $reset_request = $result->fetch_assoc();

    if (!$reset_request) {
        $error = "Invalid or expired token. Please request a new password reset.";
    } else {
        $expires_at = new DateTime($reset_request['expires_at']);
        $now = new DateTime();
        if ($now > $expires_at) {
            $error = "Invalid or expired token. Please request a new password reset.";
            // Also delete the expired token
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
            $stmt->bind_param("s", $token_hash);
            $stmt->execute();
        } else {
            $token_is_valid = true;
            $user_email = $reset_request['email'];
        }
    }
}

// Handle form submission for new password
if ($token_is_valid && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($password) || empty($confirm_password)) {
        $error = "Please enter and confirm your new password.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // All good, update the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $user_email);

        if ($stmt->execute()) {
            // Password updated, now delete the reset token
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
            $stmt->bind_param("s", $user_email);
            $stmt->execute();

            $message = "Your password has been successfully reset! You can now log in.";
            $token_is_valid = false; // Hide the form
        } else {
            $error = "Failed to update your password. Please try again.";
        }
    }
}

?>

<main class="main-content">
    <div class="auth-container">
        <h2>Reset Your Password</h2>

        <?php if ($message): ?>
            <div class="success-message"><?php echo $message; ?></div>
            <div class="auth-links">
                <p><a href="login.php">Proceed to Login</a></p>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($token_is_valid): ?>
        <form method="POST" action="reset-password.php?token=<?php echo htmlspecialchars($token); ?>">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Reset Password</button>
        </form>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
