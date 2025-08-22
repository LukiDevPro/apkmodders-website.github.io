<?php
require_once 'config.php';

// Check for maintenance mode
if ($maintenance_mode) {
    include 'maintenance.php';
    exit();
}

// Determine base path for correct asset loading
$is_sub_page = strpos($_SERVER['REQUEST_URI'], '/pages/') !== false;
$base_path = $is_sub_page ? '../' : './';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APK Modders</title>
    <link rel="stylesheet" href="<?php echo $base_path; ?>styles.css">
</head>
<body>
    <div class="moon"></div>
    
    <header>
        <div class="header-top">
            <h1><a href="<?php echo $base_path; ?>index.php">APK Modders</a></h1>
            <nav>
                <ul>
                    <li><a href="<?php echo $base_path; ?>index.php" class="active">Home</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="<?php echo $base_path; ?>pages/downloads.php">Downloads</a></li>
                    <li><a href="<?php echo $base_path; ?>pages/tutorials.php">Tutorials</a></li>
                    <li><a href="<?php echo $base_path; ?>pages/contact.php">Contact</a></li>
                </ul>
            </nav>
            <div class="language-switcher">
                <button class="lang-btn" data-lang="en">EN</button>
                <button class="lang-btn" data-lang="de">DE</button>
                <button class="lang-btn" data-lang="ru">RU</button>
            </div>
        </div>
    </header>
