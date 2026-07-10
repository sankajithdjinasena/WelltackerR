<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WelltrackeR | Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/png" href="image/Logo_R.png">
    <link rel="stylesheet" href="css/dialogflow.css">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
<df-messenger
  intent="WELCOME"
  chat-title="WelltrackeR"
  agent-id="9d5f2420-6826-4916-9e73-235b856a1965"
  language-code="en"
></df-messenger>


    <?php
    session_start();
    include 'config.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['telephone'] = $user['telephone'];

                // Redirect based on role
                if ($user['role'] == 'Doctor') {
                    $_SESSION['verification_status'] = $user['verification_status'];
                    $_SESSION['verification_details'] = $user['verification_details'];
                    header("Location: doctor_portal.php");
                } elseif ($user['role'] == 'Patient') {
                    header("Location: patient_portal.php");
                } elseif ($user['role'] == 'Admin') {
                    header("Location: admin_portal.php");
                }else {
                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                    Swal.fire({
                        title: 'Invalid Role',
                        text: 'Invalid role. Please contact admin.',
                        icon: 'error',
                        confirmButtonText: 'Go Back'
                    }).then(() => {
                        window.history.back();
                    });
                    </script>
                    ";

                }
                exit();
            } else {
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                Swal.fire({
                    title: 'Incorrect Password',
                    text: 'Please try again.',
                    icon: 'error',
                    confirmButtonText: 'Go Back'
                }).then(() => {
                    window.history.back();
                });
                </script>
                ";

            }
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
            Swal.fire({
                title: 'No User Found',
                text: 'No user found with that email.',
                icon: 'warning',
                confirmButtonText: 'Go Back'
            }).then(() => {
                window.history.back();
            });
            </script>
            ";
        }

        $stmt->close();
        $conn->close();
    }
    ?>



    <!-- Navbar -->
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
            <a href="contact.php">Contact</a>
            <a href="login.php" class="login-btn" id="active">Login</a>
            <a href="register.php" class="register-btn">Register</a>
        </div>

    </nav>


    <div class="login-content">
        <p>Track your health and wellness with ease using <b>WellTrackeR</b>. <br>Our intuitive platform helps you
            monitor your
            fitness, nutrition, and overall well-being in one convenient place.</p>
    </div>
    </div>

    <!-- Login Form -->
    <section class="login-contact-section">
        <div class="login-contact-grid">
            <div class="login-contact-form">
                <h3><b>
                        <center>Welcome back! <br>Please enter your credentials.</center>
                    </b></h3>
                <form id="loginForm" class="login-form" method="POST" action="login.php" >
                    <h2 class="login-title">Login</h2>

                    <div class="login-form-group">
                        <label for="emailInput">Email Address</label>
                        <input type="email" id="emailInput" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="login-form-group password-wrapper">
                        <label for="passwordInput">Password</label>
                        <input type="password" id="passwordInput" name="password" placeholder="Enter your password" required>
                        <i class="bx bx-hide" id="togglePassword"></i>
                    </div>

                    <button type="submit" class="login-submit-btn">
                        Login <i class="bx bx-log-in"></i>
                    </button>

                </form>
                <p id="loginError" style="color:#c0392b; display:none; margin-top:10px; font-size:14px;"></p>
                <center>
                    <p style="margin-top:15px;font-size:14px;">Don’t have an account?
                        <a href="register.php" style="color:#16a085;font-weight:600;">Register</a>
                    </p>

                    <p style="margin-top:15px;font-size:14px;">Don't remember your password?
                        <a href="forget.php " style="color:#16a085;font-weight:600;">Forget Password</a>
                    </p>
                </center>
            </div>
            <div class="login-contact-form">
                <div class="login-contact-terxt">
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
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
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
<script src="js/password.js"></script>

</html>