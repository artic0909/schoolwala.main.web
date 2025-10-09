@extends('layouts.app')

@section('title', 'Schoolwala - Fun Learning for Kids')

<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('./css/my-video-play.css') }}" />

<link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

<style>
    .sticky-cta {
        display: none !important;
    }

    .hide-scrollbar {
        overflow-y: auto;
        max-height: 700px;
        padding: 30px;

        /* Hide scrollbar for WebKit browsers */
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }

    .hide-scrollbar::-webkit-scrollbar {
        display: none;
        /* Chrome, Safari, Opera */
    }
</style>

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
                <div class="meta-item"><i class="fas fa-heart"></i> {{ $video->likes }} likes</div>
                <div class="meta-item"><i class="fas fa-eye"></i> {{ $video->views }} views</div>
                <div class="meta-item"><i class="fas fa-clock"></i> {{ $video->duration }} min</div>
                <div class="meta-item">
                    <i class="fas fa-calendar"></i> Published: {{ $video->created_at->format('M d, Y') }}
                </div>
            </div>

            <form action="{{ route('student.my-video-play.like.submit') }}" method="POST" class="video-actions">
                @csrf

                <!-- Hidden Fields -->
                <input type="hidden" name="video_id" value="{{ $video->id }}" hidden class="form-control">

                <button type="submit" class="action-btn" id="likeButton">
                    <i class="fas fa-thumbs-up"></i> Like this video
                </button>
                <button class="action-btn">
                    <i class="fas fa-share-alt"></i> Share
                </button>
                <a href="{{ $video->note_link }}" target="_blank" style="text-decoration: none; display: flex; align-items: center;" class="action-btn">
                    <i class="fas fa-download"></i> Download Notes
                </a>
            </form>
        </div>
    </div>

    <!-- Feedback Section -->
    <div class="feedback-section">
        <h2 class="section-title">Your Feedback</h2>
        <div class="feedback-form">
            <form id="feedbackForm" action="{{ route('student.my-video-play.submit') }}" method="POST">
                @csrf

                <!-- Hidden Fields -->
                <input type="hidden" name="video_id" value="{{ $video->id }}">
                <input type="hidden" name="student_id" value="{{ auth()->guard('student')->user()->id }}" hidden class="form-control">

                <div class="form-group">
                    <label class="form-label">How much did you enjoy this video?</label>
                    <div class="rating">
                        <input type="radio" id="star5" name="rating" value="5" />
                        <label for="star5"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star4" name="rating" value="5" />
                        <label for="star4"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star3" name="rating" value="5" />
                        <label for="star3"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star2" name="rating" value="4" />
                        <label for="star2"><i class="fas fa-star"></i></label>
                        <input type="radio" id="star1" name="rating" value="4" />
                        <label for="star1"><i class="fas fa-star"></i></label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="feedback" class="form-label">What did you think of this video?</label>
                    <textarea
                        id="feedback"
                        name="feedback"
                        class="form-control"
                        placeholder="Your thoughts, questions, or suggestions..."></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-submit">Submit Feedback</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Recent Feedback Section -->
    <div class="feedback-section" style="background: linear-gradient(145deg, #fef6ff, #fdf3e7); border-radius: 25px; padding: 25px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); font-family: 'Baloo 2', cursive;">
        <h2 class="section-title" style="text-align: center; font-size: 26px; color: #ff80aa; margin-bottom: 25px; text-shadow: 1px 1px 2px rgba(255, 182, 193, 0.6);">
            Recent Feedbacks 💬
        </h2>
        <div class="hide-scrollbar" style="overflow-y: auto; max-height: 700px; padding: 30px;">
            <div class="feedback-list" style="display: flex; flex-direction: column; gap: 15px;">
                @forelse ($feedbacks as $feedback)
                <div class="feedback-item" style="background: #fff; border-radius: 20px; padding: 15px 20px; box-shadow: 0 4px 12px rgba(255, 170, 200, 0.2); transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer;">
                    <div class="feedback-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <div class="feedback-user" style="font-size: 18px; color: #5a4fcf; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-user" style="background: #e4dbff; color: #5a4fcf; border-radius: 50%; padding: 6px;"></i>
                            <span>{{ $feedback->student->student_name }}</span>
                        </div>
                        <div class="feedback-date" style="font-size: 14px; color: #888;">
                            {{ $feedback->created_at->format('M d, Y') }}
                        </div>
                    </div>

                    <div class="feedback-rating" style="margin: 6px 0;">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $feedback->rating ? 'filled' : '' }}"
                            style="color: {{ $i <= $feedback->rating ? '#ffd93b' : '#ccc' }}; font-size: 18px; {{ $i <= $feedback->rating ? 'text-shadow: 0 0 3px #ffb347;' : '' }}"></i>
                            @endfor
                    </div>

                    <div class="feedback-content" style="font-size: 16px; color: #444; background: #fff9f9; padding: 10px 14px; border-radius: 15px; border: 2px dashed #ffe0ec;">
                        {{ $feedback->feedback }}
                    </div>
                </div>
                @empty
                <p class="no-feedback" style="text-align: center; color: #777; font-size: 16px; margin-top: 10px;">
                    No feedback yet 🐥 Be the first to share your thoughts!
                </p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Hover effect using inline JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const items = document.querySelectorAll('.feedback-item');
            items.forEach(item => {
                item.addEventListener('mouseenter', () => {
                    item.style.transform = 'scale(1.02)';
                    item.style.boxShadow = '0 6px 16px rgba(255, 160, 180, 0.3)';
                });
                item.addEventListener('mouseleave', () => {
                    item.style.transform = 'scale(1)';
                    item.style.boxShadow = '0 4px 12px rgba(255, 170, 200, 0.2)';
                });
            });
        });
    </script>

</div>



@endsection