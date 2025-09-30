<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExperienceSection;
use App\Models\DynamicSection;
use App\Models\DynamicSectionItem;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $experiences = ExperienceSection::orderBy('sort_order')->get();
        $dynamicSections = DynamicSection::with('items')->orderBy('sort_order')->get();

        return view('admin.about.index', compact('experiences', 'dynamicSections'));
    }

    // Experience Section Methods
    public function storeExperience(Request $request)
    {
        $request->validate([
            'field' => 'required|string|max:255',
            'year' => 'required|string|max:50',
            'role' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $sortOrder = ExperienceSection::max('sort_order') + 1;

        ExperienceSection::create([
            'field' => $request->field,
            'year' => $request->year,
            'role' => $request->role,
            'description' => $request->description,
            'sort_order' => $sortOrder,
        ]);

        return redirect()->route('admin.about.index')
            ->with('success', 'Experience section added successfully!');
    }

    public function updateExperience(Request $request, ExperienceSection $experience)
    {
        $request->validate([
            'field' => 'required|string|max:255',
            'year' => 'required|string|max:50',
            'role' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $experience->update([
            'field' => $request->field,
            'year' => $request->year,
            'role' => $request->role,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.about.index')
            ->with('success', 'Experience section updated successfully!');
    }

    public function destroyExperience(ExperienceSection $experience)
    {
        $experience->delete();

        return redirect()->route('admin.about.index')
            ->with('success', 'Experience section deleted successfully!');
    }

    // Dynamic Section Methods
    public function storeSection(Request $request)
    {
        $request->validate([
            'section_name' => 'required|string|max:255',
        ]);

        $sortOrder = DynamicSection::max('sort_order') + 1;

        DynamicSection::create([
            'section_name' => $request->section_name,
            'is_active' => true,
            'sort_order' => $sortOrder,
        ]);

        return redirect()->route('admin.about.index')
            ->with('success', 'Dynamic section created successfully!');
    }

    public function updateSection(Request $request, DynamicSection $section)
    {
        $request->validate([
            'section_name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $section->update([
            'section_name' => $request->section_name,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.about.index')
            ->with('success', 'Dynamic section updated successfully!');
    }

    public function destroySection(DynamicSection $section)
    {
        $section->delete();

        return redirect()->route('admin.about.index')
            ->with('success', 'Dynamic section deleted successfully!');
    }

    // Dynamic Section Item Methods
    public function storeSectionItem(Request $request, DynamicSection $section)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|string|max:50',
            'description' => 'required|string|max:1000',
            'link_url' => 'nullable|url|max:255',
            'link_text' => 'nullable|string|max:100',
        ]);

        $sortOrder = $section->items()->max('sort_order') + 1;

        $section->items()->create([
            'title' => $request->title,
            'year' => $request->year,
            'description' => $request->description,
            'link_url' => $request->link_url,
            'link_text' => $request->link_text,
            'sort_order' => $sortOrder,
        ]);

        return redirect()->route('admin.about.index')
            ->with('success', 'Section item added successfully!');
    }

    public function updateSectionItem(Request $request, DynamicSectionItem $item)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|string|max:50',
            'description' => 'required|string|max:1000',
            'link_url' => 'nullable|url|max:255',
            'link_text' => 'nullable|string|max:100',
        ]);

        $item->update([
            'title' => $request->title,
            'year' => $request->year,
            'description' => $request->description,
            'link_url' => $request->link_url,
            'link_text' => $request->link_text,
        ]);

        return redirect()->route('admin.about.index')
            ->with('success', 'Section item updated successfully!');
    }

    public function destroySectionItem(DynamicSectionItem $item)
    {
        $item->delete();

        return redirect()->route('admin.about.index')
            ->with('success', 'Section item deleted successfully!');
    }
}
