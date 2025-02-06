<?php
session_start();
require 'connection.php';
Database::setUpConnection();

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized access");
}

if (isset($_POST['wishlist_id'])) {
    $wishlist_id = intval($_POST['wishlist_id']);

    $delete_query = "DELETE FROM wishlist WHERE wishlist_id = ?";
    $stmt = Database::$connection->prepare($delete_query);
    $stmt->bind_param("i", $wishlist_id);
    
    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error";
    }
}
?>
