<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'product'])
            ->latest()
            ->paginate(20);
        
        return view('admin.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        $review->load(['user', 'product', 'media']);
        
        return view('admin.reviews.show', compact('review'));
    }

    public function updateStatus(Request $request, Review $review)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $review->update([
            'status' => $request->status,
            'admin_reviewed_by' => auth()->id(),
            'admin_reviewed_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy(Review $review)
    {
        // Delete review media
        foreach ($review->media as $media) {
            // Delete media files if stored locally
            $media->delete();
        }
        
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully!');
    }

    public function approve(Review $review)
    {
        $review->update([
            'status' => 'approved',
            'admin_reviewed_by' => auth()->id(),
            'admin_reviewed_at' => now()
        ]);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review approved successfully!');
    }

    public function reject(Review $review)
    {
        $review->update([
            'status' => 'rejected',
            'admin_reviewed_by' => auth()->id(),
            'admin_reviewed_at' => now()
        ]);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review rejected successfully!');
    }
}