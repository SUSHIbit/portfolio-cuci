@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Projects Count -->
    <div class="admin-card p-6 hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: var(--admin-bg-tertiary);">
                    <i class="fas fa-folder text-xl" style="color: var(--admin-accent-color);"></i>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium" style="color: var(--admin-text-secondary);">Projects</h3>
                <p class="text-3xl font-bold" style="color: var(--admin-text-primary);">{{ $stats['projects'] }}</p>
            </div>
        </div>
    </div>

    <!-- Unread Messages -->
    <div class="admin-card p-6 hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: var(--admin-bg-tertiary);">
                    <i class="fas fa-envelope text-xl" style="color: var(--admin-accent-color);"></i>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium" style="color: var(--admin-text-secondary);">New Messages</h3>
                <p class="text-3xl font-bold" style="color: var(--admin-text-primary);">{{ $stats['messages'] }}</p>
            </div>
        </div>
    </div>

    <!-- Hero Paragraphs -->
    <div class="admin-card p-6 hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: var(--admin-bg-tertiary);">
                    <i class="fas fa-paragraph text-xl" style="color: var(--admin-accent-color);"></i>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium" style="color: var(--admin-text-secondary);">Hero Paragraphs</h3>
                <p class="text-3xl font-bold" style="color: var(--admin-text-primary);">{{ $stats['hero_paragraphs'] }}</p>
            </div>
        </div>
    </div>

    <!-- Active Social Links -->
    <div class="admin-card p-6 hover:scale-[1.02] transition-transform duration-300">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: var(--admin-bg-tertiary);">
                    <i class="fas fa-share-alt text-xl" style="color: var(--admin-accent-color);"></i>
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-medium" style="color: var(--admin-text-secondary);">Social Links</h3>
                <p class="text-3xl font-bold" style="color: var(--admin-text-primary);">{{ $stats['social_links'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="admin-card">
        <div class="p-6" style="border-bottom: 1px solid var(--admin-border-primary);">
            <h3 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Quick Actions</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <a href="{{ route('admin.homepage.index') }}" class="flex items-center p-4 rounded-lg transition-all duration-300 hover:scale-[1.02]" style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary);">
                    <i class="fas fa-home mr-3 text-xl" style="color: var(--admin-accent-color);"></i>
                    <div>
                        <h4 class="font-medium" style="color: var(--admin-text-primary);">Edit Homepage</h4>
                        <p class="text-sm" style="color: var(--admin-text-secondary);">Update hero title and paragraphs</p>
                    </div>
                </a>

                <a href="{{ route('admin.projects.create') }}" class="flex items-center p-4 rounded-lg transition-all duration-300 hover:scale-[1.02]" style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary);">
                    <i class="fas fa-plus mr-3 text-xl" style="color: var(--admin-accent-color);"></i>
                    <div>
                        <h4 class="font-medium" style="color: var(--admin-text-primary);">Add New Project</h4>
                        <p class="text-sm" style="color: var(--admin-text-secondary);">Create a new portfolio project</p>
                    </div>
                </a>

                <a href="{{ route('admin.social-links.index') }}" class="flex items-center p-4 rounded-lg transition-all duration-300 hover:scale-[1.02]" style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary);">
                    <i class="fas fa-share-alt mr-3 text-xl" style="color: var(--admin-accent-color);"></i>
                    <div>
                        <h4 class="font-medium" style="color: var(--admin-text-primary);">Manage Social Links</h4>
                        <p class="text-sm" style="color: var(--admin-text-secondary);">Update social media links</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="admin-card">
        <div class="p-6" style="border-bottom: 1px solid var(--admin-border-primary);">
            <h3 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Portfolio Overview</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 rounded-lg" style="background-color: var(--admin-bg-tertiary);">
                    <div class="flex items-center">
                        <i class="fas fa-globe mr-3" style="color: var(--admin-accent-color);"></i>
                        <span style="color: var(--admin-text-primary);">Public Portfolio</span>
                    </div>
                    <a href="{{ route('home') }}" target="_blank" class="text-sm px-3 py-1 rounded transition-colors hover:scale-[1.02]" style="background-color: var(--admin-bg-primary); color: var(--admin-text-primary); border: 1px solid var(--admin-border-primary);">
                        View Live
                    </a>
                </div>

                <div class="flex items-center justify-between p-3 rounded-lg" style="background-color: var(--admin-bg-tertiary);">
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-3" style="color: var(--admin-accent-color);"></i>
                        <span style="color: var(--admin-text-primary);">Contact Messages</span>
                    </div>
                    <a href="{{ route('admin.contacts.index') }}" class="text-sm px-3 py-1 rounded transition-colors hover:scale-[1.02]" style="background-color: var(--admin-bg-primary); color: var(--admin-text-primary); border: 1px solid var(--admin-border-primary);">
                        View All
                    </a>
                </div>

                <div class="flex items-center justify-between p-3 rounded-lg" style="background-color: var(--admin-bg-tertiary);">
                    <div class="flex items-center">
                        <i class="fas fa-user mr-3" style="color: var(--admin-accent-color);"></i>
                        <span style="color: var(--admin-text-primary);">About Page</span>
                    </div>
                    <a href="{{ route('admin.about.index') }}" class="text-sm px-3 py-1 rounded transition-colors hover:scale-[1.02]" style="background-color: var(--admin-bg-primary); color: var(--admin-text-primary); border: 1px solid var(--admin-border-primary);">
                        Manage
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection