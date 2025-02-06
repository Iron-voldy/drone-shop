<?php
session_start();
require 'connection.php';
Database::setUpConnection();

if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = intval($_GET['order_id']);
$user_id = $_SESSION['user_id'];

// Fetch Order Details
$order_query = "SELECT * FROM orders WHERE order_id = ? AND user_id = ?";
$order_stmt = Database::$connection->prepare($order_query);
$order_stmt->bind_param("ii", $order_id, $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

if ($order_result->num_rows === 0) {
    die("Invalid order!");
}
$order = $order_result->fetch_assoc();

// Fetch Ordered Items
$order_items_query = "SELECT oi.quantity, oi.price, d.name, d.image_url 
                      FROM order_items oi 
                      JOIN drones d ON oi.drone_id = d.drone_id 
                      WHERE oi.order_id = ?";
$order_items_stmt = Database::$connection->prepare($order_items_query);
$order_items_stmt->bind_param("i", $order_id);
$order_items_stmt->execute();
$order_items_result = $order_items_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .order-container {
            max-width: 700px;
            margin: auto;
            text-align: center;
            padding: 40px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #f9f9f9;
        }
        .order-container img {
            width: 80px;
            margin-bottom: 20px;
        }
        .order-items {
            margin-top: 20px;
            text-align: left;
        }
        .order-items img {
            width: 60px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="order-container">
        <img src="assets/img/checkmark.png" alt="Success">
        <h2>Order Placed Successfully!</h2>
        <p>Your order <strong>#<?php echo $order['order_id']; ?></strong> has been placed successfully.</p>
        <p>Total Amount: <strong>$<?php echo number_format($order['total_price'], 2); ?></strong></p>
        <hr>
        
        <h5>Order Summary:</h5>
        <ul class="list-group order-items">
            <?php while ($item = $order_items_result->fetch_assoc()) { ?>
                <li class="list-group-item d-flex align-items-center">
                    <img src="<?php echo $item['image_url']; ?>" alt="Product">
                    <div>
                        <strong><?php echo htmlspecialchars($item['name']); ?></strong> <br>
                        Quantity: <?php echo $item['quantity']; ?> | Price: $<?php echo number_format($item['price'], 2); ?>
                    </div>
                </li>
            <?php } ?>
        </ul>

        <hr>
        <a href="index.php" class="btn btn-primary mt-3"><i class="fas fa-home"></i> Return to Home</a>
        <a href="order_details.php?order_id=<?php echo $order['order_id']; ?>" class="btn btn-success mt-3"><i class="fas fa-receipt"></i> View Order Details</a>
    </div>
</div>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
