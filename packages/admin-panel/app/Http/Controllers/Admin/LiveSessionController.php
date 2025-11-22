<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LiveSession;
use App\Models\Course;
use Illuminate\Http\Request;

class LiveSessionController extends Controller
{
    public function index(Request $request)
    {
        $query = LiveSession::with('course');

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

        $sessions = $query->orderBy('scheduled_at', 'desc')->paginate(15);

        return view('admin.live.index', compact('sessions'));
    }

    public function create()
    {
        $courses = Course::active()->orderBy('title')->get();
        return view('admin.live.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'meeting_url' => 'nullable|url',
            'status' => 'required|in:scheduled,live,completed,cancelled',
        ]);

        $session = LiveSession::create($validated);

        return redirect()
            ->route('admin.live.index')
            ->with('success', 'جلسه زنده با موفقیت ایجاد شد');
    }

    public function show(LiveSession $session)
    {
        $session->load('course');
        return view('admin.live.show', compact('session'));
    }

    public function edit(LiveSession $session)
    {
        $courses = Course::active()->orderBy('title')->get();
        return view('admin.live.edit', compact('session', 'courses'));
    }

    public function update(Request $request, LiveSession $session)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:1',
            'meeting_url' => 'nullable|url',
            'status' => 'required|in:scheduled,live,completed,cancelled',
        ]);

        $session->update($validated);

        return redirect()
            ->route('admin.live.index')
            ->with('success', 'جلسه زنده با موفقیت به‌روزرسانی شد');
    }

    public function destroy(LiveSession $session)
    {
        $session->delete();

        return redirect()
            ->route('admin.live.index')
            ->with('success', 'جلسه زنده با موفقیت حذف شد');
    }

    public function comments(LiveSession $session)
    {
        $session->load(['comments' => function($query) {
            $query->latest();
        }]);
        
        return view('admin.live.comments', compact('session'));
    }
}
