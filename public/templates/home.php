<?php
require_once("../partials/header.php");
//echo password_hash("123", PASSWORD_DEFAULT);

$posts = $QueryOperations->getPosts();
?>

<section class="blog-posts">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="all-blog-posts">
          <div class="row">
            <?php
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
                    <p><?= htmlspecialchars(substr($post['content'], 0, 200)) ?>...</p>
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
                    $categoryegories = $QueryOperations->getCategories();
                    foreach ($categoryegories as $category):
                      ?>
                      <li>
                        <a href="blog.php?category=<?= urlencode($category['category']) ?>">
                          - <?= htmlspecialchars($category['category']) ?>
                          (<?= $category['post_count'] ?>)
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

<?php
require_once("../partials/footer.php");
?>