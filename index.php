<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Elegance</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/services.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/hero.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="video-background">
        <video autoplay muted loop id="background-video">
            <source src="image/cherry_blossom.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <?php session_start(); ?>
    <header>
        <div class="header-container">
            <div class="logo">
                <img src="image/logo.png" alt="Salon Elegance logo" class="logo-img">
            </div>
            <nav class="main-nav">
                <div class="salon-info">
                    <h1 class="salon-title">Elegance</h1>
                    <h2 class="salon-subtitle">Men's Grooming & Style</h2>
                </div>
                <ul>
                    <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>"><a href="index.php">Home</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="php/contact.php">Contact</a></li>
                    <li><a href="php/products.php">Products</a></li>
                    <li><a href="./php/cart.php">Cart</a></li>
                </ul>
            </nav>
            <div class="header-right">
                <form action="php/search.php" method="GET" class="search-form">
                    <input type="text" name="query" placeholder="Search...">
                    <button type="submit">Search</button>
                </form>
                
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
</div></div>
        </div>
    </header>
    <section id="home" class="slideshow">
        <div class="slideshow-content">
            <div class="welcome-username-container">
            <img src="image1/bg2.webp" alt="hair wash" class="slide3">
                <span class="welcome-username">
                    <?php if (isset($_SESSION['username'])) {
                        echo 'Welcome ' . htmlspecialchars($_SESSION['username']) . '!';
                    } ?>
                </span>
            </div>
            <h1>Welcome to Salon Elegance</h1>
            <p>Your beauty, our duty.</p>
            <button id="btn1" onclick="window.location.href='appointment.html'">Book Appointment</button>
            <img src="image1/bg3.webp" alt="Salon Elegance slide image" class="slide1">
            <img src="image1/bg2.webp" alt="hair wash" class="slide2">
            <img src="image1/bg4.webp" alt="hair image" class="slide3">
            <img src="image1/bg4.jpg" alt="hair dryer" class="slide4">
        </div>
    </section>

    <div class="after-slideshow-cover"></div>

    <section id="services">
    <h2>Our Services</h2>
    <div class="service-container">
        <!-- Service Items -->
        <div class="service">
            <a href="hair_service.html">
                <img src="image1/mens_haircut.webp" alt="Men's Haircut" class="service-img">
                <h3>Men's Haircut</h3>
            </a>
            <p>Professional men's haircuts to suit your style.</p>
        </div>
        <div class="service">
            <a href="facial_treatments.html">
                <img src="image1/facial_treatments.jpeg" alt="Facial Treatments" class="service-img">
                <h3>Facial Treatments</h3>
            </a>
            <p>Rejuvenating facials designed to cater to men's skin, including deep cleansing and hydration.</p>
        </div>
        <div class="service">
            <a href="massage.html">
                <img src="image1/msg.webp" alt="Massage Services" class="service-img">
                <h3>Massage Services</h3>
            </a>
            <p>Relaxing massages that relieve tension and promote wellness, including Swedish and deep tissue massages.</p>
        </div>
        <div class="service">
            <a href="shaving_experience.html">
                <img src="image1/shav.jpg" alt="Shaving Experience" class="service-img">
                <h3>Shaving Experience</h3>
            </a>
            <p>Luxurious shaving services with hot towel treatment, tailored for a clean and sharp look.</p>
        </div>
        <div class="service">
            <a href="skin_care_services.html">
                <img src="image1/skinc.avif" alt="Skincare Services" class="service-img">
                <h3>Skincare Services</h3>
            </a>
            <p>Comprehensive skincare treatments designed to nourish and rejuvenate men's skin.</p>
        </div>
        <div class="service">
            <a href="men_grooming.html">
                <img src="image1/groom1.webp" alt="Men's Grooming" class="service-img">
                <h3>Men's Grooming</h3>
            </a>
            <p>Expert grooming services including beard care, hair styling, and personalized consultations.</p>
        </div>
    </div>
</section>


    
<section id="about">
    <div class="about-container">
        <div class="about-info">
            <h1>About Us</h1>
            <h2>Welcome to Salon Elegance</h2>
            <p>
                Salon Elegance has been the go-to destination for men's grooming since 2000. From stylish haircuts to expert beard trims, we offer premium services that help men look and feel their best.
            </p>
            <a href="about.html" class="learn-more">Read More</a>
        </div>
        <div class="about-image">
            <img src="image1/ab1.jpg" alt="About Men's Grooming at Salon Elegance">
        </div>
    </div>
</section>

    <footer>
        <p>&copy; 2024 Salon Elegance. All rights reserved.</p>
    </footer>

</body>
</html>
