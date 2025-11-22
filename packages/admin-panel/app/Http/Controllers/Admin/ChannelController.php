<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function index(Request $request)
    {
        $query = Channel::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $channels = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.channels.index', compact('channels'));
    }

    public function create()
    {
        return view('admin.channels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $channel = Channel::create($validated);

        return redirect()
            ->route('admin.channels.index')
            ->with('success', 'کانال با موفقیت ایجاد شد');
    }

    public function show(Channel $channel)
    {
        $channel->load('posts');
        return view('admin.channels.show', compact('channel'));
    }

    public function edit(Channel $channel)
    {
        return view('admin.channels.edit', compact('channel'));
    }

    public function update(Request $request, Channel $channel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $channel->update($validated);

        return redirect()
            ->route('admin.channels.index')
            ->with('success', 'کانال با موفقیت به‌روزرسانی شد');
    }

    public function destroy(Channel $channel)
    {
        if ($channel->posts()->count() > 0) {
            return back()->withErrors(['error' => 'این کانال دارای پست است و نمی‌توان آن را حذف کرد']);
        }

        $channel->delete();

        return redirect()
            ->route('admin.channels.index')
            ->with('success', 'کانال با موفقیت حذف شد');
    }
}
