<?php
$servername = "localhost";
$username = "root";
$password = "123456";
$dbname = "admins";
$port = 3307;
$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$admin_id = $_GET['admin_id'];
$sql = "SELECT * FROM admins WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc(); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $password = $admin['password']; // Keep the old password if not updating
    }
    
    $sql = "UPDATE admins SET fullname=?, username = ?, email = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $fullname, $username, $email, $password, $admin_id);

    if ($stmt->execute()) {
        echo "Admin updated successfully.";
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Error updating admin: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Admin</title>
</head>
<body>
    <h1>Update Admin</h1>
    <form action="" method="POST">
        <label for="fullname">Admin Full Name:</label>
        <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($admin['fullname']); ?>" required><br>
        <label for="username">Admin Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required><br>
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter new password"><br>
        <button type="submit">Update Admin</button>
    </form>
</body>
</html>
