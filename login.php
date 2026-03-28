<?php
session_start();
require 'db.php';

// redirect ak je loginnuty
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin.php");
    exit;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // vytiahnutie admina
    $stmt = $pdo->prepare("SELECT admin_id, username, password_hash FROM admins WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch();

    // password kontrola
    if ($admin && password_verify($password, $admin['password_hash'])) {
        // success
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        
        // redirect
        header("Location: admin.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/admin-login.css">
    <title>Admin Login</title>
    </head>
<body>
    <div style="max-width: 400px; margin: 100px auto; padding: 20px; border: 1px solid #ccc;">
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <div style="margin-bottom: 10px;">
                <label>Username:</label>
                <input type="text" name="username" required style="width: 100%;">
            </div>
            <div style="margin-bottom: 10px;">
                <label>Password:</label>
                <input type="password" name="password" required style="width: 100%;">
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>