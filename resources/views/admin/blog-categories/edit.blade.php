@extends('layouts.admin')

@section('title', 'Edit Category')

@section('page-title', 'Edit Category')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('admin.blog-categories.index') }}" class="inline-flex items-center text-sm hover:underline" style="color: var(--admin-text-secondary);">
            <i class="fas fa-arrow-left mr-2"></i>Back to Categories
        </a>
    </div>

    <div class="admin-card rounded-lg p-8">
        <form action="{{ route('admin.blog-categories.update', $blogCategory) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $blogCategory->name) }}" required
                       class="w-full px-4 py-2 rounded-lg border transition-colors duration-300 focus:outline-none focus:ring-2"
                       style="background-color: var(--admin-bg-secondary); border-color: var(--admin-border-primary); color: var(--admin-text-primary);">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">
                    Description
                </label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-4 py-2 rounded-lg border transition-colors duration-300 focus:outline-none focus:ring-2"
                          style="background-color: var(--admin-bg-secondary); border-color: var(--admin-border-primary); color: var(--admin-text-primary);">{{ old('description', $blogCategory->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('admin.blog-categories.index') }}" class="px-6 py-2 rounded-lg transition-colors duration-300" style="background-color: var(--admin-bg-tertiary); color: var(--admin-text-primary);">
                    Cancel
                </a>
                <button type="submit" class="admin-button px-6 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02]">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection