<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChannelPost;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChannelPostController extends Controller
{
    /**
     * Display a listing of channel posts.
     */
    public function index(Request $request)
    {
        $query = ChannelPost::with(['channel', 'author']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by channel
        if ($request->filled('channel_id')) {
            $query->where('channel_id', $request->channel_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sortField = $request->get('sort', 'published_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $channelPosts = $query->paginate(15);
        $channels = Channel::all();

        return view('admin.channelposts.index', compact('channelPosts', 'channels'));
    }

    /**
     * Show the form for creating a new channel post.
     */
    public function create()
    {
        $channels = Channel::all();
        return view('admin.channelposts.create', compact('channels'));
    }

    /**
     * Store a newly created channel post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'channel_id' => 'required|exists:channels,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|url|max:500',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published',
        ], [
            'channel_id.required' => 'انتخاب کانال الزامی است',
            'title.required' => 'عنوان الزامی است',
            'content.required' => 'محتوا الزامی است',
        ]);

        $validated['author_id'] = auth()->id() ?? 1; // Default to user 1 if no auth
        $validated['slug'] = Str::slug($validated['title']);
        $validated['view_count'] = 0;

        ChannelPost::create($validated);

        return redirect()->route('channelposts.index')
            ->with('success', 'پست جدید با موفقیت ایجاد شد');
    }

    /**
     * Display the specified channel post.
     */
    public function show(ChannelPost $channelPost)
    {
        $channelPost->load(['channel', 'author']);
        return view('admin.channelposts.show', compact('channelPost'));
    }

    /**
     * Show the form for editing the specified channel post.
     */
    public function edit(ChannelPost $channelPost)
    {
        $channels = Channel::all();
        return view('admin.channelposts.edit', compact('channelPost', 'channels'));
    }

    /**
     * Update the specified channel post.
     */
    public function update(Request $request, ChannelPost $channelPost)
    {
        $validated = $request->validate([
            'channel_id' => 'required|exists:channels,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|url|max:500',
            'published_at' => 'nullable|date',
            'status' => 'required|in:draft,published',
        ], [
            'channel_id.required' => 'انتخاب کانال الزامی است',
            'title.required' => 'عنوان الزامی است',
            'content.required' => 'محتوا الزامی است',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        $channelPost->update($validated);

        return redirect()->route('channelposts.index')
            ->with('success', 'پست با موفقیت بروزرسانی شد');
    }

    /**
     * Remove the specified channel post.
     */
    public function destroy(ChannelPost $channelPost)
    {
        $channelPost->delete();

        return redirect()->route('channelposts.index')
            ->with('success', 'پست با موفقیت حذف شد');
    }
}
