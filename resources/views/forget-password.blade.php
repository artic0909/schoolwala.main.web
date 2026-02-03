<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Forget Password | Schoolwala | Education For All</title>
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
                        Do you have forgotten your password!
                    </h2>
                    <p style="font-size: 1.1rem; max-width: 400px">
                        Don't worry! Just enter your email address and we'll send you a
                        OTP to reset your password
                    </p>
                </div>
            </div>
            <div class="auth-content">
                <div class="auth-header">
                    <div class="logo">
                        <img src="{{ asset('img/logo.png') }}" class="img-fluid" alt="SW" />
                    </div>
                    <h1 class="brand">Forget Password!</h1>
                    <p>Don't worry! Just enter your email address</p>
                </div>
                <form id="loginForm" action="{{ route('student.send-otp') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input
                            type="email"
                            class="form-control"
                            placeholder="your@email.com"
                            name="email"
                            required />
                    </div>
                    <button type="submit" class="btn-auth">SEND OTP</button>
                </form>

                <div class="auth-footer">
                    If you remember your password, <a href="{{ url('student-login') }}">Sign in</a>
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