<?php
// config.php
session_start();

define('DB_HOST', 'localhost');
define('DB_NAME', 'student_portal');
define('DB_USER', 'root');
define('DB_PASS', '');

// Email configuration (for production)
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');

function getDBConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Simple email function (for demo - in production use PHPMailer)
function sendEmail($to, $subject, $message) {
    $headers = "From: noreply@studentportal.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    // In demo, we'll just log the email
    error_log("Email to: $to | Subject: $subject | Message: $message");
    return true; // Always return true for demo
    
    // For production, uncomment:
    // return mail($to, $subject, $message, $headers);
}
?>