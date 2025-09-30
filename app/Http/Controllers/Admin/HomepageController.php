<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\HeroParagraph;

class HomepageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $heroTitle = SiteSetting::get('hero_title', "I'M ADENEKAN WONDERFUL");
        $heroParagraphs = HeroParagraph::orderBy('sort_order')->get();

        return view('admin.homepage.index', compact('heroTitle', 'heroParagraphs'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'paragraphs' => 'array',
            'paragraphs.*' => 'required|string|max:1000',
        ]);

        // Update hero title
        SiteSetting::set('hero_title', $request->hero_title);

        // Update paragraphs
        if ($request->has('paragraphs')) {
            // Delete existing paragraphs
            HeroParagraph::truncate();

            // Add new paragraphs
            foreach ($request->paragraphs as $index => $content) {
                if (!empty(trim($content))) {
                    HeroParagraph::create([
                        'content' => $content,
                        'sort_order' => $index + 1,
                    ]);
                }
            }
        }

        return redirect()->route('admin.homepage.index')
            ->with('success', 'Homepage content updated successfully!');
    }
}
