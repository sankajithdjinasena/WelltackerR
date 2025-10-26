<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/community.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/png" href="image/Logo_R.png">


</head>
<body>
    <nav>
    <div class="nav-header">
      <div class="nav-logo"><img src="image/Logo_R.png" alt="Logo"></div>
      <div class="nav-title">
        <h1>WellTrackeR</h1>
      </div>
    </div>

    <!-- Hamburger Menu -->
    <i class='bx bx-menu menu-toggle'></i>

    <div class="nav-links">
      <a href="index.php" >Home</a>
      <a href="about.php">About</a>
      <a href="community.php" id="active">Community</a>
      <a href="contact.php">Contact</a>
      <a href="login.php" class="login-btn">Login</a>
      <a href="register.php" class="register-btn">Register</a>
    </div>
  </nav>
    <!-- COMMUNITY PAGE START -->
<section class="community-header">
  <h1>Community Forum</h1>
  <p>Share your ideas, ask questions, and connect with others in the community.</p>
</section>

<!-- Post Form -->
<section class="community-post-form">
  <h2>Create a Post</h2>
  <form>
    <div class="form-group">
      <label for="post-title">Title</label>
      <input type="text" id="post-title" placeholder="Enter your post title" required>
    </div>

    <div class="form-group">
      <label for="post-message">Message</label>
      <textarea id="post-message" placeholder="Write your message..." required></textarea>
    </div>

    <button type="submit" class="post-submit-btn">Post Message <i class='bx bx-send'></i></button>
  </form>
</section>

<!-- Posts Feed -->
<section class="community-posts">
  <h2>Recent Posts</h2>

  <!-- Example Post Card -->
  <div class="post-card">
    <div class="post-header">
      <div class="post-user">
        <img src="https://i.pravatar.cc/60?img=12" alt="User">
        <div>
          <h4>John Doe</h4>
          <span>2 hours ago</span>
        </div>
      </div>
    </div>

    <div class="post-content">
      <h3>How to start learning Machine Learning?</h3>
      <p>I’m new to Data Science and would love to know how others started learning ML effectively.</p>
    </div>

    <div class="post-actions">
      <button><i class='bx bx-like'></i> Like</button>
      <button><i class='bx bx-message-dots'></i> Reply</button>
    </div>

    <!-- Replies -->
    <div class="post-replies">
      <div class="reply">
        <img src="https://i.pravatar.cc/40?img=8" alt="User">
        <div class="reply-content">
          <h5>Sarah Lee</h5>
          <p>Start with Python basics and move to scikit-learn. Kaggle is great for practice!</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Another Example -->
  <div class="post-card">
    <div class="post-header">
      <div class="post-user">
        <img src="https://i.pravatar.cc/60?img=5" alt="User">
        <div>
          <h4>Emma Watson</h4>
          <span>5 hours ago</span>
        </div>
      </div>
    </div>

    <div class="post-content">
      <h3>Best free datasets for projects?</h3>
      <p>Looking for websites that provide interesting free datasets for student projects.</p>
    </div>

    <div class="post-actions">
      <button><i class='bx bx-like'></i> Like</button>
      <button><i class='bx bx-message-dots'></i> Reply</button>
    </div>
  </div>
</section>
<!-- COMMUNITY PAGE END -->
  <footer>
    <div class="social">
      <h2>Follow us</h2>
      <div class="social-media">
        <a href="#"> <i class='bx bxl-facebook'></i></a>
        <a href="#"> <i class='bx bxl-instagram'></i></a>
        <a href="#"> <i class='bx bxl-twitter'></i></a>
      </div>
    </div>

    <div class="footer-links">
      <a href="privacy.php">Privacy Policy</a>
      <a href="terms.php">Terms of Service</a>
      <a href="contact.php">Contact Us</a>
    </div>
    <p>&copy; 2025 WellTrackeR. All rights reserved.</p>
  </footer>
</body>
<script src="js/script.js"></script>

</html>