<?php
require_once("../partials/header.php");
?>

<section class="blog-posts">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="all-blog-posts">
          <div class="row">
            <?php
            $posts = $QueryOperations->getPosts();
            foreach ($posts as $post):
              $commentCount = $post['comment_count'];
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
                      <li><a href="#"><?= $commentCount ?> Comments</a></li>
                    </ul>
                    <p><?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))) ?>...</p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>

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
                    // POSLEDNE 3
                    $recentPosts = $QueryOperations->getRecentPosts();
                    foreach ($recentPosts as $recent):
                      ?>
                      <li>
                        <a href="post-details.php?id=<?= htmlspecialchars($recent['id']) ?>">
                          <h5><?= htmlspecialchars($recent['title']) ?></h5>
                          <span><?= date('M d, Y', strtotime($recent['created_at'])) ?></span>
                        </a>
                      </li>
                    <?php endforeach; ?>
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
                    // KATEGORIE
                    $categories = $QueryOperations->getCategories();
                    foreach ($categories as $cat):
                      ?>
                      <li>
                        <a href="blog.php?category=<?= urlencode($cat['category']) ?>">
                          - <?= htmlspecialchars($cat['category']) ?>
                          (<?= $cat['post_count'] ?>)
                        </a>
                      </li>
                    <?php endforeach; ?>
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
            | Design: <a rel="nofollow" href="https://templatemo.com" target="_parent">TemplateMo</a>
            | <a href="login.php" style="color: inherit; text-decoration: none;">Admin Login</a> </p>
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