document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('loginForm');
  const emailInput = document.getElementById('emailInput');
  const passwordInput = document.getElementById('passwordInput');
  const errorEl = document.getElementById('loginError');

  // Hard-coded credentials (client-side only; insecure for production)
  const creds = {
    'admin@welltracker.com': '12345678',
    'patient@welltracker.com': '12345678'
  };

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    errorEl.style.display = 'none';
    const email = (emailInput.value || '').trim().toLowerCase();
    const password = (passwordInput.value || '');

    if (!email || !password) {
      showError('Please enter email and password.');
      return;
    }

    // Check if email exists in our creds map and password matches
    if (creds[email] && creds[email] === password) {
      // Redirect based on role
      if (email === 'admin@welltracker.com') {
        // Note: you wrote admin_portal.jtml — if that's a typo and you meant .html, change it.
        window.location.href = 'admin_portal.html';
      } else if (email === 'patient@welltracker.com') {
        window.location.href = 'patient_portal.html';
      } else {
        // fallback (shouldn't happen with current map)
        showError('Unknown user role.');
      }
      return;
    }

    // If not matched
    showError('Invalid email or password. Please try again.');
  });

  function showError(msg) {
    errorEl.textContent = msg;
    errorEl.style.display = 'block';
  }
});