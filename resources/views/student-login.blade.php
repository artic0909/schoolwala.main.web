<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Schoolwala — Sign In</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&family=Inter:wght@300;400;600&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('./css/auth.css') }}" />
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('logofav.png') }}" />
  <style>
    .custom-success-popup,
    .custom-error-popup {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 15px 20px;
      border-radius: 5px;
      color: white;
      z-index: 9999;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      animation: fadeInOut 4s ease-in-out forwards;
    }

    .custom-success-popup {
      background-color: #4CAF50;
    }

    .custom-error-popup {
      background-color: #f44336;
    }

    @keyframes fadeInOut {
      0% {
        opacity: 0;
        transform: translateY(-10px);
      }

      10% {
        opacity: 1;
        transform: translateY(0);
      }

      90% {
        opacity: 1;
      }

      100% {
        opacity: 0;
        transform: translateY(-10px);
      }
    }
  </style>
</head>

<body>
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-illustration">
        <div class="shape star"></div>
        <div class="shape pencil"></div>
        <div class="text-center text-white px-4">
          <h2 class="fw-bold mb-4" style="font-size: 2.2rem">
            Learning made fun for curious minds!
          </h2>
          <p style="font-size: 1.1rem; max-width: 400px">
            Join thousands of parents who are making learning an adventure for
            their kids
          </p>
        </div>
      </div>
      <div class="auth-content">
        <div class="auth-header">
          <div class="logo">
            <img src="{{ asset('img/logo.png') }}" class="img-fluid" alt="SW" />
          </div>
          <h1 class="brand">Welcome back!</h1>
          <p>Sign in to continue your child's learning journey</p>
        </div>
        <form id="loginForm" action="{{ route('student.student-login.verify') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group">
            <label class="form-label">Email Address</label>
            <input
              type="email"
              class="form-control"
              placeholder="your@email.com"
              name="email"
              value="{{ old('email') }}"
              required />
          </div>

          <label class="form-label">Password</label>
          <div
            class="form-group password-toggle"
            style="
                display: flex;
                align-items: center;
                justify-content: center;
              ">
            <input
              type="password"
              class="form-control"
              placeholder="••••••••"
              name="password"
              value="{{ old('password') }}"
              required />
            <button type="button" class="toggle-password">👁️</button>
          </div>
          <div class="remember-forgot">
            <div class="remember-me">
              <input type="checkbox" id="remember" />
              <label for="remember">Remember me</label>
            </div>
            <a href="{{ route('student.forget-pass-view') }}" class="forgot-password">Forgot Password?</a>
          </div>
          <button type="submit" class="btn-auth">Sign In</button>
        </form>

        <div class="auth-footer">
          Don't have an account? <a href="{{ url('student-register') }}">Sign up</a>
        </div>
      </div>
    </div>
  </div>



  <script src="{{ asset('./js/auth.js') }}"></script>


  @if (session('success'))
  <div id="successPopup" class="custom-success-popup">
    {{ session('success') }}
  </div>
  @endif

  @if (session('error'))
  <div id="errorPopup" class="custom-error-popup">
    {{ session('error') }}
  </div>
  @endif


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const successPopup = document.getElementById('successPopup');
      const errorPopup = document.getElementById('errorPopup');

      if (successPopup) setTimeout(() => successPopup.remove(), 4000);
      if (errorPopup) setTimeout(() => errorPopup.remove(), 4000);
    });
  </script>
</body>

</html>