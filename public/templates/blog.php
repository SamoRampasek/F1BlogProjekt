<?php
require_once("../partials/header.php");

// CATEGORY FILTER
$display_category = "";
$selected_category = null;
if (isset($_GET['category']) && !empty($_GET['category'])) {
  $selected_category = $_GET['category'];
  $display_category = htmlspecialchars($selected_category);
}

$posts = $QueryOperations->getAllPosts($selected_category);
?>


<section class="blog-posts grid-system">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="all-blog-posts">
          <div class="row">
            <?php if (!empty($display_category)): ?>
              <div class="col-lg-12">
                <div style="margin-bottom: 40px; padding-bottom: 15px; border-bottom: 3px solid #ff0000;">
                  <h2
                    style="font-size: 32px; text-transform: uppercase; font-weight: 900; letter-spacing: 1px; color: #ff0000; margin: 0;">
                    Category - <?= $display_category ?>
                  </h2>
                </div>
              </div>
            <?php endif; ?>

            <?php if (count($posts) > 0): ?>
              <?php foreach ($posts as $post): ?>
                <div class="col-lg-6 d-flex align-items-stretch">

                  <div class="blog-post w-100 d-flex flex-column">

                    <div class="blog-thumb">
                      <img src="<?= htmlspecialchars($post['image_url'] ?: '../assets/images/blog-thumb-01.jpg') ?>" alt="">
                    </div>

                    <div class="down-content d-flex flex-column flex-grow-1">
                      <span><?= htmlspecialchars($post['category']) ?></span>
                      <a href="post-details.php?id=<?= $post['id'] ?>">
                        <h4><?= htmlspecialchars($post['title']) ?></h4>
                      </a>
                      <ul class="post-info">
                        <li><a href="#"><?= htmlspecialchars($post['author']) ?></a></li>
                        <li><a href="#"><?= date('M d, Y', strtotime($post['created_at'])) ?></a></li>
                      </ul>

                      <p class="flex-grow-1"><?= htmlspecialchars(substr($post['content'], 0, 100)) ?>...</p>
                    </div>

                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="col-lg-12">
                <p>No posts found in this category. <a href="blog.php">View all posts</a></p>
              </div>
            <?php endif; ?>

            <div class="col-lg-12">
              <ul class="page-numbers">
                <li class="active"><a href="#">1</a></li>
                <li><a href="#"><i class="fa fa-angle-double-right"></i></a></li>
              </ul>
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