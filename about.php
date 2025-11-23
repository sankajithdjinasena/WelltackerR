<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WellTrackeR | About</title>
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
            background-image: url('image/about2.png');
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
            <a href="about.php" id="active">About</a>
            <a href="community.php">Community</a>
            <a href="contact.php">Contact</a>
            <a href="login.php" class="login-btn">Login</a>
            <a href="register.php" class="register-btn">Register</a>
        </div>
    </nav>

    <div class="header">
        <div class="header_title">
            <h1>About WellTrackeR</h1>
            <p>Revolutionizing healthcare through intelligent monitoring, AI-powered insights, and seamless
                collaboration between patients and healthcare providers.</p>
        </div>
    </div>

    <div class="about-content">
        <h2>Our Mission</h2>
        <p>At WellTrackeR, our mission is to empower individuals to take control of their health and wellness through
            innovative technology. We believe that everyone deserves access to tools that help them lead healthier
            lives.</p>
    </div>

    <div class="about-content">
        <h2>Our Story</h2>
        <p>Founded in 2025 by a team of WelltrackeR professionals, software engineers, and data scientists, WelltrackeR
            emerged from a simple observation: despite advances in medical technology, patients and healthcare providers
            still lacked comprehensive, easy-to-use tools for continuous health monitoring. <br><br>Our founders
            experienced firsthand the challenges of managing chronic conditions, coordinating care between multiple
            providers, and making sense of fragmented health data. This personal experience drove them to create a
            platform that would democratize access to intelligent health insights. <br><br>Today, WelltrackeR serves
            thousands of patients and hundreds of healthcare providers, processing over a million health records and
            continuously learning to provide better, more personalized health recommendations.</p>
    </div>

    <section class="features-section">
        <div class="features-grid">
            <div class="feature-card">
                <i class='bx bx-pulse'></i>
                <h3>Patient-Centered</h3>
                <p>Putting patients at the center of their health journey with intuitive tools and personalized
                    insights.</p>
            </div>

            <div class="feature-card">
                <i class='bx bx-trending-up'></i>
                <h3>AI-Powered</h3>
                <p>Leveraging artificial intelligence to provide predictive insights and early health risk detection.
                </p>
            </div>

            <div class="feature-card">
                <i class='bx bx-shield'></i>
                <h3>Secure & Private</h3>
                <p>Enterprise-grade security ensuring your health data remains confidential and protected at all times.
                </p>
            </div>
        </div>
    </section>


    <section class="about-section-container">
        <h2 class="about-section-title">What Makes Us Different</h2>
        <div class="about-features-grid">

            <!-- Left side -->
            <div class="about-features-list">
                <div class="about-feature-item">
                    <div class="about-feature-icon"><i class='bx bx-trending-up'></i></div>
                    <div class="about-feature-text">
                        <h3>Predictive Analytics</h3>
                        <p>Our AI algorithms analyze patterns to predict potential health issues before they become
                            critical.</p>
                    </div>
                </div>

                <div class="about-feature-item">
                    <div class="about-feature-icon"><i class='bx bx-group'></i></div>
                    <div class="about-feature-text">
                        <h3>Collaborative Care</h3>
                        <p>Seamlessly connect patients, doctors, and care teams for coordinated health management.</p>
                    </div>
                </div>

                <div class="about-feature-item">
                    <div class="about-feature-icon"><i class='bx bx-globe'></i></div>
                    <div class="about-feature-text">
                        <h3>Accessible Anywhere</h3>
                        <p>Cloud-based platform accessible from any device, ensuring your health data is always
                            available.</p>
                    </div>
                </div>

                <div class="about-feature-item">
                    <div class="about-feature-icon"><i class='bx bx-medal'></i></div>
                    <div class="about-feature-text">
                        <h3>Clinical Grade</h3>
                        <p>Built to meet healthcare standards with accuracy and reliability that healthcare
                            professionals trust.</p>
                    </div>
                </div>
            </div>

            <!-- Right side -->
            <div class="about-trust-card">
                <div class="about-trust-icon"><i class='bx bx-plus-medical'></i></div>
                <h3>Trusted by WelltrackeR Professionals</h3>
                <ul class="about-trust-list">
                    <li><i class='bx bx-check-circle'></i> HIPAA compliant security</li>
                    <li><i class='bx bx-check-circle'></i> Real-time patient monitoring</li>
                    <li><i class='bx bx-check-circle'></i> Evidence-based recommendations</li>
                    <li><i class='bx bx-check-circle'></i> Integration with EHR systems</li>
                    <li><i class='bx bx-check-circle'></i> 24/7 technical support</li>
                </ul>
            </div>

        </div>
    </section>

    <section class="cta-section">
        <div class="cta-content">
            <h2>Ready to Join Our Mission?</h2>
            <p>Be part of the healthcare revolution. Start your intelligent health tracking journey today.</p>
            <a href="register.html" class="cta-btn">Get Started Now</a>
        </div>
    </section>

    <section class="testimonials">
        <h2>Our Team</h2>
        <p>A diverse team of healthcare professionals, engineers, and designers united by a passion for improving
            healthcare outcomes.</p>
        <div class="testimonial-container">
            <div class="testimonial-card">
                <div class="testimonial-author">
                    <img src="image/user1.png" alt="User 1">
                    <h4>Dr. Sarah Johnson</h4>
                    <span>Chief Medical Officer</span>
                </div>
                <p>Former Emergency Medicine Physician with 15+ years of clinical experience</p>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-author">
                    <img src="image/user1.png" alt="User 1">
                    <h4>Michael Chen</h4>
                    <span>Chief Technology Officer</span>
                </div>
                <p>Previously led engineering teams at major healthcare technology companies</p>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-author">
                    <img src="image/user1.png" alt="User 1">
                    <h4>Dr. Amanda Rodriguez</h4>
                    <span>Head of AI & Analytics</span>
                </div>
                <p>PhD in Biomedical Informatics, specialized in predictive healthcare analytics</p>
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