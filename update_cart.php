<?php
session_start();
require 'connection.php';
Database::setUpConnection();

if (!isset($_SESSION['user_id']) || !isset($_POST['cart_id']) || !isset($_POST['quantity'])) {
    echo json_encode(["status" => "error"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_id = intval($_POST['cart_id']);
$quantity = intval($_POST['quantity']);

if ($quantity < 1) {
    echo json_encode(["status" => "error", "message" => "Invalid quantity"]);
    exit();
}

// Update Quantity
$update_query = "UPDATE cart SET quantity = ? WHERE cart_id = ? AND user_id = ?";
$stmt = Database::$connection->prepare($update_query);
$stmt->bind_param("iii", $quantity, $cart_id, $user_id);
$stmt->execute();

// Fetch Updated Cart Data
$cart_query = "SELECT c.price, c.quantity FROM cart c WHERE c.cart_id = ? AND c.user_id = ?";
$stmt = Database::$connection->prepare($cart_query);
$stmt->bind_param("ii", $cart_id, $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();
$cart_data = $cart_result->fetch_assoc();
$subtotal = $cart_data['price'] * $cart_data['quantity'];

// Recalculate Total Price
$total_query = "SELECT SUM(d.price * c.quantity) AS total FROM cart c JOIN drones d ON c.drone_id = d.drone_id WHERE c.user_id = ?";
$stmt = Database::$connection->prepare($total_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$total_result = $stmt->get_result();
$total_data = $total_result->fetch_assoc();
$total_price = $total_data['total'];

echo json_encode(["status" => "success", "subtotal" => number_format($subtotal, 2), "total_price" => number_format($total_price, 2)]);
?>
