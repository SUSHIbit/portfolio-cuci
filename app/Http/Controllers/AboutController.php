<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExperienceSection;
use App\Models\DynamicSection;
use App\Models\SocialLink;

class AboutController extends Controller
{
    public function index()
    {
        // Fetch real data from database
        $experienceSections = ExperienceSection::orderBy('sort_order')->get();
        $dynamicSections = DynamicSection::with('items')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        $socialLinks = SocialLink::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.about', [
            'experienceSections' => $experienceSections,
            'dynamicSections' => $dynamicSections,
            'socialLinks' => $socialLinks,
        ]);
    }
}
