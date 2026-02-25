<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query user
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: Dashboard.php");
            exit();
        } else {
            $error = "Invalid password. Please try again.";
        }
    } else {
        $error = "Username not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        :root {
            /* pwede mo palitan NG #52a352 */
            --primary-green: rgba(13, 110, 253, 1);
            --dark-text: #fcfcfcff;
            --light-bg: #f7f7f7;
            --white: #ffffff;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-700: #4b5563;
            --gray-800: #1f2937;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            margin: 0;
        }
        header {
            background-color: var(--primary-green);
            color: var(--dark-text);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            height: 66px;
            
        }
        .header a {
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-right: 1.5rem;
            text-decoration: none;
            color: var(--dark-text);
        }
        .header a:hover { text-decoration: underline; }
        main {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;
        }
        .main-container {
            width: 100%;
            min-height: 90vh;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 0;
        }
        .background-slideshow {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            z-index: -1;
            filter: blur(5px);
            opacity: 1;
            transition: opacity 1s ease-in-out; /* Smooth fade transition */
        }
        .background-slideshow.hidden {
            opacity: 0;
        }
        #left-panel {
            display: none;
            color: var(--white);
            position: relative;
            z-index: 1;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20rem;
            background-color: rgba(0,0,0,0.4);
        }
        #right-panel {
            width: 100%;
            background-color: rgba(255,255,255,0.75);
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 5rem;
        }
        @media (min-width: 768px) {
            .main-container { flex-direction: row; }
            #left-panel { display: flex; width: 50%; }
            #right-panel { width: 50%; padding: 3rem 4rem; }
        }
        .logo {
            width: 6rem; height: 6rem; margin-bottom: 1.5rem;
        }
        .form-title {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: var(--gray-800);
            letter-spacing: 0.025em;
        }
        .form-wrapper { width: 100%; max-width: 24rem; }
        .input-group { margin-bottom: 1.25rem; }
        label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--gray-300);
            border-radius: 0.75rem;
            outline: none;
            transition: border-color 0.2s;
        }
        input:focus { border-color: var(--primary-green); }
        .link-section {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            margin-bottom: 2rem;
        }
        .link-section a {
            color: var(--gray-500);
            text-decoration: none;
            margin-left: 45px;
        }
        .link-section a:hover {
            color: var(--primary-green);
            text-decoration: underline;
        }
        .login-btn {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary-green);
            color: var(--dark-text);
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 0.75rem;
            border: none;
            cursor: pointer;
            transition: 0.3s;
            margin-left: 23px;
        }
        .login-btn:hover {
            transform: scale(1.02);
            opacity: 0.9;
        }
        #messageBox {
            margin-top: 1.5rem;
            padding: 0.75rem;
            background-color: #fee2e2;
            color: #b91c1c;
            border-radius: 0.5rem;
            width: 100%;
            max-width: 24rem;
            font-size: 0.875rem;
            text-align: center;
        }
        #left-panel h2 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }
        #left-panel p {
            font-size: 1.25rem;
            font-style: italic;
            max-width: 28rem;
            margin: 0 auto;
        }

        .navbar-brand {
    padding-top: var(--bs-navbar-brand-padding-y);
    padding-bottom: var(--bs-navbar-brand-padding-y);
    margin-right: var(--bs-navbar-brand-margin-end);
    font-size: var(--bs-navbar-brand-font-size);
    color: var(--bs-navbar-brand-color);
    text-decoration: none;
    white-space: nowrap;
}

.navbar-brand img {
    height: 40px;
    margin-left: -4px;
    margin-right: 10px;
}
img, svg {
    vertical-align: middle;
}
*, ::after, ::before {
    box-sizing: border-box;
}

img {
    overflow-clip-margin: content-box;
    overflow: clip;
}

.ms-2 {
    font-size: 18.4px;
    margin-right: 20px;
}
    </style>
</head>
<body>
<header>                                                                      
    <div>
        <a class="navbar-brand"  href="login.php">
                <img src="lhs-reglogo.png" alt="LHS Logo">
                <span class="ms-2">LHS - Document Tracking System</span>
         </a>
    </div>
    
<div class="header"> 
    <nav class="">    
        <a href="clientTrackingPage.php">Document Tracking</a>
        <a href="#">About</a>
    </nav>
</div>

</header>
<main>
    <div class="main-container">
        <div class="background-slideshow" id="bg1"></div> <!-- First background layer -->
        <div class="background-slideshow hidden" id="bg2"></div> <!-- Second background layer for fade -->
        <div id="left-panel">
            <div class="p-4">
                <h2>Registrar's Office Portal</h2>
                <p>Your reliable gateway for academic records, enrollment status, and official documents.</p>
            </div>
        </div>
        <div id="right-panel">
            <img src="lhs-reglogo.png" alt="Registrar's Office Logo" class="logo">
            <h1 class="form-title">LOGIN</h1>

            <form method="POST" class="form-wrapper">
                <div class="input-group">
                    <label for="username">USERNAME:</label>
                    <input type="text" name="username" id="username" placeholder="Enter your username" required>
                </div>
                <div class="input-group">
                    <label for="password">PASSWORD:</label>
                    <input type="password" name="password" id="password" placeholder="Enter your password" required>
                </div>
                <div class="link-section">
                    <a href="#">FORGOT PASSWORD</a>
                    <a href="#">CREATE ACCOUNT</a>
                </div>
                <button type="submit" class="login-btn">LOG IN</button>
            </form>

            <?php if (!empty($error)): ?>
                <div id="messageBox"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
    const images = ['lhs1.webp', 'lhs2.webp', 'lhs3.webp']; 
    let currentIndex = 0;
    const bg1 = document.getElementById('bg1');
    const bg2 = document.getElementById('bg2');
    const interval = 4000; // Change image every 4 seconds (adjust as needed)
    let activeBg = bg1; // Start with bg1 active

    // Function to update the background with smooth fade
    function updateBackground() {
        const nextBg = (activeBg === bg1) ? bg2 : bg1;
        nextBg.style.backgroundImage = `url(${images[currentIndex]})`;
        nextBg.classList.remove('hidden'); // Fade in next image
        activeBg.classList.add('hidden'); // Fade out current image
        activeBg = nextBg; // Switch active background
        currentIndex = (currentIndex + 1) % images.length;
    }

    // Set initial image on bg1
    bg1.style.backgroundImage = `url(${images[0]})`;
    currentIndex = 1; // Next image

    // Start the slideshow
    setInterval(updateBackground, interval);
</script>

</body>
</html>
