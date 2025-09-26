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

<!-- COURSES GRID -->
<section id="courses" class="courses">
    <div class="container">
        <div class="section-header">
            <h2>Popular Courses</h2>
            <p>Choose from our engaging curriculum designed for young minds</p>
        </div>
        <div class="courses-grid" id="coursesGrid">
            <div class="course-card">
                <div class="course-header">
                    <div class="course-icon">📘</div>
                    <div>
                        <h3 class="course-title">Maths — Foundations</h3>
                        <div class="course-meta">10 videos · Ages 8-10</div>
                    </div>
                </div>
                <div class="course-footer" style="width: 100%">
                    <!-- <div class="course-price">₹249</div> -->
                    <a
                        class="btn-secondary"
                        href="#"
                        style="width: 100%; text-align: center">Read More</a>
                </div>
            </div>

            <div class="course-card">
                <div class="course-header">
                    <div class="course-icon">📘</div>
                    <div>
                        <h3 class="course-title">Maths — Foundations</h3>
                        <div class="course-meta">10 videos · Ages 8-10</div>
                    </div>
                </div>
                <div class="course-footer" style="width: 100%">
                    <!-- <div class="course-price">₹249</div> -->
                    <a
                        class="btn-secondary"
                        href="#"
                        style="width: 100%; text-align: center">Read More</a>
                </div>
            </div>

            <div class="course-card">
                <div class="course-header">
                    <div class="course-icon">📘</div>
                    <div>
                        <h3 class="course-title">Maths — Foundations</h3>
                        <div class="course-meta">10 videos · Ages 8-10</div>
                    </div>
                </div>
                <div class="course-footer" style="width: 100%">
                    <!-- <div class="course-price">₹249</div> -->
                    <a
                        class="btn-secondary"
                        href="#"
                        style="width: 100%; text-align: center">Read More</a>
                </div>
            </div>

            <div class="course-card">
                <div class="course-header">
                    <div class="course-icon">📘</div>
                    <div>
                        <h3 class="course-title">Maths — Foundations</h3>
                        <div class="course-meta">10 videos · Ages 8-10</div>
                    </div>
                </div>
                <div class="course-footer" style="width: 100%">
                    <!-- <div class="course-price">₹249</div> -->
                    <a
                        class="btn-secondary"
                        href="#"
                        style="width: 100%; text-align: center">Read More</a>
                </div>
            </div>

            <div class="course-card">
                <div class="course-header">
                    <div class="course-icon">📘</div>
                    <div>
                        <h3 class="course-title">Maths — Foundations</h3>
                        <div class="course-meta">10 videos · Ages 8-10</div>
                    </div>
                </div>
                <div class="course-footer" style="width: 100%">
                    <!-- <div class="course-price">₹249</div> -->
                    <a
                        class="btn-secondary"
                        href="#"
                        style="width: 100%; text-align: center">Read More</a>
                </div>
            </div>

            <div class="course-card">
                <div class="course-header">
                    <div class="course-icon">📘</div>
                    <div>
                        <h3 class="course-title">Maths — Foundations</h3>
                        <div class="course-meta">10 videos · Ages 8-10</div>
                    </div>
                </div>
                <div class="course-footer" style="width: 100%">
                    <!-- <div class="course-price">₹249</div> -->
                    <a
                        class="btn-secondary"
                        href="#"
                        style="width: 100%; text-align: center">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- HANDS ON LEARNING -->
<section class="learning">
    <div class="container">
        <div class="section-header">
            <h2>Hands-on Learning & More ✨</h2>
            <p>Explore Our Latest Product Features</p>
        </div>

        <div class="learning-grid">
            <!-- Left Image -->
            <div class="learning-image">
                <img
                    id="learningImage"
                    src="./img/mentor.png"
                    alt="Hands-on Learning" />
            </div>

            <!-- Right Content -->
            <div class="learning-content">
                <div class="learning-item active" data-img="./img/mentor.png">
                    <h3 class="title">Personal Mentor Support</h3>
                    <p class="desc">
                        One-on-one guidance to track progress and ensure individual
                        growth.
                    </p>
                </div>

                <div class="learning-item" data-img="./img/interactive-class.png">
                    <h3 class="title">Interactive Classes</h3>
                    <p class="desc">
                        Engage in live interactive sessions with teachers to boost
                        understanding and retention.
                    </p>
                </div>

                <div class="learning-item" data-img="./img/practice.png">
                    <h3 class="title">Practical Activities</h3>
                    <p class="desc">
                        Hands-on experiments and real-world examples to make concepts
                        come alive.
                    </p>
                </div>

                <div class="learning-item" data-img="./img/handson.png">
                    <h3 class="title">School Curriculum</h3>
                    <p class="desc">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                        Tempore explicabo eveniet earum iste, architecto sed?
                    </p>
                </div>
            </div>
        </div>

        <div
            class="learning-cta"
            style="
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 25px;
          ">
            <a
                class="btn btn-primary"
                href="#"
                style="width: 50%; text-align: center; padding: 20px">Book Demo Session</a>
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
                <h3>Watch short vids</h3>
                <p>Animated 5–8 minute lessons with examples.</p>
            </div>
            <div class="step">
                <div class="step-icon">🧩</div>
                <h3>Practice & play</h3>
                <p>Interactive quizzes and printable activities.</p>
            </div>
        </div>
    </div>
</section>

<!-- JOIN STUDENTS -->
<section class="join-students">
    <div class="container">
        <h2>Join Students From All Over India!</h2>
        <p class="subtitle">Learning together, growing together 🌟</p>

        <div class="stats">
            <div class="stat-item">
                <div class="icon-circle">
                    <img src="./img/playstore.png" alt="Book Icon" />
                </div>
                <h3>4.5 ★ Rating</h3>
                <p>Rated on Playstore by thousands of happy learners</p>
            </div>

            <div class="stat-item">
                <div class="icon-circle">
                    <img src="./img/trophy.png" alt="Trophy Icon" />
                </div>
                <h3>Popular Ed Tech Pick</h3>
                <p>Recognized among the top learning platforms</p>
            </div>

            <div class="stat-item">
                <div class="icon-circle">
                    <img src="./img/globe.png" alt="Globe Icon" />
                </div>
                <h3>Powered by Schoolwala</h3>
                <p>Trusted by students across India</p>
            </div>
        </div>
    </div>
</section>

<!-- STORIES OF OUR BRIGHTEST STARS -->
<section class="brightest-stars">
    <div class="container">
        <h2>🌟 Stories of our Brightest Stars!</h2>
        <p class="subtitle">Students and Parents ❤️ Schoolwala</p>

        <div class="carousel" style="padding: 10px">
            <div class="carousel-track">
                <div class="carousel-item">
                    <div class="story-card star-performer">
                        <img src="./img/student.jpg" alt="Student" />
                        <div class="badge">🌟 Star Performer</div>
                        <div class="carousel-caption">
                            <p>Excelled in English, Maths and Science</p>
                            <span>Arvind, Class 8th</span>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="story-card bright-thinker">
                        <img src="./img/student.jpg" alt="Student" />
                        <div class="badge">💡 Bright Thinker</div>
                        <div class="carousel-caption">
                            <p>I love all my mentors: They help me with all my doubts</p>
                            <span>Naksh, Class 3rd</span>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="story-card happy-achiever">
                        <img src="./img/student.jpg" alt="Student" />
                        <div class="badge">🎉 Happy Achiever</div>
                        <div class="carousel-caption">
                            <p>My Parents are happy. Thanks Schoolwala!</p>
                            <span>Utkarsh, Class 3rd</span>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="story-card skill-builder">
                        <img src="./img/student.jpg" alt="Student" />
                        <div class="badge">🚀 Skill Builder</div>
                        <div class="carousel-caption">
                            <p>Improved confidence & skills</p>
                            <span>Priya, Class 6th</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FACULTIES -->
<section class="faculty-section">
    <div class="container">
        <div class="section-header">
            <h2>Meet Our Faculty</h2>
            <p>Our teachers are no less than wizards! ✨</p>
        </div>

        <div class="faculty-cards">
            <div class="faculty-card">
                <div class="faculty-info">
                    <h3>Vishal Sir</h3>
                    <p>
                        B.Sc Graduate, CTET and HTET qualified with 4+ years of teaching
                        experience.
                    </p>
                    <a href="#">Know More ↗</a>
                </div>
                <div class="faculty-img">
                    <img src="./img/fac.png" alt="Vishal Sir" />
                </div>
            </div>

            <div class="faculty-card">
                <div class="faculty-info">
                    <h3>Vishal Sir</h3>
                    <p>
                        B.Sc Graduate, CTET and HTET qualified with 4+ years of teaching
                        experience.
                    </p>
                    <a href="#">Know More ↗</a>
                </div>
                <div class="faculty-img">
                    <img src="./img/fac.png" alt="Vishal Sir" />
                </div>
            </div>

            <div class="faculty-card">
                <div class="faculty-info">
                    <h3>Vishal Sir</h3>
                    <p>
                        B.Sc Graduate, CTET and HTET qualified with 4+ years of teaching
                        experience.
                    </p>
                    <a href="#">Know More ↗</a>
                </div>
                <div class="faculty-img">
                    <img src="./img/fac.png" alt="Vishal Sir" />
                </div>
            </div>

            <div class="faculty-card">
                <div class="faculty-info">
                    <h3>Vishal Sir</h3>
                    <p>
                        B.Sc Graduate, CTET and HTET qualified with 4+ years of teaching
                        experience.
                    </p>
                    <a href="#">Know More ↗</a>
                </div>
                <div class="faculty-img">
                    <img src="./img/fac.png" alt="Vishal Sir" />
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section id="faq" class="faq">
    <div class="container">
        <div class="section-header">
            <h2>School Curriculum FAQ</h2>
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

@endsection