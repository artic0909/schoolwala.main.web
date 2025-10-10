@extends('layouts.app')

@section('title', 'About Us - Fun Learning for Kids')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/about-us.css') }}" />


@section('content')

<!-- ABOUT US-->
<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="#"><i class="fas fa-home"></i> Home</a>
        <span>/</span>
        <span class="current"><i class="fas fa-info-circle"></i> About Us</span>
    </div>

    <!-- Hero Section -->
    <div class="hero-about">
        <div class="about-element elem-1"></div>
        <div class="about-element elem-2"></div>
        <div class="about-element elem-3"></div>
        <div class="about-element elem-4"></div>

        <h1 class="hero-title">
            Where Learning Becomes <span>an Adventure!</span>
        </h1>
        <p class="hero-subtitle">
            At Schoolwala, we believe every child deserves a magical learning
            journey. Our mission is to transform education into an exciting quest
            filled with discovery and joy.
        </p>
        @foreach($abouts as $about)
        <div class="hero-stats">
            <div class="stat-circle">
                <div class="stat-number">{{ $about -> happy_kids }}+</div>
                <div class="stat-label">Happy Kids</div>
            </div>
            <div class="stat-circle">
                <div class="stat-number">{{ $about -> fun_lessons }}+</div>
                <div class="stat-label">Fun Lessons</div>
            </div>
            <div class="stat-circle">
                <div class="stat-number">{{ $about -> satisfaction }}%</div>
                <div class="stat-label">Satisfaction</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Story Section -->
    <div class="story-section">
        <div class="story-container">
            <h2 class="section-title">Our Story</h2>
            <div class="story-content">
                <p style="text-align: justify;">
                    {{ $about -> our_story }}
                </p>

                <div class="founder-quote">
                    {{ $about -> bold_message }}
                </div>

                <p>
                    {{ $about -> our_vision }}
                </p>
            </div>
        </div>
    </div>

    <!-- FACULTIES -->
    <section class="faculty-section">
        <div class="container">
            <div class="section-header">
                <h2>Meet Our Faculty</h2>
                <p>Our teachers are no less than wizards! ✨</p>
            </div>

            <div class="faculty-cards">
                @foreach($faculties as $faculty)
                <div class="faculty-card">
                    <div class="faculty-info">
                        <h3>{{ $faculty->name }}</h3>
                        <p>
                            {{ $faculty->about_fac}}
                        </p>

                        @if (!empty($faculty->assigned_classes))
                        @foreach ($faculty->assigned_classes as $classId)
                        @php
                        $class = \App\Models\Classes::find($classId);
                        @endphp

                        <a href="#">
                            @if ($class)
                            {{ $class->name }}
                            @endif
                        </a>
                        @endforeach
                        <a href="#">↗</a>
                        @endif
                    </div>

                    <div class="faculty-img">
                        <img src="{{ asset('storage/' . $faculty->image) }}" alt="{{ $faculty->name }}" />
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>

    <!-- Values Section -->
    <div class="values-section">
        <div class="team-header">
            <h2 class="section-title">Our Magical Principles</h2>
            <p>The spells that guide everything we do</p>
        </div>

        <div class="values-grid">
            <!-- Value 1 -->
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="value-title">Playful Learning</h3>
                <p class="value-description">
                    We believe the best learning happens when kids are having fun.
                    Games, stories, and adventures make knowledge stick!
                </p>
            </div>

            <!-- Value 2 -->
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="value-title">Curiosity First</h3>
                <p class="value-description">
                    We nurture natural curiosity instead of forcing memorization.
                    Questions are always more important than answers!
                </p>
            </div>

            <!-- Value 3 -->
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-child"></i>
                </div>
                <h3 class="value-title">Kid-Centered</h3>
                <p class="value-description">
                    Our young learners guide everything we create. We listen, adapt,
                    and design with their needs in mind.
                </p>
            </div>

            <!-- Value 4 -->
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <h3 class="value-title">Growth Mindset</h3>
                <p class="value-description">
                    Mistakes are magical learning opportunities! We celebrate effort
                    and progress over perfection.
                </p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-section">
        <h2 class="cta-title">Ready for a Learning Adventure?</h2>
        <p class="cta-subtitle">
            Join thousands of curious kids exploring our magical learning world.
            Where education meets excitement!
        </p>
        <a href="#" class="btn-cta">
            <i class="fas fa-hat-wizard"></i> Start Free Trial
        </a>
    </div>
</div>

@endsection