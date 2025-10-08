@extends('layouts.app')

@section('title', 'Schoolwala - Fun Learning for Kids')

<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('./css/my-chapter-videos.css') }}" />

<link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

<style>
    .video-description {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.5em;
        max-height: 3em;
    }
</style>

@section('content')

<!-- VIDEOS -->
<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="#"><i class="fas fa-home"></i> Home</a>
        <span>/</span>
        <a href="{{ route('student.my-class', $class->id) }}"><i class="{{ $subject->icon_txt }}"></i> Subjects</a>
        <span>/</span>
        <a href="{{ route('student.my-class-content', [$class->id, $subject->id]) }}"><i class="fas fa-list-ol"></i> Chapters</a>
        <span>/</span>
        <span class="current"><i class="fas fa-play-circle"></i> Videos</span>
    </div>

    <!-- Chapter Hero -->
    <div class="chapter-hero">
        <svg
            class="math-elements"
            viewBox="0 0 100 100"
            xmlns="http://www.w3.org/2000/svg">
            <circle cx="30" cy="30" r="10" fill="white" opacity="0.2" />
            <rect
                x="60"
                y="20"
                width="20"
                height="20"
                fill="white"
                opacity="0.2" />
            <polygon points="40,70 60,70 50,50" fill="white" opacity="0.2" />
        </svg>

        <div class="chapter-header">
            <h1>{{ $chapter->name }}</h1>
            <p>
                Embark on a numerical adventure! Learn how to handle big numbers,
                compare them, and use them in real-life situations. This chapter
                will make you a number ninja!
            </p>

            <div class="chapter-stats">
                <div class="chapter-stat">
                    <div class="stat-number">{{ $chapter->videos->count() }}</div>
                    <div class="stat-label">Fun Video Lessons</div>
                </div>
                <div class="chapter-stat">
                    <div class="stat-number">{{ $chapter->videos->count() }}</div>
                    <div class="stat-label">Practice Activities</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Videos Section -->
    <div class="videos-section">
        <h2 class="section-title">Video Lessons</h2>

        <div class="video-grid">
            @foreach ($chapter->videos as $video)
            <!-- Video 1 -->
            <div class="video-card">
                <div
                    class="video-thumbnail"
                    style="
                background: url({{ asset('storage/' . $video->video_thumbnail) }});
                background-size: cover;
                background-position: center;
              ">
                    <a
                        href="{{ route('student.my-video-play', [$class->id, $subject->id, $chapter->id, $video->id]) }}"
                        class="play-btn"
                        style="text-decoration: none">
                        <i class="fas fa-play"></i>
                    </a>
                    <div class="video-duration">5:24</div>
                </div>
                <div class="video-content">
                    <h3 class="video-title">{{ $video->video_title }}</h3>
                    <p class="video-description">
                        {{ $video->video_description }}
                    </p>
                    <div class="video-actions">
                        <a href="#" class="action-btn btn-notes">
                            <i class="fas fa-download"></i> Notes
                        </a>
                        <a
                            href="{{ route('student.my-video-practice-test', [$class->id, $subject->id, $chapter->id, $video->id]) }}"
                            class="action-btn btn-practice">
                            <i class="fas fa-pencil-alt"></i> Practice
                        </a>
                        <a href="#" class="action-btn btn-completed">
                            <i class="fas fa-check-circle"></i> Mark as Completed
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Progress Section -->
    <div class="progress-section">
        <div class="progress-container">
            <div class="progress-header">
                <div class="progress-title">Your Chapter Progress</div>
                <div class="progress-percent">45%</div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
            <div class="progress-stats">
                <div>3 of 8 videos completed</div>
                <div>2 of 5 activities done</div>
            </div>
        </div>
    </div>
</div>




<script>
    // Mark as completed functionality
    const completeButtons = document.querySelectorAll(".btn-completed");

    completeButtons.forEach((button) => {
        button.addEventListener("click", function(e) {
            e.preventDefault();
            const videoCard = this.closest(".video-card");
            const videoTitle =
                videoCard.querySelector(".video-title").textContent;

            // Toggle completed state
            if (this.innerHTML.includes("Mark as Completed")) {
                this.innerHTML = '<i class="fas fa-check-circle"></i> Completed!';
                this.style.background = "rgba(126, 246, 181, 0.3)";
                this.style.color = "#22c55e";
                videoCard.style.borderLeft = "4px solid #22c55e";
            } else {
                this.innerHTML =
                    '<i class="fas fa-check-circle"></i> Mark as Completed';
                this.style.background = "rgba(255, 138, 0, 0.1)";
                this.style.color = "var(--accent)";
                videoCard.style.borderLeft = "none";
            }

            // Update progress bar
            updateProgress();
        });
    });

    // Update progress bar based on completed videos
    function updateProgress() {
        const completedVideos = document.querySelectorAll(
            '.btn-completed:not([style*="background: rgba(255, 138, 0, 0.1)"])'
        ).length;
        const totalVideos = document.querySelectorAll(".btn-completed").length;
        const percentage = Math.round((completedVideos / totalVideos) * 100);

        document.querySelector(
            ".progress-percent"
        ).textContent = `${percentage}%`;
        document.querySelector(".progress-fill").style.width = `${percentage}%`;
        document.querySelector(".progress-stats").innerHTML = `
        <div>${completedVideos} of ${totalVideos} videos completed</div>
        <div>${Math.round(completedVideos / 2)} of ${Math.round(
          totalVideos / 2
        )} activities done</div>
      `;
    }

    // Animate progress bar on page load
    document.addEventListener("DOMContentLoaded", () => {
        const progressFill = document.querySelector(".progress-fill");
        setTimeout(() => {
            progressFill.style.width = "45%";
        }, 500);
    });
</script>

@endsection