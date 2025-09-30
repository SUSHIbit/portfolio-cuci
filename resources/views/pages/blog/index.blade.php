@extends('layouts.portfolio')

@section('title', 'Blog - M. Arief Asyraf')

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
        <!-- Blog Section -->
        <section class="max-w-6xl mx-auto px-8 py-12 container-padding">
            <!-- Page Title and Filter -->
            <div class="flex justify-between items-center" style="margin-bottom: 4rem;">
                <h1 class="section-title text-5xl font-bold text-center-mobile">Blog.</h1>

                <!-- Category Filter -->
                <div class="relative">
                    <select id="categoryFilter" class="px-4 py-2 rounded-lg border transition-colors duration-300" style="background: var(--admin-bg-secondary); color: var(--admin-text-primary); border-color: var(--admin-border-primary);" onchange="filterByCategory(this.value)">
                        <option value="">Filter</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Blog Posts List -->
            <div class="space-y-6 mb-16">
                @if(isset($blogs) && $blogs->count() > 0)
                    @foreach($blogs as $blog)
                        <a href="{{ route('blog.show', $blog->slug) }}" class="block">
                            <div class="blog-card rounded-lg p-6 transition-transform duration-300 hover:scale-[1.02] cursor-pointer border border-gray-300 dark:border-gray-700" style="background: var(--admin-bg-secondary);">
                                <div class="flex justify-between items-start mb-3">
                                    <h2 class="text-2xl font-semibold" style="color: var(--admin-text-primary);">
                                        {{ $blog->title }}
                                    </h2>
                                    <span class="text-sm whitespace-nowrap ml-4" style="color: var(--admin-text-secondary);">
                                        {{ $blog->published_date->format('M d, Y') }}
                                    </span>
                                </div>
                                <p class="text-base leading-relaxed" style="color: var(--admin-text-secondary);">
                                    {{ $blog->excerpt }}
                                </p>
                            </div>
                        </a>
                    @endforeach

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $blogs->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="text-center">
                            <i class="fas fa-blog text-6xl mb-4" style="color: var(--text-tertiary);"></i>
                            <h3 class="text-xl font-semibold mb-2" style="color: var(--text-primary);">No Blog Posts Yet</h3>
                            <p class="text-gray-500 mb-6">Blog posts will appear here once published.</p>
                            @auth
                                <a href="{{ route('admin.blogs.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                                    <i class="fas fa-plus mr-2"></i>
                                    Create Your First Blog Post
                                </a>
                            @endauth
                        </div>
                    </div>
                @endif
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

    <script>
        function filterByCategory(categoryId) {
            if (categoryId) {
                window.location.href = '{{ route("blog") }}?category=' + categoryId;
            } else {
                window.location.href = '{{ route("blog") }}';
            }
        }
    </script>
@endsection