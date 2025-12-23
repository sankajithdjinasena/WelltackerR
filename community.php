<?php
include 'config.php';

// ---------- Handle new post ----------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_post'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']); # to escape special characters in a string before it is used in an SQL query
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);

    if (!empty($title) && !empty($message)) {
        $conn->query("INSERT INTO community_posts (title, message, author) VALUES ('$title', '$message', '$author')");
        echo "
              <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
              <script>
              Swal.fire({
                  title: 'Success!',
                  text: 'Post created successfully!',
                  icon: 'success',
                  confirmButtonText: 'OK'
              }).then(() => {
                  window.location = 'community.php';
              });
              </script>
              ";

    } else {
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
            title: 'Oops!',
            text: 'Please fill all fields.',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        </script>
        ";
    }
}

// ---------- Handle likes ----------
if (isset($_GET['like'])) {
    $post_id = (int)$_GET['like'];
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // prevent duplicate likes from same IP
    $check = $conn->query("SELECT * FROM community_likes WHERE post_id=$post_id AND user_ip='$user_ip'");
    if ($check->num_rows == 0) {
        $conn->query("INSERT INTO community_likes (post_id, user_ip) VALUES ($post_id, '$user_ip')");
    }
    header("Location: community.php");
    exit;
}

// ---------- Handle replies ----------
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reply_post'])) {
    $post_id = (int)$_POST['post_id'];
    $reply_text = mysqli_real_escape_string($conn, $_POST['reply_text']);
    $reply_author = mysqli_real_escape_string($conn, $_POST['reply_author']);

    if (!empty($reply_text) && !empty($reply_author)) {
        $conn->query("INSERT INTO community_replies (post_id, reply_text, author) VALUES ($post_id, '$reply_text', '$reply_author')");
        header("Location: community.php");
        exit;
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
            title: 'Hey!',
            text: 'Please enter your name and reply.',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Community | WellTrackeR</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/community.css">
  <link rel="icon" type="image/png" href="image/Logo_R.png">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>



<body>
  <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<df-messenger
  intent="WELCOME"
  chat-title="WelltrackeR"
  agent-id="9d5f2420-6826-4916-9e73-235b856a1965"
  language-code="en"
></df-messenger>

<nav>
  <div class="nav-header">
    <div class="nav-logo"><img src="image/Logo_R.png" alt="Logo"></div>
    <div class="nav-title"><h1>WellTrackeR</h1></div>
  </div>
  <i class='bx bx-menu menu-toggle'></i>
  <div class="nav-links">
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="community.php" id="active">Community</a>
    <a href="contact.php">Contact</a>
    <a href="login.php" class="login-btn">Login</a>
    <a href="register.php" class="register-btn">Register</a>
  </div>
</nav>

<section class="community-header">
  <h1>Community Forum</h1>
  <p>Share your ideas, ask questions, and connect with others in the community.</p>
</section>

<!-- Post Form -->
<section class="community-post-form">
  <h2>Create a Post</h2>
  <form method="POST" action="">
    <input type="hidden" name="new_post" value="1">
    <div class="form-group">
      <label for="name">Your Name</label>
      <input type="text" id="name" name="author" placeholder="Enter your name" required>
    </div>
    <div class="form-group">
      <label for="post-title">Title</label>
      <input type="text" id="post-title" name="title" placeholder="Enter your post title" required>
    </div>
    <div class="form-group">
      <label for="post-message">Message</label>
      <textarea id="post-message" name="message" placeholder="Write your message..." required></textarea>
    </div>
    <button type="submit" class="post-submit-btn">Post Message <i class='bx bx-send'></i></button>
  </form>
</section>

<!-- Recent Posts -->
<section class="community-posts">
  <h2>Recent Posts</h2>
  <?php
  $result = $conn->query("SELECT * FROM community_posts ORDER BY created_at DESC LIMIT 5");
  if ($result->num_rows > 0):
      while ($row = $result->fetch_assoc()):
          $post_id = $row['post_id'];
          $likes = $conn->query("SELECT COUNT(*) AS c FROM community_likes WHERE post_id=$post_id")->fetch_assoc()['c'];
  ?>
  <div class="post-card">
    <div class="post-header">
      <div class="post-user">
        <img src="https://i.pravatar.cc/60?u=<?= $row['author'] ?>" alt="User">
        <div>
          <h4><?= htmlspecialchars($row['author']) ?></h4>
          <span><?= date("M d, Y h:i A", strtotime($row['created_at'])) ?></span>
        </div>
      </div>
    </div>

    <div class="post-content">
      <h3><?= htmlspecialchars($row['title']) ?></h3>
      <p><?= nl2br(htmlspecialchars($row['message'])) ?></p>
    </div>

    <div class="post-actions">
      <button onclick="toggleReply(<?= $post_id ?>)"><i class='bx bx-message-dots'></i> Reply</button>
    </div>

    <!-- Reply Form -->
    <div id="reply-box-<?= $post_id ?>" style="display:none; margin:10px 0;">
      <form method="POST" action="">
        <input type="hidden" name="reply_post" value="1">
        <input type="hidden" name="post_id" value="<?= $post_id ?>">
        <input type="text" id="reply-author" name="reply_author" placeholder="Your Name" required>
        <textarea name="reply_text" placeholder="Write your reply..." required></textarea>
        <button type="submit" class="post-submit-btn">Reply</button>
      </form>
    </div>

    <!-- Replies -->
    <?php
      $replies = $conn->query("SELECT * FROM community_replies WHERE post_id=$post_id ORDER BY created_at DESC LIMIT 5");
      if ($replies->num_rows > 0):
    ?>
    <div class="post-replies">
      <?php while ($r = $replies->fetch_assoc()): ?>
        <div class="reply">
          <img src="https://i.pravatar.cc/40?u=<?= $r['author'] ?>" alt="User">
          <div class="reply-content">
            <h5><?= htmlspecialchars($r['author']) ?></h5>
            <p><?= nl2br(htmlspecialchars($r['reply_text'])) ?></p>
            <p>Posted: <?= htmlspecialchars($r['created_at']) ?></p>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
    <?php endif; ?>
  </div>
  <?php endwhile; else: ?>
    <p>No posts yet. Be the first to share something!</p>
  <?php endif; ?>
</section>

<footer>
  <div class="social">
    <h2>Follow us</h2>
    <div class="social-media">
      <a href="#"><i class='bx bxl-facebook'></i></a>
      <a href="#"><i class='bx bxl-instagram'></i></a>
      <a href="#"><i class='bx bxl-twitter'></i></a>
    </div>
  </div>
  <div class="footer-links">
    <a href="privacy.php">Privacy Policy</a>
    <a href="terms.php">Terms of Service</a>
    <a href="contact.php">Contact Us</a>
  </div>
  <p>&copy; 2025 WellTrackeR. All rights reserved.</p>
</footer>

<script>
function toggleReply(id) {
  const box = document.getElementById("reply-box-" + id);
  box.style.display = box.style.display === "none" ? "block" : "none";
}
</script>
</body>
</html>
