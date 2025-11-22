<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Course;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with('course');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $exams = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $courses = Course::active()->orderBy('title')->get();
        return view('admin.exams.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'duration_minutes' => 'required|integer|min:1',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after:start_at',
            'status' => 'required|in:draft,published,archived',
        ]);

        $exam = Exam::create($validated);

        return redirect()
            ->route('admin.exam.index')
            ->with('success', 'آزمون با موفقیت ایجاد شد');
    }

    public function show(Exam $exam)
    {
        $exam->load('course', 'questions');
        return view('admin.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $courses = Course::active()->orderBy('title')->get();
        return view('admin.exams.edit', compact('exam', 'courses'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'duration_minutes' => 'required|integer|min:1',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after:start_at',
            'status' => 'required|in:draft,published,archived',
        ]);

        $exam->update($validated);

        return redirect()
            ->route('admin.exam.index')
            ->with('success', 'آزمون با موفقیت به‌روزرسانی شد');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()
            ->route('admin.exam.index')
            ->with('success', 'آزمون با موفقیت حذف شد');
    }
}
