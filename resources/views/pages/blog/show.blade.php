@extends('layouts.portfolio')

@section('title', $blog->title . ' - M. Arief Asyraf')

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
        <!-- Blog Post Section -->
        <section class="max-w-4xl mx-auto px-8 py-12 container-padding">
            <!-- Back to Blog Link -->
            <div class="mb-8">
                <a href="{{ route('blog') }}" class="inline-flex items-center hover:underline transition-colors duration-300" style="color: var(--admin-text-secondary);">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Blog
                </a>
            </div>

            <!-- Blog Title and Meta -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-3 py-1 rounded-full text-sm" style="background: var(--admin-bg-secondary); color: var(--admin-text-primary); border: 1px solid var(--admin-border-primary);">
                        {{ $blog->category->name }}
                    </span>
                    <span class="text-sm" style="color: var(--admin-text-secondary);">
                        {{ $blog->published_date->format('F d, Y') }}
                    </span>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4" style="color: var(--admin-text-primary);">
                    {{ $blog->title }}
                </h1>
                <p class="text-lg" style="color: var(--admin-text-secondary);">
                    {{ $blog->excerpt }}
                </p>
            </div>

            <!-- Featured Image -->
            @if($blog->featured_image)
                <div class="mb-8 rounded-lg overflow-hidden">
                    <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-auto object-cover">
                </div>
            @endif

            <!-- Blog Content Blocks -->
            <div class="blog-content space-y-6">
                @foreach($blog->contentBlocks as $block)
                    @if($block->type === 'paragraph')
                        <div class="prose prose-lg max-w-none">
                            <p class="text-base leading-relaxed" style="color: var(--admin-text-primary);">
                                {{ $block->content }}
                            </p>
                        </div>
                    @elseif($block->type === 'image')
                        <div class="my-8 rounded-lg overflow-hidden">
                            <img src="{{ asset($block->content) }}" alt="Blog content image" class="w-full h-auto object-cover">
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Back to Blog Button -->
            <div class="mt-12 pt-8 border-t" style="border-color: var(--admin-border-primary);">
                <a href="{{ route('blog') }}" class="inline-flex items-center px-6 py-3 rounded-lg transition-colors duration-300" style="background: var(--admin-bg-secondary); color: var(--admin-text-primary); border: 1px solid var(--admin-border-primary);">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to All Posts
                </a>
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