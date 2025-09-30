@extends('layouts.admin')

@section('title', 'Create New Project')

@section('page-title', 'Create New Project')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" id="project-form">
        @csrf

        <!-- Project Details -->
        <div class="admin-card rounded-lg mb-6">
            <div class="p-6" style="border-bottom: 1px solid var(--admin-border-primary);">
                <h2 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Project Details</h2>
                <p class="text-sm" style="color: var(--admin-text-secondary);">Basic information about your project</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Project Title *</label>
                    <input
                        type="text"
                        id="title"
                        name="title"
                        value="{{ old('title') }}"
                        class="w-full px-3 py-2 rounded-lg focus:outline-none"
                        style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);"
                        placeholder="My Awesome Project"
                        required
                    >
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="short_description" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Short Description *</label>
                    <textarea
                        id="short_description"
                        name="short_description"
                        rows="3"
                        class="w-full px-3 py-2 rounded-lg focus:outline-none resize-none"
                        style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);"
                        placeholder="A brief description of your project (max 500 characters)"
                        maxlength="500"
                        required
                    >{{ old('short_description') }}</textarea>
                    @error('short_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="detailed_description" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Detailed Description *</label>
                    <textarea
                        id="detailed_description"
                        name="detailed_description"
                        rows="6"
                        class="w-full px-3 py-2 rounded-lg focus:outline-none resize-none"
                        style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);"
                        placeholder="Detailed description of your project, features, challenges, etc."
                        required
                    >{{ old('detailed_description') }}</textarea>
                    @error('detailed_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="project_url" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Project URL</label>
                        <input
                            type="url"
                            id="project_url"
                            name="project_url"
                            value="{{ old('project_url') }}"
                            class="w-full px-3 py-2 rounded-lg focus:outline-none"
                            style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);"
                            placeholder="https://example.com"
                        >
                        @error('project_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="github_url" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">GitHub URL</label>
                        <input
                            type="url"
                            id="github_url"
                            name="github_url"
                            value="{{ old('github_url') }}"
                            class="w-full px-3 py-2 rounded-lg focus:outline-none"
                            style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);"
                            placeholder="https://github.com/username/repo"
                        >
                        @error('github_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="technologies" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Technologies Used *</label>
                    <input
                        type="text"
                        id="technologies"
                        name="technologies"
                        value="{{ old('technologies') }}"
                        class="w-full px-3 py-2 rounded-lg focus:outline-none"
                        style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);"
                        placeholder="React, Node.js, MongoDB, CSS"
                        required
                    >
                    <p class="mt-1 text-sm" style="color: var(--admin-text-secondary);">Separate technologies with commas</p>
                    @error('technologies')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" class="mr-2" {{ old('is_featured') ? 'checked' : '' }}>
                        <span class="text-sm font-medium" style="color: var(--admin-text-primary);">Featured Project</span>
                    </label>
                    <p class="mt-1 text-sm" style="color: var(--admin-text-secondary);">Featured projects will be highlighted on the portfolio</p>
                </div>
            </div>
        </div>

        <!-- Project Images -->
        <div class="admin-card rounded-lg mb-6">
            <div class="p-6" style="border-bottom: 1px solid var(--admin-border-primary);">
                <h2 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Project Images *</h2>
                <p class="text-sm" style="color: var(--admin-text-secondary);">Upload at least one image for your project (max 5MB each)</p>
            </div>
            <div class="p-6">
                <div id="image-upload-area" class="border-2 border-dashed rounded-lg p-6 text-center transition-colors" style="border-color: var(--admin-border-primary);">
                    <input type="file" id="images" name="images[]" multiple accept="image/*" class="hidden" required>
                    <label for="images" class="cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-4xl mb-4" style="color: var(--admin-text-tertiary);"></i>
                        <p class="text-lg font-medium mb-2" style="color: var(--admin-text-primary);">Click to upload images</p>
                        <p class="text-sm" style="color: var(--admin-text-secondary);">or drag and drop</p>
                        <p class="text-xs mt-2" style="color: var(--admin-text-tertiary);">PNG, JPG, GIF up to 5MB each</p>
                    </label>
                </div>

                <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 hidden"></div>

                @error('images')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.projects.index') }}" class="admin-button-secondary px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Projects
            </a>
            <button type="submit" class="admin-button px-6 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02] focus:outline-none">
                <i class="fas fa-save mr-2"></i>Create Project
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('images');
    const imagePreview = document.getElementById('image-preview');
    const uploadArea = document.getElementById('image-upload-area');

    imageInput.addEventListener('change', function(e) {
        previewImages(e.target.files);
    });

    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = 'var(--admin-accent-color)';
        uploadArea.style.backgroundColor = 'var(--admin-bg-tertiary)';
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = 'var(--admin-border-primary)';
        uploadArea.style.backgroundColor = 'transparent';
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.style.borderColor = 'var(--admin-border-primary)';
        uploadArea.style.backgroundColor = 'transparent';

        const files = e.dataTransfer.files;
        imageInput.files = files;
        previewImages(files);
    });

    function previewImages(files) {
        imagePreview.innerHTML = '';

        if (files.length > 0) {
            imagePreview.classList.remove('hidden');

            Array.from(files).forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative group';
                        div.innerHTML = `
                            <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-24 object-cover rounded-lg border">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                <span class="text-white text-sm">${index === 0 ? 'Primary' : `Image ${index + 1}`}</span>
                            </div>
                        `;
                        imagePreview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            });
        } else {
            imagePreview.classList.add('hidden');
        }
    }
});
</script>
@endsection