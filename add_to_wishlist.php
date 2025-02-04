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

    if ($drone_id <= 0) {
        echo json_encode(["status" => "error", "message" => "Invalid product!"]);
        exit();
    }

    // Check if the drone exists in the database
    $checkProduct = Database::search("SELECT * FROM drones WHERE drone_id = $drone_id");
    if ($checkProduct->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Product not found!"]);
        exit();
    }

    // Check if the product is already in the wishlist
    $checkWishlist = Database::search("SELECT * FROM wishlist WHERE user_id = $user_id AND drone_id = $drone_id");
    if ($checkWishlist->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Product is already in the wishlist!"]);
        exit();
    }

    // Insert new product into wishlist
    Database::iud("INSERT INTO wishlist (user_id, drone_id) VALUES ($user_id, $drone_id)");
    
    echo json_encode(["status" => "success", "message" => "Added to wishlist successfully!"]);
}
?>
