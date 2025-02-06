<?php
session_start();
require 'connection.php';
Database::setUpConnection();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch User Orders
$orders_query = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$orders_stmt = Database::$connection->prepare($orders_query);
$orders_stmt->bind_param("i", $user_id);
$orders_stmt->execute();
$orders_result = $orders_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>My Orders</h2>
    <ul class="list-group">
        <?php while ($order = $orders_result->fetch_assoc()) { ?>
            <li class="list-group-item">
                Order #<?php echo $order['order_id']; ?> - 
                <strong>$<?php echo $order['total_price']; ?></strong> - 
                Status: <span class="badge badge-info"><?php echo $order['order_status']; ?></span>
            </li>
        <?php } ?>
    </ul>
</div>

</body>
</html>
