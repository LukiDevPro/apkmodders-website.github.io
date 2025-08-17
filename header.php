<?php
require_once 'config.php';

// Check for maintenance mode
if ($maintenance_mode && !(isset($_SESSION['user_id']) && $_SESSION['is_admin'])) {
    // Allow access to login page during maintenance
    if (basename($_SERVER['PHP_SELF']) != 'login.php' && basename($_SERVER['PHP_SELF']) != 'register.php') {
        include 'maintenance.php';
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APK Modders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="moon"></div>
    
    <header>
        <div class="header-top">
            <h1><a href="index.php">APK Modders</a></h1>
            <div class="language-switcher">
                <button class="lang-btn" data-lang="en">EN</button>
                <button class="lang-btn" data-lang="de">DE</button>
                <button class="lang-btn" data-lang="ru">RU</button>
            </div>
        </div>
    </header>
