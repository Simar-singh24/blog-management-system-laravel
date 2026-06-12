<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show admin dashboard.
     */
    public function dashboard()
    {
        $totalBlogs = Blog::count();
        $totalCategories = Category::count();
        $recentBlogs = Blog::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', [
            'totalBlogs' => $totalBlogs,
            'totalCategories' => $totalCategories,
            'recentBlogs' => $recentBlogs,
        ]);
    }

    /**
     * Show all blogs.
     */
    public function blogs()
    {
        $blogs = Blog::with('category')->paginate(10);
        return view('admin.blogs.index', ['blogs' => $blogs]);
    }

    /**
     * Show create blog form.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.blogs.create', ['categories' => $categories]);
    }

    /**
     * Store blog.
     * Images are stored in public/images instead of storage/app/public
     * for reliable serving on Render's ephemeral filesystem.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->hashName();
            $request->file('image')->storeAs('images', $imageName, 'public');
            $validated['image'] = $imageName;
        }

        Blog::create($validated);

        return redirect()->route('admin.blogs')->with('success', 'Blog created successfully!');
    }

    /**
     * Show edit blog form.
     */
    public function edit(Blog $blog)
    {
        $categories = Category::all();
        return view('admin.blogs.edit', [
            'blog' => $blog,
            'categories' => $categories,
        ]);
    }

    /**
     * Update blog.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($blog->image) {
                $oldImagePath = str_starts_with($blog->image, 'images/') ? $blog->image : 'images/' . $blog->image;
                \Storage::disk('public')->delete($oldImagePath);
            }
            $imageName = $request->file('image')->hashName();
            $request->file('image')->storeAs('images', $imageName, 'public');
            $validated['image'] = $imageName;
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs')->with('success', 'Blog updated successfully!');
    }

    /**
     * Delete blog.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            $oldImagePath = str_starts_with($blog->image, 'images/') ? $blog->image : 'images/' . $blog->image;
            \Storage::disk('public')->delete($oldImagePath);
        }
        $blog->delete();

        return redirect()->route('admin.blogs')->with('success', 'Blog deleted successfully!');
    }
}
