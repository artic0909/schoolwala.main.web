<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('./admin/assets/') }}"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>
    Admin Login | Schoolwala
  </title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('logofav.png') }}" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('./admin/assets/vendor/fonts/boxicons.css') }}" />

  <!-- Core CSS -->
  <link
    rel="stylesheet"
    href="./admin/assets/vendor/css/core.css"
    class="template-customizer-core-css" />
  <link
    rel="stylesheet"
    href="./admin/assets/vendor/css/theme-default.css"
    class="template-customizer-theme-css" />
  <link rel="stylesheet" href="./admin/assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link
    rel="stylesheet"
    href="./admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <!-- Page CSS -->
  <!-- Page -->
  <link rel="stylesheet" href="./admin/assets/vendor/css/pages/page-auth.css" />
  <!-- Helpers -->
  <script src="./admin/assets/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="./admin/assets/js/config.js"></script>

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
  <!-- Content -->

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">
                  <img src="../img/logo.png" width="50px" alt="" />
                </span>
                <span
                  class="app-brand-text demo text-body fw-bolder"
                  style="text-transform: capitalize">Schoolwala</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">Welcome to Schoolwala! 👋</h4>
            <p class="mb-4">
              Please sign-in to your account and start the adventure
            </p>

            <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('admin.admin-login.verify') }}" enctype="multipart/form-data">
              @csrf

              {{-- Email/Username --}}
              <div class="mb-3">
                <label for="email" class="form-label">Admin Email / Username</label>
                <input
                  type="text"
                  class="form-control @error('email') is-invalid @enderror"
                  id="email"
                  name="email"
                  value="{{ old('email') }}"
                  placeholder="Enter your email or username"
                  autofocus />
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Password --}}
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Admin Password</label>
                  <a href="{{ route('admin.admin-forget-password') }}">
                    <small>Forgot Password?</small>
                  </a>
                </div>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password"
                    placeholder="********" />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  @error('password')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              {{-- Remember Me --}}
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                  <label class="form-check-label" for="remember-me">
                    Remember Me
                  </label>
                </div>
              </div>

              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
              </div>
            </form>



          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>

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

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="./admin/assets/vendor/libs/jquery/jquery.js"></script>
  <script src="./admin/assets/vendor/libs/popper/popper.js"></script>
  <script src="./admin/assets/vendor/js/bootstrap.js"></script>
  <script src="./admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="./admin/assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->

  <!-- Main JS -->
  <script src="./admin/assets/js/main.js"></script>

  <!-- Page JS -->

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>