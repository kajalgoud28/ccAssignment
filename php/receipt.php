<?php
session_start();

// Check if payment is confirmed
if (isset($_POST['confirm_payment'])) {
    // Store user details in the session
    $_SESSION['user_name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['shipping_address'] = $_POST['shipping_address'];
    $_SESSION['payment_method'] = $_POST['payment_method'];

    // Ensure all required session variables are set
    if (!empty($_SESSION['user_id']) && !empty($_SESSION['user_name']) && !empty($_SESSION['email']) && !empty($_SESSION['shipping_address']) && !empty($_SESSION['payment_method'])) {
        // Include database connection
        include '../php/connection.php';

        // Prepare INSERT statement
        $sql = "INSERT INTO orders (user_id, user_name, email, total_amount, payment_method, shipping_address) 
                VALUES (?, ?, ?, ?, ?, ?)";

        // Calculate total_amount (replace with your logic)
        $total_amount = calculateTotalAmount(); // Implement your calculation function

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issdss", $_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['email'], $total_amount, $_SESSION['payment_method'], $_SESSION['shipping_address']);

        // Execute statement
        if ($stmt->execute()) {
            // Close statement and database connection
            $stmt->close();
            $conn->close();
        } else {
            // Handle insertion failure
            echo "Error: " . $stmt->error;
        }
    } else {
        // Redirect to error page or handle missing session data
        header("Location: error_page.php");
        exit;
    }
} else {
    // Redirect if no payment confirmation
    header("Location: success.php");
    exit;
}

// Function to calculate total amount (replace with your business logic)
function calculateTotalAmount() {
    // Example: Calculate total amount based on session data or other logic
    $total_amount = $_SESSION['total_price_all'] + 2 + 5; // Adjust this calculation as per your requirements
    return $total_amount;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .success-container {
            text-align: center;
            background-color: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
        }

        .success-container img {
            width: 150px;
        }

        .success-container h1 {
            color: #28a745;
            font-size: 2.5em;
            margin: 20px 0;
        }

        .success-container p {
            font-size: 1.2em;
            color: #555;
            margin: 10px 0;
        }

        .success-container a {
            text-decoration: none;
            color: #fff;
            background-color: #28a745;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .success-container a:hover {
            background-color: #218838;
        }

        .success-container .info {
            margin-top: 20px;
            font-size: 0.9em;
            color: #888;
        }

        @media screen and (max-width: 600px) {
            .success-container {
                padding: 30px;
            }

            .success-container h1 {
                font-size: 2em;
            }

            .success-container p {
                font-size: 1.1em;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <img src="../image/payment-success.png" alt="Payment Success Icon">
        <h1>Thank You!</h1>
        <p>Your payment was successfully processed!</p>
        <p>You will be redirected to the order summary page shortly, or you can <a href="success.php">click here</a> to view your order now.</p>
        <div class="info">
            <p>Redirection in <span id="countdown">5</span> seconds...</p>
        </div>
    </div>

    <script>
        // Countdown script to redirect after 5 seconds
        let countdown = 5;
        let countdownElement = document.getElementById('countdown');

        function updateCountdown() {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                window.location.href = "success.php";
            } else {
                setTimeout(updateCountdown, 1000); // Update every second
            }
        }

        updateCountdown();
    </script>
</body>
</html>
