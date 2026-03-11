<?php
session_start();
include 'db.php';

$error = '';
$max_attempts = 3; // Threshold for "many trials"

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Fetch user details including the login_attempts count
    $stmt = $conn->prepare("SELECT id, username, password, role, status, login_attempts FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Check if the user is already blocked due to too many trials
        if ($user['login_attempts'] >= $max_attempts) {
            $error = "TOO_MANY_ATTEMPTS";
        } 
        // Check if account is inactive for other reasons
        elseif ($user['status'] !== 'active') {
            $error = "ACCOUNT_INACTIVE"; 
        } 
        else {
            // Verify password
            if (password_verify($password, $user['password'])) {
                
                // Reset failed attempts on successful login
                $reset_stmt = $conn->prepare("UPDATE users SET login_attempts = 0 WHERE id = ?");
                $reset_stmt->bind_param("i", $user['id']);
                $reset_stmt->execute();

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                header("Location: Dashboard.php");
                exit();
            } else {
                // Increment failed attempts
                $new_attempts = $user['login_attempts'] + 1;
                $update_stmt = $conn->prepare("UPDATE users SET login_attempts = ? WHERE id = ?");
                $update_stmt->bind_param("ii", $new_attempts, $user['id']);
                $update_stmt->execute();

                if ($new_attempts >= $max_attempts) {
                    $error = "TOO_MANY_ATTEMPTS";
                } else {
                    $remaining = $max_attempts - $new_attempts;
                    $error = "Invalid password. You have $remaining attempt(s) left.";
                }
            }
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
    :root { --primary-color: #0056b3; }
    html, body { height: 100%; margin: 0; padding: 0; overflow: hidden; font-family: sans-serif; }
    .navbar { z-index: 10; height: 56px; }
    .login-container { position: relative; height: calc(100vh - 56px); width: 100%; display: flex; }
    .background-slideshow { position: absolute; inset: 0; background-size: cover; background-position: center; z-index: 1; filter: brightness(0.5); transition: opacity 1.5s ease-in-out; }
    .left-content { flex: 1.5; z-index: 2; display: flex; flex-direction: column; justify-content: center; padding-left: 5%; color: white; }
    @media (max-width: 991px) { .left-content { display: none; } }
    .right-panel { flex: 1; z-index: 5; display: flex; justify-content: center; align-items: center; background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(15px); border-left: 1px solid rgba(255, 255, 255, 0.2); }
    .form-card { width: 100%; max-width: 380px; padding: 40px; color: white; }
    .form-control { background: rgba(255, 255, 255, 0.9); border: none; }
    .btn-login { background-color: var(--primary-color); border: none; font-weight: 700; padding: 0.8rem; }
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
    </div>
</nav>

<div class="login-container">
    <div class="background-slideshow" id="bg1"></div>
    <div class="background-slideshow hidden" id="bg2"></div>

    <div class="left-content">
        <h1 class="display-4 fw-bold">Registrar's Office Portal</h1>
        <p class="fs-4 opacity-75">Your reliable gateway for academic records and official documents.</p>
    </div>

    <div class="right-panel">
        <div class="form-card">
            <div class="text-center mb-4">
                <img src="lhs-reglogo.png" alt="Logo" style="height: 100px;">
                <h2 class="fw-bold mt-3">LOGIN</h2>
            </div>

            <form method="POST" autocomplete="off">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase">Username</label>
                    <input type="text" name="username" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-login text-white">LOG IN</button>
            </form>

            <?php if (!empty($error) && !in_array($error, ["ACCOUNT_INACTIVE", "TOO_MANY_ATTEMPTS"])): ?>
                <div class="alert alert-danger mt-4 text-center py-2 small"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Visual Slideshow logic
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

<?php if ($error === "ACCOUNT_INACTIVE"): ?>
    <script>alert("ACCESS DENIED: Your account is currently INACTIVE.");</script>
<?php endif; ?>

<?php if ($error === "TOO_MANY_ATTEMPTS"): ?>
    <script>alert("SECURITY ALERT: Too many failed trials. Your account is temporarily locked. Please contact the Admin.");</script>
<?php endif; ?>

</body>
</html>