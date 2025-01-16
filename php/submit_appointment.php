<?php
// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$service = $_POST['service'];
$date = $_POST['date'];
$time = $_POST['time'];

// You can now process the data or store it in a database
// For example, storing the data in the database (assuming connection is already set up)

// Database connection (example)
$servername = "localhost:3307";
$username = "root";
$password = "123456";
$dbname = "hairsalon"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to insert appointment data
$sql = "INSERT INTO appointments (name, email, phone, service, date, time) 
        VALUES ('$name', '$email', '$phone', '$service', '$date', '$time')";

if ($conn->query($sql) === TRUE) {
    echo "Appointment booked successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
