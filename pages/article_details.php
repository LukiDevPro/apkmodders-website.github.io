<?php
require_once '../header.php';
require_once '../config.php';

// Get the article ID from the URL
$article_id = $_GET['id'] ?? 0;

if ($article_id <= 0) {
    header("Location: news.php");
    exit();
}

// Fetch the specific article from the database
$stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->bind_param("i", $article_id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();

if (!$article) {
    $page_title = "Error - APK Modders";
    $error_message = "Sorry, the article you are looking for could not be found.";
} else {
    $page_title = htmlspecialchars($article['title']) . " - APK Modders";
}
?>
<style>
.article-container {
    max-width: 900px;
    margin: 2rem auto;
    padding: 2rem;
    background: rgba(20, 20, 40, 0.7);
    border-radius: 15px;
    border: 1px solid #8a2be2;
    backdrop-filter: blur(5px);
}
.article-header h1 {
    color: #00ffff;
    margin-bottom: 0.5rem;
}
.article-meta {
    font-size: 0.9rem;
    color: #aaa;
    margin-bottom: 2rem;
    border-bottom: 1px solid #333;
    padding-bottom: 1rem;
}
.article-content {
    line-height: 1.8;
    font-size: 1.1rem;
}
.article-content p {
    margin-bottom: 1.5rem;
}
</style>
<main class="main-content">
    <div class="article-container">
        <?php if (!$article): ?>
            <h2 class="text-center"><?php echo $error_message; ?></h2>
            <div class="text-center mt-4">
                <a href="news.php" class="btn btn-primary">Back to News</a>
            </div>
        <?php else: ?>
            <div class="article-header">
                <h1><?php echo htmlspecialchars($article['title']); ?></h1>
                <div class="article-meta">
                    By <?php echo htmlspecialchars($article['author']); ?> on <?php echo date('F j, Y', strtotime($article['created_at'])); ?>
                </div>
            </div>
            <div class="article-content">
                <?php echo nl2br(htmlspecialchars($article['content'])); ?>
            </div>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
