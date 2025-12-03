<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $users = $query->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|string|unique:users,mobile',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:user,teacher,admin',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'نام الزامی است',
            'email.required' => 'ایمیل الزامی است',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است',
            'mobile.required' => 'شماره موبایل الزامی است',
            'mobile.unique' => 'این شماره موبایل قبلاً ثبت شده است',
            'password.required' => 'رمز عبور الزامی است',
            'password.min' => 'رمز عبور باید حداقل 6 کاراکتر باشد',
            'password.confirmed' => 'تکرار رمز عبور مطابقت ندارد',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.userlist')
            ->with('success', 'کاربر با موفقیت ایجاد شد');
    }

    /**
     * Display the specified user.
     */
    public function show($id)
    {
        $user = User::with(['orders', 'subscriptions'])->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing a user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile' => 'required|string|unique:users,mobile,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:user,teacher,admin',
            'status' => 'required|in:active,inactive',
        ], [
            'name.required' => 'نام الزامی است',
            'email.required' => 'ایمیل الزامی است',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است',
            'mobile.required' => 'شماره موبایل الزامی است',
            'mobile.unique' => 'این شماره موبایل قبلاً ثبت شده است',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.userlist')
            ->with('success', 'کاربر با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Check for associated orders
        if ($user->orders()->exists()) {
            return redirect()->route('admin.userlist')
                ->with('error', 'این کاربر دارای سفارش است و قابل حذف نیست');
        }

        $user->delete();

        return redirect()->route('admin.userlist')
            ->with('success', 'کاربر با موفقیت حذف شد');
    }

    /**
     * Show bulk upload form.
     */
    public function uploadForm()
    {
        return view('admin.users.upload');
    }

    /**
     * Process bulk user upload.
     */
    public function uploadProcess(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ], [
            'file.required' => 'فایل الزامی است',
            'file.mimes' => 'فقط فایل‌های اکسل مجاز است',
            'file.max' => 'حداکثر حجم فایل 10 مگابایت است',
        ]);

        // TODO: Process Excel file and create users
        // This would typically use Laravel Excel package

        return redirect()->route('admin.userlist')
            ->with('success', 'کاربران با موفقیت آپلود شدند');
    }
}
