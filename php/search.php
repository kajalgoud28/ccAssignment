<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="../css/search.css"> 
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/hero.css">
</head>
<body>
    <?php
    session_start();
    ?>
   <header>
        <div class="header-container">
            <div class="logo">
                <img src="../image/logo.png" alt="Salon Elegance logo" class="logo-img">
            </div>
            <nav class="main-nav">
                <div class="salon-info">
                    <h1 class="salon-title">Elegance</h1>
                    <h2 class="salon-subtitle">Hair and Beauty Salon</h2>
                </div>
                <ul>
                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><a href="../index.php">Home</a></li>
                    <li><a href="../index.php#services">Services</a></li>
                    <li><a href="../about.html">About Us</a></li>
                    <li><a href="../php/contact.php">Contact</a></li>
                    <li><a href="../php/products.php">Products</a></li>
                    <li><a href="../php/cart.php">Cart</a></li>
                </ul>
            </nav>
            <div class="header-right">
                <form action="../php/search.php" method="GET" class="search-form">
                    <input type="text" name="query" placeholder="Search...">
                    <button type="submit">Search</button>
                </form>

               <!-- User Dropdown -->
<!-- User Dropdown -->
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
</div>


            </div>
        </div>
    </header>



    <?php 
    include '../php/connection.php';

    if (isset($_GET['query'])) {
        $query = $_GET['query'];
        $query = $conn->real_escape_string($query);
        $sql = "SELECT id, name, description, price, image, mime_type FROM products WHERE name LIKE '%$query%' OR description LIKE '%$query%'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Search results for '$query':</h2>";
            echo "<div class='product_list'>";

            while ($row = $result->fetch_assoc()) {
                $mimeType = isset($row['mime_type']) ? htmlspecialchars($row['mime_type']) : 'image/jpeg';
                $imageData = base64_encode($row['image']);
                $imageSrc = "data:$mimeType;base64,$imageData";

                echo "<div class='products'>";
                echo "<img src='$imageSrc' alt='" . htmlspecialchars($row['name']) . "'>";
                echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<p>Price: $" . htmlspecialchars($row['price']) . "</p>";
                echo "<form action='../php/cart.php' method='POST'>";
                echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                echo "<button type='submit'>Add to Cart</button>";
                echo "</form>";

                // Display success message if 'added' parameter is set
                if (isset($_GET['added']) && $_GET['added'] == $row['id']) {
                    echo "<p>Your product has been added to the cart!</p>";
                }

                echo "</div>";
            }
            echo "</div>";

        } else {
            echo "<h2>No results found for '$query'</h2>";
        }

    } else {
        echo "<h2>No search query provided.</h2>";
    }

    $conn->close();
    ?>
</body>
</html>
