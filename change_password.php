<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    if (empty($currentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    if ($newPassword !== $confirmNewPassword) {
        echo json_encode(['status' => 'error', 'message' => 'New password and confirmation do not match']);
        exit;
    }

    // Path to the SQLite database file
    $dbfile = '/Applications/XAMPP/xamppfiles/htdocs/TSMS/database.db';

    try {
        $pdo = new PDO("sqlite:" . $dbfile);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = $_SESSION['username'];
        $stmt = $pdo->prepare("SELECT Password FROM users WHERE Username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($currentPassword, $user['Password'])) {
            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateStmt = $pdo->prepare("UPDATE users SET Password = :newPassword WHERE Username = :username");
            $updateStmt->bindParam(':newPassword', $newHashedPassword);
            $updateStmt->bindParam(':username', $username);

            if ($updateStmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Password changed successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to change the password']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }

    $pdo = null;
}
?>
