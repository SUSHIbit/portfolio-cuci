<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialLink;

class SocialLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $socialLinks = SocialLink::orderBy('sort_order')->get();
        return view('admin.social-links.index', compact('socialLinks'));
    }

    public function create()
    {
        return view('admin.social-links.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'icon_class' => 'required|string|max:100',
            'is_active' => 'boolean',
        ]);

        // Ensure URL starts with http:// or https://
        $url = $validated['url'];
        if (!str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
            $url = 'https://' . $url;
        }

        $sortOrder = SocialLink::max('sort_order') + 1;

        SocialLink::create([
            'platform' => $validated['platform'],
            'url' => $url,
            'icon_class' => $validated['icon_class'],
            'is_active' => $request->has('is_active'),
            'sort_order' => $sortOrder,
        ]);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Social link created successfully!');
    }

    public function show(SocialLink $socialLink)
    {
        return view('admin.social-links.show', compact('socialLink'));
    }

    public function edit(SocialLink $socialLink)
    {
        return view('admin.social-links.edit', compact('socialLink'));
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'icon_class' => 'required|string|max:100',
            'is_active' => 'boolean',
        ]);

        // Ensure URL starts with http:// or https://
        $url = $validated['url'];
        if (!str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
            $url = 'https://' . $url;
        }

        $socialLink->update([
            'platform' => $validated['platform'],
            'url' => $url,
            'icon_class' => $validated['icon_class'],
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Social link updated successfully!');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Social link deleted successfully!');
    }
}
