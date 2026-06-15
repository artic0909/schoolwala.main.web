@extends('layouts.app')

@section('title', $blog->meta_title ?? $blog->title . ' | Schoolwala')
@section('meta_description', $blog->meta_description ?? $blog->short_description)

@push('scripts')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/blogs.css') }}" />
@endpush

@section('content')
<div class="container blog-details-section">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a>
        <span>/</span>
        <a href="{{ route('student.blogs') }}">Blogs</a>
        <span>/</span>
        <span class="current">{{ Str::limit($blog->title, 30) }}</span>
    </div>

    <div class="blog-details-layout">
        <!-- Main Blog Content -->
        <div class="blog-main">
            <img src="{{ asset('storage/' . $blog->image) }}" class="blog-main-img" alt="{{ $blog->title }}">
            
            <h1 class="blog-main-title">{{ $blog->title }}</h1>
            
            <div class="blog-meta">
                <span><i class="far fa-calendar-alt"></i> {{ $blog->created_at->format('F d, Y') }}</span>
                <span><i class="far fa-clock"></i> {{ $blog->created_at->diffForHumans() }}</span>
            </div>
            
            <div class="blog-body">
                {!! $blog->content !!}
            </div>

            <!-- Share Section -->
            <div class="blog-share">
                <h3>Share this article:</h3>
                <div class="share-buttons">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="share-btn share-fb"><i class="fab fa-facebook-f"></i> Facebook</a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($blog->title) }}" target="_blank" class="share-btn share-tw"><i class="fab fa-twitter"></i> Twitter</a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' ' . request()->fullUrl()) }}" target="_blank" class="share-btn share-wa"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                </div>
            </div>
        </div>

        <!-- Sidebar / Related Blogs -->
        <div class="blog-sidebar">
            <div class="sidebar-widget">
                <h4 class="widget-title">Related Blogs</h4>
                
                @forelse($relatedBlogs as $related)
                <div class="related-item">
                    <img src="{{ asset('storage/' . $related->image) }}" class="related-img" alt="{{ $related->title }}">
                    <div class="related-info">
                        <a href="{{ route('student.blog.show', $related->slug) }}" class="related-title">
                            {{ Str::limit($related->title, 45) }}
                        </a>
                        <div class="related-date"><i class="far fa-calendar-alt"></i> {{ $related->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
                @empty
                <p>No related blogs found.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
