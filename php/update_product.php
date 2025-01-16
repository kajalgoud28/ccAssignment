<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "hairsalon";
$port = 3307;
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product ID from the GET request
$product_id = $_GET['product_id'];

// Fetch the product details based on the product ID
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated product details from form submission
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    // Check if an image is uploaded
    if ($_FILES['image']['tmp_name']) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        // Keep the old image if no new image is uploaded
        $image = $product['image'];
    }

    // Update product details in the database
    $sql = "UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsi", $name, $description, $price, $image, $product_id);

    if ($stmt->execute()) {
        echo "Product updated successfully.";
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Error updating product: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
</head>
<body>
    <h1>Update Product</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($product['description']); ?>" required><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" step="0.01" required><br>

        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image"><br>

        <button type="submit">Update Product</button>
    </form>
</body>
</html>
