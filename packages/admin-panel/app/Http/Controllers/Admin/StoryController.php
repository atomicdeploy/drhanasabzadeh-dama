<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StoryController extends Controller
{
    /**
     * Display a listing of stories.
     */
    public function index(Request $request)
    {
        $query = Story::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('link_url', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'expired') {
                $query->expired();
            } else {
                $query->where('status', $request->status);
            }
        }

        // Sorting
        $sortField = $request->get('sort', 'order');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $stories = $query->paginate(15);

        return view('admin.story.index', compact('stories'));
    }

    /**
     * Show the form for creating a new story.
     */
    public function create()
    {
        return view('admin.story.create');
    }

    /**
     * Store a newly created story.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image_url' => 'required|url|max:500',
            'link_url' => 'nullable|url|max:500',
            'expires_at' => 'nullable|date',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive,expired',
        ], [
            'image_url.required' => 'تصویر استوری الزامی است',
            'image_url.url' => 'آدرس تصویر معتبر نیست',
        ]);

        // Default expiration: 24 hours from now
        if (!isset($validated['expires_at'])) {
            $validated['expires_at'] = Carbon::now()->addHours(24);
        }

        $validated['view_count'] = 0;

        // Auto-assign order if not provided
        if (!isset($validated['order'])) {
            $maxOrder = Story::max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;
        }

        Story::create($validated);

        return redirect()->route('story.index')
            ->with('success', 'استوری جدید با موفقیت ایجاد شد');
    }

    /**
     * Display the specified story.
     */
    public function show(Story $story)
    {
        return view('admin.story.show', compact('story'));
    }

    /**
     * Show the form for editing the specified story.
     */
    public function edit(Story $story)
    {
        return view('admin.story.edit', compact('story'));
    }

    /**
     * Update the specified story.
     */
    public function update(Request $request, Story $story)
    {
        $validated = $request->validate([
            'image_url' => 'required|url|max:500',
            'link_url' => 'nullable|url|max:500',
            'expires_at' => 'nullable|date',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive,expired',
        ], [
            'image_url.required' => 'تصویر استوری الزامی است',
            'image_url.url' => 'آدرس تصویر معتبر نیست',
        ]);

        // Check if story has expired
        if (isset($validated['expires_at']) && Carbon::parse($validated['expires_at'])->isPast()) {
            $validated['status'] = 'expired';
        }

        $story->update($validated);

        return redirect()->route('story.index')
            ->with('success', 'استوری با موفقیت بروزرسانی شد');
    }

    /**
     * Remove the specified story.
     */
    public function destroy(Story $story)
    {
        $story->delete();

        return redirect()->route('story.index')
            ->with('success', 'استوری با موفقیت حذف شد');
    }
}
