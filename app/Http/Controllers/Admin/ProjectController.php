<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ProjectTechnology;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $projects = Project::with(['images', 'technologies'])->orderBy('sort_order')->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'detailed_description' => 'required|string',
            'project_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'is_featured' => 'boolean',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'technologies' => 'required|string',
        ]);

        $sortOrder = Project::max('sort_order') + 1;

        $project = Project::create([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'detailed_description' => $request->detailed_description,
            'project_url' => $request->project_url,
            'github_url' => $request->github_url,
            'is_featured' => $request->has('is_featured'),
            'sort_order' => $sortOrder,
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $filename = time() . '_' . $index . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('projects', $filename, 'public');

                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                    'alt_text' => $request->title,
                    'is_primary' => $index === 0,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        // Handle technologies
        if ($request->technologies) {
            $technologies = array_map('trim', explode(',', $request->technologies));
            foreach ($technologies as $tech) {
                if (!empty($tech)) {
                    ProjectTechnology::create([
                        'project_id' => $project->id,
                        'technology_name' => $tech,
                    ]);
                }
            }
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully!');
    }

    public function show(Project $project)
    {
        $project->load(['images', 'technologies']);
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $project->load(['images', 'technologies']);
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'detailed_description' => 'required|string',
            'project_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'is_featured' => 'boolean',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'technologies' => 'required|string',
        ]);

        $project->update([
            'title' => $request->title,
            'short_description' => $request->short_description,
            'detailed_description' => $request->detailed_description,
            'project_url' => $request->project_url,
            'github_url' => $request->github_url,
            'is_featured' => $request->has('is_featured'),
        ]);

        // Handle new image uploads
        if ($request->hasFile('new_images')) {
            $existingImagesCount = $project->images()->count();

            foreach ($request->file('new_images') as $index => $image) {
                $filename = time() . '_' . ($existingImagesCount + $index) . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('projects', $filename, 'public');

                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $path,
                    'alt_text' => $request->title,
                    'is_primary' => $existingImagesCount === 0 && $index === 0,
                    'sort_order' => $existingImagesCount + $index + 1,
                ]);
            }
        }

        // Update technologies
        $project->technologies()->delete();
        if ($request->technologies) {
            $technologies = array_map('trim', explode(',', $request->technologies));
            foreach ($technologies as $tech) {
                if (!empty($tech)) {
                    ProjectTechnology::create([
                        'project_id' => $project->id,
                        'technology_name' => $tech,
                    ]);
                }
            }
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        // Delete associated images from storage
        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully!');
    }

    public function deleteImage(ProjectImage $image)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        try {
            // Log the deletion attempt
            \Log::info('Attempting to delete image', [
                'image_id' => $image->id,
                'path' => $image->image_path,
                'user_id' => auth()->id()
            ]);

            // Validate the image exists and belongs to a project
            if (!$image->project) {
                \Log::error('Image has no associated project', ['image_id' => $image->id]);
                return response()->json(['success' => false, 'message' => 'Invalid image'], 400);
            }

            // Check if this is a primary image and if there are other images
            $project = $image->project;
            $otherImages = $project->images()->where('id', '!=', $image->id)->get();

            // If this is the primary image and there are other images, make the first other image primary
            if ($image->is_primary && $otherImages->count() > 0) {
                $firstOtherImage = $otherImages->first();
                $firstOtherImage->update(['is_primary' => true]);
                \Log::info('Set new primary image', ['new_primary_id' => $firstOtherImage->id]);
            }

            // Delete the file from storage
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
                \Log::info('File deleted from storage', ['path' => $image->image_path]);
            } else {
                \Log::warning('File not found in storage', ['path' => $image->image_path]);
            }

            // Delete the database record
            $imageId = $image->id;
            $image->delete();
            \Log::info('Image record deleted from database', ['image_id' => $imageId]);

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully',
                'deleted_image_id' => $imageId
            ]);

        } catch (\Exception $e) {
            \Log::error('Failed to delete image', [
                'image_id' => $image->id ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image: ' . $e->getMessage()
            ], 500);
        }
    }
}
