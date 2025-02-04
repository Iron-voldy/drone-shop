<?php
session_start();
require 'connection.php';

header('Content-Type: application/json'); // Ensure JSON response format

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');

    // Validate inputs
    if (empty($username) || empty($full_name) || empty($email) || empty($password) || empty($phone) || empty($address)) {
        echo json_encode(["status" => "error", "message" => "All fields are required!"]);
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Invalid email format!"]);
        exit();
    }

    // Establish database connection
    Database::setUpConnection();
    
    // Check if the email or username already exists
    $checkUserQuery = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt = Database::$connection->prepare($checkUserQuery);
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Database error: " . Database::$connection->error]);
        exit();
    }
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Username or email already exists!"]);
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user
    $insertQuery = "INSERT INTO users (username, email, password_hash, full_name, phone, address) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = Database::$connection->prepare($insertQuery);
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Database error: " . Database::$connection->error]);
        exit();
    }
    $stmt->bind_param("ssssss", $username, $email, $hashed_password, $full_name, $phone, $address);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Registration successful!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Registration failed!"]);
    }

    $stmt->close();
    Database::$connection->close();
}
?>
