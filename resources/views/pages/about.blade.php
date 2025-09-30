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
                    <a href="{{ route('blog') }}" class="mobile-nav-link">BLOG</a>
                    <a href="{{ route('contact') }}" class="mobile-nav-link">CONTACT</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="pt-32">
        <!-- About Section -->
        <section class="max-w-6xl mx-auto px-8 py-12 container-padding">
            <!-- Page Title -->
            <h1 class="section-title text-5xl font-bold text-center-mobile" style="margin-bottom: 4rem;">About Me.</h1>

            <!-- Experience Sections -->
            <div class="space-y-6 mb-16">
                @if($experienceSections->count() > 0)
                    @foreach($experienceSections as $experience)
                        <div class="rounded-lg p-6 transition-transform duration-300 hover:scale-[1.02]" style="background: var(--admin-bg-secondary); border: 1px solid var(--admin-border-primary);">
                            <div class="flex justify-between items-start mb-3">
                                <h2 class="text-2xl font-semibold" style="color: var(--admin-text-primary);">
                                    {{ $experience->field }}
                                </h2>
                                <span class="text-sm whitespace-nowrap ml-4" style="color: var(--admin-text-secondary);">
                                    {{ $experience->year }}
                                </span>
                            </div>
                            <h3 class="text-base font-medium mb-2" style="color: var(--admin-text-secondary);">
                                {{ $experience->role }}
                            </h3>
                            <p class="text-base leading-relaxed" style="color: var(--admin-text-secondary);">
                                {{ $experience->description }}
                            </p>
                        </div>
                    @endforeach
                @endif

                <!-- Dynamic Sections -->
                @if($dynamicSections->count() > 0)
                    @foreach($dynamicSections as $section)
                        <div class="mt-12">
                            <h2 class="text-3xl font-semibold mb-6" style="color: var(--admin-text-primary);">{{ $section->section_name }}.</h2>
                            <div class="space-y-6">
                                @foreach($section->items as $item)
                                    <div class="rounded-lg p-6 transition-transform duration-300 hover:scale-[1.02]" style="background: var(--admin-bg-secondary); border: 1px solid var(--admin-border-primary);">
                                        <div class="flex justify-between items-start mb-3">
                                            <h3 class="text-xl font-semibold" style="color: var(--admin-text-primary);">
                                                {{ $item->title }}
                                            </h3>
                                            @if($item->link_url)
                                                <a href="{{ $item->link_url }}" class="text-sm whitespace-nowrap ml-4 hover:underline" style="color: var(--admin-text-secondary);" target="_blank" rel="noopener noreferrer">
                                                    {{ $item->link_text ?? 'Visit' }}
                                                </a>
                                            @elseif($item->year)
                                                <span class="text-sm whitespace-nowrap ml-4" style="color: var(--admin-text-secondary);">
                                                    {{ $item->year }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-base leading-relaxed" style="color: var(--admin-text-secondary);">
                                            {{ $item->description }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

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