
<?php

include '../php/connection.php';
// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$sql = "SELECT * FROM products WHERE id = $product_id";
$result = $conn->query($sql);

$product = null;
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
    <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="php/products.php">Products</a></li> 
                
                <li>
                    
                    <ul>
                        <?php foreach ($products as $product) : ?>
                            <li><a href="php/product_detail.php?id=<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['name']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <?php if ($product): ?>
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <img src="image/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <p><?php echo htmlspecialchars($product['description']); ?></p>
            <p>Price: $<?php echo htmlspecialchars($product['price']); ?></p>
        <?php else: ?>
            <p>Product not found.</p>
        <?php endif; ?>
    </main>

    <footer>
    <div class="footer-content">
            <p>&copy; 2024 Salon Elegance. All rights reserved.</p>
            <ul class="social-media">
                <li><a href="#"><img src="image/facebook.png" alt="Facebook"></a></li>
                <li><a href="#"><img src="image/twitter.png" alt="Twitter"></a></li>
                <li><a href="#"><img src="image/instagram.png" alt="Instagram"></a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
