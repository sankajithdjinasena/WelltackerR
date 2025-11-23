<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WellTrackeR</title>
  <link rel="icon" type="image/png" href="image/Logo_R.png">
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
 <style>
        :root {
            --pcolor: #123456; 
            --text-light: #ffffff;
            --text-muted: #cccccc;
            --gradient-hero: linear-gradient(to bottom, rgba(0,0,0,0.9), rgba(0,0,0,0.1));
        }

        .header {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            text-align: left;
            height: 90vh;
            padding: 40px 80px;
            background-image: url('image/background.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: var(--pcolor);
            background-blend-mode: overlay;
            color: var(--text-light);
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-hero);
            opacity: 0.2;
            z-index: 1;
        }

        .header_title {
            position: relative;
            z-index: 2;
            max-width: 1000px;
        }
.header_title h1 {
    font-size: 74px;
    font-weight: 700;
    margin-bottom: 15px;
    line-height: 1.2;

    /* Soft gradient */
    background: linear-gradient(90deg, #ff6b6b, #7a5af5, #48dbfb, #ffb86c);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;

    animation: gradientDrift 8s ease-in-out infinite;
}

@keyframes gradientDrift {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}




        .header_title h3 {
            font-size: 32px;
            font-weight: 500;
            margin-bottom: 20px;
            line-height: 1.3;
            text-align: left;
        }

        .header_title p {
            font-size: 20px;
            font-weight: 400;
            max-width: 600px;
            margin: 0 auto 30px auto;
            line-height: 1.6;
            color: var(--text-muted);
        }
        
.nav-links a.login-btn{
  color: var(--text-light);
  border: 1px solid var(--text-light);
}
.nav-links a.login-btn:hover{
  background-color: var(--text-light);
  color: var(--pcolor);
}
    </style>
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
      <div class="nav-title">
        <h1>WellTrackeR</h1>
      </div>
    </div>

    <!-- Hamburger Menu -->
    <i class='bx bx-menu menu-toggle'></i>

    <div class="nav-links">
      <a href="index.php" id="active">Home</a>
      <a href="about.php">About</a>
      <a href="community.php">Community</a>
      <a href="contact.php">Contact</a>
      <a href="login.php" class="login-btn">Login</a>
      <a href="register.php" class="register-btn">Register</a>
    </div>
  </nav>

  <div class="header">
    <div class="header_title">
      <h1>Welcome to WellTrackeR</h1>
      <h3>Your Health,
        Intelligently Tracked</h3>
      <p style="color: #fff;">Track your health and wellness with ease using WellTrackeR. Our intuitive platform helps you monitor your
        fitness, nutrition, and overall well-being in one convenient place.</p>
      <a href="register.php" class="get-started-btn">Get Started</a>
    </div>
  </div>

  <div class="counters">
    <div class="counter_box">
      <h2>50+</h2>
      <p>Active Users</p>
    </div>
    <div class="counter_box">
      <h2>10</h2>
      <p>Healthcare Providers</p>
    </div>
    <div class="counter_box">
      <h2>100+</h2>
      <p>Health Records</p>
    </div>
    <div class="counter_box">
      <h2>99.9%</h2>
      <p>System Uptime</p>
    </div>
  </div>

  <section class="features-section">
    <h2>Comprehensive Health Management</h2>
    <p>Advanced features designed to revolutionize how you monitor and manage health data</p>

    <div class="features-grid">
      <div class="feature-card">
        <i class='bx bx-pulse'></i>
        <h3>Real-time Vitals Tracking</h3>
        <p>Monitor blood pressure, heart rate, blood sugar, and weight with intelligent trend analysis</p>
      </div>

      <div class="feature-card">
        <i class='bx bx-trending-up'></i>
        <h3>AI Health Insights</h3>
        <p>Get personalized recommendations and early risk detection powered by machine learning</p>
      </div>

      <div class="feature-card">
        <i class='bx bx-shield'></i>
        <h3>Secure & Private</h3>
        <p>Enterprise-grade security ensures your health data remains confidential and protected</p>
      </div>

      <div class="feature-card">
        <i class='bx bx-group'></i>
        <h3>Multi-Role Access</h3>
        <p>Seamless collaboration between patients, doctors, and healthcare administrators</p>
      </div>

      <div class="feature-card">
        <i class='bx bx-heart'></i>
        <h3>Preventive Care Focus</h3>
        <p>Early warning systems and health coaching to prevent complications before they occur</p>
      </div>

      <div class="feature-card">
        <i class='bx bx-plus-medical'></i>
        <h3>Doctor Integration</h3>
        <p>Healthcare providers can monitor patient progress and provide remote consultations</p>
      </div>
    </div>
  </section>
  <section class="cta-section">
    <div class="cta-content">
      <h2>Ready to Transform Your Health Journey?</h2>
      <p>Join thousands of users who trust WellTrackeR for their daily health monitoring and medical care coordination.
      </p>
      <a href="register.php" class="cta-btn">Get Started Today</a>
    </div>
  </section>


  <section class="testimonials">
    <h2>What Our Users Say</h2>
    <div class="testimonial-container">
      <div class="testimonial-card">
        <p>"WellTrackeR has completely transformed the way I track my health. Highly recommended!"</p>
        <div class="testimonial-author">
          <img src="image/user1.png" alt="User 1">
          <h4>Jane Doe</h4>
          <span>Fitness Enthusiast</span>
        </div>
      </div>

      <div class="testimonial-card">
        <p>"A very intuitive and helpful platform for monitoring fitness and nutrition."</p>
        <div class="testimonial-author">
          <img src="image/user2.png" alt="User 2">
          <h4>John Smith</h4>
          <span>Nutrition Coach</span>
        </div>
      </div>

      <div class="testimonial-card">
        <p>"I love how easy it is to track my daily wellness and stay on top of my goals."</p>
        <div class="testimonial-author">
          <img src="image/user3.png" alt="User 3">
          <h4>Emily Clark</h4>
          <span>Health Blogger</span>
        </div>
      </div>
    </div>
  </section>



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