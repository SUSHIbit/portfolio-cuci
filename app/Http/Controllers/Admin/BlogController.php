<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogContentBlock;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $blogs = Blog::with('category')->orderBy('published_date', 'desc')->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::orderBy('sort_order')->get();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'status' => 'required|in:draft,published',
            'published_date' => 'required|date',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'content_blocks' => 'required|array|min:1',
            'content_blocks.*.type' => 'required|in:paragraph,image',
            'content_blocks.*.content' => 'required',
        ]);

        // Create blog
        $blog = Blog::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'blog_category_id' => $request->blog_category_id,
            'status' => $request->status,
            'published_date' => $request->published_date,
        ]);

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            $filename = time() . '_' . Str::random(10) . '.' . $request->file('featured_image')->getClientOriginalExtension();
            $request->file('featured_image')->move(public_path('uploads/blogs/featured'), $filename);
            $blog->update(['featured_image' => 'uploads/blogs/featured/' . $filename]);
        }

        // Handle content blocks
        foreach ($request->content_blocks as $index => $block) {
            $content = $block['content'];

            // If it's an image block and has a file
            if ($block['type'] === 'image' && $request->hasFile("content_blocks.{$index}.content")) {
                $filename = time() . '_' . $index . '_' . Str::random(10) . '.' . $request->file("content_blocks.{$index}.content")->getClientOriginalExtension();
                $content = $request->file("content_blocks.{$index}.content")->storeAs('blogs/content', $filename, 'public');
            }

            BlogContentBlock::create([
                'blog_id' => $blog->id,
                'type' => $block['type'],
                'content' => $content,
                'sort_order' => $index + 1,
            ]);
        }

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    public function edit(Blog $blog)
    {
        $blog->load('contentBlocks');
        $categories = BlogCategory::orderBy('sort_order')->get();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'blog_category_id' => 'required|exists:blog_categories,id',
            'status' => 'required|in:draft,published',
            'published_date' => 'required|date',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'content_blocks' => 'required|array|min:1',
            'content_blocks.*.type' => 'required|in:paragraph,image',
        ]);

        // Update blog
        $blog->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'excerpt' => $request->excerpt,
            'blog_category_id' => $request->blog_category_id,
            'status' => $request->status,
            'published_date' => $request->published_date,
        ]);

        // Handle featured image update
        if ($request->hasFile('featured_image')) {
            // Delete old featured image
            if ($blog->featured_image && file_exists(public_path($blog->featured_image))) {
                unlink(public_path($blog->featured_image));
            }

            $filename = time() . '_' . Str::random(10) . '.' . $request->file('featured_image')->getClientOriginalExtension();
            $request->file('featured_image')->move(public_path('uploads/blogs/featured'), $filename);
            $blog->update(['featured_image' => 'uploads/blogs/featured/' . $filename]);
        }

        // Delete old content blocks and their images
        foreach ($blog->contentBlocks as $oldBlock) {
            if ($oldBlock->type === 'image' && $oldBlock->content && file_exists(public_path($oldBlock->content))) {
                unlink(public_path($oldBlock->content));
            }
        }
        $blog->contentBlocks()->delete();

        // Handle content blocks
        foreach ($request->content_blocks as $index => $block) {
            $content = $block['content'];

            // If it's an image block and has a file
            if ($block['type'] === 'image' && $request->hasFile("content_blocks.{$index}.content")) {
                $filename = time() . '_' . $index . '_' . Str::random(10) . '.' . $request->file("content_blocks.{$index}.content")->getClientOriginalExtension();
                $request->file("content_blocks.{$index}.content")->move(public_path('uploads/blogs/content'), $filename);
                $content = 'uploads/blogs/content/' . $filename;
            }

            BlogContentBlock::create([
                'blog_id' => $blog->id,
                'type' => $block['type'],
                'content' => $content,
                'sort_order' => $index + 1,
            ]);
        }

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        // Delete featured image
        if ($blog->featured_image && file_exists(public_path($blog->featured_image))) {
            unlink(public_path($blog->featured_image));
        }

        // Delete content block images
        foreach ($blog->contentBlocks as $block) {
            if ($block->type === 'image' && $block->content && file_exists(public_path($block->content))) {
                unlink(public_path($block->content));
            }
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }
}
