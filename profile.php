<?php
session_start();
require 'connection.php';
Database::setUpConnection();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch User Details
$user_query = "SELECT * FROM users WHERE user_id = ?";
$user_stmt = Database::$connection->prepare($user_query);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <style>
        .profile-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        .profile-header {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .profile-buttons {
            margin-top: 20px;
            text-align: center;
        }
        .profile-buttons .btn {
            margin: 5px;
            width: 150px;
        }
    </style>
</head>
<body>

<div class="container profile-container">
    <h2 class="text-center">User Profile</h2>

    <!-- Profile Details -->
    <div class="profile-header">
        <h4><?php echo htmlspecialchars($user['username']); ?></h4>
        <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

        <!-- Profile Edit Form -->
        <form action="update_profile.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>">
            </div>
            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>">
            </div>
            <div class="form-group">
                <label>Address:</label>
                <textarea name="address" class="form-control"><?php echo htmlspecialchars($user['address']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>

    <!-- Navigation Buttons -->
    <div class="profile-buttons">
        <a href="orders.php" class="btn btn-info"><i class="fas fa-box"></i> My Orders</a>
        <a href="wishlist.php" class="btn btn-warning"><i class="fas fa-heart"></i> Wishlist</a>
        <a href="cart.php" class="btn btn-success"><i class="fas fa-shopping-cart"></i> Cart</a>
        <a href="add_product.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</a>
    </div>
</div>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

</body>
</html>
