@extends('layouts.app')

@section('title', $subject->name . ' - ' . $class->name)
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('./css/my-class-content.css') }}" />

<link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

@section('content')

<style>
    .sticky-cta {
        display: none !important;
    }
</style>

<!-- CHAPTERS -->
<div class="container">
    <!-- BREADCRUMB -->
    <div class="breadcrumb">
        <a href="#"><i class="fas fa-home"></i> Home</a>
        <span>/</span>
        <a href="{{ route('student.my-class', $class->id) }}"><i class="{{ $subject->icon_txt }}"></i> Subjects</a>
        <span>/</span>
        <span class="current"><i class="fas fa-graduation-cap"></i> Chapters</span>
    </div>

    <!-- Subject Hero -->
    <div class="subject-hero">
        <svg
            class="math-pattern"
            viewBox="0 0 100 100"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M10,10 Q20,40 50,50 T90,10"
                stroke="white"
                stroke-width="2"
                fill="none" />
            <circle cx="30" cy="30" r="5" fill="white" />
            <circle cx="70" cy="70" r="5" fill="white" />
            <rect
                x="40"
                y="40"
                width="20"
                height="20"
                stroke="white"
                stroke-width="2"
                fill="none" />
        </svg>

        <div class="math-element" style="top: 20px; left: 30px">π</div>
        <div class="math-element" style="top: 80px; right: 40px">√</div>
        <div class="math-element" style="bottom: 30px; left: 50%">∞</div>

        <div class="subject-header">
            <div class="subject-icon">
                <i class="{{ $subject->icon_txt }}"></i>
            </div>
            <div class="subject-info">
                <h1>{{$subject->name}}</h1>
                <p>
                    Discover the magic of numbers, shapes, and patterns in our
                    exciting Class 6 curriculum. Where learning math feels like
                    playtime!
                </p>
            </div>
        </div>

        <div class="subject-stats">
            <div class="stat-item">
                <div class="stat-number">{{$subject->chapters->count()}}</div>
                <div class="stat-label">Chapters to Explore</div>
            </div>
            @php
            $totalVideos = $subject->chapters->sum(function($chapter) {
            return $chapter->videos->count();
            });
            @endphp

            <div class="stat-item">
                <div class="stat-number">{{ $totalVideos }}+</div>
                <div class="stat-label">Fun Video Lessons</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{$totalVideos}}+</div>
                <div class="stat-label">Interactive Activities</div>
            </div>
        </div>
    </div>

    <!-- Chapters Section -->
    <div class="chapters-section">
        <div class="section-header">
            <h2 class="section-title">Your Chapters</h2>
            <div class="class-selector">
                <i class="fas fa-chalkboard-teacher"></i>
                {{$class->name}}
            </div>
        </div>

        <div class="chapters-container">
            <ul class="chapter-list">
                @foreach($subject->chapters as $chapter)
                <!-- Chapter 1 -->
                <li class="chapter-item">
                    <div class="chapter-info">
                        <div class="chapter-number">{{$loop->iteration}}</div>
                        <div class="chapter-details">
                            <h3>{{$chapter->name}}</h3>
                            <p>
                                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Maiores, ex.
                            </p>
                        </div>
                    </div>
                    <div class="chapter-meta">
                        <div class="video-count">
                            <i class="fas fa-video"></i> {{$chapter->videos->count()}} videos
                        </div>
                        <!-- <div class="duration"><i class="fas fa-clock"></i> 45 min</div> -->

                        @php
                        $student = Auth::guard('student')->user();

                        // Find subscriber record for this student, class & fees
                        $subscriber = \App\Models\Subscribers::where('student_id', $student->id)
                        ->where('class_id', $class->id)
                        ->where('fees_id', $chapter->fees_id ?? null)
                        ->first();
                        @endphp

                        @if($student->type === 'waiver')
                        {{-- Case 1: Waiver student --}}
                        <a
                            href="{{ route('student.my-chapter-videos', [
            'classId' => $class->id,
            'subjectId' => $subject->id,
            'chapterId' => $chapter->id
        ]) }}"
                            class="play-btn"
                            style="text-decoration: none">
                            <i class="fas fa-play"></i>
                        </a>

                        @elseif($student->type === 'regular' && $subscriber && $subscriber->status === 'active')
                        {{-- Case 2: Regular student with active subscription --}}
                        <a
                            href="{{ route('student.my-chapter-videos', [
            'classId' => $class->id,
            'subjectId' => $subject->id,
            'chapterId' => $chapter->id
        ]) }}"
                            class="play-btn"
                            style="text-decoration: none">
                            <i class="fas fa-play"></i>
                        </a>

                        @elseif($student->type === 'regular' && (!$subscriber || $subscriber->status === 'inactive'))
                        {{-- Case 3 & 4: Regular student with no subscription or inactive subscription --}}
                        <a
                            href="{{ route('student.my-payment', [
            'classId' => $class->id,
            'subjectId' => $subject->id,
            'chapterId' => $chapter->id
        ]) }}"
                            class="play-btn"
                            style="text-decoration: none">
                            <i class="fas fa-play"></i>
                        </a>
                        @endif

                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection