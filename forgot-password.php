<?php
require_once 'config.php';
require_once 'header.php';

$message = '';
$error = '';
$show_token = ''; // For demonstration purposes

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        // Check if user with this email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            // To prevent user enumeration, show a generic success message even if email doesn't exist.
            $message = 'If an account with that email exists, a password reset link has been sent.';
        } else {
            // Generate a secure token
            $token = bin2hex(random_bytes(50));
            $expires = new DateTime('NOW');
            $expires->add(new DateInterval('PT1H')); // 1 hour expiration

            // Store the token hash in the database
            $token_hash = hash('sha256', $token);

            $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $token_hash, $expires->format('Y-m-d H:i:s'));

            if ($stmt->execute()) {
                $message = 'If an account with that email exists, a password reset link has been sent.';

                // --- EMAIL SENDING LOGIC WOULD GO HERE ---
                // For now, we will display the token and the link for demonstration purposes.
                // In a real application, this should be sent via email and not displayed to the user.
                $reset_link = "http://{$_SERVER['HTTP_HOST']}/reset-password.php?token=" . $token;
                $show_token = "<strong>DEMO ONLY:</strong> Your password reset link is: <a href='{$reset_link}'>{$reset_link}</a>";
                // --- END OF EMAIL LOGIC ---

            } else {
                $error = 'Could not process your request. Please try again later.';
            }
        }
    }
}
?>

<main class="main-content">
    <div class="auth-container">
        <h2>Forgot Password</h2>
        <p style="text-align: center; color: #aaa; margin-bottom: 1.5rem;">Enter your email address and we will send you a link to reset your password.</p>

        <?php if ($message): ?>
            <div class="success-message"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($show_token): ?>
            <div class="info-message" style="background: rgba(0, 200, 83, 0.1); color: #4caf50; padding: 1rem; border-radius: 5px; margin-bottom: 1.5rem; text-align: center; border-left: 3px solid #4caf50; word-wrap: break-word;"><?php echo $show_token; ?></div>
        <?php endif; ?>

        <?php if (empty($message) && empty($show_token)): // Hide form after submission ?>
        <form method="POST" action="forgot-password.php">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Send Reset Link</button>
        </form>
        <?php endif; ?>

        <div class="auth-links">
            <p><a href="login.php">Back to Login</a></p>
        </div>
    </div>
</main>

<?php
// Note: We would need a footer.php for consistency, but for now, this closes the HTML structure.
?>
</body>
</html>
