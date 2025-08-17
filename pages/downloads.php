<?php require_once '../header.php'; ?>
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
        // Sample app data
        const apps = [
            {
                id: 1,
                name: 'Game Mod 1',
                version: 'v2.5.1',
                size: '85 MB',
                category: 'games',
                icon: '🎮',
                description: 'Unlimited coins and gems'
            },
            {
                id: 2,
                name: 'Premium App',
                version: 'v3.1.0',
                size: '45 MB',
                category: 'apps',
                icon: '📱',
                description: 'All premium features unlocked'
            },
            {
                id: 3,
                name: 'Game Mod 2',
                version: 'v1.8.3',
                size: '120 MB',
                category: 'games',
                icon: '🎯',
                description: 'Unlimited lives and boosters'
            },
            {
                id: 4,
                name: 'Tool Kit',
                version: 'v5.2.0',
                size: '30 MB',
                category: 'tools',
                icon: '🔧',
                description: 'Essential tools for modding'
            },
            {
                id: 5,
                name: 'Streaming App',
                version: 'v4.7.2',
                size: '65 MB',
                category: 'apps',
                icon: '🎬',
                description: 'Ad-free streaming experience'
            },
            {
                id: 6,
                name: 'Game Mod 3',
                version: 'v2.0.0',
                size: '210 MB',
                category: 'games',
                icon: '🏎️',
                description: 'Unlimited money and cars'
            }
        ];

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

            appGrid.innerHTML = appsToShow.map(app => `
                <div class="app-card" data-category="${app.category}">
                    <div class="app-image">${app.icon}</div>
                    <div class="app-info">
                        <h3>${app.name}</h3>
                        <p>${app.description}</p>
                        <div class="app-meta">
                            <span>${app.version}</span>
                            <span>${app.size}</span>
                        </div>
                        <a href="#" class="download-btn" data-app-id="${app.id}">Download</a>
                    </div>
                </div>
            `).join('');
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

            // Download button click
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('download-btn')) {
                    e.preventDefault();
                    const appId = e.target.getAttribute('data-app-id');
                    alert(`Downloading app with ID: ${appId}`);
                    // In a real app, you would handle the download here
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
                    app.description.toLowerCase().includes(searchTerm)
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
