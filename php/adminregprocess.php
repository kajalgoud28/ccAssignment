<?php
// Connect to MySQL database
$host = 'localhost:3307'; // or use '127.0.0.1'
$dbname = 'admins'; // your database name
$username = 'root'; // your MySQL username
$password = '123456'; // your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Insert into the database
    $sql = "INSERT INTO admins (fullname, email, username, password) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$fullname, $email, $username, $password]);

    echo "Admin successfully registered!";
}
?>