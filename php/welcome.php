<?php

session_start();

if(!isset($_SESSION['username']) || empty ($_SESSION['username'])){
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-wodth, initial-scale=1.0">
        <title>Welcome</title>
</head>
<body>
    <h1> Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p> <a href="../php/logout.php"> Logout</a></p>
</body>
</html>
