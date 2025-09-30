<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'M. Arief Asyraf Portfolio')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/nigiri.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body class="min-h-screen bg-gradient-custom text-primary font-inter">
    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-transparent backdrop-blur-sm">
        <!-- Desktop Navigation -->
        <nav class="desktop-nav max-w-6xl mx-auto px-8 py-6 hidden md:flex items-center justify-between">
            <!-- Logo -->
            <div class="logo text-primary text-2xl font-bold">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/sushi.png') }}" alt="Sushi Logo" class="w-10 h-10">
                </a>
            </div>

            <!-- Desktop Navigation Links -->
            <div class="flex items-center space-x-8">
                <a href="{{ route('about') }}" class="text-secondary hover:opacity-80 transition-all duration-300">About</a>
                <a href="{{ route('projects') }}" class="text-secondary hover:opacity-80 transition-all duration-300">Projects</a>
                <a href="{{ route('blog') }}" class="text-secondary hover:opacity-80 transition-all duration-300">Blog</a>
                <a href="{{ route('contact') }}" class="text-secondary hover:opacity-80 transition-all duration-300 border border-primary px-4 py-2 rounded-full">Contact</a>
            </div>

            <!-- Desktop Theme Toggle -->
            <button id="theme-toggle-desktop" class="theme-toggle">
                <img src="{{ asset('assets/images/light-mode.png') }}" alt="Toggle theme" class="theme-toggle-icon w-6 h-6">
            </button>
        </nav>

        <!-- Mobile Navigation -->
        <nav class="mobile-nav max-w-6xl mx-auto px-8 py-6 flex md:hidden items-center justify-between">
            <!-- Logo (Left) -->
            <div class="logo text-primary text-2xl font-bold">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/sushi.png') }}" alt="Sushi Logo" class="w-10 h-10">
                </a>
            </div>

            <!-- Hamburger Menu (Right) -->
            <button class="mobile-menu-toggle" id="mobile-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </nav>

        <!-- Mobile Menu -->
        <div class="mobile-menu hidden md:hidden bg-background/95 backdrop-blur-sm border-t border-primary/10">
            <div class="max-w-6xl mx-auto px-8 py-6">
                <div class="flex flex-col space-y-4">
                    <a href="{{ route('about') }}" class="text-secondary hover:opacity-80 transition-all duration-300">About</a>
                    <a href="{{ route('projects') }}" class="text-secondary hover:opacity-80 transition-all duration-300">Projects</a>
                    <a href="{{ route('blog') }}" class="text-secondary hover:opacity-80 transition-all duration-300">Blog</a>
                    <a href="{{ route('contact') }}" class="text-secondary hover:opacity-80 transition-all duration-300">Contact</a>

                    <!-- Mobile Theme Toggle -->
                    <div class="flex items-center justify-between pt-4 border-t border-primary/10">
                        <span class="text-secondary">Theme</span>
                        <button id="theme-toggle-mobile" class="theme-toggle">
                            <div class="theme-toggle-icon"></div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>