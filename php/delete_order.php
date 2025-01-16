<?php
include '../php/connection.php';

// Check if the order ID is set and valid
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $order_id = $conn->real_escape_string($_POST['order_id']);  // Correct the variable name to $order_id

    // Delete order query
    $sql = "DELETE FROM orders WHERE order_id = '$order_id'";  // Use $order_id here as well

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the admin dashboard with success message
        header("Location: admin_dashboard.php?message=Order+deleted+successfully&type=success");
    } else {
        // Redirect back to the admin dashboard with error message
        header("Location: admin_dashboard.php?message=Error+deleting+order&type=error");
    }
} else {
    // Redirect if no order ID is set or method is not POST
    header("Location: admin_dashboard.php?message=Invalid+request&type=error");
}

// Close the database connection
$conn->close();
?>
