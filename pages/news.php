<?php
require_once '../header.php';
require_once '../config.php';

// Fetch all articles from the database
$articles_result = $conn->query("SELECT * FROM articles ORDER BY created_at DESC");
$articles = [];
if ($articles_result) {
    while ($row = $articles_result->fetch_assoc()) {
        $articles[] = $row;
    }
}
?>
<style>
.news-container {
    max-width: 900px;
    margin: 2rem auto;
    padding: 2rem;
}
.article-summary {
    background: rgba(20, 20, 40, 0.7);
    border-radius: 15px;
    border: 1px solid #8a2be2;
    padding: 2rem;
    margin-bottom: 2rem;
    backdrop-filter: blur(5px);
}
.article-summary h2 a {
    color: #00ffff;
    text-decoration: none;
    transition: color 0.3s ease;
}
.article-summary h2 a:hover {
    color: #fff;
}
.article-meta {
    font-size: 0.9rem;
    color: #aaa;
    margin: 0.5rem 0 1rem 0;
}
.article-excerpt {
    line-height: 1.7;
}
.read-more-link {
    display: inline-block;
    margin-top: 1rem;
    color: #8a2be2;
    font-weight: bold;
}
</style>
<main class="main-content">
    <div class="news-container">
        <h1 style="text-align: center; margin-bottom: 3rem;">News & Updates</h1>

        <?php if (!empty($articles)): ?>
            <?php foreach ($articles as $article): ?>
                <article class="article-summary">
                    <h2><a href="article_details.php?id=<?php echo $article['id']; ?>"><?php echo htmlspecialchars($article['title']); ?></a></h2>
                    <div class="article-meta">
                        By <?php echo htmlspecialchars($article['author']); ?> on <?php echo date('F j, Y', strtotime($article['created_at'])); ?>
                    </div>
                    <div class="article-excerpt">
                        <p><?php echo nl2br(htmlspecialchars(substr($article['content'], 0, 200))); ?>...</p>
                    </div>
                    <a href="article_details.php?id=<?php echo $article['id']; ?>" class="read-more-link">Read More →</a>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No news articles have been posted yet.</p>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
