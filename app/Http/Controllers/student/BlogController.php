<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = \App\Models\Blog::where('status', 1)->orderBy('created_at', 'desc')->paginate(12);
        return view('blogs', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = \App\Models\Blog::where('slug', $slug)->where('status', 1)->firstOrFail();
        $relatedBlogs = \App\Models\Blog::where('status', 1)->where('id', '!=', $blog->id)->orderBy('created_at', 'desc')->take(4)->get();
        return view('blog-details', compact('blog', 'relatedBlogs'));
    }
}
