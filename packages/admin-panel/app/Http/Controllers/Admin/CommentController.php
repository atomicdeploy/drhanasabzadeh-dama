<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of comments for moderation.
     */
    public function index(Request $request)
    {
        $query = Comment::with(['commentable', 'user']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('content', 'like', "%{$search}%");
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $comments = $query->paginate(15);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Show the form for editing a comment.
     */
    public function edit($id)
    {
        $comment = Comment::with(['commentable', 'user'])->findOrFail($id);
        return view('admin.comments.edit', compact('comment'));
    }

    /**
     * Update the specified comment.
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $validated = $request->validate([
            'content' => 'required|string',
            'status' => 'required|in:pending,approved,spam',
            'rating' => 'nullable|integer|min:1|max:5',
        ], [
            'content.required' => 'متن نظر الزامی است',
            'status.required' => 'وضعیت الزامی است',
        ]);

        $comment->update($validated);

        return redirect()->route('admin.comment.index')
            ->with('success', 'نظر با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified comment.
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('admin.comment.index')
            ->with('success', 'نظر با موفقیت حذف شد');
    }

    /**
     * Approve a comment.
     */
    public function approve($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['status' => 'approved']);

        return redirect()->route('admin.comment.index')
            ->with('success', 'نظر تایید شد');
    }

    /**
     * Mark a comment as spam.
     */
    public function markAsSpam($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update(['status' => 'spam']);

        return redirect()->route('admin.comment.index')
            ->with('success', 'نظر به عنوان هرزنامه علامت‌گذاری شد');
    }

    /**
     * Bulk approve comments.
     */
    public function bulkApprove(Request $request)
    {
        $ids = $request->input('comment_ids', []);
        Comment::whereIn('id', $ids)->update(['status' => 'approved']);

        return redirect()->route('admin.comment.index')
            ->with('success', count($ids) . ' نظر تایید شد');
    }

    /**
     * Bulk delete comments.
     */
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('comment_ids', []);
        Comment::whereIn('id', $ids)->delete();

        return redirect()->route('admin.comment.index')
            ->with('success', count($ids) . ' نظر حذف شد');
    }
}
