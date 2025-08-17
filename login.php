<?php
require_once 'config.php';

// Allow access to login page during maintenance
if ($maintenance_mode && !(isset($_SESSION['user_id']) && $_SESSION['is_admin'])) {
    // Only block if not already on login page
    if (basename($_SERVER['PHP_SELF']) != 'login.php') {
        include 'maintenance.php';
        exit();
    }
}

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, is_admin FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            // Redirect to home page
            header('Location: index.php');
            exit();
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - APK Modders</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Moon Styling */
        .moon {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100vmax;
            height: 100vmax;
            background: radial-gradient(circle, #1a1a3a 0%, #0a0a1a 70%);
            border-radius: 50%;
            z-index: -1;
            box-shadow: 0 0 100px rgba(138, 43, 226, 0.3);
            animation: pulse 8s infinite alternate;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 100px rgba(138, 43, 226, 0.3); }
            100% { box-shadow: 0 0 150px rgba(138, 43, 226, 0.5); }
        }

        /* Header Styling */
        header {
            padding: 1rem 2rem;
            background: rgba(10, 10, 26, 0.7);
            backdrop-filter: blur(10px);
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            z-index: 1;
            border-bottom: 1px solid #8a2be2;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            margin: 0;
            font-size: 1.8rem;
            background: linear-gradient(90deg, #ff00ff, #00ffff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        h1 a {
            color: transparent;
            text-decoration: none;
        }

        .language-switcher {
            display: flex;
            gap: 0.5rem;
        }

        .lang-btn {
            background: transparent;
            border: 1px solid #8a2be2;
            color: #fff;
            padding: 0.3rem 0.8rem;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .lang-btn:hover {
            background: rgba(138, 43, 226, 0.2);
        }

        /* Auth Container */
        .auth-container {
            max-width: 400px;
            margin: 5rem auto;
            padding: 2rem;
            background: rgba(20, 20, 40, 0.8);
            border-radius: 10px;
            border: 1px solid #8a2be2;
            box-shadow: 0 0 20px rgba(138, 43, 226, 0.3);
            position: relative;
            z-index: 1;
        }
        
        .auth-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #00ffff;
            font-size: 1.8rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #ddd;
            font-size: 0.9rem;
        }
        
        .form-control {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #444;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #8a2be2;
            box-shadow: 0 0 5px rgba(138, 43, 226, 0.5);
        }
        
        .btn-login {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(45deg, #ff00ff, #00ffff);
            border: none;
            border-radius: 5px;
            color: #0a0a1a;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .auth-links {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        
        .auth-links a {
            color: #8a2be2;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .auth-links a:hover {
            color: #00ffff;
            text-decoration: underline;
        }
        
        .error-message {
            color: #ff6b6b;
            margin-bottom: 1.5rem;
            padding: 0.8rem;
            background: rgba(255, 107, 107, 0.1);
            border-radius: 5px;
            text-align: center;
            border-left: 3px solid #ff6b6b;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .auth-container {
                margin: 3rem 1rem;
                padding: 1.5rem;
            }
            
            h1 {
                font-size: 1.5rem;
            }
            
            .auth-container h2 {
                font-size: 1.5rem;
            }
        }
    </style>
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
    
    <main class="main-content">
        <div class="auth-container">
            <h2>Login</h2>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label for="username">Username or Email</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <button type="submit" class="btn-login">Login</button>
                
                <div class="auth-links">
                    <p>Don't have an account? <a href="register.php">Register here</a></p>
                    <p><a href="forgot-password.php">Forgot password?</a></p>
                </div>
            </form>
        </div>
    </main>
    
    <footer>
        <p>&copy; <?php echo date('Y'); ?> APK Modders. All rights reserved.</p>
    </footer>
</body>
</html>
