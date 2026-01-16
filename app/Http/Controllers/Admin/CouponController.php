<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with(['creator'])
            ->latest()
            ->paginate(20);
        
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        $products = Product::where('status', 'published')->get();
        
        return view('admin.coupons.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'total_usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'applicable_to' => 'required|in:all,categories,products,users'
        ]);

        $validated['created_by'] = auth()->id();
        $validated['is_active'] = $request->has('is_active');
        
        $coupon = Coupon::create($validated);

        // Handle restrictions
        if ($request->applicable_to !== 'all') {
            $this->saveRestrictions($coupon, $request);
        }

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully!');
    }

    public function show(Coupon $coupon)
    {
        $coupon->load(['creator', 'restrictions']);
        
        return view('admin.coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        $categories = Category::where('status', 'active')->get();
        $products = Product::where('status', 'published')->get();
        
        $coupon->load(['restrictions']);
        
        return view('admin.coupons.edit', compact('coupon', 'categories', 'products'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount_amount' => 'nullable|numeric|min:0',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'total_usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'applicable_to' => 'required|in:all,categories,products,users'
        ]);

        $validated['is_active'] = $request->has('is_active');
        
        $coupon->update($validated);

        // Update restrictions
        $coupon->restrictions()->delete();
        if ($request->applicable_to !== 'all') {
            $this->saveRestrictions($coupon, $request);
        }

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->restrictions()->delete();
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully!');
    }

    public function toggleStatus(Request $request, Coupon $coupon)
    {
        $coupon->update([
            'is_active' => !$coupon->is_active
        ]);

        return response()->json(['success' => true]);
    }

    private function saveRestrictions($coupon, $request)
    {
        $restrictions = [];
        
        if ($request->applicable_to === 'categories' && $request->has('categories')) {
            foreach ($request->categories as $categoryId) {
                $restrictions[] = [
                    'coupon_id' => $coupon->id,
                    'restriction_type' => 'category',
                    'entity_id' => $categoryId
                ];
            }
        }
        
        if ($request->applicable_to === 'products' && $request->has('products')) {
            foreach ($request->products as $productId) {
                $restrictions[] = [
                    'coupon_id' => $coupon->id,
                    'restriction_type' => 'product',
                    'entity_id' => $productId
                ];
            }
        }
        
        if (!empty($restrictions)) {
            \App\Models\CouponRestriction::insert($restrictions);
        }
    }

    public function generateCode()
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Coupon::where('code', $code)->exists());

        return response()->json(['code' => $code]);
    }
}