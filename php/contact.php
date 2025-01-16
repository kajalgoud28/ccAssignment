<?php
include '../php/connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data and sanitize inputs to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Insert data into the database
    $sql = "INSERT INTO contacts (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

    if (mysqli_query($conn, $sql)) {
        // Display a success message in the same page
        echo "<script>
                alert('Thank you for contacting us, we will respond shortly.');
                window.location.href = 'contact.php'; // Redirect to the contact page after submission
              </script>";
    } else {
        echo "<script>
                alert('Error: Could not send your message.');
                window.location.href = 'contact.php';
              </script>";
    }
    
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Elegance - Contact Us</title>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/contact.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php session_start(); ?>

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
                    <li><a href="../index.php#services">Services</a></li>
                    <li><a href="../about.html">About Us</a></li>
                    <li><a href="../php/contact.php">Contact</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="cart.php">Cart</a></li>
                </ul>
            </nav>
            <div class="header-right">
                <form action="php/search.php" method="GET" class="search-form">
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
    <main>
        <section class="contact-container">
            <header class="contact-header">
                <h2>Contact Us</h2>
                <p>We'd love to hear from you. Please fill out the form below, and we will get back to you soon.</p>
            </header>

            <form action="contact.php" method="POST" class="contact-form">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="6" required></textarea>

                <button type="submit">Send Message</button>
            </form>

            <article class="contact-info">
                <p><strong>Visit Us:</strong> 123 Beauty Lane, Elegance City</p>
                <p><strong>Call Us:</strong> +123 456 7890</p>
                <p><strong>Email Us:</strong> <a href="mailto:info@salonelegance.com">info@salonelegance.com</a></p>
            </article>

            <div class="contact-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Salon Elegance. All rights reserved.</p>
    </footer>
</body>
</html>
