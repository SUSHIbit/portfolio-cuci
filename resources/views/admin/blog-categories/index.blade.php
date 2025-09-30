@extends('layouts.admin')

@section('title', 'Blog Categories')

@section('page-title', 'Blog Categories')

@section('content')
<div class="max-w-6xl">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold" style="color: var(--admin-text-primary);">All Categories</h2>
            <p class="text-sm" style="color: var(--admin-text-secondary);">Manage blog categories</p>
        </div>
        <a href="{{ route('admin.blog-categories.create') }}" class="admin-button px-4 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02] focus:outline-none">
            <i class="fas fa-plus mr-2"></i>Add New Category
        </a>
    </div>

    @if($categories->count() > 0)
        <div class="admin-card rounded-lg overflow-hidden">
            <table class="w-full">
                <thead style="background-color: var(--admin-bg-tertiary);">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--admin-text-secondary);">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--admin-text-secondary);">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--admin-text-secondary);">Posts</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" style="color: var(--admin-text-secondary);">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y" style="divide-color: var(--admin-border-primary);">
                    @foreach($categories as $category)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="font-medium" style="color: var(--admin-text-primary);">{{ $category->name }}</div>
                                @if($category->description)
                                    <div class="text-sm mt-1" style="color: var(--admin-text-secondary);">{{ Str::limit($category->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm" style="color: var(--admin-text-secondary);">{{ $category->slug }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded" style="background-color: var(--admin-bg-tertiary); color: var(--admin-text-primary);">
                                    {{ $category->blogs_count }} {{ Str::plural('post', $category->blogs_count) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.blog-categories.edit', $category) }}" class="admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" style="color: var(--admin-accent-color);" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.blog-categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" style="color: #dc2626;" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="admin-card rounded-lg p-12 text-center">
            <i class="fas fa-folder-open text-6xl mb-4" style="color: var(--admin-text-tertiary);"></i>
            <h3 class="text-lg font-semibold mb-2" style="color: var(--admin-text-primary);">No Categories Yet</h3>
            <p class="text-sm mb-6" style="color: var(--admin-text-secondary);">Create your first blog category to get started.</p>
            <a href="{{ route('admin.blog-categories.create') }}" class="admin-button px-6 py-3 rounded-lg transition-all duration-300 hover:scale-[1.02]">
                <i class="fas fa-plus mr-2"></i>Add First Category
            </a>
        </div>
    @endif
</div>
@endsection