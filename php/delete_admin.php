<?php
$servername = "localhost:3307";
$username = "root";
$password = "123456";
$dbname = "admins";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin_id'])) {
    $admin_id = $conn->real_escape_string($_POST['admin_id']);  
    $sql = "DELETE FROM admins WHERE id = '$admin_id'";   if ($conn->query($sql) === TRUE) {
       
        header("Location: admin_dashboard.php?message=admin+deleted+successfully&type=success");
    } else {       
        header("Location: admin_dashboard.php?message=Error+deleting+admin&type=error");
    }
} else {    
    header("Location: admin_dashboard.php?message=Invalid+request&type=error");
}
$conn->close();
?>
