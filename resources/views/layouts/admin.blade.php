<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="admin-root">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Portfolio Admin') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/nigiri.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Admin Panel Design System - Based on Original Portfolio */
        :root {
            /* Neutral Grayscale Palette */
            --color-neutral-50: #ffffff;
            --color-neutral-100: #f5f5f5;
            --color-neutral-200: #e5e5e5;
            --color-neutral-300: #d4d4d4;
            --color-neutral-400: #a3a3a3;
            --color-neutral-500: #737373;
            --color-neutral-600: #525252;
            --color-neutral-700: #404040;
            --color-neutral-800: #262626;
            --color-neutral-900: #171717;
            --color-neutral-950: #0a0a0a;

            /* Admin Theme Colors - Dark Mode Default */
            --admin-bg-primary: var(--color-neutral-950);
            --admin-bg-secondary: var(--color-neutral-900);
            --admin-bg-tertiary: var(--color-neutral-800);
            --admin-bg-card: var(--color-neutral-900);
            --admin-text-primary: var(--color-neutral-50);
            --admin-text-secondary: var(--color-neutral-300);
            --admin-text-tertiary: var(--color-neutral-500);
            --admin-border-primary: var(--color-neutral-700);
            --admin-border-secondary: var(--color-neutral-800);
            --admin-accent-color: var(--color-neutral-50);
        }

        /* Light Theme Support */
        #admin-root.light-theme {
            --admin-bg-primary: var(--color-neutral-50);
            --admin-bg-secondary: var(--color-neutral-100);
            --admin-bg-tertiary: var(--color-neutral-200);
            --admin-bg-card: var(--color-neutral-50);
            --admin-text-primary: var(--color-neutral-950);
            --admin-text-secondary: var(--color-neutral-700);
            --admin-text-tertiary: var(--color-neutral-500);
            --admin-border-primary: var(--color-neutral-300);
            --admin-border-secondary: var(--color-neutral-200);
            --admin-accent-color: var(--color-neutral-950);
        }

        /* Base Typography & Layout */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: var(--admin-bg-primary);
            color: var(--admin-text-primary);
            transition: all 0.3s ease;
        }

        /* Admin Sidebar */
        .admin-sidebar {
            background: var(--admin-bg-secondary);
            border-right: 1px solid var(--admin-border-primary);
        }

        .admin-nav-link {
            color: var(--admin-text-secondary);
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 12px 4px 12px;
            padding: 12px 16px;
        }

        .admin-nav-link:hover {
            background-color: var(--admin-bg-tertiary);
            color: var(--admin-text-primary);
            transform: translateX(2px);
        }

        .admin-nav-link.active {
            background-color: var(--admin-bg-tertiary);
            color: var(--admin-text-primary);
            border-left: 3px solid var(--admin-accent-color);
        }

        /* Admin Content */
        .admin-content {
            background-color: var(--admin-bg-primary);
        }

        .admin-card {
            background-color: var(--admin-bg-card);
            border: 1px solid var(--admin-border-primary);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .admin-card:hover {
            border-color: var(--admin-border-secondary);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Theme Toggle */
        .theme-toggle {
            width: 24px;
            height: 24px;
            background: transparent;
            border: 1px solid var(--admin-border-primary);
            border-radius: 6px;
            color: var(--admin-text-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-toggle:hover {
            background-color: var(--admin-bg-tertiary);
            color: var(--admin-text-primary);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--admin-bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--admin-border-primary);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--admin-text-tertiary);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 1000;
                transition: transform 0.3s ease;
            }

            .admin-sidebar.open {
                transform: translateX(0);
            }

            .mobile-overlay {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .mobile-overlay.open {
                opacity: 1;
                visibility: visible;
            }

            .admin-main-content {
                margin-left: 0 !important;
            }
        }

        /* Success/Error Messages */
        .admin-alert {
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            border: 1px solid;
        }

        .admin-alert-success {
            background-color: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.3);
            color: #16a34a;
        }

        .admin-alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
            color: #dc2626;
        }

        /* Form Elements */
        .admin-input:focus,
        .admin-textarea:focus {
            outline: none;
            border-color: var(--admin-accent-color);
            box-shadow: 0 0 0 3px rgba(128, 128, 128, 0.2);
        }

        .admin-button {
            background-color: var(--admin-bg-tertiary);
            color: var(--admin-text-primary);
            border: 1px solid var(--admin-border-primary);
            border-radius: 8px;
            padding: 8px 16px;
            transition: all 0.3s ease;
            cursor: pointer;
            font-weight: 500;
        }

        .admin-button:hover {
            background-color: var(--admin-bg-secondary);
            color: var(--admin-text-primary);
            border-color: var(--admin-border-secondary);
            transform: translateY(-1px);
        }

        .admin-button-primary {
            background-color: var(--admin-accent-color);
            color: var(--admin-bg-primary);
            border-color: var(--admin-accent-color);
        }

        .admin-button-primary:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .admin-button-secondary {
            background-color: var(--admin-bg-primary);
            color: var(--admin-text-secondary);
            border: 1px solid var(--admin-border-primary);
        }

        .admin-button-secondary:hover {
            background-color: var(--admin-bg-tertiary);
            color: var(--admin-text-primary);
        }
    </style>
</head>
<body class="admin-content">
    <!-- Mobile Overlay -->
    <div class="mobile-overlay md:hidden" id="mobile-overlay"></div>

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="admin-sidebar w-64 md:w-64" id="admin-sidebar">
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-opacity-20" style="border-color: var(--admin-border-primary);">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold" style="color: var(--admin-text-primary);">Portfolio Admin</h2>
                        <p class="text-sm mt-1" style="color: var(--admin-text-tertiary);">Welcome, {{ Auth::user()->name }}</p>
                    </div>
                    <!-- Theme Toggle -->
                    <button class="theme-toggle md:hidden" id="theme-toggle">
                        <i class="fas fa-sun" id="theme-icon"></i>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 px-3">
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link flex items-center {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>

                <a href="{{ route('admin.homepage.index') }}" class="admin-nav-link flex items-center {{ request()->routeIs('admin.homepage.*') ? 'active' : '' }}">
                    <i class="fas fa-home mr-3"></i>
                    Homepage
                </a>

                <a href="{{ route('admin.about.index') }}" class="admin-nav-link flex items-center {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                    <i class="fas fa-user mr-3"></i>
                    About Page
                </a>

                <a href="{{ route('admin.projects.index') }}" class="admin-nav-link flex items-center {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
                    <i class="fas fa-folder mr-3"></i>
                    Projects
                </a>

                <a href="{{ route('admin.blog-categories.index') }}" class="admin-nav-link flex items-center {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags mr-3"></i>
                    Blog Categories
                </a>

                <a href="{{ route('admin.blogs.index') }}" class="admin-nav-link flex items-center {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                    <i class="fas fa-blog mr-3"></i>
                    Blog Posts
                </a>

                <a href="{{ route('admin.social-links.index') }}" class="admin-nav-link flex items-center {{ request()->routeIs('admin.social-links.*') ? 'active' : '' }}">
                    <i class="fas fa-share-alt mr-3"></i>
                    Social Links
                </a>

                <a href="{{ route('admin.contacts.index') }}" class="admin-nav-link flex items-center {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope mr-3"></i>
                    Messages
                </a>

                <!-- Separator -->
                <div class="h-px mx-4 my-6" style="background-color: var(--admin-border-primary);"></div>

                <a href="{{ route('home') }}" class="admin-nav-link flex items-center" target="_blank">
                    <i class="fas fa-external-link-alt mr-3"></i>
                    View Site
                </a>

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="admin-nav-link flex items-center w-full text-left">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        Logout
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col admin-main-content">
            <!-- Top Bar -->
            <header style="background-color: var(--admin-bg-card); border-bottom: 1px solid var(--admin-border-primary);">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <!-- Mobile Menu Toggle -->
                            <button class="md:hidden flex items-center justify-center w-8 h-8 rounded-lg" style="background-color: var(--admin-bg-tertiary);" id="mobile-menu-toggle">
                                <i class="fas fa-bars" style="color: var(--admin-text-primary);"></i>
                            </button>

                            <h1 class="text-2xl font-semibold" style="color: var(--admin-text-primary);">
                                @yield('page-title', 'Dashboard')
                            </h1>
                        </div>

                        <div class="flex items-center space-x-4">
                            <!-- Theme Toggle for Desktop -->
                            <button class="theme-toggle hidden md:flex" id="theme-toggle-desktop">
                                <i class="fas fa-sun" id="theme-icon-desktop"></i>
                            </button>

                            <div class="text-sm" style="color: var(--admin-text-tertiary);">
                                {{ now()->format('F j, Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6" style="background-color: var(--admin-bg-primary);">
                @if(session('success'))
                    <div class="admin-alert admin-alert-success">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="admin-alert admin-alert-error">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="admin-alert admin-alert-error">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Please fix the following errors:
                        </div>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- JavaScript for Theme Toggle and Mobile Menu -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const adminRoot = document.getElementById('admin-root');
            const themeToggle = document.getElementById('theme-toggle');
            const themeToggleDesktop = document.getElementById('theme-toggle-desktop');
            const themeIcon = document.getElementById('theme-icon');
            const themeIconDesktop = document.getElementById('theme-icon-desktop');
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const adminSidebar = document.getElementById('admin-sidebar');
            const mobileOverlay = document.getElementById('mobile-overlay');

            // Initialize theme from localStorage or default to dark
            const savedTheme = localStorage.getItem('admin-theme') || 'dark';
            if (savedTheme === 'light') {
                adminRoot.classList.add('light-theme');
                updateThemeIcons('light');
            } else {
                updateThemeIcons('dark');
            }

            // Theme toggle functionality
            function toggleTheme() {
                adminRoot.classList.toggle('light-theme');
                const isLight = adminRoot.classList.contains('light-theme');
                localStorage.setItem('admin-theme', isLight ? 'light' : 'dark');
                updateThemeIcons(isLight ? 'light' : 'dark');
            }

            function updateThemeIcons(theme) {
                const iconClass = theme === 'light' ? 'fas fa-moon' : 'fas fa-sun';
                if (themeIcon) themeIcon.className = iconClass;
                if (themeIconDesktop) themeIconDesktop.className = iconClass;
            }

            // Bind theme toggle events
            if (themeToggle) themeToggle.addEventListener('click', toggleTheme);
            if (themeToggleDesktop) themeToggleDesktop.addEventListener('click', toggleTheme);

            // Mobile menu functionality
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function() {
                    adminSidebar.classList.toggle('open');
                    mobileOverlay.classList.toggle('open');
                });
            }

            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', function() {
                    adminSidebar.classList.remove('open');
                    mobileOverlay.classList.remove('open');
                });
            }

            // Close mobile menu when clicking nav links
            document.querySelectorAll('.admin-nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        adminSidebar.classList.remove('open');
                        mobileOverlay.classList.remove('open');
                    }
                });
            });
        });
    </script>
</body>
</html>