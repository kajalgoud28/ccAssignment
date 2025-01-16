<?php
include '../php/connection.php'; // Ensure this is the correct path and file name

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['uname'];
    $email = $_POST['email']; // Collect email input
    $psw = password_hash($_POST['psw'], PASSWORD_DEFAULT);

    // Check if username already exists
    $sql = "SELECT id FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username exists
        echo '<script>alert("Username already exists!"); window.location.href="../signup.html";</script>';
    } else {
        // Insert new user with email
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $uname, $email, $psw);

        if ($stmt->execute()) {
            // Registration successful
            echo '<script>alert("Registered successfully"); window.location.href="../login.html";</script>';
        } else {
            // Registration failed
            echo '<script>alert("Error: ' . $stmt->error . '"); window.location.href="../signup.html";</script>';
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
