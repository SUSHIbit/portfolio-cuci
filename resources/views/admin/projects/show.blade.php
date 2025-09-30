@extends('layouts.admin')

@section('title', 'View Project')

@section('page-title', 'Project: ' . $project->title)

@section('content')
<div class="max-w-4xl">
    <!-- Project Header -->
    <div class="admin-card rounded-lg mb-6">
        <div class="p-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold mb-2" style="color: var(--admin-text-primary);">{{ $project->title }}</h1>
                    <div class="flex items-center space-x-4">
                        @if($project->is_featured)
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">Featured Project</span>
                        @endif
                        <span class="text-sm" style="color: var(--admin-text-secondary);">Created {{ $project->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('admin.projects.edit', $project) }}" class="admin-button px-4 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02]">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    @if($project->project_url)
                        <a href="{{ $project->project_url }}" target="_blank" class="admin-button px-4 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02]" style="background-color: #10b981; color: white;">
                            <i class="fas fa-external-link-alt mr-2"></i>View Live
                        </a>
                    @endif
                </div>
            </div>

            <div class="prose max-w-none">
                <h3 class="text-lg font-semibold mb-2" style="color: var(--admin-text-primary);">Short Description</h3>
                <p class="mb-4" style="color: var(--admin-text-secondary);">{{ $project->short_description }}</p>

                <h3 class="text-lg font-semibold mb-2" style="color: var(--admin-text-primary);">Detailed Description</h3>
                <div class="whitespace-pre-line" style="color: var(--admin-text-secondary);">{{ $project->detailed_description }}</div>
            </div>
        </div>
    </div>

    <!-- Project Links -->
    @if($project->project_url || $project->github_url)
        <div class="admin-card rounded-lg mb-6">
            <div class="p-6" style="border-bottom: 1px solid var(--admin-border-primary);">
                <h2 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Project Links</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($project->project_url)
                        <div class="flex items-center p-4 rounded-lg" style="background-color: var(--admin-bg-tertiary);">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4" style="background-color: #10b981;">
                                <i class="fas fa-globe text-white"></i>
                            </div>
                            <div>
                                <h3 class="font-medium" style="color: var(--admin-text-primary);">Live Project</h3>
                                <a href="{{ $project->project_url }}" target="_blank" class="text-sm break-all hover:underline" style="color: #10b981;">
                                    {{ $project->project_url }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($project->github_url)
                        <div class="flex items-center p-4 rounded-lg" style="background-color: var(--admin-bg-tertiary);">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4" style="background-color: var(--admin-text-primary);">
                                <i class="fab fa-github" style="color: var(--admin-bg-primary);"></i>
                            </div>
                            <div>
                                <h3 class="font-medium" style="color: var(--admin-text-primary);">Source Code</h3>
                                <a href="{{ $project->github_url }}" target="_blank" class="text-sm break-all hover:underline" style="color: var(--admin-text-secondary);">
                                    {{ $project->github_url }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Technologies -->
    @if($project->technologies->count() > 0)
        <div class="admin-card rounded-lg mb-6">
            <div class="p-6" style="border-bottom: 1px solid var(--admin-border-primary);">
                <h2 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Technologies Used</h2>
            </div>
            <div class="p-6">
                <div class="flex flex-wrap gap-2">
                    @foreach($project->technologies as $tech)
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ $tech->technology_name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Project Images -->
    @if($project->images->count() > 0)
        <div class="admin-card rounded-lg mb-6">
            <div class="p-6" style="border-bottom: 1px solid var(--admin-border-primary);">
                <h2 class="text-lg font-semibold" style="color: var(--admin-text-primary);">Project Images</h2>
                <p class="text-sm" style="color: var(--admin-text-secondary);">{{ $project->images->count() }} image(s)</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($project->images as $image)
                        <div class="relative group">
                            <img src="{{ asset($image->image_path) }}"
                                 alt="{{ $image->alt_text }}"
                                 class="w-full h-64 object-cover rounded-lg cursor-pointer"
                                 style="border: 1px solid var(--admin-border-primary);"
                                 onclick="openImageModal('{{ asset($image->image_path) }}', '{{ $image->alt_text }}')">
                            @if($image->is_primary)
                                <div class="absolute top-3 left-3 bg-yellow-500 text-white px-2 py-1 text-xs rounded">Primary</div>
                            @endif
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-25 transition-opacity rounded-lg flex items-center justify-center">
                                <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.projects.index') }}" class="admin-button-secondary px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Projects
        </a>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.projects.edit', $project) }}" class="admin-button px-4 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02]">
                <i class="fas fa-edit mr-2"></i>Edit Project
            </a>
            <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-button px-4 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02]" style="background-color: #dc2626; color: white;">
                    <i class="fas fa-trash mr-2"></i>Delete Project
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 hidden flex items-center justify-center z-50" onclick="closeImageModal()">
    <div class="max-w-4xl max-h-full p-4">
        <img id="modal-image" src="" alt="" class="max-w-full max-h-full object-contain">
    </div>
    <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300">
        <i class="fas fa-times"></i>
    </button>
</div>

<script>
function openImageModal(src, alt) {
    const modal = document.getElementById('image-modal');
    const modalImage = document.getElementById('modal-image');
    modalImage.src = src;
    modalImage.alt = alt;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('image-modal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal with escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection