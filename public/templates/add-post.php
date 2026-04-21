<?php
session_start();
require_once '../../app/models/Database.php';
require_once '../../app/models/AdminCheck.php';
require_once '../../app/models/QueryOperations.php'; 

$db = new Database();
$auth = new AdminCheck();
$queryOps = new QueryOperations($db);

$auth->loginCheck();

$message = '';
$messageType = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($queryOps->addPost($_POST)) {
        $message = "Článok bol úspešne pridaný!";
        $messageType = "success";
    } else {
        $message = "Nastala chyba pri pridávaní článku.";
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pridať nový článok - F1 Admin</title>
    <link rel="stylesheet" href="../assets/css/add-post-style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">
</head>

<body>

    <div class="form-container">
        <h2>Nový príspevok</h2>
        
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
            <label for="title">Nadpis:</label>
            <input type="text" id="title" name="title" placeholder="Názov článku" required>

            <label for="category">Kategória:</label>
            <input type="text" id="category" name="category" placeholder="napr. Race Recap" required>

            <label for="author">Autor:</label>
            <input type="text" id="author" name="author" value="Admin" required>

            <label for="image_url">URL obrázka:</label>
            <input type="text" id="image_url" name="image_url" placeholder="https://media.formula1.com/image/..." required>

            <label for="content">Obsah článku:</label>
            <textarea id="content" name="content" rows="8" placeholder="Tu napíšte text..." required></textarea>

            <button type="submit">Publikovať článok</button>
        </form>

        <a href="admin.php" class="back-link">&larr; Späť na hlavnú stránku</a>
    </div>

</body>

</html>