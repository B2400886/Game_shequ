<?php
// register.php - User Registration
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Password encryption
    $phone = $_POST['phone'] ?? null;
    $address = $_POST['address'] ?? null;

    // Check if the username already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->rowCount() > 0) {
        echo "Username already exists";
        exit;
    }

    // Insert new user
    $stmt = $pdo->prepare("INSERT INTO users (username, password, phone, address) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$username, $password, $phone, $address])) {
        echo "Registration successful";
        header("Location: login.php"); // Redirect to login page after successful registration
    } else {
        echo "Registration failed";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Game Community</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/forum_home.css">

</head>
<body>
<!-- 顶部导航栏 -->
<div class="navbar">
        <div class="logo">
            <a href="#">Game Community</a>
        </div>
        <div class="menu">
            <a href="./index.php">Home</a>
            <a href="./home.php">Game Community</a>
            <a href="./create_post.php">Create New Post</a>
            <a href="./about.php">About Us</a>
        </div>
    </div>

<div class="container">
    <div class="auth-form">
        <h2>Register</h2>
        <form action="register.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <label for="address">Address</label>
            <input type="text" id="address" name="address">

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</div>
</body>
</html>

