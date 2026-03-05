<?php

namespace App\Http\Controllers;

use App\Models\Post;

class SitemapController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', true)->latest()->get();
        return response()->view('sitemap', compact('posts'))
            ->header('Content-Type', 'text/xml');
    }
}
