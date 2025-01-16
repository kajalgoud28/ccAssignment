<?php
// Simulate user data - in a real application, you'd query a database
$users = [
    'user1' => 'password1',
    'user2' => 'password2'
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    if (array_key_exists($username, $users) && $users[$username] == $password) {
        echo 'Login successful! Welcome, ' . htmlspecialchars($username) . '!';
    } else {
        echo 'Invalid username or password.';
    }
}
?>
