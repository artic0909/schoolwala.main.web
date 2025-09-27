@extends('layouts.app')

@section('title', 'Schoolwala - Fun Learning for Kids')

<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('./css/my-video-play.css') }}" />

<link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

@section('content')
<!-- VIDEO PLAY -->
<div class="container">
    <!-- Video Player -->
    <div class="video-player-container">
        <div class="video-wrapper">
            <div class="video-player">
                <iframe
                    src="{{ $video->video_link }}"
                    title="YouTube video player"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
            </div>
        </div>

        <div class="video-info">
            <h1 class="video-title">{{ $video->video_title }}</h1>

            <div class="video-meta">
                <div class="meta-item"><i class="fas fa-eye"></i> 1,245 views</div>
                <div class="meta-item"><i class="fas fa-clock"></i> 5:24 min</div>
                <div class="meta-item">
                    <i class="fas fa-calendar"></i> Published: {{ $video->created_at->format('M d, Y') }}
                </div>
            </div>

            <div class="video-actions">
                <button class="action-btn" id="likeButton">
                    <i class="fas fa-thumbs-up"></i> Like this video
                </button>
                <button class="action-btn">
                    <i class="fas fa-share-alt"></i> Share
                </button>
                <button class="action-btn">
                    <i class="fas fa-download"></i> Download Notes
                </button>
            </div>
        </div>
    </div>

    <!-- Feedback Section -->
    <div class="feedback-section">
        <h2 class="section-title">Your Feedback</h2>
        <div class="feedback-form">
            <form id="feedbackForm">
                <div class="form-group">
                    <label class="form-label">How much did you enjoy this video?</label>
                    <div class="rating">
                        <input type="radio" id="star5" name="rating" value="5" />
                        <label for="star5"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star4" name="rating" value="4" />
                        <label for="star4"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star3" name="rating" value="3" />
                        <label for="star3"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star2" name="rating" value="2" />
                        <label for="star2"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star1" name="rating" value="1" />
                        <label for="star1"><i class="fas fa-star"></i></label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="feedback" class="form-label">What did you think of this video?</label>
                    <textarea
                        id="feedback"
                        class="form-control"
                        placeholder="Your thoughts, questions, or suggestions..."></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-submit">Submit Feedback</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection