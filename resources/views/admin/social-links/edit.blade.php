@extends('layouts.admin')

@section('title', 'Edit Social Link')

@section('page-title', 'Edit Social Link: ' . $socialLink->platform)

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.social-links.update', $socialLink) }}" method="POST" id="social-link-form">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">Social Link Details</h2>
                <p class="text-sm text-gray-600">Update your social media link information</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="platform" class="block text-sm font-medium text-gray-700 mb-2">Platform Name *</label>
                    <input
                        type="text"
                        id="platform"
                        name="platform"
                        value="{{ old('platform', $socialLink->platform) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Twitter, LinkedIn, GitHub, etc."
                        required
                    >
                    @error('platform')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700 mb-2">Profile URL *</label>
                    <input
                        type="url"
                        id="url"
                        name="url"
                        value="{{ old('url', $socialLink->url) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="https://twitter.com/yourusername"
                        required
                    >
                    @error('url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="icon_class" class="block text-sm font-medium text-gray-700 mb-2">Icon Class *</label>
                    <div class="flex items-center space-x-3">
                        <input
                            type="text"
                            id="icon_class"
                            name="icon_class"
                            value="{{ old('icon_class', $socialLink->icon_class) }}"
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="fab fa-twitter"
                            required
                        >
                        <div id="icon-preview" class="w-10 h-10 bg-gray-100 rounded flex items-center justify-center">
                            <i id="preview-icon" class="{{ old('icon_class', $socialLink->icon_class) }} text-xl"></i>
                        </div>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">FontAwesome icon class (e.g., fab fa-twitter, fab fa-github)</p>
                    @error('icon_class')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" class="mr-2" {{ old('is_active', $socialLink->is_active) ? 'checked' : '' }}>
                        <span class="text-sm font-medium text-gray-700">Active</span>
                    </label>
                    <p class="mt-1 text-sm text-gray-500">Only active links will be displayed on the portfolio</p>
                </div>
            </div>
        </div>

        <!-- Current Preview -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Current Preview</h3>
                <p class="text-sm text-gray-600">How this link currently appears</p>
            </div>
            <div class="p-6">
                <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="{{ $socialLink->icon_class }} text-xl text-gray-600"></i>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-900">{{ $socialLink->platform }}</h4>
                        <a href="{{ $socialLink->url }}" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-800 break-all">
                            {{ $socialLink->url }}
                        </a>
                        <div class="flex items-center mt-1">
                            <span class="px-2 py-1 text-xs rounded {{ $socialLink->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $socialLink->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Icon Selection -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Quick Icon Selection</h3>
                <p class="text-sm text-gray-600">Click an icon to use it automatically</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <button type="button" onclick="selectIcon('Twitter', 'fab fa-twitter')" class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors">
                        <i class="fab fa-twitter text-blue-400 text-xl"></i>
                        <span class="text-sm font-medium">Twitter</span>
                    </button>
                    <button type="button" onclick="selectIcon('Facebook', 'fab fa-facebook')" class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors">
                        <i class="fab fa-facebook text-blue-600 text-xl"></i>
                        <span class="text-sm font-medium">Facebook</span>
                    </button>
                    <button type="button" onclick="selectIcon('LinkedIn', 'fab fa-linkedin')" class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors">
                        <i class="fab fa-linkedin text-blue-700 text-xl"></i>
                        <span class="text-sm font-medium">LinkedIn</span>
                    </button>
                    <button type="button" onclick="selectIcon('GitHub', 'fab fa-github')" class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-colors">
                        <i class="fab fa-github text-gray-800 text-xl"></i>
                        <span class="text-sm font-medium">GitHub</span>
                    </button>
                    <button type="button" onclick="selectIcon('Instagram', 'fab fa-instagram')" class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:bg-pink-50 hover:border-pink-300 transition-colors">
                        <i class="fab fa-instagram text-pink-500 text-xl"></i>
                        <span class="text-sm font-medium">Instagram</span>
                    </button>
                    <button type="button" onclick="selectIcon('YouTube', 'fab fa-youtube')" class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:bg-red-50 hover:border-red-300 transition-colors">
                        <i class="fab fa-youtube text-red-600 text-xl"></i>
                        <span class="text-sm font-medium">YouTube</span>
                    </button>
                    <button type="button" onclick="selectIcon('Telegram', 'fab fa-telegram')" class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors">
                        <i class="fab fa-telegram text-blue-500 text-xl"></i>
                        <span class="text-sm font-medium">Telegram</span>
                    </button>
                    <button type="button" onclick="selectIcon('Dribbble', 'fab fa-dribbble')" class="flex items-center space-x-2 p-3 border border-gray-200 rounded-lg hover:bg-pink-50 hover:border-pink-300 transition-colors">
                        <i class="fab fa-dribbble text-pink-400 text-xl"></i>
                        <span class="text-sm font-medium">Dribbble</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.social-links.index') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                <i class="fas fa-arrow-left mr-2"></i>Back to Social Links
            </a>
            <div class="flex items-center space-x-3">
                <form action="{{ route('admin.social-links.destroy', $socialLink) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this social link?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>Delete
                    </button>
                </form>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="fas fa-save mr-2"></i>Update Social Link
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const iconClassInput = document.getElementById('icon_class');
    const previewIcon = document.getElementById('preview-icon');

    iconClassInput.addEventListener('input', function() {
        updateIconPreview(this.value);
    });

    function updateIconPreview(iconClass) {
        if (iconClass.trim()) {
            previewIcon.className = iconClass + ' text-xl';
        } else {
            previewIcon.className = 'text-gray-400 text-xl';
        }
    }
});

function selectIcon(platform, iconClass) {
    document.getElementById('platform').value = platform;
    document.getElementById('icon_class').value = iconClass;

    // Update preview
    const previewIcon = document.getElementById('preview-icon');
    previewIcon.className = iconClass + ' text-xl';
}
</script>
@endsection