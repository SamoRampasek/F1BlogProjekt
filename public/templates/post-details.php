<?php
require_once("../partials/header.php");

if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  // najdenie postu
  $prikaz = $db->prepare("SELECT * FROM posts WHERE id = ?");
  $prikaz->execute([$id]);
  $post = $prikaz->fetch();

  if (!$post) {
    die("Článok nebol nájdený!");
  }
  // novy comment
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
      $name = trim($_POST['name'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $message = trim($_POST['message'] ?? '');
      // kontrola
      if (!empty($name) && !empty($email) && !empty($message)) {
          $insertStmt = $db->prepare("INSERT INTO comments (name, email, message, post_id) VALUES (?, ?, ?, ?)");
          $insertStmt->execute([$name, $email, $message, $id]);
          
          // refresh
          header("Location: post-details.php?id=" . $id);
          exit;
      }
  }
  // vytiahnutie commentov
  $commentsStmt = $db->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC");
  $commentsStmt->execute([$id]);
  $comments = $commentsStmt->fetchAll();
  $commentCount = count($comments);

} else {
  die("Neznáme ID článku.");
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
                              <h4><?= htmlspecialchars($comment['name']) ?><span><?= date('M d, Y', strtotime($comment['created_at'])) ?></span></h4>
                              <p><?= nl2br(htmlspecialchars($comment['message'])) ?></p>
                            </div>
                          </li>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <li><p>No comments yet. Be the first to share your thoughts!</p></li>
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
                            <textarea name="message" rows="6" id="message" placeholder="Type your comment" required=""></textarea>
                          </fieldset>
                        </div>
                        <div class="col-lg-12">
                          <fieldset>
                            <button type="submit" name="submit_comment" id="form-submit" class="main-button">Submit</button>
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
                      // 3 posledne
                      $prikaz_recent = $db->query("SELECT id, title, created_at FROM posts ORDER BY created_at DESC LIMIT 3");

                      while ($recent = $prikaz_recent->fetch()):
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
          <div class="copyright-text">
            <p>Copyright 2020 Stand Blog Co. | Design: <a rel="nofollow" href="https://templatemo.com" target="_parent">TemplateMo</a></p>
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
</body>
</html>