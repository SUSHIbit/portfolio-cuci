@extends('layouts.admin')

@section('title', 'Edit Blog Post')

@section('page-title', 'Edit Blog Post')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.blogs.index') }}" class="inline-flex items-center text-sm hover:underline" style="color: var(--admin-text-secondary);">
            <i class="fas fa-arrow-left mr-2"></i>Back to Blog Posts
        </a>
    </div>

    <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data" id="blogForm">
        @csrf
        @method('PUT')

        <div class="admin-card rounded-lg p-8 mb-6">
            <h3 class="text-lg font-semibold mb-6" style="color: var(--admin-text-primary);">Basic Information</h3>

            <div class="mb-6">
                <label for="title" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title" value="{{ old('title', $blog->title) }}" required
                       class="w-full px-4 py-2 rounded-lg border transition-colors duration-300 focus:outline-none focus:ring-2"
                       style="background-color: var(--admin-bg-secondary); border-color: var(--admin-border-primary); color: var(--admin-text-primary);">
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="excerpt" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">
                    Excerpt <span class="text-red-500">*</span>
                </label>
                <textarea id="excerpt" name="excerpt" rows="3" required
                          class="w-full px-4 py-2 rounded-lg border transition-colors duration-300 focus:outline-none focus:ring-2"
                          style="background-color: var(--admin-bg-secondary); border-color: var(--admin-border-primary); color: var(--admin-text-primary);">{{ old('excerpt', $blog->excerpt) }}</textarea>
                @error('excerpt')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="blog_category_id" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select id="blog_category_id" name="blog_category_id" required
                            class="w-full px-4 py-2 rounded-lg border transition-colors duration-300 focus:outline-none focus:ring-2"
                            style="background-color: var(--admin-bg-secondary); border-color: var(--admin-border-primary); color: var(--admin-text-primary);">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('blog_category_id', $blog->blog_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('blog_category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required
                            class="w-full px-4 py-2 rounded-lg border transition-colors duration-300 focus:outline-none focus:ring-2"
                            style="background-color: var(--admin-bg-secondary); border-color: var(--admin-border-primary); color: var(--admin-text-primary);">
                        <option value="draft" {{ old('status', $blog->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $blog->status) == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="published_date" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">
                        Published Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="published_date" name="published_date" value="{{ old('published_date', $blog->published_date ? $blog->published_date->format('Y-m-d') : date('Y-m-d')) }}" required
                           class="w-full px-4 py-2 rounded-lg border transition-colors duration-300 focus:outline-none focus:ring-2"
                           style="background-color: var(--admin-bg-secondary); border-color: var(--admin-border-primary); color: var(--admin-text-primary);">
                    @error('published_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="featured_image" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">
                        Featured Image
                    </label>
                    @if($blog->featured_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="Current featured image" class="h-24 w-auto rounded-lg border" style="border-color: var(--admin-border-primary);">
                            <p class="text-xs mt-1" style="color: var(--admin-text-secondary);">Current image (upload new to replace)</p>
                        </div>
                    @endif
                    <input type="file" id="featured_image" name="featured_image" accept="image/*"
                           class="w-full px-4 py-2 rounded-lg border transition-colors duration-300 focus:outline-none focus:ring-2"
                           style="background-color: var(--admin-bg-secondary); border-color: var(--admin-border-primary); color: var(--admin-text-primary);">
                    @error('featured_image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="admin-card rounded-lg p-8 mb-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Content Blocks</h3>
                <div class="flex gap-2">
                    <button type="button" onclick="addParagraphBlock()" class="admin-button px-4 py-2 rounded-lg text-sm">
                        <i class="fas fa-paragraph mr-2"></i>Add Paragraph
                    </button>
                    <button type="button" onclick="addImageBlock()" class="admin-button px-4 py-2 rounded-lg text-sm">
                        <i class="fas fa-image mr-2"></i>Add Image
                    </button>
                </div>
            </div>

            <div id="contentBlocks" class="space-y-4">
                <!-- Existing content blocks will be loaded here -->
            </div>
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.blogs.index') }}" class="px-6 py-2 rounded-lg transition-colors duration-300" style="background-color: var(--admin-bg-tertiary); color: var(--admin-text-primary);">
                Cancel
            </a>
            <button type="submit" class="admin-button px-6 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02]">
                Update Blog Post
            </button>
        </div>
    </form>
</div>

<script>
let blockIndex = 0;

// Existing content blocks data from the server
const existingBlocks = @json(old('content_blocks', $blog->contentBlocks->map(function($block) {
    return [
        'id' => $block->id,
        'type' => $block->type,
        'content' => $block->content,
        'order' => $block->order
    ];
})->sortBy('order')->values()));

function addParagraphBlock(content = '', existingBlockId = null) {
    const container = document.getElementById('contentBlocks');
    const blockDiv = document.createElement('div');
    blockDiv.className = 'content-block p-4 rounded-lg relative';
    blockDiv.style.backgroundColor = 'var(--admin-bg-tertiary)';
    blockDiv.style.border = '1px solid var(--admin-border-primary)';
    blockDiv.dataset.index = blockIndex;

    const existingIdField = existingBlockId ?
        `<input type="hidden" name="content_blocks[${blockIndex}][id]" value="${existingBlockId}">` : '';

    blockDiv.innerHTML = `
        <div class="flex justify-between items-center mb-3">
            <span class="text-sm font-medium" style="color: var(--admin-text-primary);">
                <i class="fas fa-paragraph mr-2"></i>Paragraph
            </span>
            <button type="button" onclick="removeBlock(this)" class="text-red-500 hover:text-red-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        ${existingIdField}
        <input type="hidden" name="content_blocks[${blockIndex}][type]" value="paragraph">
        <textarea name="content_blocks[${blockIndex}][content]" rows="4" required
                  class="w-full px-4 py-2 rounded-lg border transition-colors duration-300 focus:outline-none focus:ring-2"
                  style="background-color: var(--admin-bg-secondary); border-color: var(--admin-border-primary); color: var(--admin-text-primary);"
                  placeholder="Enter paragraph content...">${content}</textarea>
    `;

    container.appendChild(blockDiv);
    blockIndex++;
}

function addImageBlock(existingImagePath = null, existingBlockId = null) {
    const container = document.getElementById('contentBlocks');
    const blockDiv = document.createElement('div');
    blockDiv.className = 'content-block p-4 rounded-lg relative';
    blockDiv.style.backgroundColor = 'var(--admin-bg-tertiary)';
    blockDiv.style.border = '1px solid var(--admin-border-primary)';
    blockDiv.dataset.index = blockIndex;

    const existingIdField = existingBlockId ?
        `<input type="hidden" name="content_blocks[${blockIndex}][id]" value="${existingBlockId}">` : '';

    const existingImageHtml = existingImagePath ? `
        <div class="mb-3">
            <img src="/storage/${existingImagePath}" alt="Current image" class="h-32 w-auto rounded-lg border mb-2" style="border-color: var(--admin-border-primary);">
            <p class="text-xs" style="color: var(--admin-text-secondary);">Current image (upload new to replace)</p>
            <input type="hidden" name="content_blocks[${blockIndex}][existing_image]" value="${existingImagePath}">
        </div>
    ` : '';

    const fileInputRequired = existingImagePath ? '' : 'required';

    blockDiv.innerHTML = `
        <div class="flex justify-between items-center mb-3">
            <span class="text-sm font-medium" style="color: var(--admin-text-primary);">
                <i class="fas fa-image mr-2"></i>Image
            </span>
            <button type="button" onclick="removeBlock(this)" class="text-red-500 hover:text-red-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        ${existingIdField}
        <input type="hidden" name="content_blocks[${blockIndex}][type]" value="image">
        ${existingImageHtml}
        <input type="file" name="content_blocks[${blockIndex}][content]" accept="image/*" ${fileInputRequired}
               class="w-full px-4 py-2 rounded-lg border transition-colors duration-300 focus:outline-none focus:ring-2"
               style="background-color: var(--admin-bg-secondary); border-color: var(--admin-border-primary); color: var(--admin-text-primary);">
    `;

    container.appendChild(blockDiv);
    blockIndex++;
}

function removeBlock(button) {
    const block = button.closest('.content-block');
    const blockIdInput = block.querySelector('input[name*="[id]"]');

    // If this is an existing block (has an ID), mark it for deletion
    if (blockIdInput) {
        const blockId = blockIdInput.value;
        const deleteInput = document.createElement('input');
        deleteInput.type = 'hidden';
        deleteInput.name = 'deleted_blocks[]';
        deleteInput.value = blockId;
        document.getElementById('blogForm').appendChild(deleteInput);
    }

    block.remove();
}

// Load existing content blocks on page load
document.addEventListener('DOMContentLoaded', function() {
    if (existingBlocks.length > 0) {
        existingBlocks.forEach(block => {
            if (block.type === 'paragraph') {
                addParagraphBlock(block.content, block.id);
            } else if (block.type === 'image') {
                addImageBlock(block.content, block.id);
            }
        });
    } else {
        // Add at least one paragraph block if no existing blocks
        addParagraphBlock();
    }
});
</script>
@endsection