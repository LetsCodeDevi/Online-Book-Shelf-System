<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize an array to hold the response
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($username) || empty($password)) {
       # $_SESSION['error'] = "Username and password are required.";
        #header("Location: login.php");
        $response['status'] = 'error';
        $response['message'] = 'All fields are required.';
        echo json_encode($response);
        exit();
    }

    $dbfile = '/Applications/XAMPP/xamppfiles/htdocs/TSMS/database.db';

    try {
        $pdo = new PDO("sqlite:" . $dbfile);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE Username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Password'])) {
            #echo "Login successful. Welcome, " . htmlspecialchars($user['Name']) . "!";
            #header("Location: homepage.html");
            $_SESSION['loggedin'] = true;
            $response['status'] = 'success';
            $response['message'] = 'User Login Successfull';
            echo json_encode($response);
        } else {
            # $_SESSION['error'] = "Invalid username or password.";
           # header("Location: login.php");
           # exit();
           $response['status'] = 'error';
           $response['message'] = 'Error: Invalid username or password.';
           echo json_encode($response);
        }

    } catch (PDOException $e) {
       # $_SESSION['error'] = "Error: " . $e->getMessage();
       # header("Location: login.php");
       # exit();
       $response['status'] = 'error';
       $response['message'] = 'Error: ' . $e->getMessage();
       echo json_encode($response);
    }

    $pdo = null;
} else {
   # $_SESSION['error'] = "Invalid request method.";
   # header("Location: login.php");  
   # exit();
   $response['status'] = 'error';
   $response['message'] = 'Invalid request method.';
   echo json_encode($response);
}
?>