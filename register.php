<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WelltrackeR | Register</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/png" href="image/Logo_R.png">
    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>

    <?php
    include 'config.php';

    if (isset($_POST['register'])) {
        // Sanitize inputs
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $role = $_POST['role'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Check password match
        if ($password !== $confirm_password) {
            echo "<script>alert('Passwords do not match!');</script>";
        } else {
            // Check if email already exists
            $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
            $checkEmail->bind_param("s", $email);
            $checkEmail->execute();
            $result = $checkEmail->get_result();

            if ($result->num_rows > 0) {
                echo "<script>alert('Email already registered! Please login.');</script>";
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Set verification status based on role
                $verification_status = (strtolower($role) === 'doctor') ? 'Pending' : 'Verified';

                // Insert user
                $stmt = $conn->prepare(
                    "INSERT INTO users (first_name, last_name, email, password, role, verification_status) 
                VALUES (?, ?, ?, ?, ?, ?)"
                );
                $stmt->bind_param(
                    "ssssss",
                    $first_name,
                    $last_name,
                    $email,
                    $hashed_password,
                    $role,
                    $verification_status
                );

                if ($stmt->execute()) {
                    echo "<script>
                        alert('Registration successful! You can now login.');
                        window.location.href='login.php';
                      </script>";
                } else {
                    echo "<script>alert('Error: Registration failed. Try again.');</script>";
                }

                $stmt->close();
            }

            $checkEmail->close();
        }
    }
    ?>



    <style>
        .password-wrapper i {
            top: 55%;
        }
    </style>

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
            <a href="login.php" class="login-btn">Login</a>
            <a href="register.php" class="register-btn" id="active">Register</a>
        </div>
    </nav>

    <!-- Login Form -->
    <section class="login-contact-section">
        <div class="login-contact-grid">
            <div class="login-contact-form">
                <h3>Create an Account</h3>
                <p>Please fill in your details to register.</p>
       <form id="registerForm" action="register.php" method="POST" onsubmit="return validateRegisterForm()">
    <div class="login-form-group">
        <label>First Name</label>
        <input type="text" id="first_name" name="first_name" placeholder="Enter first name" required>
    </div>
    <div class="login-form-group">
        <label>Last Name</label>
        <input type="text" id="last_name" name="last_name" placeholder="Enter last name" required>
    </div>
    <div class="login-form-group">
        <label for="role">Register as</label>
        <select id="role" name="role" required>
            <option value="">-- Select Role --</option>
            <option value="doctor">Doctor</option>
            <option value="patient">Patient</option>
        </select>
    </div>
    <div class="login-form-group">
        <label>Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>
    </div>
    <div class="login-form-group">
        <label>Password</label>
        <div class="password-wrapper">
            <input type="password" id="passwordInput" name="password" placeholder="Enter password" required oninput="checkPasswordStrength(this.value)">
            <i id="togglePassword" class="bx bx-hide"></i>
        </div>
        <ul class="password-rules" id="passwordRules">
            <li id="ruleLength">At least 8 characters</li>
            <li id="ruleUpper">At least 1 uppercase letter</li>
            <li id="ruleLower">At least 1 lowercase letter</li>
            <li id="ruleNumber">At least 1 number</li>
            <li id="ruleSpecial">At least 1 special character (!@#$%^&*)</li>
        </ul>
        <div id="strengthMsg" style="font-size:12px; margin-top:5px;"></div>
    </div>
    <div class="login-form-group">
        <label>Confirm Password</label>
        <input type="password" id="confirmPassword" name="confirm_password" placeholder="Enter password again" required>
    </div>

    <p id="registerError" style="color:#c0392b; margin-top:10px; font-size:14px;"></p>

    <button type="submit" name="register" class="login-submit-btn">
        Register <i class="bx bx-user-plus"></i>
    </button>
</form>

<script>
const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('passwordInput');
togglePassword.addEventListener('click', () => {
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;
    togglePassword.classList.toggle('bx-show');
});

// Password strength & rules checker
function checkPasswordStrength(password) {
    const rules = {
        ruleLength: password.length >= 8,
        ruleUpper: /[A-Z]/.test(password),
        ruleLower: /[a-z]/.test(password),
        ruleNumber: /[0-9]/.test(password),
        ruleSpecial: /[!@#$%^&*(),.?":{}|<>]/.test(password)
    };

    for (let id in rules) {
        const el = document.getElementById(id);
        if (rules[id]) el.classList.add('valid');
        else el.classList.remove('valid');
    }

    const strength = Object.values(rules).filter(v => v).length;
    const strengthMsg = document.getElementById('strengthMsg');
    if (strength === 5) {
        strengthMsg.textContent = "Strong password";
        strengthMsg.style.color = "green";
    } else if (strength >= 3) {
        strengthMsg.textContent = "Medium strength";
        strengthMsg.style.color = "orange";
    } else {
        strengthMsg.textContent = "Weak password";
        strengthMsg.style.color = "red";
    }
}

// Form validation
function validateRegisterForm() {
    const firstName = document.getElementById('first_name').value.trim();
    const lastName = document.getElementById('last_name').value.trim();
    const role = document.getElementById('role').value;
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('passwordInput').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();
    const errorEl = document.getElementById('registerError');

    errorEl.textContent = "";

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!firstName || !lastName || !role || !email || !password || !confirmPassword) {
        errorEl.textContent = "All fields are required.";
        return false;
    }

    if (!emailRegex.test(email)) {
        errorEl.textContent = "Please enter a valid email address.";
        return false;
    }

    if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password) || !/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        errorEl.textContent = "Password must meet all requirements listed above.";
        return false;
    }

    if (password !== confirmPassword) {
        errorEl.textContent = "Passwords do not match.";
        return false;
    }

    return true; // All validations passed
}
</script>

                <center>
                    <p style="margin-top:15px;font-size:14px;">Already have an account?
                        <a href="login.php" style="color:#16a085;font-weight:600;">Login</a>
                    </p>
                </center>
            </div>
            <div class="login-contact-form">
                <div class="contact-info">

                    <h2>
                        <center>Welcome to WellTrackeR</center>
                    </h2>
                    <h4>
                        <center>Create your free account in seconds</center>
                    </h4>
                    <p>
                        <center>Track your health and wellness with ease using WellTrackeR. Our intuitive platform helps
                            you monitor your fitness, nutrition, and overall well-being in one convenient place.
                        </center>
                    </p>
                    <div class="progress-container">
                        <div class="progress-bar" id="progressBar">0%</div>
                    </div>
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

                    <p><i><b>
                                <center>“Your journey starts here — sign up and unlock the possibilities.”</center>
                            </b></i></p>
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
        <p>&copy; 2025 WellTrackeR. All rights reserved.</p>
    </footer>

</body>
<script src="js/script.js"></script>
</html>