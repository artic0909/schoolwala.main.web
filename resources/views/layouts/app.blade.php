<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Schoolwala — Fun Learning for Kids')</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('logofav.png') }}" />

    <style>
        .cute-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 16px 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Baloo 2', cursive;
            font-size: 18px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
            animation: slideIn 0.5s ease, fadeOut 0.5s ease 3.5s forwards;
            z-index: 9999;
        }

        .cute-alert .cute-icon {
            font-size: 28px;
        }

        .cute-alert.success {
            background: linear-gradient(135deg, #b8f1b0, #a0e3f2);
            color: #2c3e50;
            border: 2px solid #6ad784;
        }

        .cute-alert.error {
            background: linear-gradient(135deg, #ffb6b9, #ffcad4);
            color: #5a1e2d;
            border: 2px solid #ff6b81;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
    </style>
</head>

<body>
    <!-- {{-- HEADER --}} -->
    @include('partials.header')

    <!-- {{-- MAIN CONTENT --}} -->
    <main>
        @yield('content')
    </main>

    <!-- {{-- FOOTER --}} -->
    @include('partials.footer')

    <!-- {{-- Sticky CTA --}} -->
    <div class="sticky-cta">
        <div class="container">
            <div class="sticky-content">
                <p>Learning made fun for curious minds! 🚀</p>
                <a class="btn-primary" href="#">Book a Demo</a>
            </div>
        </div>
    </div>


    <!-- Alerts -->
    @if (session('success'))
    <div class="cute-alert success" id="cuteAlert">
        <div class="cute-icon">🌈</div>
        <div class="cute-message">{{ session('success') }}</div>
    </div>
    @endif

    @if (session('error'))
    <div class="cute-alert error" id="cuteAlert">
        <div class="cute-icon">💔</div>
        <div class="cute-message">{{ session('error') }}</div>
    </div>
    @endif


    <!-- {{-- JS --}} -->
    <script src="{{ asset('js/script.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alertBox = document.getElementById('cuteAlert');
            if (alertBox) {
                // Add little pop animation
                alertBox.style.transform = "scale(0.8)";
                setTimeout(() => alertBox.style.transform = "scale(1)", 100);

                // Remove alert after 4 seconds
                setTimeout(() => {
                    alertBox.style.transition = "all 0.5s ease";
                    alertBox.style.opacity = "0";
                    alertBox.style.transform = "translateX(100%)";
                    setTimeout(() => alertBox.remove(), 500);
                }, 4000);
            }
        });
    </script>

    @stack('scripts')
</body>

</html>