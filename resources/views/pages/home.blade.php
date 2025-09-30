@extends('layouts.portfolio')

@section('title', 'M. Arief Asyraf Portfolio')

@section('content')
    <!-- Mobile Navigation Menu Overlay -->
    <div class="nav-mobile" id="nav-mobile">
        <div class="mobile-overlay-container">
            <!-- Top Section: Theme Toggle and Close Button -->
            <div class="mobile-overlay-top">
                <!-- Theme Toggle (Left - aligned with logo) -->
                <button id="theme-toggle-overlay" class="theme-toggle">
                    <img src="{{ asset('assets/images/light-mode.png') }}" alt="Toggle theme" class="theme-toggle-icon w-6 h-6">
                </button>

                <!-- Close Button (Right - aligned with hamburger menu) -->
                <button class="mobile-menu-toggle active" id="mobile-menu-close">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

            <!-- Center Section: Navigation Links -->
            <div class="mobile-overlay-center">
                <div class="mobile-overlay-links">
                    <a href="{{ route('home') }}" class="mobile-nav-link">HOME</a>
                    <a href="{{ route('about') }}" class="mobile-nav-link">ABOUT</a>
                    <a href="{{ route('projects') }}" class="mobile-nav-link">PROJECTS</a>
                    <a href="{{ route('blog') }}" class="mobile-nav-link">BLOG</a>
                    <a href="{{ route('contact') }}" class="mobile-nav-link">CONTACT</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="pt-32">
        <!-- Hero Section -->
        <section class="hero-section max-w-6xl mx-auto px-10 sm:px-14 md:px-18 lg:px-12 py-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <!-- Left Content -->
                <div class="hero-content lg:col-span-8">
                    <!-- Main Heading -->
                    <h1 class="hero-title text-6xl lg:text-7xl font-bold leading-tight mb-8 tracking-wide text-center-mobile">
                        {{ $heroTitle ?? "I'M ADENEKAN WONDERFUL" }}
                    </h1>

                    <!-- Description -->
                    <div class="hero-description text-lg text-secondary leading-relaxed mb-12 space-y-6">
                        @if(isset($heroParagraphs) && $heroParagraphs->count() > 0)
                            @foreach($heroParagraphs as $paragraph)
                                <p>{!! $paragraph->content !!}</p>
                            @endforeach
                        @else
                            <p>
                                Your friendly neighborhood frontend developer, UX architect, and JavaScript engineer. I spend my days (and often nights) painting the
                                internet canvas with <span class="text-primary font-semibold">PROJECTS</span> and lines of code, turning zeroes and ones into immersive, interactive experiences.
                            </p>

                            <p>
                                Bona fide photochromic <span class="text-primary font-semibold">LENS</span> enthusiast - sunlight or indoors, I've got it covered. I tread the path of minimalism, finding beauty in
                                simplicity and order. When I'm not crafting beautiful web experiences, you can find me reading <span class="text-primary font-semibold">ARTICLES</span> or swaying to the rhythm of
                                Pop Music & Jazz, losing myself in the captivating flow of melodies. anyways you can <span class="text-primary font-semibold">CONTACT ME</span>
                            </p>
                        @endif
                    </div>

                    <!-- CTA Link -->
                    <a href="{{ route('about') }}" class="hero-cta inline-flex items-center text-primary hover:text-secondary transition-colors duration-300 group">
                        <span class="text-lg mr-3">See More About Me</span>
                        <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>

                <!-- Right Decorative Elements -->
                <div class="decorative-container lg:col-span-4 flex justify-center lg:justify-end hide-mobile">
                    <div class="decorative-elements relative">
                        <!-- Decorative Dots -->
                        <div class="decorative-dot w-2 h-2 bg-primary rounded-full opacity-60"></div>
                        <div class="decorative-dot w-2 h-2 bg-primary rounded-full opacity-40 mt-8 ml-12"></div>
                        <div class="decorative-dot w-2 h-2 bg-primary rounded-full opacity-80 mt-16 ml-6"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="max-w-6xl mx-auto px-6 sm:px-8 lg:px-12 py-12">
        <!-- Social Links -->
        <div class="footer-social flex items-center space-x-6">
            @if(isset($socialLinks) && $socialLinks->count() > 0)
                @foreach($socialLinks->where('is_active', true) as $social)
                    <a href="{{ $social->url }}" class="text-tertiary hover:text-primary transition-colors duration-300" target="_blank" rel="noopener noreferrer">
                        <i class="{{ $social->icon_class }} text-2xl"></i>
                    </a>
                @endforeach
            @endif
        </div>
    </footer>
@endsection