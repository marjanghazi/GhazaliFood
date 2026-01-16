<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with(['assignedTo', 'respondedBy'])
            ->latest()
            ->paginate(20);
        
        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function show(Feedback $feedback)
    {
        $feedback->load(['assignedTo', 'respondedBy']);
        
        return view('admin.feedback.show', compact('feedback'));
    }

    public function edit(Feedback $feedback)
    {
        $statuses = ['new', 'in_progress', 'resolved', 'closed'];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        
        // Get admin users for assignment
        $admins = \App\Models\User::whereIn('role_id', [1, 2, 3])->get();
        
        return view('admin.feedback.edit', compact('feedback', 'statuses', 'priorities', 'admins'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,in_progress,resolved,closed',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        $feedback->update($validated);

        return redirect()->route('admin.feedback.show', $feedback)
            ->with('success', 'Feedback updated successfully!');
    }

    public function updateStatus(Request $request, Feedback $feedback)
    {
        $request->validate([
            'status' => 'required|in:new,in_progress,resolved,closed'
        ]);

        $feedback->update(['status' => $request->status]);

        return response()->json(['success' => true]);
    }

    public function respond(Request $request, Feedback $feedback)
    {
        $request->validate([
            'response' => 'required|string',
            'send_email' => 'boolean'
        ]);

        $feedback->update([
            'response' => $request->response,
            'responded_by' => auth()->id(),
            'responded_at' => now(),
            'status' => 'resolved'
        ]);

        // Send email response if requested
        if ($request->has('send_email') && $request->send_email) {
            // You would implement email sending here
            // Mail::to($feedback->email)->send(new FeedbackResponse($feedback));
        }

        return redirect()->route('admin.feedback.show', $feedback)
            ->with('success', 'Response sent successfully!');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('admin.feedback.index')
            ->with('success', 'Feedback deleted successfully!');
    }

    public function export()
    {
        $feedbacks = Feedback::all();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="feedback-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($feedbacks) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Email', 'Subject', 'Type', 'Status', 'Priority', 'Date']);
            
            foreach ($feedbacks as $feedback) {
                fputcsv($file, [
                    $feedback->name,
                    $feedback->email,
                    $feedback->subject,
                    ucfirst($feedback->feedback_type),
                    ucfirst($feedback->status),
                    ucfirst($feedback->priority),
                    $feedback->created_at->format('Y-m-d')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}