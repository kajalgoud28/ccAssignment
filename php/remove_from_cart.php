<?php
include '../php/connection.php';

session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

if ($user_id === 0) {
    header("Location: ../login.html"); // Redirect to login if not logged in
    exit;
}

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    
    // Remove the item from the cart
    $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $product_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: cart.php"); // Redirect back to cart
exit;
?>
