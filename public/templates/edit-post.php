<?php
session_start();
require '../../app/models/Database.php';
require_once '../../app/models/AdminCheck.php'; 
$db = new Database();
$auth = new AdminCheck();
$auth->loginCheck();
// id kontrola pre istotu
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit;
}
$id = $_GET['id'];
$message = '';

// updatovanie postu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $image_url = $_POST['image_url'];
    $content = $_POST['content'];
    // update v db
    $prikaz = $db->prepare("UPDATE posts SET title = ?, category = ?, author = ?, image_url = ?, content = ? WHERE id = ?");
    
    if ($prikaz->execute([$title, $category, $author, $image_url, $content, $id])) {
        // redirect
        header("Location: admin.php");
        exit;
    } else {
        $message = "Something went wrong updating the post.";
    }
}

// vytiahnutie dat pre form
$prikaz = $db->prepare("SELECT * FROM posts WHERE id = ?");
$prikaz->execute([$id]);
$post = $prikaz->fetch();
// error handlovanie
if (!$post) {
    header("Location: admin.php");
    exit;
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
        
        <form method="POST" action="edit-post.php?id=<?= $post['id'] ?>">
            
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