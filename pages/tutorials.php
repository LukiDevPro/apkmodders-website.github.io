<?php require_once '../header.php'; ?>
<main class="main-content">
        <div class="tutorials-container">
            <h2>Modding Tutorials</h2>
            <p>Learn how to mod your favorite apps and games with our step-by-step guides.</p>

            <div class="tutorial-grid">
                <!-- Tutorial 1 -->
                <div class="tutorial-card">
                    <div class="tutorial-image" style="background: linear-gradient(45deg, #1a237e, #4a148c);">
                        <span>📱</span>
                    </div>
                    <div class="tutorial-info">
                        <h3>Beginner's Guide to APK Modding</h3>
                        <p>Learn the basics of APK modding with this comprehensive beginner's guide.</p>
                        <div class="tutorial-meta">
                            <span>15 min read</span>
                            <span class="difficulty beginner">Beginner</span>
                        </div>
                        <div class="tutorial-categories">
                            <span class="category-tag">Basics</span>
                            <span class="category-tag">Tutorial</span>
                        </div>
                        <a href="#" class="read-more">Read Tutorial →</a>
                    </div>
                </div>

                <!-- Tutorial 2 -->
                <div class="tutorial-card">
                    <div class="tutorial-image" style="background: linear-gradient(45deg, #0d47a1, #1a237e);">
                        <span>🔓</span>
                    </div>
                    <div class="tutorial-info">
                        <h3>Unlocking Premium Features</h3>
                        <p>Step-by-step guide to unlocking premium features in any app.</p>
                        <div class="tutorial-meta">
                            <span>25 min read</span>
                            <span class="difficulty intermediate">Intermediate</span>
                        </div>
                        <div class="tutorial-categories">
                            <span class="category-tag">Premium</span>
                            <span class="category-tag">Guide</span>
                        </div>
                        <a href="#" class="read-more">Read Tutorial →</a>
                    </div>
                </div>

                <!-- Tutorial 3 -->
                <div class="tutorial-card">
                    <div class="tutorial-image" style="background: linear-gradient(45deg, #b71c1c, #c2185b);">
                        <span>🎮</span>
                    </div>
                    <div class="tutorial-info">
                        <h3>Game Hacking 101</h3>
                        <p>Learn how to hack popular mobile games and get unlimited resources.</p>
                        <div class="tutorial-meta">
                            <span>35 min read</span>
                            <span class="difficulty advanced">Advanced</span>
                        </div>
                        <div class="tutorial-categories">
                            <span class="category-tag">Games</span>
                            <span class="category-tag">Hacking</span>
                        </div>
                        <a href="#" class="read-more">Read Tutorial →</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 APK Modders. All rights reserved.</p>
    </footer>

    <script>
        // Add click event to tutorial cards
        document.querySelectorAll('.tutorial-card').forEach(card => {
            card.addEventListener('click', (e) => {
                // Don't trigger if clicking on a link inside the card
                if (!e.target.closest('a')) {
                    const link = card.querySelector('a.read-more');
                    if (link) {
                        window.location.href = link.href;
                    }
                }
            });
        });
    </script>
</body>
</html>
