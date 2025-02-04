<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Please log in first!"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $drone_id = isset($_POST['drone_id']) ? intval($_POST['drone_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if ($drone_id <= 0 || $quantity <= 0) {
        echo json_encode(["status" => "error", "message" => "Invalid product or quantity!"]);
        exit();
    }

    // Check if the drone exists in the database
    $checkProduct = Database::search("SELECT * FROM drones WHERE drone_id = $drone_id");
    if ($checkProduct->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Product not found!"]);
        exit();
    }

    // Check if the product is already in the cart
    $checkCart = Database::search("SELECT * FROM cart WHERE user_id = $user_id AND drone_id = $drone_id");
    if ($checkCart->num_rows > 0) {
        // Update quantity if product already exists in cart
        Database::iud("UPDATE cart SET quantity = quantity + $quantity WHERE user_id = $user_id AND drone_id = $drone_id");
    } else {
        // Insert new product into cart
        Database::iud("INSERT INTO cart (user_id, drone_id, quantity) VALUES ($user_id, $drone_id, $quantity)");
    }

    echo json_encode(["status" => "success", "message" => "Added to cart successfully!"]);
}
?>
