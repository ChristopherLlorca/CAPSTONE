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

        // 1. Verify password
        if (password_verify($password, $user['password'])) {
            
            // 2. CHECK ACCOUNT STATUS
            if ($user['status'] !== 'active') {
                $error = "ACCOUNT_INACTIVE"; 
            } else {
                // If active, proceed with login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: Dashboard.php");
                exit();
            }
            
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
    <title>LHS - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    :root {
        --primary-color: #0056b3; 
    }
    /* Lock the screen to prevent outer scrolling */
    html, body { 
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden; 
        background-color: #f8f9fa; 
    }
    
    .navbar-brand img { height: 40px; }
    
    /* Calculate height to fit perfectly below navbar */
    .login-main {
        display: flex;
        height: calc(100vh - 56px); 
        width: 100%;
    }

    #left-panel {
        flex: 1;
        position: relative;
        display: none; 
        background-color: #000;
    }
    
    @media (min-width: 992px) {
        #left-panel { display: block; }
    }

    .background-slideshow {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        z-index: 1;
        filter: brightness(0.6);
        transition: opacity 1s ease-in-out;
    }
    
    .slideshow-overlay {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        padding: 3rem;
    }

    #right-panel {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        background: white;
        overflow-y: auto; /* Only scrolls locally if the form exceeds screen height */
    }

    .form-card {
        width: 100%;
        max-width: 350px;
        padding-bottom: 20px;
    }

    .btn-login {
        background-color: var(--primary-color);
        border: none;
        font-weight: 600;
        padding: 0.75rem;
    }

    .hidden { opacity: 0; }
</style>
</head>
<body>
     
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="login.php">
            <img src="lhs-reglogo.png" alt="LHS Logo">
            <span class="ms-2">LHS - Document Tracking System</span>
        </a>
        
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link fw-bold px-3 text-white" href="clientTrackingPage.php">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Tracking Portal
                </a>
            </li>
        </ul>
    </div>
</nav>

<main class="login-main">
    <div id="left-panel">
        <div class="background-slideshow" id="bg1"></div>
        <div class="background-slideshow hidden" id="bg2"></div>
        <div class="slideshow-overlay">
            <h1 class="display-5 fw-bold">Registrar's Office Portal</h1>
            <p class="lead">Your reliable gateway for academic records, enrollment status, and official documents.</p>
        </div>
    </div>

    <div id="right-panel">
        <div class="form-card">
            <div class="text-center mb-4">
                <img src="lhs-reglogo.png" alt="Logo" style="height: 80px;">
                <h2 class="fw-bold mt-3">LOGIN</h2>
            </div>

            <form method="POST" autocomplete="off">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase">Username</label>
                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Enter your username" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter your password" required autocomplete="new-password">
                </div>
                
                <div class="d-flex justify-content-center align-items-center mb-4">
                    <a href="forgot_password.php" class="text-decoration-none small text-muted">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-login text-white">LOG IN</button>
            </form>

            <?php if (!empty($error) && $error !== "ACCOUNT_INACTIVE"): ?>
                <div class="alert alert-danger mt-4 text-center py-2 small"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if ($error === "ACCOUNT_INACTIVE"): ?>
    <script>
        alert("ACCESS DENIED: Your account is currently INACTIVE. Please contact the Administrator for assistance.");
    </script>
<?php endif; ?>

<script>
    const images = ['lhs1.webp', 'lhs2.webp', 'lhs3.webp']; 
    let currentIndex = 0;
    const bg1 = document.getElementById('bg1');
    const bg2 = document.getElementById('bg2');
    let activeBg = bg1;

    function updateBackground() {
        const nextBg = (activeBg === bg1) ? bg2 : bg1;
        nextBg.style.backgroundImage = `url(${images[currentIndex]})`;
        nextBg.classList.remove('hidden');
        activeBg.classList.add('hidden');
        activeBg = nextBg;
        currentIndex = (currentIndex + 1) % images.length;
    }

    bg1.style.backgroundImage = `url(${images[0]})`;
    currentIndex = 1;
    setInterval(updateBackground, 4000);
</script>
</body>
</html><?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            if ($user['status'] !== 'active') {
                $error = "ACCOUNT_INACTIVE"; 
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: Dashboard.php");
                exit();
            }
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
    <title>LHS - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
    :root {
        --primary-color: #0056b3; 
    }

    /* Prevent scrolling & fix background */
    html, body { 
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden; 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .navbar {
        z-index: 10;
        height: 56px;
    }

    /* Main Container with Background Slideshow */
    .login-container {
        position: relative;
        height: calc(100vh - 56px);
        width: 100%;
        display: flex;
    }

    /* Slideshow stays behind everything */
    .background-slideshow {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        z-index: 1;
        filter: brightness(0.5);
        transition: opacity 1.5s ease-in-out;
    }

    /* Left Side Content */
    .left-content {
        flex: 1.5;
        z-index: 2;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-left: 5%;
        color: white;
    }

    @media (max-width: 991px) {
        .left-content { display: none; }
    }

    /* Right Side Login Panel - Glassmorphism Effect */
    .right-panel {
        flex: 1;
        z-index: 5;
        display: flex;
        justify-content: center;
        align-items: center;
        /* This creates the blur effect from your wireframe */
        background: rgba(255, 255, 255, 0.1); 
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-left: 1px solid rgba(255, 255, 255, 0.2);
    }

    .form-card {
        width: 100%;
        max-width: 380px;
        padding: 40px;
        color: white;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.9);
        border: none;
    }

    .btn-login {
        background-color: var(--primary-color);
        border: none;
        font-weight: 700;
        padding: 0.8rem;
        transition: transform 0.2s;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        background-color: #004494;
    }

    .hidden { opacity: 0; }
</style>
</head>
<body>
     
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="login.php">
            <img src="lhs-reglogo.png" alt="LHS Logo" style="height: 40px;">
            <span class="ms-2">LHS - Document Tracking System</span>
        </a>
        <div class="ms-auto">
            <a class="nav-link fw-bold text-white" href="clientTrackingPage.php">
                <i class="bi bi-geo-alt-fill"></i> Tracking Portal
            </a>
        </div>
    </div>
</nav>

<div class="login-container">
    <div class="background-slideshow" id="bg1"></div>
    <div class="background-slideshow hidden" id="bg2"></div>

    <div class="left-content">
        <h1 class="display-4 fw-bold">Registrar's Office Portal</h1>
        <p class="fs-4 opacity-75">Your reliable gateway for academic records, <br>enrollment status, and official documents.</p>
    </div>

    <div class="right-panel">
        <div class="form-card">
            <div class="text-center mb-4">
                <img src="lhs-reglogo.png" alt="Logo" style="height: 100px; filter: drop-shadow(0px 4px 10px rgba(0,0,0,0.3));">
                <h2 class="fw-bold mt-3 letter-spacing-2">LOGIN</h2>
            </div>

            <form method="POST" autocomplete="off">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase text-white">Username</label>
                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Enter username" required autocomplete="off">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase text-white">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter password" required autocomplete="new-password">
                </div>
                
                <div class="text-center mb-4">
                    <a href="forgot_password.php" class="text-decoration-none small text-white-50">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-login text-white">LOG IN</button>
            </form>

            <?php if (!empty($error) && $error !== "ACCOUNT_INACTIVE"): ?>
                <div class="alert alert-danger mt-4 text-center py-2 small" style="background: rgba(220, 53, 69, 0.8); color: white; border: none;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php if ($error === "ACCOUNT_INACTIVE"): ?>
    <script>alert("ACCESS DENIED: Your account is currently INACTIVE.");</script>
<?php endif; ?>

<script>
    const images = ['lhs1.webp', 'lhs2.webp', 'lhs3.webp']; 
    let currentIndex = 0;
    const bg1 = document.getElementById('bg1');
    const bg2 = document.getElementById('bg2');
    let activeBg = bg1;

    function updateBackground() {
        const nextBg = (activeBg === bg1) ? bg2 : bg1;
        nextBg.style.backgroundImage = `url(${images[currentIndex]})`;
        nextBg.classList.remove('hidden');
        activeBg.classList.add('hidden');
        activeBg = nextBg;
        currentIndex = (currentIndex + 1) % images.length;
    }

    bg1.style.backgroundImage = `url(${images[0]})`;
    currentIndex = 1;
    setInterval(updateBackground, 5000);
</script>
</body>
</html>