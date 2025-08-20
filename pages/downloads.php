<?php
require_once '../header.php';
require_once '../config.php'; // Ensure database connection is available

// Fetch apps from the database
$apps_result = $conn->query("SELECT * FROM apps ORDER BY created_at DESC");
$apps_data = [];
if ($apps_result) {
    while ($row = $apps_result->fetch_assoc()) {
        $apps_data[] = $row;
    }
}
?>
<main class="main-content">
        <div class="downloads-container">
            <h2>Available Mods</h2>

            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search mods...">
            </div>

            <div class="category-filter">
                <button class="category-btn active" data-category="all">All</button>
                <button class="category-btn" data-category="games">Games</button>
                <button class="category-btn" data-category="apps">Apps</button>
                <button class="category-btn" data-category="tools">Tools</button>
            </div>

            <div class="app-grid" id="appGrid">
                <!-- Apps will be loaded here by JavaScript -->
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 APK Modders. All rights reserved.</p>
    </footer>

    <script>
        // Get app data from PHP
        const apps = <?php echo json_encode($apps_data); ?>;

        // Initialize the page
        document.addEventListener('DOMContentLoaded', () => {
            displayApps(apps);
            setupEventListeners();
        });

        // Display apps in the grid
        function displayApps(appsToShow) {
            const appGrid = document.getElementById('appGrid');

            if (appsToShow.length === 0) {
                appGrid.innerHTML = '<div class="no-results">No mods found matching your search.</div>';
                return;
            }

            appGrid.innerHTML = appsToShow.map(app => {
                // Use a placeholder icon if icon_url is null
                const iconDisplay = app.icon_url ? `<img src="${app.icon_url}" alt="${app.name}">` : '❓';

                return `
                <div class="app-card" data-category="${app.category}">
                    <div class="app-image">${iconDisplay}</div>
                    <div class="app-info">
                        <h3>${app.name}</h3>
                        <p>${app.description}</p>
                        <div class="app-meta">
                            <span>${app.version}</span>
                            <span>${app.size}</span>
                        </div>
                        <a href="${app.download_link}" class="download-btn" data-app-id="${app.id}">Download</a>
                    </div>
                </div>
            `}).join('');
        }

        // Setup event listeners
        function setupEventListeners() {
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', filterApps);

            // Category filter buttons
            const categoryBtns = document.querySelectorAll('.category-btn');
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    filterApps();
                });
            });

            // Download button click (optional: can add tracking or a confirmation)
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('download-btn')) {
                    // The link will work directly, but we can prevent default and add a confirmation
                    // e.preventDefault();
                    // const appName = e.target.closest('.app-info').querySelector('h3').textContent;
                    // if(confirm(`You are about to download ${appName}. Continue?`)) {
                    //     window.location.href = e.target.href;
                    // }
                }
            });
        }

        // Filter apps based on search and category
        function filterApps() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const activeCategory = document.querySelector('.category-btn.active').getAttribute('data-category');

            let filteredApps = [...apps];

            // Filter by search term
            if (searchTerm) {
                filteredApps = filteredApps.filter(app =>
                    app.name.toLowerCase().includes(searchTerm) ||
                    (app.description && app.description.toLowerCase().includes(searchTerm))
                );
            }

            // Filter by category
            if (activeCategory !== 'all') {
                filteredApps = filteredApps.filter(app => app.category === activeCategory);
            }

            displayApps(filteredApps);
        }
    </script>
</body>
</html>
