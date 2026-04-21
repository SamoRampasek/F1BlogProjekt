<?php
require_once("../partials/header.php");

if (isset($_GET['id'])) {
  $id = (int) $_GET['id'];
  $post = $QueryOperations->getPostById($id);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $wasAdded = $QueryOperations->commentControl($id, $_POST);

    if ($wasAdded) {
      header("Location: post-details.php?id=" . $id);
      exit;
    }
  }

  $comments = $QueryOperations->getComments($id);
  $commentCount = count($comments);
}
?>

<section class="blog-posts grid-system">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="all-blog-posts">
          <div class="row">
            <div class="col-lg-12">
              <div class="blog-post">
                <div class="blog-thumb">
                  <a href="<?= htmlspecialchars($post['image_url'] ?? '') ?>" target="_blank">
                    <img src="<?= htmlspecialchars($post['image_url'] ?? '') ?>" alt="">
                  </a>
                </div>
                <div class="down-content">
                  <span><?= htmlspecialchars($post['category'] ?? 'General') ?></span>
                  <a href="#">
                    <h4><?= htmlspecialchars($post['title'] ?? '') ?></h4>
                  </a>
                  <ul class="post-info">
                    <li><a href="#"><?= htmlspecialchars($post['author'] ?? 'Admin') ?></a></li>
                    <li><a href="#"><?= date('M d, Y', strtotime($post['created_at'] ?? 'now')) ?></a></li>
                    <li><a href="#"><?= $commentCount ?> Comments</a></li>
                  </ul>
                  <p><?= nl2br(htmlspecialchars($post['content'] ?? '')) ?></p>
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="sidebar-item comments">
                <div class="sidebar-heading">
                  <h2><?= $commentCount ?> comments</h2>
                </div>
                <div class="content">
                  <ul>
                    <?php if ($commentCount > 0): ?>
                      <?php foreach ($comments as $comment): ?>
                        <li>
                          <div class="author-thumb">
                            <img src="../assets/images/user.jpg" alt="User Avatar">
                          </div>
                          <div class="right-content">
                            <h4>
                              <?= htmlspecialchars($comment['name']) ?><span><?= date('M d, Y', strtotime($comment['created_at'])) ?></span>
                            </h4>
                            <p><?= nl2br(htmlspecialchars($comment['message'])) ?></p>
                          </div>
                        </li>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <li>
                        <p>No comments yet. Be the first to share your thoughts!</p>
                      </li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="sidebar-item submit-comment">
                <div class="sidebar-heading">
                  <h2>Your comment</h2>
                </div>
                <div class="content">
                  <form id="comment" action="post-details.php?id=<?= $id ?>" method="POST">
                    <div class="row">
                      <div class="col-md-6 col-sm-12">
                        <fieldset>
                          <input name="name" type="text" id="name" placeholder="Your name" required="">
                        </fieldset>
                      </div>
                      <div class="col-md-6 col-sm-12">
                        <fieldset>
                          <input name="email" type="email" id="email" placeholder="Your email" required="">
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          <textarea name="message" rows="6" id="message" placeholder="Type your comment"
                            required=""></textarea>
                        </fieldset>
                      </div>
                      <div class="col-lg-12">
                        <fieldset>
                          <button type="submit" name="submit_comment" id="form-submit"
                            class="main-button">Submit</button>
                        </fieldset>
                      </div>
                    </div>
                  </form>
                </div>
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
                      $recentPosts = $QueryOperations->getRecentPosts();
                      foreach ($recentPosts as $recent):
                    ?>
                      <li>
                        <a href="post-details.php?id=<?= $recent['id'] ?>">
                          <h5><?= htmlspecialchars($recent['title']) ?></h5>
                          <span><?= date('M d, Y', strtotime($recent['created_at'])) ?></span>
                        </a>
                      </li>
                    <?php endforeach; ?>
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