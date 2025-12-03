<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers.
     */
    public function index(Request $request)
    {
        $query = Teacher::with('user');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('bio', 'like', "%{$search}%")
                  ->orWhere('expertise', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $teachers = $query->paginate(15);

        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /**
     * Store a newly created teacher.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'bio' => 'nullable|string',
            'expertise' => 'required|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'education' => 'nullable|string',
            'certificates' => 'nullable|string',
            'social_links' => 'nullable|array',
            'status' => 'required|in:active,inactive',
        ], [
            'user_id.required' => 'انتخاب کاربر الزامی است',
            'user_id.exists' => 'کاربر انتخاب شده معتبر نیست',
            'expertise.required' => 'تخصص الزامی است',
            'status.required' => 'وضعیت الزامی است',
        ]);

        Teacher::create($validated);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'مدرس با موفقیت ایجاد شد');
    }

    /**
     * Display the specified teacher.
     */
    public function show($id)
    {
        $teacher = Teacher::with(['user', 'courses'])->findOrFail($id);
        return view('admin.teachers.show', compact('teacher'));
    }

    /**
     * Show the form for editing a teacher.
     */
    public function edit($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified teacher.
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validated = $request->validate([
            'bio' => 'nullable|string',
            'expertise' => 'required|string|max:255',
            'experience_years' => 'nullable|integer|min:0',
            'education' => 'nullable|string',
            'certificates' => 'nullable|string',
            'social_links' => 'nullable|array',
            'status' => 'required|in:active,inactive',
        ], [
            'expertise.required' => 'تخصص الزامی است',
            'status.required' => 'وضعیت الزامی است',
        ]);

        $teacher->update($validated);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'مدرس با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified teacher.
     */
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);

        // Check for associated courses
        if ($teacher->courses()->exists()) {
            return redirect()->route('admin.teachers.index')
                ->with('error', 'این مدرس دارای دوره است و قابل حذف نیست');
        }

        $teacher->delete();

        return redirect()->route('admin.teachers.index')
            ->with('success', 'مدرس با موفقیت حذف شد');
    }
}
