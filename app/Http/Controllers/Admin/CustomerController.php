<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role_id', 4) // Customer role
            ->withCount(['orders'])
            ->latest()
            ->paginate(20);
        
        return view('admin.customers.index', compact('customers'));
    }

    public function show(User $customer)
    {
        // Verify this is a customer
        if ($customer->role_id != 4) {
            abort(404);
        }
        
        $customer->load(['orders' => function($query) {
            $query->latest()->limit(10);
        }]);
        
        return view('admin.customers.show', compact('customer'));
    }

    public function edit(User $customer)
    {
        if ($customer->role_id != 4) {
            abort(404);
        }
        
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer)
    {
        if ($customer->role_id != 4) {
            abort(404);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,suspended'
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Customer updated successfully!');
    }

    public function toggleStatus(Request $request, User $customer)
    {
        if ($customer->role_id != 4) {
            abort(404);
        }
        
        $customer->update([
            'status' => $customer->status === 'active' ? 'inactive' : 'active'
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy(User $customer)
    {
        if ($customer->role_id != 4) {
            abort(404);
        }
        
        // Optional: Check if customer has orders before deleting
        if ($customer->orders()->count() > 0) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Cannot delete customer with existing orders.');
        }
        
        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully!');
    }

    public function export()
    {
        $customers = User::where('role_id', 4)->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="customers-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($customers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Email', 'Phone', 'Status', 'Joined Date', 'Total Orders']);
            
            foreach ($customers as $customer) {
                fputcsv($file, [
                    $customer->name,
                    $customer->email,
                    $customer->phone ?? 'N/A',
                    ucfirst($customer->status),
                    $customer->created_at->format('Y-m-d'),
                    $customer->orders_count ?? 0
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}