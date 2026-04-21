<?php
session_start();
require_once '../../app/core/Database.php';
require_once '../../app/core/Login.php';

$db = new Database();
$login = new Login($db);
$login->checkSession();
$error = $login->processForm();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../assets/css/admin-login.css">
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