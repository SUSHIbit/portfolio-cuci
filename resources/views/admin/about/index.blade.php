@extends('layouts.admin')

@section('title', 'About Page Management')

@section('page-title', 'About Page Management')

@section('content')
<div class="max-w-6xl">
    <!-- Experience Sections -->
    <div class="admin-card mb-6">
        <div class="p-6" style="border-bottom: 1px solid var(--admin-border-primary);">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Experience Sections</h2>
                    <p class="text-sm" style="color: var(--admin-text-secondary);">Manage your professional experience entries</p>
                </div>
                <button type="button" id="add-experience" class="admin-button px-4 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02] focus:outline-none">
                    <i class="fas fa-plus mr-2"></i>Add Experience
                </button>
            </div>
        </div>
        <div class="p-6">
            @if($experiences->count() > 0)
                <div class="space-y-4">
                    @foreach($experiences as $experience)
                        <div class="rounded-lg p-4" style="border: 1px solid var(--admin-border-primary); background-color: var(--admin-bg-tertiary);">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-medium" style="color: var(--admin-text-primary);">{{ $experience->field }}</h3>
                                    <p class="text-sm mt-1" style="color: var(--admin-text-secondary);">{{ $experience->year }} - {{ $experience->role }}</p>
                                    <p class="text-sm mt-2" style="color: var(--admin-text-primary);">{{ $experience->description }}</p>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    <button type="button" onclick="editExperience({{ $experience->id }}, '{{ $experience->field }}', '{{ $experience->year }}', '{{ $experience->role }}', `{{ $experience->description }}`)" class="admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" style="color: var(--admin-accent-color);">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.about.experience.destroy', $experience) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this experience?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" style="color: #dc2626;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8" style="color: var(--admin-text-secondary);">
                    <i class="fas fa-briefcase text-4xl mb-4" style="color: var(--admin-text-tertiary);"></i>
                    <p>No experience sections yet. Add your first experience entry!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Dynamic Sections -->
    <div class="admin-card mb-6">
        <div class="p-6" style="border-bottom: 1px solid var(--admin-border-primary);">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Dynamic Sections</h2>
                    <p class="text-sm" style="color: var(--admin-text-secondary);">Create custom sections like "My Goals", "My Playlist", etc.</p>
                </div>
                <button type="button" id="add-section" class="admin-button px-4 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02] focus:outline-none">
                    <i class="fas fa-plus mr-2"></i>Add Section
                </button>
            </div>
        </div>
        <div class="p-6">
            @if($dynamicSections->count() > 0)
                <div class="space-y-6">
                    @foreach($dynamicSections as $section)
                        <div class="rounded-lg p-4" style="border: 1px solid var(--admin-border-primary); background-color: var(--admin-bg-tertiary);">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <h3 class="font-medium" style="color: var(--admin-text-primary);">{{ $section->section_name }}</h3>
                                    <span class="ml-2 px-2 py-1 text-xs rounded {{ $section->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $section->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button type="button" onclick="addSectionItem({{ $section->id }})" class="admin-button px-3 py-1 rounded text-sm transition-colors" style="color: var(--admin-accent-color);">
                                        <i class="fas fa-plus"></i> Add Item
                                    </button>
                                    <button type="button" onclick="editSection({{ $section->id }}, '{{ $section->section_name }}', {{ $section->is_active ? 'true' : 'false' }})" class="admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" style="color: var(--admin-accent-color);">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.about.sections.destroy', $section) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure? This will delete all items in this section.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" style="color: #dc2626;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            @if($section->items->count() > 0)
                                <div class="space-y-2 ml-4">
                                    @foreach($section->items as $item)
                                        <div class="pl-4 py-2" style="border-left: 2px solid var(--admin-border-primary);">
                                            <div class="flex items-start justify-between">
                                                <div class="flex-1">
                                                    <h4 class="font-medium" style="color: var(--admin-text-primary);">{{ $item->title }}</h4>
                                                    <p class="text-sm" style="color: var(--admin-text-secondary);">{{ $item->year }}</p>
                                                    <p class="text-sm mt-1" style="color: var(--admin-text-primary);">{{ $item->description }}</p>
                                                    @if($item->link_url)
                                                        <a href="{{ $item->link_url }}" class="text-sm hover:underline" style="color: var(--admin-accent-color);" target="_blank">
                                                            {{ $item->link_text ?: 'View Link' }} <i class="fas fa-external-link-alt ml-1"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                                <div class="flex items-center space-x-2 ml-4">
                                                    <button type="button" onclick="editSectionItem({{ $item->id }}, '{{ $item->title }}', '{{ $item->year }}', `{{ $item->description }}`, '{{ $item->link_url }}', '{{ $item->link_text }}')" class="admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" style="color: var(--admin-accent-color);">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('admin.about.sections.items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" style="color: #dc2626;">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm ml-4" style="color: var(--admin-text-secondary);">No items in this section yet.</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8" style="color: var(--admin-text-secondary);">
                    <i class="fas fa-layer-group text-4xl mb-4" style="color: var(--admin-text-tertiary);"></i>
                    <p>No dynamic sections yet. Create your first custom section!</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.dashboard') }}" class="admin-button-secondary px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>
</div>

<!-- Experience Modal -->
<div id="experience-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="admin-card rounded-lg p-6 w-full max-w-md">
        <h3 id="experience-modal-title" class="text-lg font-semibold mb-4" style="color: var(--admin-text-primary);">Add Experience</h3>
        <form id="experience-form" method="POST">
            @csrf
            <div id="experience-method"></div>

            <div class="mb-4">
                <label for="experience-field" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Field</label>
                <input type="text" id="experience-field" name="field" class="w-full px-3 py-2 rounded-lg" style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);" required>
            </div>

            <div class="mb-4">
                <label for="experience-year" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Year</label>
                <input type="text" id="experience-year" name="year" class="w-full px-3 py-2 rounded-lg" style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);" required>
            </div>

            <div class="mb-4">
                <label for="experience-role" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Role</label>
                <input type="text" id="experience-role" name="role" class="w-full px-3 py-2 rounded-lg" style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);" required>
            </div>

            <div class="mb-4">
                <label for="experience-description" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Description</label>
                <textarea id="experience-description" name="description" rows="3" class="w-full px-3 py-2 rounded-lg resize-none" style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);" required></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeExperienceModal()" class="admin-button-secondary px-4 py-2 rounded-lg transition-colors">Cancel</button>
                <button type="submit" class="admin-button px-4 py-2 rounded-lg transition-colors">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Section Modal -->
<div id="section-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="admin-card rounded-lg p-6 w-full max-w-md">
        <h3 id="section-modal-title" class="text-lg font-semibold mb-4" style="color: var(--admin-text-primary);">Add Section</h3>
        <form id="section-form" method="POST">
            @csrf
            <div id="section-method"></div>

            <div class="mb-4">
                <label for="section-name" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Section Name</label>
                <input type="text" id="section-name" name="section_name" class="w-full px-3 py-2 rounded-lg" style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);" required>
            </div>

            <div class="mb-4">
                <label class="flex items-center">
                    <input type="checkbox" id="section-active" name="is_active" class="mr-2">
                    <span class="text-sm font-medium" style="color: var(--admin-text-primary);">Active</span>
                </label>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeSectionModal()" class="admin-button-secondary px-4 py-2 rounded-lg transition-colors">Cancel</button>
                <button type="submit" class="admin-button px-4 py-2 rounded-lg transition-colors">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Section Item Modal -->
<div id="section-item-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="admin-card rounded-lg p-6 w-full max-w-md">
        <h3 id="section-item-modal-title" class="text-lg font-semibold mb-4" style="color: var(--admin-text-primary);">Add Section Item</h3>
        <form id="section-item-form" method="POST">
            @csrf
            <div id="section-item-method"></div>

            <div class="mb-4">
                <label for="item-title" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Title</label>
                <input type="text" id="item-title" name="title" class="w-full px-3 py-2 rounded-lg" style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);" required>
            </div>

            <div class="mb-4">
                <label for="item-year" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Year</label>
                <input type="text" id="item-year" name="year" class="w-full px-3 py-2 rounded-lg" style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);" required>
            </div>

            <div class="mb-4">
                <label for="item-description" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Description</label>
                <textarea id="item-description" name="description" rows="3" class="w-full px-3 py-2 rounded-lg resize-none" style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);" required></textarea>
            </div>

            <div class="mb-4">
                <label for="item-link-url" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Link URL (optional)</label>
                <input type="url" id="item-link-url" name="link_url" class="w-full px-3 py-2 rounded-lg" style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);">
            </div>

            <div class="mb-4">
                <label for="item-link-text" class="block text-sm font-medium mb-2" style="color: var(--admin-text-primary);">Link Text (optional)</label>
                <input type="text" id="item-link-text" name="link_text" class="w-full px-3 py-2 rounded-lg" style="background-color: var(--admin-bg-tertiary); border: 1px solid var(--admin-border-primary); color: var(--admin-text-primary);">
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeSectionItemModal()" class="admin-button-secondary px-4 py-2 rounded-lg transition-colors">Cancel</button>
                <button type="submit" class="admin-button px-4 py-2 rounded-lg transition-colors">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
// Experience Modal Functions
function openExperienceModal() {
    document.getElementById('experience-modal').classList.remove('hidden');
}

function closeExperienceModal() {
    document.getElementById('experience-modal').classList.add('hidden');
    document.getElementById('experience-form').reset();
}

function editExperience(id, field, year, role, description) {
    document.getElementById('experience-modal-title').textContent = 'Edit Experience';
    document.getElementById('experience-form').action = `/admin/about/experience/${id}`;
    document.getElementById('experience-method').innerHTML = '@method("PUT")';
    document.getElementById('experience-field').value = field;
    document.getElementById('experience-year').value = year;
    document.getElementById('experience-role').value = role;
    document.getElementById('experience-description').value = description;
    openExperienceModal();
}

// Section Modal Functions
function openSectionModal() {
    document.getElementById('section-modal').classList.remove('hidden');
}

function closeSectionModal() {
    document.getElementById('section-modal').classList.add('hidden');
    document.getElementById('section-form').reset();
}

function editSection(id, name, isActive) {
    document.getElementById('section-modal-title').textContent = 'Edit Section';
    document.getElementById('section-form').action = `/admin/about/sections/${id}`;
    document.getElementById('section-method').innerHTML = '@method("PUT")';
    document.getElementById('section-name').value = name;
    document.getElementById('section-active').checked = isActive;
    openSectionModal();
}

// Section Item Modal Functions
function openSectionItemModal() {
    document.getElementById('section-item-modal').classList.remove('hidden');
}

function closeSectionItemModal() {
    document.getElementById('section-item-modal').classList.add('hidden');
    document.getElementById('section-item-form').reset();
}

function addSectionItem(sectionId) {
    document.getElementById('section-item-modal-title').textContent = 'Add Section Item';
    document.getElementById('section-item-form').action = `/admin/about/sections/${sectionId}/items`;
    document.getElementById('section-item-method').innerHTML = '';
    openSectionItemModal();
}

function editSectionItem(id, title, year, description, linkUrl, linkText) {
    document.getElementById('section-item-modal-title').textContent = 'Edit Section Item';
    document.getElementById('section-item-form').action = `/admin/about/sections/items/${id}`;
    document.getElementById('section-item-method').innerHTML = '@method("PUT")';
    document.getElementById('item-title').value = title;
    document.getElementById('item-year').value = year;
    document.getElementById('item-description').value = description;
    document.getElementById('item-link-url').value = linkUrl;
    document.getElementById('item-link-text').value = linkText;
    openSectionItemModal();
}

// Event Listeners
document.getElementById('add-experience').addEventListener('click', function() {
    document.getElementById('experience-modal-title').textContent = 'Add Experience';
    document.getElementById('experience-form').action = '{{ route("admin.about.experience.store") }}';
    document.getElementById('experience-method').innerHTML = '';
    openExperienceModal();
});

document.getElementById('add-section').addEventListener('click', function() {
    document.getElementById('section-modal-title').textContent = 'Add Section';
    document.getElementById('section-form').action = '{{ route("admin.about.sections.store") }}';
    document.getElementById('section-method').innerHTML = '';
    document.getElementById('section-active').checked = true;
    openSectionModal();
});

// Close modals when clicking outside
document.getElementById('experience-modal').addEventListener('click', function(e) {
    if (e.target === this) closeExperienceModal();
});

document.getElementById('section-modal').addEventListener('click', function(e) {
    if (e.target === this) closeSectionModal();
});

document.getElementById('section-item-modal').addEventListener('click', function(e) {
    if (e.target === this) closeSectionItemModal();
});
</script>
@endsection