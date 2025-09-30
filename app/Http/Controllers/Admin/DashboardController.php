<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ContactMessage;
use App\Models\SiteSetting;
use App\Models\HeroParagraph;
use App\Models\SocialLink;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $stats = [
            'projects' => Project::count(),
            'messages' => ContactMessage::where('is_read', false)->count(),
            'hero_paragraphs' => HeroParagraph::count(),
            'social_links' => SocialLink::where('is_active', true)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
