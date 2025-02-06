<?php
session_start();
require 'connection.php';
Database::setUpConnection();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch Cart
$cart_query = "SELECT c.cart_id, c.drone_id, d.name, d.image_url, d.price, c.quantity 
               FROM cart c
               JOIN drones d ON c.drone_id = d.drone_id 
               WHERE c.user_id = ?";
$cart_stmt = Database::$connection->prepare($cart_query);
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();

$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Cart</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <script src="./assets/js/jQuery 3.7.1.js"></script>
</head>
<body>

<div class="container mt-5">
    <h2>My Cart</h2>

    <ul class="list-group">
        <?php while ($cart = $cart_result->fetch_assoc()) { 
            $subtotal = $cart['price'] * $cart['quantity'];
            $total_price += $subtotal;
        ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <img src="<?php echo $cart['image_url']; ?>" width="50" class="mr-3"> 
                    <strong><?php echo htmlspecialchars($cart['name']); ?></strong>
                    - $<?php echo number_format($cart['price'], 2); ?>
                    <br>
                    <label>Quantity:</label>
                    <input type="number" class="form-control quantity-input" data-id="<?php echo $cart['cart_id']; ?>" 
                           value="<?php echo $cart['quantity']; ?>" min="1" style="width: 60px; display: inline-block;">
                </div>

                <!-- Subtotal -->
                <span class="subtotal" id="subtotal-<?php echo $cart['cart_id']; ?>">
                    $<?php echo number_format($subtotal, 2); ?>
                </span>

                <!-- Remove Button -->
                <button class="btn btn-danger btn-sm remove-cart" data-id="<?php echo $cart['cart_id']; ?>">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </li>
        <?php } ?>
    </ul>

    <h4 class="mt-4">Total: <span id="total-price">$<?php echo number_format($total_price, 2); ?></span></h4>

    <!-- Checkout Button -->
    <div class="text-right mt-3">
        <form action="checkout.php" method="POST">
            <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
            <button type="submit" class="btn btn-success">Proceed to Checkout</button>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Update Quantity
    $(".quantity-input").on("change", function() {
        var cartId = $(this).data("id");
        var newQuantity = $(this).val();

        $.ajax({
            url: "update_cart.php",
            type: "POST",
            data: { cart_id: cartId, quantity: newQuantity },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === "success") {
                    $("#subtotal-" + cartId).text("$" + data.subtotal);
                    $("#total-price").text("$" + data.total_price);
                } else {
                    alert("Error updating quantity.");
                }
            }
        });
    });

    // Remove from Cart
    $(".remove-cart").click(function() {
        var cartId = $(this).data("id");

        $.ajax({
            url: "remove_from_cart.php",
            type: "POST",
            data: { cart_id: cartId },
            success: function(response) {
                location.reload();
            }
        });
    });
});
</script>

</body>
</html>
