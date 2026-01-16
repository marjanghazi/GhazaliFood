<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with(['creator'])
            ->latest()
            ->paginate(20);
        
        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string',
            'link_url' => 'nullable|url|max:500',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'display_order' => 'nullable|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_closable' => 'boolean',
            'status' => 'required|in:active,inactive,scheduled'
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_closable'] = $request->has('is_closable');
        
        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully!');
    }

    public function show(Announcement $announcement)
    {
        $announcement->load(['creator']);
        
        return view('admin.announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $request->validate([
            'text' => 'required|string',
            'link_url' => 'nullable|url|max:500',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'display_order' => 'nullable|integer|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_closable' => 'boolean',
            'status' => 'required|in:active,inactive,scheduled'
        ]);

        $validated['is_closable'] = $request->has('is_closable');
        
        $announcement->update($validated);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully!');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully!');
    }
}