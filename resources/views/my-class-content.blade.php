@extends('layouts.app')

@section('title', 'Schoolwala - Fun Learning for Kids')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('./css/my-class-content.css') }}" />

<link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

@section('content')

<!-- CHAPTERS -->
<div class="container">
    <!-- BREADCRUMB -->
    <div class="breadcrumb">
        <a href="#"><i class="fas fa-home"></i> Home</a>
        <span>/</span>
        <a href="#"><i class="fas fa-book-open"></i> Learning</a>
        <span>/</span>
        <a href="#"><i class="fas fa-calculator"></i> Mathematics</a>
        <span>/</span>
        <span class="current"><i class="fas fa-graduation-cap"></i> Class 8 Curriculum</span>
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
                <i class="fas fa-calculator"></i>
            </div>
            <div class="subject-info">
                <h1>Fun with Mathematics!</h1>
                <p>
                    Discover the magic of numbers, shapes, and patterns in our
                    exciting Class 6 curriculum. Where learning math feels like
                    playtime!
                </p>
            </div>
        </div>

        <div class="subject-stats">
            <div class="stat-item">
                <div class="stat-number">12</div>
                <div class="stat-label">Chapters to Explore</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">85+</div>
                <div class="stat-label">Fun Video Lessons</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">200+</div>
                <div class="stat-label">Interactive Activities</div>
            </div>
        </div>
    </div>

    <!-- Chapters Section -->
    <div class="chapters-section">
        <div class="section-header">
            <h2 class="section-title">Adventure Through Math Chapters</h2>
            <div class="class-selector">
                <i class="fas fa-chalkboard-teacher"></i>
                Class 8 Mathematics
            </div>
        </div>

        <div class="chapters-container">
            <ul class="chapter-list">
                <!-- Chapter 1 -->
                <li class="chapter-item">
                    <div class="chapter-info">
                        <div class="chapter-number">1</div>
                        <div class="chapter-details">
                            <h3>Knowing Our Numbers</h3>
                            <p>
                                Journey through the world of big numbers and their
                                operations
                            </p>
                        </div>
                    </div>
                    <div class="chapter-meta">
                        <div class="video-count">
                            <i class="fas fa-video"></i> 6 videos
                        </div>
                        <div class="duration"><i class="fas fa-clock"></i> 45 min</div>
                        <a
                            href="/my-chapter-videos"
                            class="play-btn"
                            style="text-decoration: none">
                            <i class="fas fa-play"></i>
                        </a>
                    </div>
                </li>

                <!-- Chapter 2 -->
                <li class="chapter-item">
                    <div class="chapter-info">
                        <div class="chapter-number">2</div>
                        <div class="chapter-details">
                            <h3>Whole Numbers</h3>
                            <p>Explore the fascinating properties of whole numbers</p>
                        </div>
                    </div>
                    <div class="chapter-meta">
                        <div class="video-count">
                            <i class="fas fa-video"></i> 7 videos
                        </div>
                        <div class="duration"><i class="fas fa-clock"></i> 40 min</div>
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                </li>

                <!-- Chapter 3 -->
                <li class="chapter-item">
                    <div class="chapter-info">
                        <div class="chapter-number">3</div>
                        <div class="chapter-details">
                            <h3>Playing With Numbers</h3>
                            <p>Discover patterns, factors, and multiples through games</p>
                        </div>
                    </div>
                    <div class="chapter-meta">
                        <div class="video-count">
                            <i class="fas fa-video"></i> 9 videos
                        </div>
                        <div class="duration"><i class="fas fa-clock"></i> 55 min</div>
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                </li>

                <!-- Chapter 4 -->
                <li class="chapter-item">
                    <div class="chapter-info">
                        <div class="chapter-number">4</div>
                        <div class="chapter-details">
                            <h3>Basic Geometrical Ideas</h3>
                            <p>Lines, angles, and shapes come to life!</p>
                        </div>
                    </div>
                    <div class="chapter-meta">
                        <div class="video-count">
                            <i class="fas fa-video"></i> 6 videos
                        </div>
                        <div class="duration"><i class="fas fa-clock"></i> 35 min</div>
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                </li>

                <!-- Chapter 5 -->
                <li class="chapter-item">
                    <div class="chapter-info">
                        <div class="chapter-number">5</div>
                        <div class="chapter-details">
                            <h3>Understanding Elementary Shapes</h3>
                            <p>Triangles, circles, and polygons - oh my!</p>
                        </div>
                    </div>
                    <div class="chapter-meta">
                        <div class="video-count">
                            <i class="fas fa-video"></i> 8 videos
                        </div>
                        <div class="duration"><i class="fas fa-clock"></i> 50 min</div>
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                </li>

                <!-- Chapter 6 -->
                <li class="chapter-item">
                    <div class="chapter-info">
                        <div class="chapter-number">6</div>
                        <div class="chapter-details">
                            <h3>Integers</h3>
                            <p>Explore the world of positive and negative numbers</p>
                        </div>
                    </div>
                    <div class="chapter-meta">
                        <div class="video-count">
                            <i class="fas fa-video"></i> 7 videos
                        </div>
                        <div class="duration"><i class="fas fa-clock"></i> 42 min</div>
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                </li>

                <!-- Chapter 7 -->
                <li class="chapter-item">
                    <div class="chapter-info">
                        <div class="chapter-number">7</div>
                        <div class="chapter-details">
                            <h3>Fractions</h3>
                            <p>Slice and dice numbers with fractional fun</p>
                        </div>
                    </div>
                    <div class="chapter-meta">
                        <div class="video-count">
                            <i class="fas fa-video"></i> 10 videos
                        </div>
                        <div class="duration"><i class="fas fa-clock"></i> 60 min</div>
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                </li>

                <!-- Chapter 8 -->
                <li class="chapter-item">
                    <div class="chapter-info">
                        <div class="chapter-number">8</div>
                        <div class="chapter-details">
                            <h3>Decimals</h3>
                            <p>Dot your way through decimal numbers</p>
                        </div>
                    </div>
                    <div class="chapter-meta">
                        <div class="video-count">
                            <i class="fas fa-video"></i> 8 videos
                        </div>
                        <div class="duration"><i class="fas fa-clock"></i> 48 min</div>
                        <div class="play-btn">
                            <i class="fas fa-play"></i>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection