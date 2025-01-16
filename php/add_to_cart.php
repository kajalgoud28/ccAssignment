<?php
// Include connection file
include '../php/connection.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get product ID and quantity from POST data
    $product_id = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    // Check if the product is already in the cart
    $sql = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Product is already in the cart, update the quantity
        $sql = "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iii', $quantity, $user_id, $product_id);
    } else {
        // Product is not in the cart, insert new record
        $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iii', $user_id, $product_id, $quantity);
    }

    if ($stmt->execute()) {
        // Redirect back to the products page with success message
        header("Location: products.php?added=$product_id");
    } else {
        // Handle error
        echo "Error adding product to cart.";
    }

    $stmt->close();
    $conn->close();
}
?>
