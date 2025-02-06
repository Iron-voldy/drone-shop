<?php
session_start();
require 'connection.php';
Database::setUpConnection();

if (!isset($_SESSION['user_id']) || !isset($_POST['cart_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_id = intval($_POST['cart_id']);

// Delete item from cart
$delete_query = "DELETE FROM cart WHERE cart_id = ? AND user_id = ?";
$stmt = Database::$connection->prepare($delete_query);
$stmt->bind_param("ii", $cart_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Item removed"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to remove"]);
}

$stmt->close();
?>
