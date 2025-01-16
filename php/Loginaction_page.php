<?php
session_start();

$servername="localhost:3307";
$username="root";
$password="123456";
$db_name="login_system";
$port=3307;


$conn=new mysqli($servername,$username,$password,$db_name,$port);

if($conn->connect_error){
    die("Connection failed: ". $conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $uname=$_POST['uname'];
    $psw=$_POST['psw'];

    // Check if username exists
    $sql = "SELECT * FROM users WHERE username='$uname'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($psw, $row['password'])) {
            // Store session variables
            $_SESSION['username'] = $uname;
            header("Location: ../php/welcome.php"); // Redirect to a welcome page
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "Invalid username!";
    }
}

$conn->close();
?>
    
}