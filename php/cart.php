
<?php
include '../php/connection.php';
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
if ($user_id === 0) {
    header("Location: ../login.html");
    exit;
}

$sql = "SELECT p.id, p.name, p.price, p.image, c.quantity 
        FROM products p 
        JOIN cart c ON p.id = c.product_id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = [];
$total_price = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
        $total_price += $row['price'] * $row['quantity'];
    }
}
$_SESSION['cart'] = $cart_items;
$_SESSION['total_price'] = $total_price;

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Elegance</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Material Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <style>
        body {
    background-image: url('../image/bgg5.jpg'); /* Make sure to adjust the path to your image */
    background-size: 100%;
    background-position: center;
    background-attachment: fixed; /* Makes the background fixed when scrolling */
    margin: 0;
    
}
    </style>
<header>
    <div class="header-container">
        <div class="logo">
            <img src="../image/logo.png" alt="Salon Elegance logo" class="logo-img">
        </div>
        <nav class="main-nav">
            <div class="salon-info">
                <h1 class="salon-title">Elegance</h1>
                <h2 class="salon-subtitle">Men's Grooming & Style</h2>
            </div>
            <ul>
                <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><a href="../index.php">Home</a></li>
                <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'services.php' ? 'active' : ''; ?>"><a href="../index.php#services">Services</a></li>
                <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>"><a href="../index.php#about">About Us</a></li>
                <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>"><a href="contact.php">Contact</a></li>
                <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>"><a href="products.php">Products</a></li>
                <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'active' : ''; ?>"><a href="./php/cart.php">Cart</a></li>
            </ul>
        </nav>
        <div class="header-right">
            <form action="../php/search.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Search...">
                <button type="submit">Search</button>
            </form>
            <div class="dropdown">
    <button class="dropbtn">
        <i class="fas fa-user"></i>
        <?php if (isset($_SESSION['username'])): ?>
            <?php echo htmlspecialchars($_SESSION['username']); ?>
        <?php else: ?>
            Account
        <?php endif; ?>
    </button>
    <div class="dropdown-content">
        <?php if (isset($_SESSION['username'])): ?>
            <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <p> <?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Not provided'; ?></p>
            <a href="php/logout.php">Logout</a>
        <?php else: ?>
            <a href="login.html">Login</a>
        <?php endif; ?>
    </div>
</div></div>
        </div>
</header>

<?php if (!empty($cart_items)): ?>
    <table>
        <thead>
            <tr>
                <th></th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart_items as $item): ?>
                <tr><b>
                    <td><img src="data:image/jpeg;base64,<?php echo base64_encode($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="100"></td>
                    <td><b><?php echo htmlspecialchars($item['name']); ?></b></td>
                    <td><b>₹<?php echo number_format($item['price'], 2); ?></b></td>
                    <td><b><?php echo $item['quantity']; ?></b></td>
                    <td><b>₹<?php echo number_format($item['price'] * $item['quantity'], 2); ?></b></td>
                    <td>
                        <form method="POST" action="checkout.php">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($item['name']); ?>">
                            <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                            <input type="hidden" name="quantity" value="<?php echo $item['quantity']; ?>">
                            <button type="submit" name="buy_now">Buy Now</button>
                        </form>
                            <form method="POST" action="remove_from_cart.php" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                <button type="submit" name="remove_from_cart">Remove</button>
                            </form>
                        </td>
            </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p>Total: ₹<?php echo number_format($total_price, 2); ?></p>
        <form method="POST" action="checkout.php">
            <button type="submit" name="purchase_all">Purchase All</button>
        </form>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</main>
<footer>
        <p>&copy; 2024 Salon Elegance. All rights reserved.</p>
    </footer>

</body>
</html>
