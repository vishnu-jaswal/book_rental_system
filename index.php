<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Redirect based on role
        if ($user['role'] == 'librarian') {
            header("Location: librarian_dashboard.php?user=" . $username);
        } else if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php?user=" . $username);
        } else {
            header("Location: dashboard.php?user=" . $username);
        }
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>User Login</h1>
    <form action="index.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="registration.php">Register here</a>.</p>
</body>

</html>