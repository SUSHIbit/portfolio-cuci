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

        return view('pages.projects', [
            'projects' => $projects,
            'socialLinks' => $socialLinks,
        ]);
    }
}
