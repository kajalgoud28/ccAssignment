<?php
session_start();
include '../php/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['uname'];
    $psw = $_POST['psw'];

    // Fetch user info including email
    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($psw, $row['password'])) {
            $_SESSION['username'] = $uname;
            $_SESSION['email'] = $row['email'];  // Store email in session
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $row['id'];  // Store user_id in session
            $_SESSION['user_role'] = 'user';  // Set role as 'user'

            // Update logged_in status with current datetime for user
            $stmt = $conn->prepare("UPDATE users SET logged_in = NOW(), role = 'user' WHERE username = ?");
            $stmt->bind_param("s", $uname);
            if ($stmt->execute()) {
                // Registration successful
                echo '<script>alert("Sign-in successfully"); window.location.href="../index.php";</script>';
            } else {
                // Registration failed
                echo '<script>alert("Error: ' . $stmt->error . '"); window.location.href="../signup.html";</script>';
            }
            $stmt->close();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "Username not found!";
    }
}

$conn->close();
?>
