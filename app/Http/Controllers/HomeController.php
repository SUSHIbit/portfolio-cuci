<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\HeroParagraph;
use App\Models\SocialLink;

class HomeController extends Controller
{
    public function index()
    {
        $heroTitle = SiteSetting::get('hero_title', "I'M ADENEKAN WONDERFUL");
        $heroParagraphs = HeroParagraph::orderBy('sort_order')->get();
        $socialLinks = SocialLink::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.home', [
            'heroTitle' => $heroTitle,
            'heroParagraphs' => $heroParagraphs,
            'socialLinks' => $socialLinks,
        ]);
    }
}
