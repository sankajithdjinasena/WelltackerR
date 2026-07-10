<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WellTrackeR | Contact</title>
  <link rel="icon" type="image/png" href="image/Logo_R.png">
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="css/dialogflow.css">
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
            background-image: url('image/contact.png');
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
            max-width: 800px;
        }

        .header_title h1 {
            font-size: 64px;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.2;
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
<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if (!empty($first_name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO contact_messages (first_name, last_name, email, phone, subject, message)
                VALUES ('$first_name', '$last_name', '$email', '$phone', '$subject', '$message')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('✅ Your message has been sent successfully!');</script>";
        } else {
            echo "<script>alert('❌ Error: Unable to send message. Please try again later.');</script>";
        }
    } else {
        echo "<script>alert('⚠️ Please fill all required fields.');</script>";
    }
}
?>

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
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="community.php">Community</a>
      <a href="contact.php" id="active">Contact</a>
      <a href="login.php" class="login-btn">Login</a>
      <a href="register.php" class="register-btn">Register</a>
    </div>
  </nav>

  <div class="header">
    <div class="header_title">
      <h1>Contact Us</h1>
      <p>Have questions about WellTrackeR ? We're here to help. Reach out to our team for support, partnerships, or
        general inquiries.</p>
    </div>
  </div>

  <section class="contact-features-section">
    <div class="contact-features-grid">
      <div class="contact-feature-card">
        <i class='bx bx-message'></i>
        <h3>General Support</h3>
        <p>Questions about using our platform or need technical assistance?</p>
        <h4>support@welltracker.com</h4>
      </div>

      <div class="contact-feature-card">
        <i class='bx bx-group'></i>
        <h3>Partnership</h3>
        <p>Healthcare institutions interested in partnerships and integrations.</p>
        <h4>partnerships@welltracker.com</h4>
      </div>

      <div class="contact-feature-card">
        <i class='bx bx-shield'></i>
        <h3>Security</h3>
        <p>Report security vulnerabilities or compliance questions.</p>
        <h4>security@welltracker.com</h4>
      </div>

      <div class="contact-feature-card">
        <i class='bx bx-line-chart'></i>
        <h3>Sales</h3>
        <p>Enterprise plans and custom solutions for healthcare organizations.</p>
        <h4>sales@welltracker.com</h4>
      </div>
    </div>
  </section>

  <section class="contact-section">
    <div class="contact-grid">

      <!-- Left: Form -->
      <div class="contact-form">
        <h3>Send us a message</h3>
        <p>Fill out the form below and we'll get back to you within 24 hours.</p>

        <form method="POST" action="">
          <div class="form-row">
            <div class="form-group">
              <label>First Name</label>
              <input type="text" name="first_name" placeholder="John" required>
            </div>
            <div class="form-group">
              <label>Last Name</label>
              <input type="text" name="last_name" placeholder="Doe">
            </div>
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="john@example.com" required>
          </div>

          <div class="form-group">
            <label>Phone (Optional)</label>
            <input type="tel" name="phone" placeholder="+1 (555) 123-4567">
          </div>

          <div class="form-group">
            <label>Subject</label>
            <select name="subject">
              <option>Select a subject</option>
              <option>General Inquiry</option>
              <option>Technical Support</option>
              <option>Partnership</option>
            </select>
          </div>

          <div class="form-group">
            <label>Message</label>
            <textarea name="message" placeholder="Tell us how we can help you..." required></textarea>
          </div>

          <button type="submit" class="contact-submit-btn">Send Message <i class='bx bx-send'></i></button>
        </form>
      </div>

      <!-- Right: Info + FAQ -->
      <div>
        <div class="contact-info">
          <h3>Contact Information</h3>

          <div class="contact-item">
            <div class="contact-icon"><i class='bx bx-envelope'></i></div>
            <div class="contact-text">
              <strong>Email</strong><br>
              support@welltracker.com
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class='bx bx-phone'></i></div>
            <div class="contact-text">
              <strong>Phone</strong><br>
              +94 11-678-9012
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class='bx bx-map'></i></div>
            <div class="contact-text">
              <strong>Address</strong><br>
              12 WelltrackeR Ave<br>Colombo District
            </div>
          </div>

          <div class="contact-item">
            <div class="contact-icon"><i class='bx bx-time'></i></div>
            <div class="contact-text">
              <strong>Business Hours</strong><br>
              Mon – Fri: 8:00 AM – 6:00 PM PST<br>
              Sat – Sun: 9:00 AM – 5:00 PM PST
            </div>
          </div>
        </div>

        <div class="faq-card">
          <h3>Frequently Asked Questions</h3>
          <p><strong>Is my health data secure?</strong> Yes, we use enterprise-grade encryption and are HIPAA compliant
            to ensure your data is protected.</p>
          <p><strong>Can doctors access my data?</strong> Only with your explicit permission. You control who can view
            your health information.</p>
          <p><strong>Do you offer enterprise solutions?</strong> Yes, we have custom solutions for hospitals, clinics,
            and healthcare organizations.</p>
          <button class="contact-submit-btn faq-btn">View All FAQs</button>
        </div>
      </div>

    </div>
  </section>

  <!-- Emergency Notice -->
  <div class="emergency-notice">
    <i class='bx bx-error'></i><strong>Medical Emergency Notice</strong><br>
    If you are experiencing a medical emergency, please call 110 or visit your nearest emergency room immediately.
    WellTrackeR is not intended for emergency medical situations.
  </div>



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
    <p>&copy; 2026 WellTrackeR. All rights reserved.</p>

  </footer>

</body>

<script src="js/script.js"></script>

</html>