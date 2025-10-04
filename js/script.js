window.addEventListener('scroll', () => {
    if (window.scrollY > 10) {
        document.body.classList.add('scrolled');
    } else {
        document.body.classList.remove('scrolled');
    }
});

const toggle = document.querySelector(".menu-toggle");
  const navLinks = document.querySelector(".nav-links");

  toggle.addEventListener("click", () => {
    navLinks.classList.toggle("active");
    toggle.classList.toggle("bx-x"); // swap to X icon
  });

  // Optional: add "scrolled" effect
  window.addEventListener("scroll", () => {
    document.body.classList.toggle("scrolled", window.scrollY > 10);
  });

const form = document.getElementById("registerForm");
const inputs = form.querySelectorAll("input[required], select[required], textarea[required]");
const progressBar = document.getElementById("progressBar");

inputs.forEach(input => {
  input.addEventListener("input", updateProgress);
  input.addEventListener("change", updateProgress); // for dropdown/select
});

function updateProgress() {
  let filled = 0;
  inputs.forEach(input => {
    if (input.value.trim() !== "") filled++;
  });
  let progress = Math.round((filled / inputs.length) * 100);
  progressBar.style.width = progress + "%";
  progressBar.textContent = progress + "%";
}

const password = document.getElementById("passwordInput");
const strengthBar = document.getElementById("strengthBar");
const strengthText = document.getElementById("strengthText");

password.addEventListener("input", () => {
  const val = password.value;
  let strength = 0;

  if (val.length >= 6) strength++;
  if (/[A-Z]/.test(val)) strength++;
  if (/[0-9]/.test(val)) strength++;
  if (/[^A-Za-z0-9]/.test(val)) strength++;

  switch (strength) {
    case 0:
      strengthBar.style.width = "0%";
      strengthBar.style.background = "transparent";
      strengthText.textContent = "";
      break;
    case 1:
      strengthBar.style.width = "25%";
      strengthBar.style.background = "red";
      strengthText.textContent = "Weak";
      strengthText.style.color = "red";
      break;
    case 2:
      strengthBar.style.width = "50%";
      strengthBar.style.background = "orange";
      strengthText.textContent = "Fair";
      strengthText.style.color = "orange";
      break;
    case 3:
      strengthBar.style.width = "75%";
      strengthBar.style.background = "blue";
      strengthText.textContent = "Good";
      strengthText.style.color = "blue";
      break;
    case 4:
      strengthBar.style.width = "100%";
      strengthBar.style.background = "green";
      strengthText.textContent = "Strong";
      strengthText.style.color = "green";
      break;
  }
});

const strengthText_confirm = document.getElementById("strengthText-confirm");
const confirmPassword = document.getElementById('confirm-password');
const submitBtn = document.getElementById('submitBtn');

function checkPasswordMatch() {
    if (confirmPassword.value === "") {
        strengthText_confirm.textContent = "";
        return false;
    } else if (password.value === confirmPassword.value) {
        strengthText_confirm.style.color = "green";
        strengthText_confirm.textContent = "Passwords match";
        return true;
    } else {
        strengthText_confirm.style.color = "red";
        strengthText_confirm.textContent = "Passwords do not match";
        return false;
    }
}

password.addEventListener('input', checkPasswordMatch);
confirmPassword.addEventListener('input', checkPasswordMatch);

