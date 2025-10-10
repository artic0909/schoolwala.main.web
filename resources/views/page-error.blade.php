<!DOCTYPE html>
<html
  lang="en"
  class="light-style"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="./admin/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Page Not Found | Schoolwala</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../logofav.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="./admin/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link
      rel="stylesheet"
      href="./admin/assets/vendor/css/core.css"
      class="template-customizer-core-css"
    />
    <link
      rel="stylesheet"
      href="./admin/assets/vendor/css/theme-default.css"
      class="template-customizer-theme-css"
    />
    <link rel="stylesheet" href="./admin/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link
      rel="stylesheet"
      href="./admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css"
    />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="./admin/assets/vendor/css/pages/page-misc.css" />
    <!-- Helpers -->
    <script src="./admin/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="./admin/assets/js/config.js"></script>
  </head>

  <body>
    <!-- Content -->

    <!-- Error -->
    <div class="container-xxl container-p-y">
      <div class="misc-wrapper">
        <h2 class="mb-2 mx-2">Page Not Found :(</h2>
        <p class="mb-4 mx-2">
          Oops! <img src="{{asset('img/logo.png')}}" width="50" alt=""> The requested URL was not found on this server.
        </p>
        @guest
        <a href="{{ route('student.home') }}" class="btn btn-primary">Back to Schoolwala</a>
        @endguest
        @auth
        <a href="{{ route('student.home') }}" class="btn btn-primary">Back to Schoolwala</a>
        @endauth
        <div class="mt-3">
          <img
            src="{{ asset('./admin/assets/img/illustrations/page-misc-error-light.png') }}"
            alt="page-misc-error-light"
            width="500"
            class="img-fluid"
          />
        </div>
      </div>
    </div>
    <!-- /Error -->

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
