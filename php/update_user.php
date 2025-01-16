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

// Get user ID from the GET request
$user_id = $_GET['user_id'];

// Fetch the user details based on the user ID
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated user details from form submission
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Update user details in the database
    $sql = "UPDATE users SET username = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $role, $user_id);

    if ($stmt->execute()) {
        echo "User updated successfully.";
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
</head>
<body>
    <h1>Update User</h1>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($user['role']); ?>" required><br>

        <button type="submit">Update User</button>
    </form>
</body>
</html>
