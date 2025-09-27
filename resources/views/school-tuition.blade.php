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
            @foreach($classes as $class)
            <div class="class-pill" data-id="{{ $class->id }}">
                {{ $class->name }}
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CURRICULUM -->
<section class="curriculum">
    <div class="container">
        <div class="section-header">
            <h2>Personalise - Curriculum for Every Subject</h2>
            <p>Select a class to see subjects and chapters.</p>
        </div>
        <div class="curriculum-grid" id="curriculumCards">
            <p class="text-muted">👉 Please select a class pill above.</p>
        </div>
    </div>
</section>

<!-- COURSE ABOUT -->
<section class="course-about" id="courseAbout">
    <div class="container">
        <div class="section-header text-center">
            <h2 id="aboutTitle">About Online Tuition</h2>
            <p id="aboutDescription">Choose a class to see details.</p>
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
            <p class="text-muted">👉 Select a class to see FAQs.</p>
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


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const pills = document.querySelectorAll(".class-pill");
        const curriculumCards = document.getElementById("curriculumCards");
        const aboutTitle = document.getElementById("aboutTitle");
        const aboutDescription = document.getElementById("aboutDescription");
        const faqAcc = document.getElementById("faqAcc");

        function initAccordions() {
            const buttons = faqAcc.querySelectorAll(".accordion-button");
            buttons.forEach(btn => {
                btn.addEventListener("click", function() {
                    const content = this.nextElementSibling;
                    const isOpen = content.classList.contains("open");

                    // Toggle this accordion
                    if (isOpen) {
                        content.classList.remove("open");
                        content.style.maxHeight = null;
                    } else {
                        content.classList.add("open");
                        content.style.maxHeight = content.scrollHeight + "px";
                    }
                });
            });
        }

        pills.forEach(pill => {
            pill.addEventListener("click", function() {
                pills.forEach(p => p.classList.remove("active"));
                this.classList.add("active");

                const classId = this.getAttribute("data-id");
                curriculumCards.innerHTML = "<p>Loading...</p>";
                faqAcc.innerHTML = "<p>Loading FAQs...</p>";

                fetch(`/get-class-curriculum/${classId}`)
                    .then(res => res.json())
                    .then(data => {
                        // Curriculum
                        let html = "";
                        data.subjects.forEach(subject => {
                            html += `<div class="subject-box">
                            <h3>${subject.name}</h3>
                            <ul>${subject.chapters.map(ch => `<li>${ch.name}</li>`).join('')}</ul>
                        </div>`;
                        });
                        curriculumCards.innerHTML = html || "<p>No subjects found</p>";

                        // About
                        aboutTitle.textContent = `About Online Tuition For ${data.name}`;
                        aboutDescription.textContent = data.description || "No description available.";

                        // FAQs
                        if (data.faqs.length > 0) {
                            let faqHtml = "";
                            data.faqs.forEach(faq => {
                                faqHtml += `<div class="accordion-item">
                                <button class="accordion-button">${faq.question}</button>
                                <div class="accordion-content" style="max-height:0; overflow:hidden; transition: max-height 0.3s ease;">
                                    <p>${faq.answer}</p>
                                </div>
                            </div>`;
                            });
                            faqAcc.innerHTML = faqHtml;
                            initAccordions();
                        } else {
                            faqAcc.innerHTML = "<p>No FAQs available.</p>";
                        }
                    })
                    .catch(err => {
                        curriculumCards.innerHTML = "<p style='color:red'>Error loading data</p>";
                        faqAcc.innerHTML = "<p style='color:red'>Error loading FAQs</p>";
                    });
            });
        });

        if (pills.length > 0) pills[0].click();
    });
</script>



@endsection