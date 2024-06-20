<?php
// Set the content type to JSON for the response
header('Content-Type: application/json');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize an array to hold the response
$response = array();


// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
    $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    // Check if any of the required fields are empty
    if (empty($name) || empty($user) || empty($email) || empty($phone) || empty($pass)) {
        $response['status'] = 'error';
        $response['message'] = 'All fields are required.';
        echo json_encode($response);
        exit();
    }

    // Path to the SQLite database file
    $dbfile = '/Applications/XAMPP/xamppfiles/htdocs/TSMS/database.db';

    try {
        
        // Connect to the SQLite database
        $pdo = new PDO("sqlite:" . $dbfile);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            Name TEXT NOT NULL,
            Username TEXT NOT NULL,
            Email TEXT NOT NULL,
            Contact VARCHAR(255) NOT NULL,
            Password TEXT NOT NULL)");

        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

        // Prepare the SQL statement to insert user data
        $stmt = $pdo->prepare("INSERT INTO users (Name, Username, Email, Contact, Password) VALUES (:name, :username, :email, :phone, :password)");
        // Bind the parameters to the SQL query
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':username', $user);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':password', $hashedPassword);

        // Execute the statement and check if the insertion was successful
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'New record created successfully';
            echo json_encode($response);
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error: Could not insert data';
            echo json_encode($response);
        }

    } catch (PDOException $e) {
        // Handle any PDO exceptions
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $e->getMessage();
        echo json_encode($response);
    }

    // Close the database connection
    $pdo = null;
} else {
    // If the request method is not POST, return an error response
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
    echo json_encode($response);
}
?>
