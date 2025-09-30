@extends('layouts.admin')

@section('title', 'Projects Management')

@section('page-title', 'Projects Management')

@section('content')
<div class="max-w-6xl">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold" style="color: var(--admin-text-primary);">All Projects</h2>
            <p class="text-sm" style="color: var(--admin-text-secondary);">Manage your portfolio projects</p>
        </div>
        <a href="{{ route('admin.projects.create') }}" class="admin-button px-4 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02] focus:outline-none">
            <i class="fas fa-plus mr-2"></i>Add New Project
        </a>
    </div>

    @if($projects->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($projects as $project)
                <div class="admin-card rounded-lg hover:shadow-lg transition-shadow">
                    @if($project->images->count() > 0 && $project->images->where('is_primary', true)->first())
                        <div class="aspect-video rounded-t-lg overflow-hidden" style="background-color: var(--admin-bg-tertiary);">
                            <img src="{{ asset($project->images->where('is_primary', true)->first()->image_path) }}"
                                 alt="{{ $project->title }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="aspect-video rounded-t-lg flex items-center justify-center" style="background-color: var(--admin-bg-tertiary);">
                            <i class="fas fa-image text-3xl" style="color: var(--admin-text-tertiary);"></i>
                        </div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="font-semibold text-lg" style="color: var(--admin-text-primary);">{{ $project->title }}</h3>
                            @if($project->is_featured)
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">Featured</span>
                            @endif
                        </div>

                        <p class="text-sm mb-4 line-clamp-3" style="color: var(--admin-text-secondary);">{{ $project->short_description }}</p>

                        @if($project->technologies->count() > 0)
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($project->technologies->take(3) as $tech)
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">{{ $tech->technology_name }}</span>
                                    @endforeach
                                    @if($project->technologies->count() > 3)
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">+{{ $project->technologies->count() - 3 }} more</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.projects.show', $project) }}" class="admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" style="color: var(--admin-accent-color);" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project) }}" class="admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" style="color: var(--admin-accent-color);" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-button w-8 h-8 flex items-center justify-center rounded transition-colors" style="color: #dc2626;" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="flex items-center space-x-2 text-sm" style="color: var(--admin-text-secondary);">
                                <i class="fas fa-images"></i>
                                <span>{{ $project->images->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="admin-card rounded-lg">
            <div class="p-12 text-center">
                <i class="fas fa-folder-open text-6xl mb-4" style="color: var(--admin-text-tertiary);"></i>
                <h3 class="text-lg font-medium mb-2" style="color: var(--admin-text-primary);">No projects yet</h3>
                <p class="mb-6" style="color: var(--admin-text-secondary);">Get started by creating your first project</p>
                <a href="{{ route('admin.projects.create') }}" class="admin-button px-4 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02]">
                    <i class="fas fa-plus mr-2"></i>Add New Project
                </a>
            </div>
        </div>
    @endif

    <!-- Back Button -->
    <div class="mt-8">
        <a href="{{ route('admin.dashboard') }}" class="admin-button-secondary px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>
</div>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection