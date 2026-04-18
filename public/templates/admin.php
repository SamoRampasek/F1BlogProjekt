<?php
session_start();
require_once '../../app/models/Database.php';
require_once '../../app/models/AdminCheck.php';
require_once '../../app/models/BlogOperations.php';
require_once '../../app/models/QueryOperations.php';

$db = new Database();

$auth = new AdminCheck();
$auth->loginCheck();

$BlogOperations = new BlogOperations($db);
$QueryOperations = new QueryOperations($db);

if (isset($_GET['delete_id'])) {
  $id = (int) $_GET['delete_id'];

  $BlogOperations->deletePost($id);

  header("Location: admin.php");
  exit;
}

if (isset($_GET['delete_message_id'])) {
  $id = (int) $_GET['delete_message_id'];

  $BlogOperations->deleteMessage($id);

  header("Location: admin.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link
    href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap"
    rel="stylesheet">
  <title>F1 Blog - Admin Panel</title>

  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-stand-blog.css">
  <link rel="stylesheet" href="../assets/css/owl.css">

  <style>
    .admin-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      background: #fff;
    }
    .admin-table th {
      background: #f4f4f4;
      padding: 15px;
      text-transform: uppercase;
      font-size: 13px;
      border-bottom: 2px solid #e10600;
    }
    .admin-table td {
      padding: 15px;
      border-bottom: 1px solid #eee;
      vertical-align: middle;
    }
    .btn-delete {
      color: #e10600;
      font-weight: bold;
      margin-left: 10px;
      cursor: pointer;
    }
    .btn-edit {
      color: #007bff;
      font-weight: bold;
    }
    .admin-header-flex {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }
  </style>
</head>

<body>
  <header class="background-header">
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="home.php">
          <h2>F1 Blog<em>.</em></h2>
        </a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="home.php">View Site</a></li>
            <li class="nav-item active"><a class="nav-link" href="admin.php">Admin Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section class="blog-posts" style="margin-top: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="admin-header-flex">
            <h2
              style="border-left: 5px solid #e10600; padding-left: 15px; text-transform: uppercase; font-weight: 900;">
              Manage Posts</h2>
            <div class="main-button">
              <a href="add-post.php"
                style="background-color: #e10600; color: white; padding: 10px 20px; border-radius: 4px;">+ Create New
                Post</a>
            </div>
          </div>

          <div class="all-blog-posts">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Title</th>
                  <th>Category</th>
                  <th>Author</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // POSTY
                $posts = $QueryOperations->getAllPosts();
                foreach ($posts as $post):
                  ?>
                  <tr>
                    <td><?= date('M d, Y', strtotime($post['created_at'])) ?></td>
                    <td><strong><?= htmlspecialchars($post['title']) ?></strong></td>
                    <td><?= htmlspecialchars($post['category']) ?></td>
                    <td><?= htmlspecialchars($post['author']) ?></td>
                    <td>
                      <a href="edit-post.php?id=<?= $post['id'] ?>" class="btn-edit"><i class="fa fa-edit"></i> Edit</a>
                      <a href="admin.php?delete_id=<?= $post['id'] ?>" class="btn-delete"
                        onclick="return confirm('Are you sure you want to delete this post?')"><i class="fa fa-trash"></i>
                        Delete</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="blog-posts" style="margin-top: 50px;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="admin-header-flex">
            <h2
              style="border-left: 5px solid #e10600; padding-left: 15px; text-transform: uppercase; font-weight: 900;">
              User Messages</h2>
          </div>

          <div class="all-blog-posts">
            <table class="admin-table">
              <thead>
                <tr>
                  <th>Subject</th>
                  <th>Message</th>
                  <th>Email</th>
                  <th>Created at</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // SPRAVY
                $messages = $QueryOperations->getAllMessages();
                foreach ($messages as $message):
                  ?>
                  <tr>
                    <td><?= htmlspecialchars($message['subject']) ?></td>
                    <td><strong><?= htmlspecialchars($message['message']) ?></strong></td>
                    <td><?= htmlspecialchars($message['email']) ?></td>
                    <td><?= date('M d, Y', strtotime($message['created_at'])) ?></td>
                    <td>
                      <a href="admin.php?delete_message_id=<?= $message['message_id'] ?>" class="btn-delete"
                        onclick="return confirm('Are you sure you want to delete this message?')"><i
                          class="fa fa-trash"></i>
                        Delete</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="copyright-text">
            <p>Copyright 2026 F1 Blog Admin | Welcome, <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/custom.js"></script>
</body>

</html>