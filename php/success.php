<?php
session_start();

// Function to convert binary image data to base64
function base64_image($image_data, $mime_type) {
    return 'data:' . $mime_type . ';base64,' . base64_encode($image_data);
}

// Check if payment and checkout data exist
if (isset($_SESSION['checkout_product'], $_SESSION['shipping_address'], $_SESSION['payment_method'], $_SESSION['user_name'], $_SESSION['email'], $_SESSION['phone'])) {
    $checkout_products = $_SESSION['checkout_product'];
    $total_price_all = $_SESSION['total_price_all'];
    $shipping_address = $_SESSION['shipping_address'];
    $payment_method = $_SESSION['payment_method'];
    $user_name = $_SESSION['user_name'];  // Fetch the name from the session
    $email = $_SESSION['email'];  // Fetch the email from the session
    $phone = $_SESSION['phone'];  // Fetch the phone from the session
} else {
    // Redirect to cart if no payment information is found
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success</title>
    <style>
        /* Main styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            display: flex;
            justify-content: space-between;
            background-color: #fff;
            width: 80%;
            max-width: 1000px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
        }

        .left {
            width: 50%;
            padding-right: 20px;
        }

        .right {
            width: 50%;
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
        }

        h1 {
            font-size: 2.2em;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            font-size: 1.1em;
            line-height: 1.6;
        }

        .address-info {
            margin-top: 20px;
        }

        .address-info p {
            margin: 5px 0;
        }

        .cart {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ff5a5f;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1em;
        }

        /* Order Summary Styling */
        .order-summary h2 {
            margin-top: 0;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table th, .summary-table td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .summary-table th {
            background-color: #f9f9f9;
        }

        .order-total {
            margin-top: 20px;
            font-size: 1.2em;
            font-weight: bold;
            text-align: right;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .summary-item img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        @media screen and (max-width: 800px) {
            .container {
                flex-direction: column;
                padding: 15px;
            }

            .left, .right {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Left Section: Thank You Message and Billing Info -->
    <div class="left">
        <h1>Thank you for your purchase!</h1>
        <p>Your order will be processed within 24 hours during working days. We will notify you by email once your order has been shipped.</p>
        
        <div class="address-info">
            <h3>Billing address</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($shipping_address); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        </div>

        <a href="cart.php" class="cart">Back to cart</a>
    </div>

    <!-- Right Section: Order Summary -->
    <div class="right order-summary">
        <h2>Order Summary</h2>
        <table class="summary-table">
            <tr>
                <th>Date</th>
                <th>Order Number</th>
                <th>Payment Method</th>
            </tr>
            <tr>
                <td><?php echo date('d M Y'); ?></td>
                <td>024-125478956</td>
                <td><?php echo htmlspecialchars($payment_method); ?></td>
            </tr>
        </table>

        <?php foreach ($checkout_products as $product): ?>
            <div class="summary-item">
                <!-- Display Product Image -->
                <img src="<?php echo base64_image($product['image_data'], $product['mime_type']); ?>" alt="Product Image">
                <p><strong><?php echo htmlspecialchars($product['product_name']); ?></strong><br>
                Qty: <?php echo $product['quantity']; ?> | ₹<?php echo number_format($product['price'], 2); ?></p>
                <p>₹<?php echo number_format($product['total_price'], 2); ?></p>
            </div>
        <?php endforeach; ?>

        <div class="order-total">
            <p>Sub Total: ₹<?php echo number_format($total_price_all, 2); ?></p>
            <p>Shipping: ₹2.00</p>
            <p>Tax: ₹5.00</p>
            <p><strong>Order Total: ₹<?php echo number_format($total_price_all + 2 + 5, 2); ?></strong></p>
        </div>
    </div>
</div>

</body>
</html>
