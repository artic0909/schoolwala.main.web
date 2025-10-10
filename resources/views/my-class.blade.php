@extends('layouts.app')

@section('title', 'Schoolwala - My Class')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('./css/my-class.css') }}" />

<link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

<style>
    .sticky-cta {
        display: none !important;
    }
</style>


@section('content')
<!-- BREADCRUMB -->
<div class="container">
    <div class="breadcrumb">
        <a href="#"><i class="fas fa-home"></i> Home</a>
        <span>/</span>
        <a href="#"><i class="fas fa-book-open"></i> Learning</a>
        <span>/</span>
        <span><i class="fas fa-graduation-cap"></i> MY Class</span>
    </div>
</div>

<!-- Hero Section -->
<div class="container">
    <div class="curriculum-hero">
        <h1>Designed for <span>Every Student</span></h1>
        <p>
            Comprehensive curriculum aligned with WBBSE, CBSE, ICSE, and State
            Boards. Engaging content designed to make learning fun and effective
            for students from Class 5 to Class 10.
        </p>
    </div>
</div>

<!-- Class Navigation -->
<div class="container">
    <div class="class-navigation">
        <div class="class-tabs">
            <div class="class-tab active">{{ $class->name }}</div>
        </div>
    </div>
</div>

<!-- Subject Cards -->
<div class="container">
    <div class="subjects-section">
        <h2 class="section-title">Subjects We Cover</h2>
        <div class="subject-cards">
            <!-- Subjects Cards -->
            @foreach($class->subjects as $subject)
            <div class="subject-card">
                <div class="subject-icon {{ $subject->bg_color_txt }}">
                    <i class="{{ $subject->icon_txt }}"></i>
                </div>
                <div class="subject-content">
                    <h3 class="subject-title">{{ $subject->name }}</h3>
                    <p class="subject-description">
                        Build strong foundation in concepts with interactive problems
                        and visual learning.
                    </p>
                    <div class="subject-topics">
                        <h4>Key Topics:</h4>
                        <div class="topics-list">
                            @foreach($subject->chapters as $chapter)
                            <span class="topic-pill">{{ $chapter->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <a
                        href="{{ route('student.my-class-content', ['classId' => $class->id, 'subjectId' => $subject->id]) }}"
                        class="btn-view"
                        style="margin-top: 20px">Let's Learn</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- COURSE ABOUT -->
<section class="course-about" id="courseAbout">
    <div class="container">
        <div class="section-header text-center">
            <h2>About Online Tuition For {{ $class->name }}</h2>
            <p>
                {{ $class->name }} Online Tuition helps your child learn English, Math,
                Science, and Social Studies through live interactive classes and the
                support of two dedicated mentors.
            </p>
        </div>

        <div class="about-box">
            <p class="highlight-text">
                {{$class->description}}
            </p>

            <div class="extra-content" style="display: none">
                <p>
                    Through daily lessons, doubt clearing, and academic assistance, we
                    help students stay on track with their goals. Whether it’s
                    completing homework, preparing for exams, or understanding new
                    topics, CuriousJr ensures your child has help available at the
                    right time.
                </p>
            </div>

            <div class="read-more text-center">
                <a href="#" class="read-more-btn">Read More <span>&#9660;</span></a>
            </div>
        </div>
    </div>
</section>

<!-- Curriculum Details -->
<div class="container">
    <div class="curriculum-details">
        <div class="detail-header">
            <h2>How Our Curriculum Works</h2>
            <p>
                Our structured approach ensures students build strong foundations
                and develop critical thinking skills
            </p>
        </div>
        <div class="detail-grid">
            <div class="detail-card">
                <div class="detail-icon">
                    <span>📚</span>
                </div>
                <h3 class="detail-title">Structured Learning Path</h3>
                <p class="detail-content">
                    Our curriculum is divided into levels and modules that
                    progressively build concepts from basic to advanced.
                </p>
            </div>

            <div class="detail-card">
                <div class="detail-icon">
                    <span>🎬</span>
                </div>
                <h3 class="detail-title">Animated Video Lessons</h3>
                <p class="detail-content">
                    Complex concepts broken down into bite-sized, engaging animated
                    videos for better understanding.
                </p>
            </div>

            <div class="detail-card">
                <div class="detail-icon">
                    <span>🧩</span>
                </div>
                <h3 class="detail-title">Practice & Assessments</h3>
                <p class="detail-content">
                    Regular practice problems and assessments to reinforce learning
                    and track progress.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Key Features -->
<div class="container">
    <div class="key-features">
        <h2 class="section-title">Why Choose Schoolwala?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="feature-title">Expert Educators</h3>
                <p class="feature-description">
                    Content created by subject matter experts with teaching
                    experience.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3 class="feature-title">Learn Anywhere</h3>
                <p class="feature-description">
                    Access courses on mobile, tablet, or desktop at your convenience.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-gamepad"></i>
                </div>
                <h3 class="feature-title">Gamified Learning</h3>
                <p class="feature-description">
                    Interactive games and quizzes to make learning fun and engaging.
                </p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Progress Tracking</h3>
                <p class="feature-description">
                    Detailed reports to track your child's progress and performance.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- FAQ -->
<section id="faq" class="faq">
    <div class="container">
        <div class="section-header">
            <h2>School Curriculum FAQ</h2>
            <p>Common questions from parents</p>
        </div>

        <div class="accordion" id="faqAcc">
            @foreach($faqs as $faq)
            <div class="accordion-item">
                <button class="accordion-button">
                    {{$faq->question}}
                </button>
                <div class="accordion-content">
                    <p>
                        {{$faq->answer}}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const readMoreBtn = document.querySelector(".read-more-btn");
        const extraContent = document.querySelector(".extra-content");
        let isExpanded = false;

        readMoreBtn.addEventListener("click", function(e) {
            e.preventDefault();
            isExpanded = !isExpanded;
            extraContent.style.display = isExpanded ? "block" : "none";
            readMoreBtn.innerHTML = isExpanded ?
                'Read Less <span style="transform: rotate(180deg);">&#9660;</span>' :
                "Read More <span>&#9660;</span>";
        });
    });
</script>


@endsection