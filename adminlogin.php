<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <!-- Video Background -->
    <div class="video-background">
        <video autoplay muted loop id="background-video">
            <source src="image/cherry_blossom.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <!-- Login Form -->
    <div class="login-container">
        <h2>Admin Login</h2>
        <form action="./php/adminloginprocess.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login">Login</button>
        </form>
        <?php if (isset($error)) { echo "<p class='error-message'>$error</p>"; } ?>
    </div>
</body>
</html>
