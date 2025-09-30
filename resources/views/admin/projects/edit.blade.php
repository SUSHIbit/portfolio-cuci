@extends('layouts.admin')

@section('title', 'Edit Project')

@section('page-title', 'Edit Project: ' . $project->title)

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data" id="project-form">
        @csrf
        @method('PUT')

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
                        value="{{ old('title', $project->title) }}"
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
                    >{{ old('short_description', $project->short_description) }}</textarea>
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
                    >{{ old('detailed_description', $project->detailed_description) }}</textarea>
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
                            value="{{ old('project_url', $project->project_url) }}"
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
                            value="{{ old('github_url', $project->github_url) }}"
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
                        value="{{ old('technologies', $project->technologies->pluck('technology_name')->implode(', ')) }}"
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
                        <input type="checkbox" name="is_featured" class="mr-2" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}>
                        <span class="text-sm font-medium" style="color: var(--admin-text-primary);">Featured Project</span>
                    </label>
                    <p class="mt-1 text-sm" style="color: var(--admin-text-secondary);">Featured projects will be highlighted on the portfolio</p>
                </div>
            </div>
        </div>

        <!-- Existing Images -->
        @if($project->images->count() > 0)
            <div class="admin-card rounded-lg mb-6">
                <div class="p-6" style="border-bottom: 1px solid var(--admin-border-primary);">
                    <h2 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Current Images</h2>
                    <p class="text-sm" style="color: var(--admin-text-secondary);">Manage existing project images</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($project->images as $image)
                            <div class="relative image-container" id="image-{{ $image->id }}" style="cursor: pointer;">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->alt_text }}" class="w-full h-32 object-cover rounded-lg" style="border: 1px solid var(--admin-border-primary); display: block;">
                                @if($image->is_primary)
                                    <div class="absolute top-2 left-2 text-white px-2 py-1 text-xs rounded" style="background-color: #f59e0b; z-index: 5;">Primary</div>
                                @endif
                                <div class="image-overlay absolute inset-0 rounded-lg flex items-center justify-center" style="
                                    background-color: rgba(0, 0, 0, 0.7);
                                    opacity: 0;
                                    transition: opacity 0.3s ease;
                                    z-index: 3;
                                ">
                                    <button
                                        type="button"
                                        onclick="deleteImage({{ $image->id }})"
                                        data-image-id="{{ $image->id }}"
                                        class="delete-image-btn"
                                        style="
                                            background-color: #dc2626;
                                            color: white;
                                            padding: 8px 16px;
                                            border-radius: 6px;
                                            border: none;
                                            font-size: 14px;
                                            font-weight: 500;
                                            cursor: pointer;
                                            transition: background-color 0.2s ease;
                                            z-index: 4;
                                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                                        "
                                        title="Delete this image"
                                        onmouseover="this.style.backgroundColor='#b91c1c'"
                                        onmouseout="this.style.backgroundColor='#dc2626'"
                                    >
                                        <i class="fas fa-trash" style="margin-right: 6px;"></i>Delete
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Add New Images -->
        <div class="admin-card rounded-lg mb-6">
            <div class="p-6" style="border-bottom: 1px solid var(--admin-border-primary);">
                <h2 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Add New Images</h2>
                <p class="text-sm" style="color: var(--admin-text-secondary);">Upload additional images for your project (max 5MB each)</p>
            </div>
            <div class="p-6">
                <div id="image-upload-area" class="border-2 border-dashed rounded-lg p-6 text-center transition-colors" style="border-color: var(--admin-border-primary);">
                    <input type="file" id="new_images" name="new_images[]" multiple accept="image/*" class="hidden">
                    <label for="new_images" class="cursor-pointer">
                        <i class="fas fa-cloud-upload-alt text-4xl mb-4" style="color: var(--admin-text-tertiary);"></i>
                        <p class="text-lg font-medium mb-2" style="color: var(--admin-text-primary);">Click to upload new images</p>
                        <p class="text-sm" style="color: var(--admin-text-secondary);">or drag and drop</p>
                        <p class="text-xs mt-2" style="color: var(--admin-text-tertiary);">PNG, JPG, GIF up to 5MB each</p>
                    </label>
                </div>

                <div id="image-preview" class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 hidden"></div>

                @error('new_images')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('new_images.*')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.projects.index') }}" class="admin-button-secondary px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Projects
            </a>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.projects.show', $project) }}" class="admin-button-secondary px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-eye mr-2"></i>View Project
                </a>
                <button type="submit" class="admin-button px-6 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02] focus:outline-none">
                    <i class="fas fa-save mr-2"></i>Update Project
                </button>
            </div>
        </div>
    </form>
</div>

<style>
/* Image hover delete functionality */
.image-container:hover .image-overlay {
    opacity: 1 !important;
}

.image-container {
    position: relative;
    overflow: hidden;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
}

.delete-image-btn:hover {
    transform: scale(1.05);
}

.delete-image-btn:active {
    transform: scale(0.98);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('new_images');
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
                            <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-32 object-cover rounded-lg" style="border: 1px solid var(--admin-border-primary);">
                            <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                <span class="text-white text-sm">New Image ${index + 1}</span>
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

function deleteImage(imageId) {
    if (confirm('Are you sure you want to delete this image?')) {
        console.log('Attempting to delete image ID:', imageId);

        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (!csrfToken) {
            alert('CSRF token not found. Please refresh the page.');
            return;
        }

        const url = `{{ url('admin/projects/images') }}/${imageId}`;
        console.log('DELETE request URL:', url);

        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);

            if (data.success) {
                const imageElement = document.getElementById(`image-${imageId}`);
                if (imageElement) {
                    imageElement.remove();
                    alert('Image deleted successfully!');

                    // Check if this was the last image
                    const remainingImages = document.querySelectorAll('[id^="image-"]');
                    if (remainingImages.length === 0) {
                        location.reload(); // Reload to hide the "Current Images" section
                    }
                } else {
                    console.error('Image element not found:', `image-${imageId}`);
                }
            } else {
                alert('Failed to delete image: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('Failed to delete image: ' + error.message);
        });
    }
}
</script>
@endsection