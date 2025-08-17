<?php
require_once 'config.php';

// Only show maintenance page if maintenance mode is enabled
if (!$maintenance_mode) {
    header('Location: index.php');
    exit();
}

// Allow admin to bypass maintenance mode
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode - APK Modders</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .maintenance-container {
            max-width: 600px;
            margin: 5rem auto;
            padding: 2rem;
            text-align: center;
            background: rgba(20, 20, 40, 0.8);
            border-radius: 10px;
            border: 1px solid #8a2be2;
            box-shadow: 0 0 20px rgba(138, 43, 226, 0.3);
        }
        
        .maintenance-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            color: #8a2be2;
        }
        
        .maintenance-container h1 {
            color: #00ffff;
            margin-bottom: 1rem;
        }
        
        .maintenance-container p {
            color: #ddd;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .admin-login {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #333;
        }
        
        .admin-login a {
            color: #8a2be2;
            text-decoration: none;
        }
        
        .admin-login a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="moon"></div>
    
    <header>
        <div class="header-top">
            <h1>APK Modders</h1>
        </div>
    </header>
    
    <main class="main-content">
        <div class="maintenance-container">
            <div class="maintenance-icon">🔧</div>
            <h1>Under Maintenance</h1>
            <p>We're currently performing scheduled maintenance. We'll be back online shortly. Thank you for your patience.</p>
            <p>If you're an administrator, please <a href="login.php?redirect=admin">login here</a>.</p>
        </div>
    </main>
    
    <footer>
        <p>&copy; <?php echo date('Y'); ?> APK Modders. All rights reserved.</p>
    </footer>
</body>
</html>
