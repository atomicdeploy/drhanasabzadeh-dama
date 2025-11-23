<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DiscountController extends Controller
{
    /**
     * Display a listing of discounts.
     */
    public function index(Request $request)
    {
        $query = Discount::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'expired') {
                $query->expired();
            }
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $discounts = $query->paginate(15);

        return view('admin.discount.index', compact('discounts'));
    }

    /**
     * Show the form for creating a new discount.
     */
    public function create()
    {
        return view('admin.discount.create');
    }

    /**
     * Store a newly created discount.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:discounts,code|max:50',
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'usage_limit_total' => 'nullable|integer|min:1',
            'minimum_purchase_amount' => 'nullable|numeric|min:0',
            'applicable_type' => 'required|in:all,categories,courses',
            'applicable_ids' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'code.required' => 'کد تخفیف الزامی است',
            'code.unique' => 'این کد تخفیف قبلاً استفاده شده است',
            'type.required' => 'نوع تخفیف الزامی است',
            'value.required' => 'مقدار تخفیف الزامی است',
            'end_date.after' => 'تاریخ پایان باید بعد از تاریخ شروع باشد',
        ]);

        $validated['used_count'] = 0;
        $validated['code'] = strtoupper($validated['code']);

        Discount::create($validated);

        return redirect()->route('discount.index')
            ->with('success', 'کد تخفیف جدید با موفقیت ایجاد شد');
    }

    /**
     * Display the specified discount.
     */
    public function show(Discount $discount)
    {
        return view('admin.discount.show', compact('discount'));
    }

    /**
     * Show the form for editing the specified discount.
     */
    public function edit(Discount $discount)
    {
        return view('admin.discount.edit', compact('discount'));
    }

    /**
     * Update the specified discount.
     */
    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:50|unique:discounts,code,' . $discount->id,
            'description' => 'nullable|string|max:500',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit_per_user' => 'nullable|integer|min:1',
            'usage_limit_total' => 'nullable|integer|min:1',
            'minimum_purchase_amount' => 'nullable|numeric|min:0',
            'applicable_type' => 'required|in:all,categories,courses',
            'applicable_ids' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ], [
            'code.required' => 'کد تخفیف الزامی است',
            'code.unique' => 'این کد تخفیف قبلاً استفاده شده است',
            'end_date.after' => 'تاریخ پایان باید بعد از تاریخ شروع باشد',
        ]);

        $validated['code'] = strtoupper($validated['code']);

        $discount->update($validated);

        return redirect()->route('discount.index')
            ->with('success', 'کد تخفیف با موفقیت بروزرسانی شد');
    }

    /**
     * Remove the specified discount.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('discount.index')
            ->with('success', 'کد تخفیف با موفقیت حذف شد');
    }

    /**
     * Validate discount code via AJAX.
     */
    public function validateCode(Request $request)
    {
        $code = strtoupper($request->input('code'));
        $discount = Discount::where('code', $code)->first();

        if (!$discount) {
            return response()->json([
                'valid' => false,
                'message' => 'کد تخفیف معتبر نیست'
            ]);
        }

        if (!$discount->isValid()) {
            return response()->json([
                'valid' => false,
                'message' => $discount->isExpired() ? 'کد تخفیف منقضی شده است' : 'کد تخفیف فعال نیست'
            ]);
        }

        return response()->json([
            'valid' => true,
            'discount' => [
                'type' => $discount->type,
                'value' => $discount->value,
                'minimum_purchase' => $discount->minimum_purchase_amount
            ],
            'message' => 'کد تخفیف معتبر است'
        ]);
    }
}
