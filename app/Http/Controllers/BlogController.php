<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category', 'tags'])
            ->where('is_published', true);

        // Case-insensitive search
        if ($request->has('search') && $request->search != '') {
            $search = strtolower($request->search);
            // using LOWER and LIKE to assure case-insensitivity on standard DBs
            $query->whereRaw('LOWER(title) LIKE ?', ['%' . $search . '%']);
        }

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('blog.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::with(['user', 'category', 'tags', 'comments.user'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('blog.show', compact('post'));
    }
}
