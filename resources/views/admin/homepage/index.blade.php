@extends('layouts.admin')

@section('title', 'Homepage Content')

@section('page-title', 'Homepage Content')

@section('content')
<div class="max-w-4xl">
    <form action="{{ route('admin.homepage.update') }}" method="POST" id="homepage-form">
        @csrf
        @method('PUT')

        <!-- Hero Title Section -->
        <div class="admin-card mb-6">
            <div class="p-6" style="border-bottom: 1px solid var(--admin-border-primary);">
                <h2 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Hero Title</h2>
                <p class="text-sm" style="color: var(--admin-text-secondary);">This is the main title displayed on your homepage</p>
            </div>
            <div class="p-6">
                <label for="hero_title" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Main Title</label>
                <input
                    type="text"
                    id="hero_title"
                    name="hero_title"
                    value="{{ old('hero_title', $heroTitle) }}"
                    class="w-full px-4 py-3 rounded-lg transition-all duration-300 focus:outline-none"
                    style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);"
                    placeholder="I'M ADENEKAN WONDERFUL"
                    required
                >
                @error('hero_title')
                    <p class="mt-2 text-sm" style="color: #dc2626;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Hero Paragraphs Section -->
        <div class="admin-card mb-6">
            <div class="p-6" style="border-bottom: 1px solid var(--admin-border-primary);">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Hero Description Paragraphs</h2>
                        <p class="text-sm" style="color: var(--admin-text-secondary);">Add as many paragraphs as you want for your hero description</p>
                    </div>
                    <button type="button" id="add-paragraph" class="admin-button px-4 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02] focus:outline-none">
                        <i class="fas fa-plus mr-2"></i>Add Paragraph
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div id="paragraphs-container">
                    @if($heroParagraphs->count() > 0)
                        @foreach($heroParagraphs as $index => $paragraph)
                            <div class="paragraph-item mb-4" data-index="{{ $index }}">
                                <div class="flex items-start space-x-3">
                                    <div class="flex flex-col space-y-2">
                                        <button type="button" class="move-up admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" {{ $index === 0 ? 'disabled' : '' }}>
                                            <i class="fas fa-chevron-up"></i>
                                        </button>
                                        <button type="button" class="move-down admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" {{ $index === $heroParagraphs->count() - 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Paragraph {{ $index + 1 }}</label>
                                        <textarea
                                            name="paragraphs[]"
                                            rows="3"
                                            class="w-full px-4 py-3 rounded-lg transition-all duration-300 focus:outline-none resize-none"
                                            style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);"
                                            placeholder="Enter paragraph content..."
                                            required
                                        >{{ old('paragraphs.' . $index, $paragraph->content) }}</textarea>
                                    </div>
                                    <button type="button" class="remove-paragraph w-8 h-8 flex items-center justify-center rounded transition-colors mt-8 admin-button" style="color: #dc2626;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="paragraph-item mb-4" data-index="0">
                            <div class="flex items-start space-x-3">
                                <div class="flex flex-col space-y-2">
                                    <button type="button" class="move-up admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" disabled>
                                        <i class="fas fa-chevron-up"></i>
                                    </button>
                                    <button type="button" class="move-down admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" disabled>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Paragraph 1</label>
                                    <textarea
                                        name="paragraphs[]"
                                        rows="3"
                                        class="w-full px-4 py-3 rounded-lg transition-all duration-300 focus:outline-none resize-none"
                                        style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);"
                                        placeholder="Enter paragraph content..."
                                        required
                                    >{{ old('paragraphs.0', 'A creative and experienced Front End Developer with a passion for creating visually appealing and user-friendly websites and applications.') }}</textarea>
                                </div>
                                <button type="button" class="remove-paragraph w-8 h-8 flex items-center justify-center rounded transition-colors mt-8 admin-button" style="color: #dc2626;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                @error('paragraphs')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="admin-button-secondary px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
            </a>
            <button type="submit" class="admin-button px-6 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02] focus:outline-none">
                <i class="fas fa-save mr-2"></i>Save Changes
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let paragraphIndex = {{ $heroParagraphs->count() ?: 1 }};

    // Add paragraph functionality
    document.getElementById('add-paragraph').addEventListener('click', function() {
        const container = document.getElementById('paragraphs-container');
        const newParagraph = createParagraphElement(paragraphIndex);
        container.appendChild(newParagraph);
        paragraphIndex++;
        updateParagraphNumbers();
        updateMoveButtons();
    });

    // Remove paragraph functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-paragraph')) {
            const paragraphItem = e.target.closest('.paragraph-item');
            const container = document.getElementById('paragraphs-container');

            // Don't allow removing the last paragraph
            if (container.children.length > 1) {
                paragraphItem.remove();
                updateParagraphNumbers();
                updateMoveButtons();
            }
        }
    });

    // Move up/down functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.move-up')) {
            const item = e.target.closest('.paragraph-item');
            const prev = item.previousElementSibling;
            if (prev) {
                item.parentNode.insertBefore(item, prev);
                updateParagraphNumbers();
                updateMoveButtons();
            }
        } else if (e.target.closest('.move-down')) {
            const item = e.target.closest('.paragraph-item');
            const next = item.nextElementSibling;
            if (next) {
                item.parentNode.insertBefore(next, item);
                updateParagraphNumbers();
                updateMoveButtons();
            }
        }
    });

    function createParagraphElement(index) {
        const div = document.createElement('div');
        div.className = 'paragraph-item mb-4';
        div.dataset.index = index;
        div.innerHTML = `
            <div class="flex items-start space-x-3">
                <div class="flex flex-col space-y-2">
                    <button type="button" class="move-up admin-button w-8 h-8 flex items-center justify-center rounded transition-colors">
                        <i class="fas fa-chevron-up"></i>
                    </button>
                    <button type="button" class="move-down admin-button w-8 h-8 flex items-center justify-center rounded transition-colors">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Paragraph ${index + 1}</label>
                    <textarea
                        name="paragraphs[]"
                        rows="3"
                        class="w-full px-4 py-3 rounded-lg transition-all duration-300 focus:outline-none resize-none"
                        style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);"
                        placeholder="Enter paragraph content..."
                        required
                    ></textarea>
                </div>
                <button type="button" class="remove-paragraph admin-button w-8 h-8 flex items-center justify-center rounded transition-colors mt-8" style="color: #dc2626;">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        return div;
    }

    function updateParagraphNumbers() {
        const paragraphs = document.querySelectorAll('.paragraph-item');
        paragraphs.forEach((paragraph, index) => {
            const label = paragraph.querySelector('label');
            label.textContent = `Paragraph ${index + 1}`;
            paragraph.dataset.index = index;
        });
    }

    function updateMoveButtons() {
        const paragraphs = document.querySelectorAll('.paragraph-item');
        paragraphs.forEach((paragraph, index) => {
            const moveUp = paragraph.querySelector('.move-up');
            const moveDown = paragraph.querySelector('.move-down');

            moveUp.disabled = index === 0;
            moveDown.disabled = index === paragraphs.length - 1;

            if (moveUp.disabled) {
                moveUp.classList.add('opacity-50');
            } else {
                moveUp.classList.remove('opacity-50');
            }

            if (moveDown.disabled) {
                moveDown.classList.add('opacity-50');
            } else {
                moveDown.classList.remove('opacity-50');
            }
        });
    }

    // Initialize move buttons
    updateMoveButtons();
});
</script>
@endsection