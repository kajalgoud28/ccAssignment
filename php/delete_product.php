<?php
include '../php/connection.php';


// Check if the product ID is set and valid
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $product_id = $conn->real_escape_string($_POST['product_id']);

    // Delete product query
    $sql = "DELETE FROM products WHERE id = '$product_id'";

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the admin dashboard with success message
        header("Location: admin_dashboard.php?message=Product+deleted+successfully&type=success");
    } else {
        // Redirect back to the admin dashboard with error message
        header("Location: admin_dashboard.php?message=Error+deleting+product&type=error");
    }
} else {
    // Redirect if no product ID is set or method is not POST
    header("Location: admin_dashboard.php?message=Invalid+request&type=error");
}

// Close the database connection
$conn->close();
?>
