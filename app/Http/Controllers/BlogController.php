<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Show homepage with blogs.
     */
    public function index()
    {
        $blogs = Blog::with('category')->latest()->paginate(9);
        $categories = Category::all();

        return view('frontend.home', [
            'blogs' => $blogs,
            'categories' => $categories,
        ]);
    }

    /**
     * Show single blog detail.
     */
    public function show($id)
    {
        $blog = Blog::with('category')->findOrFail($id);
        $relatedBlogs = Blog::where('category_id', $blog->category_id)
            ->where('id', '!=', $id)
            ->with('category')
            ->take(3)
            ->get();

        return view('frontend.blog-detail', [
            'blog' => $blog,
            'relatedBlogs' => $relatedBlogs,
        ]);
    }

    /**
     * Filter blogs with AJAX.
     */
    public function filter(Request $request)
    {
        $query = Blog::with('category');

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('short_description', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // Date filter
        if ($request->has('date_filter') && !empty($request->date_filter)) {
            $days = intval($request->date_filter);
            if ($days > 0) {
                $query->whereDate('created_at', '>=', now()->subDays($days));
            }
        }

        $blogs = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => view('frontend.partials.blog-cards', ['blogs' => $blogs])->render(),
            'count' => $blogs->count(),
        ]);
    }
}
