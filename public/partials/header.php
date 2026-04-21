<?php
session_start();
require '../../app/core/Database.php';
require_once("../../app/models/QueryOperations.php");

$db = new Database();
$QueryOperations = new QueryOperations($db);

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap"
        rel="stylesheet">
    <title>F1 Blog</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/fontawesome.css">
    <link rel="stylesheet" href="../assets/css/templatemo-stand-blog.css">
    <link rel="stylesheet" href="../assets/css/owl.css">
</head>

<body>
    <div id="preloader">
        <div class="jumper">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <!-- Header -->
    <header class="background-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="home.php">
                    <h2>F1 Blog<em>.</em></h2>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item <?= ($current_page == 'home.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="home.php">Home
                            <?= ($current_page == 'home.php') ? '<span class="sr-only">(current)</span>' : ''; ?>
                        </a>
                    </li>

                    <li class="nav-item <?= ($current_page == 'about.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="about.php">About Us
                            <?= ($current_page == 'about.php') ? '<span class="sr-only">(current)</span>' : ''; ?>
                        </a>
                    </li>

                    <li class="nav-item <?= ($current_page == 'blog.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="blog.php">Blog Entries
                            <?= ($current_page == 'blog.php') ? '<span class="sr-only">(current)</span>' : ''; ?>
                        </a>
                    </li>

                    <li class="nav-item <?= ($current_page == 'contact.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="contact.php">Contact Us
                            <?= ($current_page == 'contact.php') ? '<span class="sr-only">(current)</span>' : ''; ?>
                        </a>
                    </li>

                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true): ?>
                        <li class="nav-item <?= ($current_page == 'admin.php') ? 'active' : ''; ?>">
                            <a class="nav-link" href="admin.php">Admin Dashboard
                                <?= ($current_page == 'admin.php') ? '<span class="sr-only">(current)</span>' : ''; ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>