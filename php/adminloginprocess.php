<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start(); // Ensure no output is sent before header

session_start();

$servername = "localhost:3307";
$username = "root";
$password = "123456";
$dbname = "admins";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$error = ""; // Initialize $error to capture any errors

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to prevent SQL Injection
    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the username parameter (string type)
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $admin['password'])) {
                // Store admin ID in session and redirect to admin dashboard
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['username'] = $admin['username'];
                header("Location: ./admin_dashboard.php"); // Ensure the path is correct
                exit();
            } else {
                $error = "Invalid password. Please try again.";
            }
        } else {
            $error = "No admin found with that username.";
        }

        $stmt->close();
    } else {
        // If the prepare fails, capture the error here
        $error = "Failed to prepare statement: " . $conn->error;
    }

    $conn->close();
}

// Output any error messages
if ($error) {
    echo "<p style='color: red;'>$error</p>";
}

ob_end_flush(); // End output buffering
?>
