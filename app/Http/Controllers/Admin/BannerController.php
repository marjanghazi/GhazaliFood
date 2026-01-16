<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::with(['creator'])
            ->latest()
            ->paginate(20);
        
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        $positions = [
            'home_top' => 'Homepage Top',
            'home_middle' => 'Homepage Middle',
            'home_bottom' => 'Homepage Bottom',
            'sidebar' => 'Sidebar',
            'popup' => 'Popup'
        ];
        
        return view('admin.banners.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'position' => 'required|in:home_top,home_middle,home_bottom,sidebar,popup',
            'display_order' => 'nullable|integer|min:0',
            'link_url' => 'nullable|url|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'banner_image' => 'required|image|max:2048',
            'banner_mobile_image' => 'nullable|image|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,scheduled'
        ]);

        // Upload banner image
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('banners', 'public');
        }
        
        // Upload mobile banner image
        if ($request->hasFile('banner_mobile_image')) {
            $validated['banner_mobile_image'] = $request->file('banner_mobile_image')->store('banners', 'public');
        }
        
        $validated['created_by'] = auth()->id();
        
        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner created successfully!');
    }

    public function show(Banner $banner)
    {
        $banner->load(['creator']);
        
        return view('admin.banners.show', compact('banner'));
    }

    public function edit(Banner $banner)
    {
        $positions = [
            'home_top' => 'Homepage Top',
            'home_middle' => 'Homepage Middle',
            'home_bottom' => 'Homepage Bottom',
            'sidebar' => 'Sidebar',
            'popup' => 'Popup'
        ];
        
        return view('admin.banners.edit', compact('banner', 'positions'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'position' => 'required|in:home_top,home_middle,home_bottom,sidebar,popup',
            'display_order' => 'nullable|integer|min:0',
            'link_url' => 'nullable|url|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'banner_image' => 'nullable|image|max:2048',
            'banner_mobile_image' => 'nullable|image|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,scheduled'
        ]);

        // Upload new banner image
        if ($request->hasFile('banner_image')) {
            // Delete old image
            if ($banner->banner_image) {
                Storage::disk('public')->delete($banner->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('banners', 'public');
        }
        
        // Upload new mobile banner image
        if ($request->hasFile('banner_mobile_image')) {
            // Delete old image
            if ($banner->banner_mobile_image) {
                Storage::disk('public')->delete($banner->banner_mobile_image);
            }
            $validated['banner_mobile_image'] = $request->file('banner_mobile_image')->store('banners', 'public');
        }
        
        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner updated successfully!');
    }

    public function destroy(Banner $banner)
    {
        // Delete images
        if ($banner->banner_image) {
            Storage::disk('public')->delete($banner->banner_image);
        }
        if ($banner->banner_mobile_image) {
            Storage::disk('public')->delete($banner->banner_mobile_image);
        }
        
        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner deleted successfully!');
    }
}