<?php
session_start();
require 'connection.php';

header('Content-Type: application/json'); // Ensure proper JSON response format

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        echo json_encode(["status" => "error", "message" => "Email and password are required!"]);
        exit();
    }
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Establish database connection
    Database::setUpConnection();
    
    // Search for user in the database
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = Database::$connection->prepare($query);
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Database error: " . Database::$connection->error]);
        exit();
    }
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            echo json_encode(["status" => "success", "message" => "Login successful!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid password!"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "User not found!"]);
    }
    
    $stmt->close();
    Database::$connection->close();
}
?>
