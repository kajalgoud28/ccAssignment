
<?php
include '../php/connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES ['image']['name'];

    // Upload image
    move_uploaded_file( $_FILES ['image']['tmp_name'], "image/" . $image);

    // Insert product
    $sql = "INSERT INTO products (name, description, price, image) VALUES ('$name', '$description', '$price', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "New product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <a href="index.html"></a>
    </header>

    <main>
        <h1>Add New Product</h1>
        <form action="../php/add_product.php" method="post" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <label for="price">Price:</label>
            <input type="text" id="price" name="price" required>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" required>
            <button type="submit">Add Product</button>
        </form>
    </main>

    <footer>
        <!-- Include your footer content here -->
    </footer>
</body>
</html>
