<?php
session_start();
require 'connection.php';
Database::setUpConnection();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch Wishlist
$wishlist_query = "SELECT w.wishlist_id, d.drone_id, d.name, d.image_url, d.price 
                   FROM wishlist w
                   JOIN drones d ON w.drone_id = d.drone_id 
                   WHERE w.user_id = ?";
$wishlist_stmt = Database::$connection->prepare($wishlist_query);
$wishlist_stmt->bind_param("i", $user_id);
$wishlist_stmt->execute();
$wishlist_result = $wishlist_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Wishlist</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>My Wishlist</h2>

    <ul class="list-group">
        <?php while ($wish = $wishlist_result->fetch_assoc()) { ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <!-- Clickable Product Link -->
                <a href="product-details.php?drone_id=<?php echo $wish['drone_id']; ?>" class="text-dark">
                    <img src="<?php echo $wish['image_url']; ?>" width="50" class="mr-3"> 
                    <strong><?php echo htmlspecialchars($wish['name']); ?></strong> 
                    - $<?php echo number_format($wish['price'], 2); ?>
                </a>
                
                <!-- Remove from Wishlist Button -->
                <button class="btn btn-danger btn-sm remove-wishlist" data-id="<?php echo $wish['wishlist_id']; ?>">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </li>
        <?php } ?>
    </ul>
</div>

<!-- ✅ Load jQuery at the end of the file -->
<script src="./assets/js/jQuery 3.7.1.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $(".remove-wishlist").click(function() {
        var wishlistId = $(this).data("id");

        $.ajax({
            url: "remove_from_wishlist.php",
            type: "POST",
            data: { wishlist_id: wishlistId },
            success: function(response) {
                location.reload();
            }
        });
    });
});
</script>

</body>
</html>
