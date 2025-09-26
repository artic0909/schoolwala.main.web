@extends('layouts.app')

@section('title', 'My Profile - Schoolwala')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/student-profile.css') }}" />

@section('content')


<!-- PROFILE -->
<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span><a href="#" class="current"><i class="fas fa-user"></i>&nbsp;My Profile</a></span>
        <span>/</span>
        <span class="" style="text-decoration: underline"><a href="student-profile-edit.html"><i class="fas fa-edit"></i>&nbsp;Update Profile</a></span>
        <span>/</span>
        <span class="btn-outline"><a href="{{ route('student.student-logout') }}"><i class="fas fa-power-off"></i>&nbsp;Logout</a></span>
    </div>

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="avatar-container">
            <div class="avatar">
                <div
                    class="profile-img"
                    style="
                background: url('./img/profile.png');
                height: 120px;
                width: 120px;
                border-radius: 50%;
                background-size: cover;
                background-position: center;
              "></div>
            </div>
            <div class="avatar-decoration decoration-1">
                <i class="fas fa-star"></i>
            </div>
            <div class="avatar-decoration decoration-2">
                <i class="fas fa-lightbulb"></i>
            </div>
            <div class="avatar-decoration decoration-3">
                <i class="fas fa-trophy"></i>
            </div>
        </div>

        <div class="profile-info">
            <h1 class="profile-name">{{ Auth::user()->student_name }}</h1>
            <p class="profile-bio">
                Curious learner exploring the world of numbers and science!
                Currently in Class 8.
            </p>

            <div class="profile-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">128</div>
                        <div class="stat-label">Videos Watched</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">4,560</div>
                        <div class="stat-label">Learning Points</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">42</div>
                        <div class="stat-label">Practice Completed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Badges Section -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">My Achievements</h2>
        </div>

        <div class="badges-container">
            <!-- Badge 1 -->
            <div class="badge-card">
                <div class="badge-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3 class="badge-title">Math Master</h3>
                <p class="badge-description">Completed 50+ math lessons</p>
            </div>

            <!-- Badge 2 -->
            <div class="badge-card">
                <div class="badge-icon">
                    <i class="fas fa-flask"></i>
                </div>
                <h3 class="badge-title">Science Explorer</h3>
                <p class="badge-description">Finished all science experiments</p>
            </div>

            <!-- Badge 3 -->
            <div class="badge-card">
                <div class="badge-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h3 class="badge-title">Reading Champion</h3>
                <p class="badge-description">Read 100+ storybooks</p>
            </div>

            <!-- Badge 4 -->
            <div class="badge-card">
                <div class="badge-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3 class="badge-title">Quick Learner</h3>
                <p class="badge-description">Completed lessons in record time</p>
            </div>
        </div>
    </div>

    <!-- Progress Section -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">Learning Progress</h2>
        </div>

        <div class="progress-grid">
            <!-- Math -->
            <div class="subject-card">
                <div class="subject-header">
                    <div class="subject-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <h3 class="subject-title">Mathematics</h3>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 75%"></div>
                </div>
                <div class="progress-info">
                    <span>75% Completed</span>
                    <span>24 of 32 topics</span>
                </div>
            </div>

            <!-- Science -->
            <div class="subject-card">
                <div class="subject-header">
                    <div class="subject-icon">
                        <i class="fas fa-flask"></i>
                    </div>
                    <h3 class="subject-title">Science</h3>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 60%"></div>
                </div>
                <div class="progress-info">
                    <span>60% Completed</span>
                    <span>18 of 30 topics</span>
                </div>
            </div>

            <!-- English -->
            <div class="subject-card">
                <div class="subject-header">
                    <div class="subject-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h3 class="subject-title">English</h3>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 85%"></div>
                </div>
                <div class="progress-info">
                    <span>85% Completed</span>
                    <span>17 of 20 topics</span>
                </div>
            </div>

            <!-- Social Studies -->
            <div class="subject-card">
                <div class="subject-header">
                    <div class="subject-icon">
                        <i class="fas fa-globe-asia"></i>
                    </div>
                    <h3 class="subject-title">Social Studies</h3>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 45%"></div>
                </div>
                <div class="progress-info">
                    <span>45% Completed</span>
                    <span>9 of 20 topics</span>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection