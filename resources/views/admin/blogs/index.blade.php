@extends('layouts.admin')

@section('title', 'Blog Posts')

@section('page-title', 'Blog Posts')

@section('content')
<div class="max-w-6xl">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold" style="color: var(--admin-text-primary);">All Blog Posts</h2>
            <p class="text-sm" style="color: var(--admin-text-secondary);">Manage your blog posts</p>
        </div>
        <a href="{{ route('admin.blogs.create') }}" class="admin-button px-4 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02] focus:outline-none">
            <i class="fas fa-plus mr-2"></i>Add New Post
        </a>
    </div>

    @if($blogs->count() > 0)
        <div class="space-y-4">
            @foreach($blogs as $blog)
                <div class="admin-card rounded-lg p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="font-semibold text-lg" style="color: var(--admin-text-primary);">{{ $blog->title }}</h3>
                                <span class="px-2 py-1 text-xs rounded {{ $blog->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($blog->status) }}
                                </span>
                            </div>
                            <p class="text-sm mb-3" style="color: var(--admin-text-secondary);">{{ Str::limit($blog->excerpt, 120) }}</p>
                            <div class="flex items-center gap-4 text-sm" style="color: var(--admin-text-secondary);">
                                <span><i class="fas fa-folder mr-1"></i>{{ $blog->category->name }}</span>
                                <span><i class="fas fa-calendar mr-1"></i>{{ $blog->published_date->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            <a href="{{ route('admin.blogs.edit', $blog) }}" class="admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" style="color: var(--admin-accent-color);" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this blog post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" style="color: #dc2626;" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="admin-card rounded-lg p-12 text-center">
            <i class="fas fa-blog text-6xl mb-4" style="color: var(--admin-text-tertiary);"></i>
            <h3 class="text-lg font-semibold mb-2" style="color: var(--admin-text-primary);">No Blog Posts Yet</h3>
            <p class="text-sm mb-6" style="color: var(--admin-text-secondary);">Create your first blog post to get started.</p>
            <a href="{{ route('admin.blogs.create') }}" class="admin-button px-6 py-3 rounded-lg transition-all duration-300 hover:scale-[1.02]">
                <i class="fas fa-plus mr-2"></i>Add First Post
            </a>
        </div>
    @endif
</div>
@endsection