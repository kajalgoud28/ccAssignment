<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "hairsalon";
$port = 3307;

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prod_name = $conn->real_escape_string($_POST['prod_name']);
    $description = $conn->real_escape_string($_POST['description']);
    $price = $conn->real_escape_string($_POST['price']);

    // Handle file upload
    $image = $_FILES['image']['tmp_name'];
    if ($image) {
        $imgData = file_get_contents($image);
        $imgData = $conn->real_escape_string($imgData);
    }

    // Insert into the products table
    $sql = "INSERT INTO products (name, description, price, image) VALUES ('$prod_name', '$description', '$price', '$imgData')";

    if ($conn->query($sql) === TRUE) {
        $message = "Product added successfully!";
        $message_type = "success-message";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
        $message_type = "error-message";
    }

    // Close the connection
    $conn->close();

    // Redirect back to the form with a message
    header("Location: admin_dashboard.php?message=" . urlencode($message) . "&message_type=" . urlencode($message_type));
    exit();
}
?>
