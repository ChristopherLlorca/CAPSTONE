<?php
// create_admin.php — run once in browser then delete
include 'db.php';

// change these credentials as you prefer
$username = 'admin';
$password = 'AdminPass123';   // change to a stronger password before running
$full_name = 'System Administrator';
$role = 'admin';

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, password, full_name, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param('ssss', $username, $hash, $full_name, $role);

if ($stmt->execute()) {
    echo "Admin user created. Username: <strong>$username</strong> Password: <strong>$password</strong><br>";
    echo "Delete this file (create_admin.php) now for security.";
} else {
    echo "Error creating user: " . $conn->error;
}
$stmt->close();
$conn->close();
