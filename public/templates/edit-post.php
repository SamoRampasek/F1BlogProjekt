<?php
session_start();
require '../../app/models/Database.php';
require_once '../../app/models/AdminCheck.php'; 
require_once '../../app/models/QueryOperations.php';
require_once '../../app/core/Helper.php';

$db = new Database();
$auth = new AdminCheck();
$queryOps = new QueryOperations($db);

$auth->loginCheck();

$id = $_GET['id'] ?? null;
if (!$id) {
    Helper::redirect("admin.php");
}


$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($queryOps->updatePost((int)$id, $_POST)) {
        Helper::redirect("admin.php");
    } else {
        $message = "Something went wrong updating the post.";
    }
}

$post = $queryOps->getPostById((int)$id);

if (!$post) {
    Helper::redirect("admin.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Post - F1 Admin</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/add-post-style.css">
</head>
<body>

    <div class="form-container">
        <h2>Edit Post</h2>
        
        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        
        <form method="POST" action="edit-post.php?id=<?= htmlspecialchars($post['id']) ?>">
            
            <label for="title">Title</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>

            <label for="category">Category</label>
            <input type="text" id="category" name="category" value="<?= htmlspecialchars($post['category']) ?>" required>

            <label for="author">Author</label>
            <input type="text" id="author" name="author" value="<?= htmlspecialchars($post['author']) ?>" required>

            <label for="image_url">Image URL</label>
            <input type="text" id="image_url" name="image_url" value="<?= htmlspecialchars($post['image_url']) ?>" required>

            <label for="content">Content</label>
            <textarea id="content" name="content" rows="10" required><?= htmlspecialchars($post['content']) ?></textarea>

            <button type="submit">Update Post</button>
        </form>

        <a href="admin.php" class="back-link">&larr; Back to Dashboard</a>
    </div>

</body>
</html>