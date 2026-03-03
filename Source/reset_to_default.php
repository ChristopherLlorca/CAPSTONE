<?php
include 'db.php';
session_start();

if ($_SESSION['role'] === 'admin' && isset($_GET['user'])) {
    $username = $_GET['user'];
    $req_id = $_GET['id'];
    
    // 1. Hash the default password
    $default_password = password_hash("LHS12345", PASSWORD_DEFAULT);
    
    // 2. Update the user table
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $stmt->bind_param("ss", $default_password, $username);
    
    if ($stmt->execute()) {
        // 3. Delete the request from the inbox
        $conn->query("DELETE FROM password_requests WHERE id = $req_id");
        header("Location: User.php?msg=Password for $username has been reset to: LHS12345");
    }
}
?>