<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\SocialLink;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with('category')
            ->published()
            ->orderBy('published_date', 'desc');

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('blog_category_id', $request->category);
        }

        $blogs = $query->paginate(10);
        $categories = BlogCategory::orderBy('sort_order')->get();
        $socialLinks = SocialLink::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.blog.index', compact('blogs', 'categories', 'socialLinks'));
    }

    public function show($slug)
    {
        $blog = Blog::with(['category', 'contentBlocks'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $socialLinks = SocialLink::where('is_active', true)->orderBy('sort_order')->get();

        return view('pages.blog.show', compact('blog', 'socialLinks'));
    }
}
