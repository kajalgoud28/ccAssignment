<?php
include('connection.php'); // Include your database connection

// Check if the user ID is set
if (isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']); // Get the user ID and ensure it's an integer

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id); // Bind the parameter

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect back to the admin dashboard with a success message
        header("Location: admin_dashboard.php?message=User deleted successfully");
    } else {
        // Redirect back to the admin dashboard with an error message
        header("Location: admin_dashboard.php?message=Error deleting user");
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect back if user ID is not set
    header("Location: admin_dashboard.php?message=No user ID provided");
}
?>
