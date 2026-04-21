<?php
session_start();
require_once '../../app/core/Database.php';
require_once '../../app/models/AdminCheck.php';
require_once '../../app/models/QueryOperations.php'; 

$db = new Database();
$auth = new AdminCheck();
$QueryOperations = new QueryOperations($db);

$auth->loginCheck();

$message = '';
$messageType = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($QueryOperations->addPost($_POST, $_SESSION['admin_username'])) {
        $message = "Článok bol úspešne pridaný!";
        $messageType = "success";
    } else {
        $message = "Nastala chyba pri pridávaní článku.";
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add a new Post - F1 Admin</title>
    <link rel="stylesheet" href="../assets/css/add-post-style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">
</head>

<body>

    <div class="form-container">
        <h2>New Post</h2>
        
        <?php if ($message): ?>
            <?php 
                $bgColor = ($messageType === 'success') ? '#e8f5e9' : '#ffebee';
                $textColor = ($messageType === 'success') ? '#28a745' : '#e10600';
            ?>
            <div class="message" style="color: <?= $textColor ?>; background: <?= $bgColor ?>;">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form action="add-post.php" method="POST">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" placeholder="Názov článku" required>

            <label for="category">Category</label>
            <input type="text" id="category" name="category" placeholder="napr. Race Recap" required>

            <label for="image_url">Image URL</label>
            <input type="text" id="image_url" name="image_url" placeholder="https://media.formula1.com/image/..." required>

            <label for="content">Content</label>
            <textarea id="content" name="content" rows="10" placeholder="Write your text here..." required></textarea>

            <button type="submit">Publish Post</button>
        </form>

        <a href="admin.php" class="back-link">&larr; Back to Dashboard</a>
    </div>

</body>

</html>