@extends('layouts.app')

@section('title', 'Blogs | Schoolwala')
@section('meta_description', 'Read our latest articles, news, and insights on education and fun learning for kids at Schoolwala.')
@push('scripts')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/blogs.css') }}" />
@endpush

@section('content')
<div class="container">
    <div class="blogs-hero">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a>
            <span>/</span>
            <span class="current"><i class="fas fa-book"></i> Blogs</span>
        </div>

        <h1>Our Latest <span>Blogs</span></h1>
        <p>Read our latest articles, news, and insights</p>
    </div>

    <div class="blogs-grid">
        @forelse($blogs as $blog)
        <div class="blog-card">
            <img src="{{ asset('storage/' . $blog->image) }}" class="blog-img" alt="{{ $blog->title }}">
            <div class="blog-content">
                <h3 class="blog-title">{{ Str::limit($blog->title, 50) }}</h3>
                <p class="blog-desc">{{ Str::limit($blog->short_description, 100) }}</p>
                <div class="blog-footer">
                    <div class="blog-date">
                        <i class="far fa-calendar-alt"></i> {{ $blog->created_at->format('M d, Y') }}
                    </div>
                    <a href="{{ route('student.blog.show', $blog->slug) }}" class="btn-outline">Read More</a>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px 0;">
            <p>No blogs found at the moment. Please check back later!</p>
        </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $blogs->links('pagination::bootstrap-4') }} 
    </div>
</div>
@endsection
