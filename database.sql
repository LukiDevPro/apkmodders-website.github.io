-- Using existing database
-- Database schema for APK Modders site

-- Apps table to store modded APKs
CREATE TABLE IF NOT EXISTS apps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    version VARCHAR(20) NOT NULL,
    size VARCHAR(20) NOT NULL,
    category ENUM('games', 'apps', 'tools') NOT NULL,
    icon_url VARCHAR(255),
    description TEXT,
    download_link VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample data for apps table
INSERT INTO `apps` (`id`, `name`, `version`, `size`, `category`, `icon_url`, `description`, `download_link`) VALUES
(1, 'Game Mod 1', 'v2.5.1', '85 MB', 'games', NULL, 'Unlimited coins and gems', '#'),
(2, 'Premium App', 'v3.1.0', '45 MB', 'apps', NULL, 'All premium features unlocked', '#'),
(3, 'Game Mod 2', 'v1.8.3', '120 MB', 'games', NULL, 'Unlimited lives and boosters', '#'),
(4, 'Tool Kit', 'v5.2.0', '30 MB', 'tools', NULL, 'Essential tools for modding', '#'),
(5, 'Streaming App', 'v4.7.2', '65 MB', 'apps', NULL, 'Ad-free streaming experience', '#'),
(6, 'Game Mod 3', 'v2.0.0', '210 MB', 'games', NULL, 'Unlimited money and cars', '#');

-- Articles table for news/blog posts
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sample data for articles table
INSERT INTO `articles` (`title`, `content`, `author`) VALUES
('Welcome to the New APK Modders Site!', 'This is the first news article on our brand new site. We have been working hard to bring you a better experience. Explore the new downloads page and let us know what you think!', 'Admin'),
('How to Get Started with Modding', 'This is a sample article about modding. In a full article, we would explain the tools and techniques needed to start modifying your own apps. We would cover topics like decompiling, code injection, and recompiling APKs.', 'LukiDev');
