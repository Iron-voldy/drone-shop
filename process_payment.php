<?php
session_start();
require 'connection.php';
Database::setUpConnection();

if (!isset($_POST['user_id']) || !isset($_POST['total_price']) || !isset($_POST['payment_method'])) {
    header("Location: checkout.php");
    exit();
}

$user_id = intval($_POST['user_id']);
$total_price = floatval($_POST['total_price']);
$payment_method = $_POST['payment_method'];

// Step 1: Create Order
$order_query = "INSERT INTO orders (user_id, total_price, order_status) VALUES (?, ?, 'Pending')";
$order_stmt = Database::$connection->prepare($order_query);
$order_stmt->bind_param("id", $user_id, $total_price);
$order_stmt->execute();
$order_id = Database::$connection->insert_id;

// Step 2: Move Items from Cart to Order Items with Correct Pricing
$cart_query = "SELECT c.drone_id, c.quantity, d.price 
               FROM cart c 
               JOIN drones d ON c.drone_id = d.drone_id 
               WHERE c.user_id = ?";
$cart_stmt = Database::$connection->prepare($cart_query);
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();

while ($cart = $cart_result->fetch_assoc()) {
    $order_item_query = "INSERT INTO order_items (order_id, drone_id, quantity, price) VALUES (?, ?, ?, ?)";
    $order_item_stmt = Database::$connection->prepare($order_item_query);
    $order_item_stmt->bind_param("iiid", $order_id, $cart['drone_id'], $cart['quantity'], $cart['price']);
    $order_item_stmt->execute();
}

// Step 3: Record Payment
$payment_query = "INSERT INTO payments (order_id, user_id, amount, payment_method, payment_status) 
                  VALUES (?, ?, ?, ?, 'Pending')";
$payment_stmt = Database::$connection->prepare($payment_query);
$payment_stmt->bind_param("iids", $order_id, $user_id, $total_price, $payment_method);
$payment_stmt->execute();

// Step 4: Clear Cart after Successful Order
$clear_cart_query = "DELETE FROM cart WHERE user_id = ?";
$clear_cart_stmt = Database::$connection->prepare($clear_cart_query);
$clear_cart_stmt->bind_param("i", $user_id);
$clear_cart_stmt->execute();

// Step 5: Redirect to Success Page
header("Location: order_success.php?order_id=" . $order_id);
exit();
?>
