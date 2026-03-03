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
            // If the admin set the status to 'inactive', block the login
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
        body { 
            background-color: #f8f9fa; 
            margin: 0;
            overflow-x: hidden;
        }
        .navbar-brand img { height: 40px; }
        
        .login-main {
            display: flex;
            min-height: calc(100vh - 56px); 
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
            padding: 2px;
            background: white;
        }

        .form-card {
            width: 100%;
            max-width: 350px;
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
            <img src="lhs-reglogo.png" alt="LHS Logo" style="height: 40px;">
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

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase">Username</label>
                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Enter your username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter your password" required>
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
</html>