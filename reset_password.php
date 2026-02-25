<?php
include 'config.php';

$error = '';
$success = '';
$valid_token = false;

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    try {
        $pdo = getDBConnection();
        
        // Check if token is valid and not expired
        $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ? AND used = FALSE AND expires_at > NOW()");
        $stmt->execute([$token]);
        
        if ($stmt->rowCount() > 0) {
            $valid_token = true;
            $reset_data = $stmt->fetch(PDO::FETCH_ASSOC);
            $email = $reset_data['email'];
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                
                if (empty($password)) {
                    $error = 'Please enter a new password.';
                } elseif ($password !== $confirm_password) {
                    $error = 'Passwords do not match.';
                } elseif (strlen($password) < 6) {
                    $error = 'Password must be at least 6 characters long.';
                } else {
                    // Update password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    
                    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
                    $stmt->execute([$hashed_password, $email]);
                    
                    // Mark token as used
                    $stmt = $pdo->prepare("UPDATE password_resets SET used = TRUE WHERE token = ?");
                    $stmt->execute([$token]);
                    
                    $success = 'Password reset successfully! You can now <a href="llogin.php">login</a> with your new password.';
                    $valid_token = false; // Token is now used
                }
            }
        } else {
            $error = 'Invalid or expired reset token.';
        }
    } catch(PDOException $e) {
        $error = 'Database error: ' . $e->getMessage();
    }
} else {
    $error = 'No reset token provided.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Student Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .links {
            text-align: center;
            margin-top: 20px;
        }
        .links a {
            color: #007bff;
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <?php if ($valid_token): ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit">Reset Password</button>
        </form>
        <?php endif; ?>
        
        <div class="links">
            <p><a href="llogin.php">Back to Login</a></p>
            <p><a href="forgot_password.php">Request another reset link</a></p>
        </div>
    </div>
</body>
</html>