<?php require 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="TemplateMo">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
  <title>F1 Blog</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-stand-blog.css">
  <link rel="stylesheet" href="assets/css/owl.css">
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
        <a class="navbar-brand" href="index.php">
          <h2>F1 Blog<em>.</em></h2>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
          aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.php">About Us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="blog.php">Blog Entries</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="post-details.php">Post Details</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.php">Contact Us</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Page Content -->

  <section class="call-to-action">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="main-content">
            <div class="row">
              <div class="col-lg-8">
                <span>Stand Blog HTML5 Template</span>
                <h4>Create a new post!</h4>
              </div>
              <div class="col-lg-4">
                <div class="main-button">
                  <a href="add-post.php">Post Now!</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="blog-posts">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="all-blog-posts">
            <div class="row">

              <?php
              // clanky
              $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 4");
              while ($post = $stmt->fetch()):
                ?>
                <div class="col-lg-12">
                  <div class="blog-post">
                    <div class="blog-thumb">
                      <a href="<?= htmlspecialchars($post['image_url']) ?>" target="_blank">
                        <img src="<?= htmlspecialchars($post['image_url']) ?>"
                          alt="<?= htmlspecialchars($post['title']) ?>">
                      </a>
                    </div>
                    <div class="down-content">
                      <span><?= htmlspecialchars($post['category']) ?></span>
                      <a href="post-details.php?id=<?= $post['id'] ?>">
                        <h4><?= htmlspecialchars($post['title']) ?></h4>
                      </a>
                      <ul class="post-info">
                        <li><a href="#"><?= htmlspecialchars($post['author']) ?></a></li>
                        <li><a href="#"><?= date('M d, Y', strtotime($post['created_at'])) ?></a></li>
                        <li><a href="#">0 Comments</a></li>
                      </ul>
                      <p><?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))) ?>...</p>
                      <div class="post-options">
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>

              <div class="col-lg-12">
                <div class="main-button">
                  <a href="blog.php">View All Posts</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="sidebar">
            <div class="row">
              <div class="col-lg-12">
                <div class="sidebar-item search">
                  <form id="search_form" name="gs" method="GET" action="#">
                    <input type="text" name="q" class="searchText" placeholder="type to search..." autocomplete="on">
                  </form>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="sidebar-item recent-posts">
                  <div class="sidebar-heading">
                    <h2>Recent Posts</h2>
                  </div>
                  <div class="content">
                    <ul>
                      <?php
                      // najnovsie 3
                      $stmt_recent = $pdo->query("SELECT id, title, created_at FROM posts ORDER BY created_at DESC LIMIT 3");

                      while ($recent = $stmt_recent->fetch()):
                        ?>
                        <li>
                          <a href="post-details.php?id=<?= $recent['id'] ?>">
                            <h5><?= htmlspecialchars($recent['title']) ?></h5>
                            <span><?= date('M d, Y', strtotime($recent['created_at'])) ?></span>
                          </a>
                        </li>
                      <?php endwhile; ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="sidebar-item categories">
                  <div class="sidebar-heading">
                    <h2>Categories</h2>
                  </div>
                  <div class="content">
                    <ul>
                      <?php
                      // kategorie
                      $stmt_cats = $pdo->query("SELECT category, COUNT(*) as post_count FROM posts GROUP BY category ORDER BY category ASC");

                      while ($cat = $stmt_cats->fetch()):
                        ?>
                        <li>
                          <a href="blog.php?category=<?= urlencode($cat['category']) ?>">
                            - <?= htmlspecialchars($cat['category']) ?>
                            (<?= $cat['post_count'] ?>)
                          </a>
                        </li>
                      <?php endwhile; ?>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="sidebar-item tags">
                  <div class="sidebar-heading">
                    <h2>Tag Clouds</h2>
                  </div>
                  <div class="content">
                    <ul>
                      <li><a href="#">Lifestyle</a></li>
                      <li><a href="#">Creative</a></li>
                      <li><a href="#">HTML5</a></li>
                      <li><a href="#">Inspiration</a></li>
                      <li><a href="#">Motivation</a></li>
                      <li><a href="#">PSD</a></li>
                      <li><a href="#">Responsive</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <ul class="social-icons">
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Behance</a></li>
            <li><a href="#">Linkedin</a></li>
            <li><a href="#">Dribbble</a></li>
          </ul>
        </div>
        <div class="col-lg-12">
          <div class="copyright-text">
            <p>Copyright 2020 Stand Blog Co.
              | Design: <a rel="nofollow" href="https://templatemo.com" target="_parent">TemplateMo</a></p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="assets/js/custom.js"></script>
  <script src="assets/js/owl.js"></script>
  <script src="assets/js/slick.js"></script>
  <script src="assets/js/isotope.js"></script>
  <script src="assets/js/accordions.js"></script>

  <script language="text/Javascript">
    cleared[0] = cleared[1] = cleared[2] = 0;
    function clearField(t) {
      if (!cleared[t.id]) {
        cleared[t.id] = 1;
        t.value = '';
        t.style.color = '#fff';
      }
    }
  </script>

</body>

</html>