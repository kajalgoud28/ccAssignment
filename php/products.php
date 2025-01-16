<?php
include '../php/connection.php';
session_start(); // Start session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$sql = "SELECT id, name, description, price, image FROM products";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->execute();
$result = $stmt->get_result();
$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/products.css">
    <link rel="stylesheet" href="css/services.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/hero.css">
    <!-- Material Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<header>
    <div class="header-container">
        <div class="logo">
            <img src="../image/logo.png" alt="Salon Elegance logo" class="logo-img">
        </div>
        <div class="salon-info">
            <h1 class="salon-title">Elegance</h1>
            <p class="salon-subtitle">Men's Grooming & Style</p>
        </div>
        <nav class="main-nav">
            <ul>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], 'index.php') !== false ? 'active' : ''; ?>"><a href="../index.php">Home</a></li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], 'index.php') !== false ? 'active' : ''; ?>"><a href="../index.php#services">Services</a></li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], 'index.php') !== false ? 'active' : ''; ?>"><a href="../about.html">About Us</a></li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], 'contact.php') !== false ? 'active' : ''; ?>"><a href="../php/contact.php">Contact</a></li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], 'products.php') !== false ? 'active' : ''; ?>"><a href="../php/products.php">Products</a></li>
                <li class="<?php echo strpos($_SERVER['PHP_SELF'], 'cart.php') !== false ? 'active' : ''; ?>"><a href="cart.php">Cart</a></li>
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
                        <p><?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Not provided'; ?></p>
                        <a href="php/logout.php">Logout</a>
                    <?php else: ?>
                        <a href="login.html">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <div class="product-image">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <h2><?php echo htmlspecialchars($product['name']); ?></h2>
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p class="price">₹<?php echo number_format($product['price'], 2); ?></p>
            <form action="add_to_cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="number" name="quantity" value="1" min="1" max="10" id="quantity_<?php echo $product['id']; ?>">
                <button type="submit">Add to Cart</button>
            </form>
            
            <form method="POST" action="checkout.php">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                <input type="hidden" name="quantity" id="buy_now_quantity_<?php echo $product['id']; ?>" value="1">
                <button type="submit" name="buy_now" onclick="updateBuyNowQuantity(<?php echo $product['id']; ?>)">Buy Now</button>
            </form>
            <?php if (isset($_GET['added']) && $_GET['added'] == $product['id']): ?>
                <p class="success-message">Your product has been added to the cart!</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<script>
    function updateBuyNowQuantity(productId) {
        // Get the quantity from the input field
        var quantity = document.getElementById('quantity_' + productId).value;
        // Set it in the Buy Now hidden input field
        document.getElementById('buy_now_quantity_' + productId).value = quantity;
    }
</script>
<footer>
        <p>&copy; 2024 Salon Elegance. All rights reserved.</p>
    </footer>

</body>
</html>
