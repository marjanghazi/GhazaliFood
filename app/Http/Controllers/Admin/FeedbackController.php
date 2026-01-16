<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with(['assignedTo', 'respondedBy'])
            ->latest()
            ->paginate(20);
        
        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        $admins = \App\Models\User::whereIn('role_id', [1, 2, 3])->get();
        return view('admin.feedback.create', compact('admins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
            'feedback_type' => 'required|in:general,complaint,suggestion,support,other',
            'priority' => 'required|in:low,medium,high,urgent'
        ]);

        $validated['ip_address'] = $request->ip();
        $validated['user_agent'] = $request->userAgent();

        Feedback::create($validated);

        return redirect()->route('admin.feedback.index')
            ->with('success', 'Feedback created successfully!');
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
            'assigned_to' => 'nullable|exists:users,id',
            'response' => 'nullable|string'
        ]);

        if ($request->has('response') && $request->response) {
            $validated['responded_by'] = auth()->id();
            $validated['responded_at'] = now();
        }

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
        $feedbacks = Feedback::with(['assignedTo', 'respondedBy'])->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="feedback-export-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($feedbacks) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fwrite($file, "\xEF\xBB\xBF");
            
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone', 'Subject', 'Message', 'Type', 'Status', 'Priority', 'Assigned To', 'Response', 'Responded At', 'Created At']);
            
            foreach ($feedbacks as $feedback) {
                fputcsv($file, [
                    $feedback->id,
                    $feedback->name,
                    $feedback->email,
                    $feedback->phone ?? 'N/A',
                    $feedback->subject,
                    $feedback->message,
                    ucfirst($feedback->feedback_type),
                    ucfirst($feedback->status),
                    ucfirst($feedback->priority),
                    $feedback->assignedTo->name ?? 'Not Assigned',
                    $feedback->response ?? 'No Response',
                    $feedback->responded_at ? $feedback->responded_at->format('Y-m-d H:i:s') : 'N/A',
                    $feedback->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}