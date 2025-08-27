document.addEventListener('DOMContentLoaded', function() {
  // Toggle password visibility
  const toggleButtons = document.querySelectorAll('.toggle-password');
  toggleButtons.forEach(button => {
    button.addEventListener('click', function() {
      const input = this.previousElementSibling;
      const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
      input.setAttribute('type', type);
      this.textContent = type === 'password' ? '👁️' : '🔒';
    });
  });

  // Form animations
  const inputs = document.querySelectorAll('.form-control');
  inputs.forEach(input => {
    input.addEventListener('focus', function() {
      this.parentElement.style.transform = 'translateY(-2px)';
    });
    input.addEventListener('blur', function() {
      this.parentElement.style.transform = 'translateY(0)';
    });
  });

  // Login form
  const loginFormEl = document.getElementById('loginForm');
  if (loginFormEl) {
    loginFormEl.addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Login successful! Redirecting to dashboard...');
    });
  }

  // Signup form
  const signupFormEl = document.getElementById('signupForm');
  if (signupFormEl) {
    signupFormEl.addEventListener('submit', function(e) {
      e.preventDefault();
      alert('Account created successfully! Welcome to Schoolwala!');
    });
  }
});
