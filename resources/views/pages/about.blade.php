@extends('layouts.portfolio')

@section('title', 'About - M. Arief Asyraf')

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
                    <a href="{{ route('contact') }}" class="mobile-nav-link">CONTACT</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="pt-32">
        <!-- About Section -->
        <section class="about-section max-w-4xl mx-auto px-10 sm:px-14 md:px-18 lg:px-12 py-12">
            <!-- Page Title -->
            <h1 class="section-title text-5xl font-bold text-center-mobile" style="margin-bottom: 6rem;">About Me.</h1>

            <!-- Experience Sections -->
            @if($experienceSections->count() > 0)
                @foreach($experienceSections as $experience)
                    <div class="timeline-item" style="margin-bottom: 6rem;">
                        <div class="timeline-header flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-semibold">{{ $experience->field }}</h2>
                            <span class="timeline-date text-tertiary text-sm">{{ $experience->year }}</span>
                        </div>
                        <div class="space-y-8">
                            <div>
                                <h3 class="text-lg font-medium text-primary mb-2">{{ $experience->role }}</h3>
                                <p class="text-secondary text-sm leading-relaxed">
                                    {{ $experience->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Dynamic Sections -->
            @if($dynamicSections->count() > 0)
                @foreach($dynamicSections as $section)
                    <div style="margin-bottom: 6rem;">
                        <h2 class="text-2xl font-semibold mb-6">{{ $section->section_name }}.</h2>
                        <div class="space-y-6">
                            @foreach($section->items as $item)
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-medium text-primary mb-2">{{ $item->title }}</h3>
                                        <p class="text-secondary text-sm leading-relaxed">
                                            {{ $item->description }}
                                        </p>
                                    </div>
                                    @if($item->link_url)
                                        <a href="{{ $item->link_url }}" class="text-tertiary hover:text-primary text-xs ml-8" target="_blank" rel="noopener noreferrer">{{ $item->link_text ?? 'Visit' }}</a>
                                    @elseif($item->year)
                                        <span class="text-tertiary text-xs ml-8">{{ $item->year }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Empty State Message -->
            @if($experienceSections->count() == 0 && $dynamicSections->count() == 0)
                <div class="text-center py-16">
                    <div class="text-tertiary text-lg mb-4">
                        <i class="fas fa-user-edit text-4xl mb-4"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-primary mb-4">About page content coming soon</h3>
                    <p class="text-secondary">
                        This page will be updated with experience details and personal information.
                    </p>
                </div>
            @endif
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