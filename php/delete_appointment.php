<?php
include '../php/connection.php';

// Check if the appointment ID is set and valid
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointment_id'])) {
    $appointment_id = $conn->real_escape_string($_POST['appointment_id']);  // Use appointment_id here

    // Delete appointment query
    $sql = "DELETE FROM appointments WHERE id = '$appointment_id'";  // Use $appointment_id in the SQL query

    if ($conn->query($sql) === TRUE) {
        // Redirect back to the admin dashboard with success message
        header("Location: admin_dashboard.php?message=Appointment+deleted+successfully&type=success");
        exit();
    } else {
        // Redirect back to the admin dashboard with error message
        header("Location: admin_dashboard.php?message=Error+deleting+appointment&type=error");
        exit();
    }
} else {
    // Redirect if no Appointment ID is set or method is not POST
    header("Location: admin_dashboard.php?message=Invalid+request&type=error");
    exit();
}

// Close the database connection
$conn->close();
?>
