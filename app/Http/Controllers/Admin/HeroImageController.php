<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class HeroImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heroImages = HeroImage::orderBy('image_type')
            ->orderBy('sort_order')
            ->get();

        return view('admin.hero-images.index', compact('heroImages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $imageTypes = [
            'main' => 'Main Image',
            'floating' => 'Floating Product Image',
            'badge' => 'Quality Badge',
            'background' => 'Background Element'
        ];

        $positions = [
            'main' => 'Main Image',
            'floating_1' => 'Floating Image 1',
            'floating_2' => 'Floating Image 2',
            'floating_3' => 'Floating Image 3',
            'floating_4' => 'Floating Image 4',
            'badge_1' => 'Badge 1',
            'badge_2' => 'Badge 2',
            'badge_3' => 'Badge 3',
            'background' => 'Background'
        ];

        return view('admin.hero-images.create', compact('imageTypes', 'positions'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image_type' => 'required|in:main,floating,badge,background',
            'image' => 'required_if:image_type,main,floating,background|image|max:5120',
            'position' => 'required|in:main,floating_1,floating_2,floating_3,floating_4,badge_1,badge_2,badge_3,background',
            'product_label' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:50',
            'badge_text' => 'nullable|string|max:100',
            'link' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer'
            // Remove the 'is_active' validation here
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'title',
            'subtitle',
            'image_type',
            'position',
            'product_label',
            'icon',
            'badge_text',
            'link',
            'sort_order'
        ]);

        // Handle is_active checkbox
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image') && in_array($request->image_type, ['main', 'floating', 'background'])) {
            $imagePath = $request->file('image')->store('hero-images', 'public');
            $data['image_url'] = $imagePath;
        }

        // For badges, we might not need an image
        if ($request->image_type === 'badge') {
            $data['image_url'] = null;
        }

        HeroImage::create($data);

        return redirect()->route('admin.hero-images.index')
            ->with('success', 'Hero image added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HeroImage $heroImage)
    {
        $imageTypes = [
            'main' => 'Main Image',
            'floating' => 'Floating Product Image',
            'badge' => 'Quality Badge',
            'background' => 'Background Element'
        ];

        $positions = [
            'main' => 'Main Image',
            'floating_1' => 'Floating Image 1',
            'floating_2' => 'Floating Image 2',
            'floating_3' => 'Floating Image 3',
            'floating_4' => 'Floating Image 4',
            'badge_1' => 'Badge 1',
            'badge_2' => 'Badge 2',
            'badge_3' => 'Badge 3',
            'background' => 'Background'
        ];

        return view('admin.hero-images.edit', compact('heroImage', 'imageTypes', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HeroImage $heroImage)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image_type' => 'required|in:main,floating,badge,background',
            'image' => 'nullable|image|max:5120',
            'position' => 'required|in:main,floating_1,floating_2,floating_3,floating_4,badge_1,badge_2,badge_3,background',
            'product_label' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:50',
            'badge_text' => 'nullable|string|max:100',
            'link' => 'nullable|url|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only([
            'title',
            'subtitle',
            'image_type',
            'position',
            'product_label',
            'icon',
            'badge_text',
            'link',
            'is_active',
            'sort_order'
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($heroImage->image_url && !str_contains($heroImage->image_url, 'http')) {
                Storage::disk('public')->delete($heroImage->image_url);
            }

            $imagePath = $request->file('image')->store('hero-images', 'public');
            $data['image_url'] = $imagePath;
        }

        $heroImage->update($data);

        return redirect()->route('admin.hero-images.index')
            ->with('success', 'Hero image updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HeroImage $heroImage)
    {
        // Delete image file if exists
        if ($heroImage->image_url && !str_contains($heroImage->image_url, 'http')) {
            Storage::disk('public')->delete($heroImage->image_url);
        }

        $heroImage->delete();

        return redirect()->route('admin.hero-images.index')
            ->with('success', 'Hero image deleted successfully!');
    }

    /**
     * Update the sort order of hero images
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:hero_images,id'
        ]);

        foreach ($request->order as $index => $id) {
            HeroImage::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(HeroImage $heroImage)
    {
        $heroImage->update([
            'is_active' => !$heroImage->is_active
        ]);

        return redirect()->back()
            ->with('success', 'Status updated successfully!');
    }
}
