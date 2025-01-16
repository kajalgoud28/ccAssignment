<?php
session_start();
function calculateTotalAmount() {
    // Adjust the total price if needed (like shipping charges)
    $total_amount = $_SESSION['total_price_all'] + 2 + 5; 
    return $total_amount;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_payment'])) {
    // Sanitize and validate the input
    $user_name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $shipping_address = filter_input(INPUT_POST, 'shipping_address', FILTER_SANITIZE_STRING);
    $payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);

    // Check if input is valid
    if (!empty($user_name) && !empty($email) && !empty($shipping_address) && !empty($payment_method)) {
        // Store user details in session
        $_SESSION['user_name'] = $user_name;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
        $_SESSION['shipping_address'] = $shipping_address;
        $_SESSION['payment_method'] = $payment_method;

        // Check if user is logged in
        if (!empty($_SESSION['user_id'])) {
            include '../php/connection.php';
            $total_amount = calculateTotalAmount();
            
            // Insert into orders table
            $sql = "INSERT INTO orders (user_id, user_name, email, total_amount, payment_method, shipping_address) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param(
                    "issdss",
                    $_SESSION['user_id'], 
                    $_SESSION['user_name'], 
                    $_SESSION['email'], 
                    $total_amount, 
                    $_SESSION['payment_method'], 
                    $_SESSION['shipping_address']
                );
                if ($stmt->execute()) {
                    $stmt->close();
                    $conn->close();
                    // Redirect to success page after insertion
                    header("Location: success.php");
                    exit;
                } else {
                    echo "Error: " . $stmt->error;
                }
            } else {
                die("Database error: " . $conn->error);
            }
        } else {
            header("Location: error_page.php");  // Redirect to error page if user not logged in
            exit;
        }
    } else {
        header("Location: error_page.php");  // Redirect to error page if validation fails
        exit;
    }
} else {
    header("Location: checkout.php");  // Redirect back if the form is not submitted properly
    exit;
}
