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

    <!-- {{-- JS --}} -->
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>

</html>