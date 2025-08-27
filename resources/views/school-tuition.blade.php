@extends('layouts.app')

@section('title', 'Schoolwala - Fun Learning for Kids')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

@section('content')
<!-- HERO -->
<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Make learning playful — <span>for every curious kid</span></h1>
            <p>
                Short animated lessons, fun quizzes, and printable activity sheets.
                Designed for ages 6–14 with playful visuals and gentle pacing.
            </p>

            <div class="hero-actions">
                <a class="btn-primary" href="#">Book Demo Session</a>
                <a class="btn-secondary" href="#courses">Browse Courses</a>
            </div>

            <div class="hero-features">
                <div class="feature">
                    <div class="feature-icon">🎯</div>
                    <div>
                        <div class="feature-title">Class-wise roadmap</div>
                        <div>Clear path for each grade</div>
                    </div>
                </div>

                <div class="feature">
                    <div class="feature-icon">🧪</div>
                    <div>
                        <div class="feature-title">Hands-on activities</div>
                        <div>Downloadable worksheets</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-image">
            <div class="illustration-container">
                <div class="kid-illustration"></div>
                <div class="shape star"></div>
                <div class="shape pencil"></div>
            </div>
        </div>
    </div>
</section>

<!-- CLASS PILL NAV -->
<section class="class-pills">
    <div class="container">
        <div class="pill-container" id="classPills">
            <div class="class-pill active">Class 3</div>
            <div class="class-pill">Class 4</div>
            <div class="class-pill">Class 5</div>
            <div class="class-pill">Class 6</div>
            <div class="class-pill">Class 7</div>
            <div class="class-pill">Class 8</div>
            <div class="class-pill">Class 9</div>
        </div>
    </div>
</section>

<!-- CURRICULUM -->
<section class="curriculum">
    <div class="container">
        <div class="section-header">
            <h2>Personalise- Curriculum for Every Subject</h2>
            <p>
                Covers your child’s grade, board, and all key subjects—start to
                finish.
            </p>
        </div>
        <div class="curriculum-grid" id="curriculumCards">
            <div class="subject-box">
                <h3>English</h3>
                <ul>
                    <li>Grammar</li>
                    <li>Writing Skills</li>
                    <li>Comprehension</li>
                    <li>Vocabulary</li>
                    <li>Creative Writing</li>
                </ul>
            </div>
            <div class="subject-box">
                <h3>Maths</h3>
                <ul>
                    <li>Numbers</li>
                    <li>Addition & Subtraction</li>
                    <li>Fractions</li>
                    <li>Geometry</li>
                    <li>Algebra</li>
                </ul>
            </div>
            <div class="subject-box">
                <h3>Science</h3>
                <ul>
                    <li>Plants & Animals</li>
                    <li>Human Body</li>
                    <li>Environment</li>
                    <li>Experiments</li>
                    <li>Physics</li>
                </ul>
            </div>
            <div class="subject-box">
                <h3>Social Studies</h3>
                <ul>
                    <li>My Country</li>
                    <li>Maps & Globes</li>
                    <li>Community</li>
                    <li>Culture</li>
                    <li>History</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- COURSE ABOUT -->
<section class="course-about" id="courseAbout">
    <div class="container">
        <div class="section-header text-center">
            <h2>About Online Tuition For Class 3</h2>
            <p>
                Class 3 Online Tuition helps your child learn English, Math,
                Science, and Social Studies through live interactive classes and the
                support of two dedicated mentors.
            </p>
        </div>

        <div class="about-box">
            <p class="highlight-text">
                As a parent, you want to make sure your child gets the right
                attention in school subjects from an early stage. At CuriousJr, our
                online tuition for Class 3 gives your child the guidance they need
                in English, Maths, Science, and Social Studies.
            </p>

            <p class="highlight-text">
                As a parent, you want to make sure your child gets the right
                attention in school subjects from an early stage. At CuriousJr, our
                online tuition for Class 3 gives your child the guidance they need
                in English, Maths, Science, and Social Studies.
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

<!-- HOW IT WORKS -->
<section id="how" class="how-it-works">
    <div class="container">
        <div class="section-header">
            <h2>How our classes work</h2>
            <p>A short, engaging format — learn, play, and practice.</p>
        </div>

        <div class="steps">
            <div class="step">
                <div class="step-icon">📚</div>
                <h3>Choose a roadmap</h3>
                <p>Pick your class and subject. Start from fundamentals.</p>
            </div>
            <div class="step">
                <div class="step-icon">🎬</div>
                <h3>Watch classes</h3>
                <p>Animated 10–20 minute lessons with examples.</p>
            </div>
            <div class="step">
                <div class="step-icon">🧩</div>
                <h3>Practice & play</h3>
                <p>Interactive quizzes and printable activities.</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section id="faq" class="faq">
    <div class="container">
        <div class="section-header">
            <h2>Tuition Curriculum FAQ</h2>
            <p>Common questions from parents</p>
        </div>

        <div class="accordion" id="faqAcc">
            <div class="accordion-item">
                <button class="accordion-button">
                    How many students are there in one class?
                </button>
                <div class="accordion-content">
                    <p>
                        We keep small group sizes to encourage participation. Each class
                        has a maximum of 8 students to ensure personalized attention.
                    </p>
                </div>
            </div>
            <div class="accordion-item">
                <button class="accordion-button">What subjects are in demo?</button>
                <div class="accordion-content">
                    <p>
                        English, Maths and Science demo lessons are available. You can
                        try one subject or multiple during the demo session.
                    </p>
                </div>
            </div>
            <div class="accordion-item">
                <button class="accordion-button">How are doubts handled?</button>
                <div class="accordion-content">
                    <p>
                        Teachers pause for doubt time and answer live, plus chat
                        support. Each session includes dedicated Q&A time.
                    </p>
                </div>
            </div>
            <div class="accordion-item">
                <button class="accordion-button">What's the class schedule?</button>
                <div class="accordion-content">
                    <p>
                        Classes are scheduled after school hours and on weekends. You
                        can choose between multiple time slots based on your preference.
                    </p>
                </div>
            </div>
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