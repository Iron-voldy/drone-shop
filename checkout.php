<?php
session_start();
require 'connection.php';
Database::setUpConnection();

if (!isset($_SESSION['user_id']) || !isset($_POST['total_price'])) {
    header("Location: cart.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$total_price = floatval($_POST['total_price']);

// Fetch User Details
$user_query = "SELECT * FROM users WHERE user_id = ?";
$user_stmt = Database::$connection->prepare($user_query);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user = $user_stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="./assets/js/jQuery 3.7.1.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2>Checkout</h2>

    <form action="process_payment.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">

        <div class="form-group">
            <label>Full Name:</label>
            <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
        </div>

        <div class="form-group">
            <label>Phone:</label>
            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>

        <div class="form-group">
            <label>Shipping Address:</label>
            <textarea class="form-control" name="address" required><?php echo htmlspecialchars($user['address']); ?></textarea>
        </div>

        <h4>Total Amount: $<?php echo number_format($total_price, 2); ?></h4>

        <!-- Payment Options -->
        <div class="form-group">
            <label>Select Payment Method:</label>
            <select name="payment_method" class="form-control" required>
                <option value="Credit Card">Credit Card</option>
                <option value="PayPal">PayPal</option>
                <option value="Bank Transfer">Bank Transfer</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Complete Payment</button>
    </form>
</div>

</body>
</html>
