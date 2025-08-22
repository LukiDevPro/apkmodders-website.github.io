<?php
require_once '../header.php';
require_once '../config.php';

// Get the app ID from the URL
$app_id = $_GET['id'] ?? 0;

if ($app_id <= 0) {
    // Redirect or show error if ID is invalid
    header("Location: downloads.php");
    exit();
}

// Fetch the specific app from the database
$stmt = $conn->prepare("SELECT * FROM apps WHERE id = ?");
$stmt->bind_param("i", $app_id);
$stmt->execute();
$result = $stmt->get_result();
$app = $result->fetch_assoc();

if (!$app) {
    // If no app is found, show a simple error message and die
    $page_title = "Error - APK Modders";
    $error_message = "Sorry, the app you are looking for could not be found.";
} else {
    $page_title = htmlspecialchars($app['name']) . " - APK Modders";
}

?>
<style>
/* Styles for the detail page */
.app-detail-container {
    max-width: 900px;
    margin: 2rem auto;
    padding: 2rem;
    background: rgba(20, 20, 40, 0.7);
    border-radius: 15px;
    border: 1px solid #8a2be2;
    backdrop-filter: blur(5px);
}
.app-detail-header {
    display: flex;
    gap: 2rem;
    align-items: flex-start;
    border-bottom: 1px solid #333;
    padding-bottom: 2rem;
    margin-bottom: 2rem;
}
.app-detail-icon {
    width: 150px;
    height: 150px;
    border-radius: 20px;
    background: #1a1a3a;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 5rem;
    color: #8a2be2;
    flex-shrink: 0;
}
.app-detail-icon img {
    width: 100%;
    height: 100%;
    border-radius: 20px;
    object-fit: cover;
}
.app-detail-title h1 {
    color: #00ffff;
    margin: 0 0 0.5rem 0;
}
.app-detail-meta {
    display: flex;
    gap: 1rem;
    color: #aaa;
    margin-bottom: 1rem;
}
.app-detail-body {
    line-height: 1.8;
}
.app-detail-body h3 {
    color: #00ffff;
    margin-top: 2rem;
    margin-bottom: 1rem;
    border-left: 4px solid #8a2be2;
    padding-left: 1rem;
}
.download-section {
    text-align: center;
    margin-top: 3rem;
}
.download-section .download-btn {
    padding: 1rem 3rem;
    font-size: 1.2rem;
}
</style>

<main class="main-content">
    <div class="app-detail-container">
        <?php if (!$app): ?>
            <h2 class="text-center"><?php echo $error_message; ?></h2>
            <div class="text-center mt-4">
                <a href="downloads.php" class="btn btn-primary">Back to Downloads</a>
            </div>
        <?php else: ?>
            <div class="app-detail-header">
                <div class="app-detail-icon">
                    <?php echo $app['icon_url'] ? '<img src="' . htmlspecialchars($app['icon_url']) . '" alt="' . htmlspecialchars($app['name']) . '">' : '❓'; ?>
                </div>
                <div class="app-detail-title">
                    <h1><?php echo htmlspecialchars($app['name']); ?></h1>
                    <div class="app-detail-meta">
                        <span>Version: <?php echo htmlspecialchars($app['version']); ?></span>
                        <span>Size: <?php echo htmlspecialchars($app['size']); ?></span>
                        <span>Category: <a href="downloads.php?category=<?php echo htmlspecialchars($app['category']); ?>"><?php echo ucfirst(htmlspecialchars($app['category'])); ?></a></span>
                    </div>
                    <div class="download-section">
                        <a href="<?php echo htmlspecialchars($app['download_link']); ?>" class="download-btn">Download APK</a>
                    </div>
                </div>
            </div>
            <div class="app-detail-body">
                <h3>Description</h3>
                <p><?php echo nl2br(htmlspecialchars($app['description'])); ?></p>

                <!-- Placeholder for more sections -->
                <h3>What's New</h3>
                <p>All the latest features and bug fixes are included in this version.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
