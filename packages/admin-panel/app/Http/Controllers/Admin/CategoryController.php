<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with('parent', 'children');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_fa', 'like', "%{$search}%")
                  ->orWhere('name_en', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sortField = $request->get('sort', 'order');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $categories = $query->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = Category::root()->active()->orderBy('order')->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_fa' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'nullable|integer',
            'icon' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name_fa']);
        }

        $category = Category::create($validated);

        return redirect()
            ->route('admin.cat.index')
            ->with('success', 'دسته‌بندی با موفقیت ایجاد شد');
    }

    public function show(Category $category)
    {
        $category->load('parent', 'children', 'courses');
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::root()
            ->where('id', '!=', $category->id)
            ->active()
            ->orderBy('order')
            ->get();
            
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name_fa' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'nullable|integer',
            'icon' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if (isset($validated['parent_id']) && $validated['parent_id'] == $category->id) {
            return back()->withErrors(['parent_id' => 'دسته‌بندی نمی‌تواند والد خودش باشد']);
        }

        $category->update($validated);

        return redirect()
            ->route('admin.cat.index')
            ->with('success', 'دسته‌بندی با موفقیت به‌روزرسانی شد');
    }

    public function destroy(Category $category)
    {
        if ($category->courses()->count() > 0) {
            return back()->withErrors(['error' => 'این دسته‌بندی دارای دوره است و نمی‌توان آن را حذف کرد']);
        }

        if ($category->children()->count() > 0) {
            $category->children()->update(['parent_id' => $category->parent_id]);
        }

        $category->delete();

        return redirect()
            ->route('admin.cat.index')
            ->with('success', 'دسته‌بندی با موفقیت حذف شد');
    }

    public function getCategories(Request $request)
    {
        $query = Category::active();

        if ($request->filled('parent_id')) {
            $query->where('parent_id', $request->parent_id);
        } else {
            $query->root();
        }

        $categories = $query->orderBy('order')->get(['id', 'name_fa', 'name_en']);

        return response()->json($categories);
    }
}
