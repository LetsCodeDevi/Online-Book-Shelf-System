<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);

if (empty($name) || empty($username) || empty($email) || empty($phone)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

// Path to the SQLite database file
$dbfile = '/Applications/XAMPP/xamppfiles/htdocs/TSMS/database.db';

try {
    $pdo = new PDO("sqlite:" . $dbfile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $currentUsername = $_SESSION['username'];
    $stmt = $pdo->prepare("UPDATE users SET Name = :name, Username = :username, Email = :email, Contact = :phone WHERE Username = :currentUsername");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':currentUsername', $currentUsername);

    if ($stmt->execute()) {
        // Update session username if changed
        if ($username !== $currentUsername) {
            $_SESSION['username'] = $username;
        }
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
}

$pdo = null;
?>
