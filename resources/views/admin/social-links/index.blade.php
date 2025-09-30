@extends('layouts.admin')

@section('title', 'Social Links Management')

@section('page-title', 'Social Links Management')

@section('content')
<div class="max-w-4xl">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold" style="color: var(--admin-text-primary);">Social Media Links</h2>
            <p class="text-sm" style="color: var(--admin-text-secondary);">Manage your social media presence</p>
        </div>
        <a href="{{ route('admin.social-links.create') }}" class="admin-button px-4 py-2 rounded-lg transition-all duration-300 hover:scale-[1.02] focus:outline-none">
            <i class="fas fa-plus mr-2"></i>Add Social Link
        </a>
    </div>

    @if($socialLinks->count() > 0)
        <div class="admin-card rounded-lg">
            <div style="border-color: var(--admin-border-primary);" class="divide-y">
                @foreach($socialLinks as $link)
                    <div class="p-6 flex items-center justify-between transition-colors" style="hover:background-color: var(--admin-bg-tertiary);">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: var(--admin-bg-tertiary);">
                                <i class="{{ $link->icon_class }} text-xl" style="color: var(--admin-text-secondary);"></i>
                            </div>
                            <div>
                                <h3 class="font-medium" style="color: var(--admin-text-primary);">{{ $link->platform }}</h3>
                                <a href="{{ $link->url }}" target="_blank" class="text-sm break-all hover:underline" style="color: var(--admin-accent-color);">
                                    {{ $link->url }}
                                </a>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs mr-2" style="color: var(--admin-text-secondary);">Icon:</span>
                                    <code class="text-xs px-2 py-1 rounded" style="background-color: var(--admin-bg-tertiary); color: var(--admin-text-primary);">{{ $link->icon_class }}</code>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <span class="mr-2 text-sm text-gray-600">Status:</span>
                                <span class="px-2 py-1 text-xs rounded {{ $link->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $link->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.social-links.edit', $link) }}" class="text-indigo-600 hover:text-indigo-800" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.social-links.destroy', $link) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this social link?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Icon Reference -->
        <div class="bg-white rounded-lg shadow mt-6">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Common Social Media Icons</h3>
                <p class="text-sm text-gray-600">FontAwesome icon classes for popular platforms</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                        <i class="fab fa-twitter text-blue-400 text-xl"></i>
                        <div>
                            <div class="font-medium text-sm">Twitter</div>
                            <code class="text-xs text-gray-600">fab fa-twitter</code>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                        <i class="fab fa-facebook text-blue-600 text-xl"></i>
                        <div>
                            <div class="font-medium text-sm">Facebook</div>
                            <code class="text-xs text-gray-600">fab fa-facebook</code>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                        <i class="fab fa-linkedin text-blue-700 text-xl"></i>
                        <div>
                            <div class="font-medium text-sm">LinkedIn</div>
                            <code class="text-xs text-gray-600">fab fa-linkedin</code>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                        <i class="fab fa-github text-gray-800 text-xl"></i>
                        <div>
                            <div class="font-medium text-sm">GitHub</div>
                            <code class="text-xs text-gray-600">fab fa-github</code>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                        <i class="fab fa-instagram text-pink-500 text-xl"></i>
                        <div>
                            <div class="font-medium text-sm">Instagram</div>
                            <code class="text-xs text-gray-600">fab fa-instagram</code>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                        <i class="fab fa-youtube text-red-600 text-xl"></i>
                        <div>
                            <div class="font-medium text-sm">YouTube</div>
                            <code class="text-xs text-gray-600">fab fa-youtube</code>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                        <i class="fab fa-telegram text-blue-500 text-xl"></i>
                        <div>
                            <div class="font-medium text-sm">Telegram</div>
                            <code class="text-xs text-gray-600">fab fa-telegram</code>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded">
                        <i class="fab fa-dribbble text-pink-400 text-xl"></i>
                        <div>
                            <div class="font-medium text-sm">Dribbble</div>
                            <code class="text-xs text-gray-600">fab fa-dribbble</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow">
            <div class="p-12 text-center">
                <i class="fas fa-share-alt text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No social links yet</h3>
                <p class="text-gray-600 mb-6">Connect your social media accounts to your portfolio</p>
                <a href="{{ route('admin.social-links.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    <i class="fas fa-plus mr-2"></i>Add First Social Link
                </a>
            </div>
        </div>
    @endif

    <!-- Back Button -->
    <div class="mt-8">
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
    </div>
</div>
@endsection