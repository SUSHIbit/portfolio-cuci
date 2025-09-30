@extends('layouts.portfolio')

@section('title', 'Contact - M. Arief Asyraf')

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
        <!-- Contact Section -->
        <section class="max-w-4xl mx-auto px-8 py-12 container-padding">
            <div class="contact-grid grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Left Content -->
                <div class="lg:col-span-7">
                    <!-- Page Title -->
                    <h1 class="section-title text-5xl font-bold mb-8 text-center-mobile">Contact.</h1>

                    <!-- Email CTA -->
                    <div class="mb-12">
                        <p class="text-lg text-secondary mb-4">
                            Get in touch or shoot me an email directly on
                            <a href="mailto:ariefsushi1@gmail.com" class="text-primary font-semibold hover:text-secondary transition-colors duration-300">
                                ariefsushi1@gmail.com
                            </a>
                        </p>
                    </div>

                    <!-- Contact Form -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-600 text-white rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-600 text-white rounded-lg">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="contact-form space-y-6" id="contact-form" action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <!-- Name Field -->
                        <div>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                placeholder="Name"
                                value="{{ old('name') }}"
                                required
                                class="w-full bg-transparent border border-border-primary text-primary placeholder-tertiary py-4 px-6 rounded-lg focus:border-primary focus:outline-none transition-all duration-300"
                            >
                        </div>

                        <!-- Email Field -->
                        <div>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="Email"
                                value="{{ old('email') }}"
                                required
                                class="w-full bg-transparent border border-border-primary text-primary placeholder-tertiary py-4 px-6 rounded-lg focus:border-primary focus:outline-none transition-all duration-300"
                            >
                        </div>

                        <!-- Message Field -->
                        <div>
                            <textarea
                                id="message"
                                name="message"
                                placeholder="Message"
                                rows="6"
                                required
                                class="w-full bg-transparent border border-border-primary text-primary placeholder-tertiary py-4 px-6 rounded-lg focus:border-primary focus:outline-none resize-none transition-all duration-300"
                            >{{ old('message') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6">
                            <button
                                type="submit"
                                class="w-full sm:w-auto px-12 py-4 bg-neutral-900 text-white rounded-lg font-semibold hover:bg-neutral-800 transition-all duration-300 min-h-12"
                            >
                                Send Message
                            </button>
                        </div>
                    </form>

                    <!-- Back Link -->
                    <div class="mt-16">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-primary hover:text-secondary transition-colors duration-300 group">
                            <span class="text-lg mr-3">Go Back Home</span>
                            <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Right Decorative Elements -->
                <div class="decorative-container lg:col-span-5 flex justify-center lg:justify-end hide-mobile">
                    <div class="decorative-elements relative">
                        <!-- Decorative Circle -->
                        <div class="w-32 h-32 border-2 border-primary rounded-full flex items-center justify-center">
                            <div class="w-16 h-16 border border-secondary rounded-full"></div>
                        </div>

                        <!-- Decorative Dots -->
                        <div class="absolute -bottom-8 -right-8">
                            <div class="decorative-dot w-2 h-2 bg-primary rounded-full opacity-60"></div>
                        </div>
                        <div class="absolute top-16 -left-12">
                            <div class="decorative-dot w-2 h-2 bg-primary rounded-full opacity-40"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="max-w-6xl mx-auto px-8 py-12 container-padding">
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