<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\SocialLink;

class ProjectController extends Controller
{
    public function index()
    {
        // Fetch real data from database
        $projects = Project::with(['images', 'technologies', 'primaryImage'])
            ->orderBy('sort_order')
            ->get();

        $socialLinks = SocialLink::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Prepare project data for JavaScript
        $projectsData = $projects->mapWithKeys(function($project) {
            return ['project' . $project->id => [
                'id' => $project->id,
                'title' => $project->title,
                'shortDescription' => $project->short_description,
                'detailedDescription' => $project->detailed_description,
                'projectUrl' => $project->project_url,
                'githubUrl' => $project->github_url,
                'technologies' => $project->technologies->pluck('technology_name')->toArray(),
                'primaryImage' => $project->primaryImage ? asset($project->primaryImage->image_path) : null,
                'images' => $project->images->map(function($image) {
                    return asset($image->image_path);
                })->toArray()
            ]];
        });

        return view('pages.projects', [
            'projects' => $projects,
            'socialLinks' => $socialLinks,
            'projectsData' => $projectsData,
        ]);
    }
}
