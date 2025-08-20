<?php
require_once '../header.php';
require_once '../config.php'; // Ensure database connection is available

// --- Backend Search & Filtering Logic ---
$search_term = $_GET['search'] ?? '';
$category = $_GET['category'] ?? 'all';

$sql = "SELECT * FROM apps";
$conditions = [];
$params = [];
$types = '';

// Add search condition
if (!empty($search_term)) {
    $conditions[] = "(name LIKE ? OR description LIKE ?)";
    $params[] = "%" . $search_term . "%";
    $params[] = "%" . $search_term . "%";
    $types .= 'ss';
}

// Add category condition
if ($category !== 'all') {
    $conditions[] = "category = ?";
    $params[] = $category;
    $types .= 's';
}

// Append conditions to the query
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(' AND ', $conditions);
}

$sql .= " ORDER BY created_at DESC";

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$apps_result = $stmt->get_result();

$apps_data = [];
if ($apps_result) {
    while ($row = $apps_result->fetch_assoc()) {
        $apps_data[] = $row;
    }
}
// --- End of Backend Logic ---
?>
<main class="main-content">
    <div class="downloads-container">
        <h2>Available Mods</h2>

        <form action="downloads.php" method="GET" class="search-and-filter">
            <div class="search-bar">
                <input type="text" name="search" id="searchInput" placeholder="Search mods..." value="<?php echo htmlspecialchars($search_term); ?>">
            </div>

            <div class="category-filter">
                <button type="submit" name="category" value="all" class="category-btn <?php echo ($category === 'all') ? 'active' : ''; ?>">All</button>
                <button type="submit" name="category" value="games" class="category-btn <?php echo ($category === 'games') ? 'active' : ''; ?>">Games</button>
                <button type="submit" name="category" value="apps" class="category-btn <?php echo ($category === 'apps') ? 'active' : ''; ?>">Apps</button>
                <button type="submit" name="category" value="tools" class="category-btn <?php echo ($category === 'tools') ? 'active' : ''; ?>">Tools</button>
            </div>
        </form>

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
        // The form submission now handles filtering, so the old JS event listeners are not needed for that.
    });

    // Display apps in the grid (this function remains the same)
    function displayApps(appsToShow) {
        const appGrid = document.getElementById('appGrid');

        if (appsToShow.length === 0) {
            appGrid.innerHTML = '<div class="no-results">No mods found matching your search.</div>';
            return;
        }

        appGrid.innerHTML = appsToShow.map(app => {
            const iconDisplay = app.icon_url ? `<img src="${app.icon_url}" alt="${app.name}">` : '❓';
            const detailUrl = `app_details.php?id=${app.id}`;

            return `
            <a href="${detailUrl}" class="app-card-link">
                <div class="app-card" data-category="${app.category}">
                    <div class="app-image">${iconDisplay}</div>
                    <div class="app-info">
                        <h3>${app.name}</h3>
                        <p>${app.description}</p>
                        <div class="app-meta">
                            <span>${app.version}</span>
                            <span>${app.size}</span>
                        </div>
                        <span class="download-btn-wrapper">
                            <span class="download-btn" data-download-link="${app.download_link}">Download</span>
                        </span>
                    </div>
                </div>
            </a>
        `}).join('');

        // Add event listener to handle download button clicks separately
        appGrid.addEventListener('click', function(event) {
            if (event.target.classList.contains('download-btn')) {
                event.preventDefault(); // Stop the link to the detail page from firing
                event.stopPropagation(); // Stop event bubbling
                const downloadLink = event.target.dataset.downloadLink;
                window.location.href = downloadLink;
            }
        });
    }

    // We can add a little JS to submit the form on search input change for a live search feel
    const searchInput = document.getElementById('searchInput');
    let debounceTimer;
    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            searchInput.form.submit();
        }, 500); // 500ms delay
    });
</script>
</body>
</html>
