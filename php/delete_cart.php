<?php
include '../php/connection.php';

// Check if the contact ID is set and valid
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cart_id'])) {
    $cart_id = $conn->real_escape_string($_POST['cart_id']);  // Sanitize the input

    // Delete contact query
    $sql = "DELETE FROM cart WHERE id = '$cart_id'";  // Use correct column name

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the admin dashboard with a success message
        header("Location: admin_dashboard.php?message=Cart+deleted+successfully&type=success");
    } else {
        // Redirect back to the admin dashboard with an error message
        header("Location: admin_dashboard.php?message=Error+deleting+cart&type=error");
    }
} else {
    // Redirect if no contact ID is set or method is not POST
    header("Location: admin_dashboard.php?message=Invalid+request&type=error");
}

// Close the database connection
$conn->close();
?>

