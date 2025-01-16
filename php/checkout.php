<?php
session_start();
include('../php/connection.php'); 
function base64_image($image_data, $mime_type) {
    return 'data:' . $mime_type . ';base64,' . base64_encode($image_data);
}
if (isset($_POST['buy_now'])) {
    $product_id = $_POST['product_id'];
    $query = "SELECT name, price, image, mime_type FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $product_name = $product['name'];
        $price = $product['price'];
        $image_data = $product['image']; 
        $mime_type = $product['mime_type']; 

        $quantity = $_POST['quantity'];
        $total_price = $price * $quantity;
        $_SESSION['checkout_product'] = [
            [
                'product_id' => $product_id,
                'product_name' => $product_name,
                'price' => $price,
                'quantity' => $quantity,
                'total_price' => $total_price,
                'image_data' => $image_data,
                'mime_type' => $mime_type
            ]
        ];

        $_SESSION['total_price_all'] = $total_price;
    }
} elseif (isset($_POST['purchase_all'])) {
    // Fetch cart items
    $cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $checkout_products = [];
    $total_price_all = 0;
    foreach ($cart_items as $item) {
        $query = "SELECT name, price, image, mime_type FROM products WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $item['id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $product_name = $product['name'];
            $price = $product['price'];
            $image_data = $product['image']; 
            $mime_type = $product['mime_type']; 

            $quantity = $item['quantity'];
            $total_price = $price * $quantity;

            $checkout_products[] = [
                'product_id' => $item['id'],
                'product_name' => $product_name,
                'price' => $price,
                'quantity' => $quantity,
                'total_price' => $total_price,
                'image_data' => $image_data,
                'mime_type' => $mime_type
            ];

            $total_price_all += $total_price;
        }
    }
    $_SESSION['checkout_product'] = $checkout_products;
    $_SESSION['total_price_all'] = $total_price_all;
} else {
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .checkout-container {
            background-color: white;
            width: 100%;
            max-width: 900px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        .product-summary, .cart-summary {
            margin-bottom: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        .product-summary p {
            font-size: 1.2em;
           color: #444;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }
        table th, table td {
            padding: 16px;
            text-align: left;
        }
        table th {
            background-color: #fafafa;
            font-weight: bold;
            color: #555;
        }
        table td img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }
        form input[type="text"],
        form input[type="email"],
        form input[type="tel"],
        form select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            max-width: 400px;}
        form button {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.1em;
            width: 100%;
            max-width: 400px;
            transition: background-color 0.3s ease;        }

           form button:hover {
            background-color: #45a049;
        }

        @media (max-width: 768px) {
            .checkout-container {
                padding: 20px;
            }
            table th, table td {
                font-size: 0.9em;
            }
        }
        .payment-details {
            display: none;
            margin-top: 20px;
        }
        .payment-details input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            max-width: 400px;
        }
    </style>
</head>
<body>
<div class="checkout-container">
    <h1>Checkout</h1>
    <?php if (isset($_POST['buy_now'])): ?>
        <div class="product-summary">
            <img src="<?php echo base64_image($image_data, $mime_type); ?>" alt="Product Image" style="max-width: 200px; height: auto;">
            <p><strong>Product:</strong> <?php echo htmlspecialchars($product_name); ?></p>
            <p><strong>Price:</strong> ₹<?php echo number_format($price, 2); ?></p>
            <p><strong>Quantity:</strong> <?php echo $quantity; ?></p>
            <p><strong>Total:</strong> ₹<?php echo number_format($total_price, 2); ?></p>
        </div>
    <?php elseif (isset($_POST['purchase_all'])): ?>
        <h2>All Cart Items</h2>
        <table>
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            <?php foreach ($_SESSION['checkout_product'] as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                    <td><img src="<?php echo base64_image($product['image_data'], $product['mime_type']); ?>" alt="Product Image" style="max-width: 100px; height: auto;"></td>
                    <td>₹<?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td>₹<?php echo number_format($product['total_price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p><strong>Total Price for All Items:</strong> ₹<?php echo number_format($_SESSION['total_price_all'], 2); ?></p>
    <?php endif; ?>

    <form method="POST" action="process_success.php">
        <label for="name">Full Name:</label>
        <input type="text" name="name" required>

        <label for="email">Email Address:</label>
        <input type="email" name="email" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" name="phone" required>

        <label for="shipping_address">Shipping Address:</label>
        <input type="text" name="shipping_address" required>

        <label for="payment_method">Payment Method:</label>
        <select name="payment_method" id="payment_method" required>
            <option value="" disabled selected>Select a Payment Method</option>
            <option value="Credit Card">Credit Card</option>
            <option value="UPI">UPI</option>
            <option value="cod">Cash On Delivery</option>
        </select>
        <div id="credit_card_details" class="payment-details">
            <label for="card_number">Card Number:</label>
            <input type="text" name="card_number" pattern="\d{16}" maxlength="16" placeholder="Enter 16-digit card number">

            <label for="cvv">CVV:</label>
            <input type="text" name="cvv" pattern="\d{3}" maxlength="3" placeholder="Enter 3-digit CVV">

            <label for="expiry_date">Expiry Date (MM/YY):</label>
            <input type="text" name="expiry_date" placeholder="MM/YY" pattern="\d{2}/\d{2}">
        </div>

        <!-- UPI Payment Section -->
        <div id="upi_details" class="payment-details">
            <label for="upi_id">UPI ID:</label>
            <input type="text" name="upi_id" placeholder="Enter your UPI ID">
        </div>

        <button type="submit" name="confirm_payment">Confirm Payment</button>
    </form>
</div>
<script>
    // JavaScript to toggle the visibility of payment details
    document.getElementById('payment_method').addEventListener('change', function() {
        var paymentMethod = this.value;
        var creditCardDetails = document.getElementById('credit_card_details');
        var upiDetails = document.getElementById('upi_details');

        // Hide both sections initially
        creditCardDetails.style.display = 'none';
        upiDetails.style.display = 'none';

        // Show appropriate section based on the selected payment method
        if (paymentMethod === 'Credit Card') {
            creditCardDetails.style.display = 'block';
        } else if (paymentMethod === 'UPI') {
            upiDetails.style.display = 'block';
        }
    });
</script>

</body>
</html>
