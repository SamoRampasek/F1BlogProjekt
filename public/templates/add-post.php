<?php
require_once '../../app/models/Database.php';
require_once '../../app/models/AdminCheck.php';
require_once '../../app/models/BlogOperations.php';

$db = new Database();
session_start();

$auth = new AdminCheck();
$auth->loginCheck();

$blog = new BlogOperations($db);
?>
<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <title>Pridať nový článok</title>
    <link rel="stylesheet" href="../assets/css/add-post-style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">
</head>

<body>

    <div class="form-container">
        <h2>Nový príspevok</h2>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = $_POST['title'];
            $category = $_POST['category'];
            $content = $_POST['content'];
            $author = $_POST['author'];
            $image_url = $_POST['image_url'];

            if ($blog->addPost($title, $category, $content, $author, $image_url)) {
                echo "<div class='message' style='color: #28a745; background: #e8f5e9;'>Článok bol úspešne pridaný!</div>";
            } else {
                echo "<div class='message' style='color: #e10600; background: #ffebee;'>Nastala chyba.</div>";
            }
        }
        ?>

        <form action="add-post.php" method="POST">
            <label>Nadpis:</label>
            <input type="text" name="title" placeholder="Názov článku" required>

            <label>Kategória:</label>
            <input type="text" name="category" placeholder="napr. Race Recap" required>

            <label>Autor:</label>
            <input type="text" name="author" value="Admin" required>

            <label>URL obrázka:</label>
            <input type="text" name="image_url" placeholder="https://media.formula1.com/image/..." required>

            <label>Obsah článku:</label>
            <textarea name="content" rows="8" placeholder="Tu napíšte text..." required></textarea>

            <button type="submit">Publikovať článok</button>
        </form>

        <a href="admin.php" class="back-link">← Späť na hlavnú stránku</a>
    </div>

</body>

</html>