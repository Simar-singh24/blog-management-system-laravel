<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Blog Dashboard')</title>

    <!-- Bootstrap 5 CSS (local fallback) -->
    <link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Font Awesome (local fallback) -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/all.min.css') }}">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('styles')
</head>
<body>
    @yield('content')

    <!-- jQuery (local) -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}" defer></script>
    
    <!-- Bootstrap 5 JS (local) -->
    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}" defer></script>
    
    <!-- GSAP (local) -->
    <script src="{{ asset('vendor/gsap/gsap.min.js') }}" defer></script>
    <script src="{{ asset('vendor/gsap/ScrollTrigger.min.js') }}" defer></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>

    @yield('scripts')
</body>
</html>
