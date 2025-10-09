@extends('layouts.app')

@section('title', 'My Profile - Schoolwala')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/student-profile.css') }}" />

<style>
    .sticky-cta {
        display: none !important;
    }
</style>

@section('content')


<!-- PROFILE -->
<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span><a href="#" class="current"><i class="fas fa-user"></i>&nbsp;My Profile</a></span>
        <span>/</span>
        <span class="btn-outline"><a href="{{ route('student.student-profile.update.view') }}"><i class="fas fa-edit"></i>&nbsp;Update Profile</a></span>
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
        height: 120px;
        width: 120px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        background-image: 
            @if($profile->profile_image)
                url('{{ asset('storage/' . $profile->profile_image) }}')
            @elseif($profile->profile_icon)
                none
            @else
                url('{{ asset('img/profile.png') }}')
            @endif;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
    ">
                    @if($profile->profile_icon && !$profile->profile_image)
                    <i class="{{ $profile->profile_icon }}"></i>
                    @endif
                </div>

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
            <h1 class="profile-name" style="text-transform: capitalize;">{{ Auth::user()->student_name }}</h1>
            <p class="profile-bio">
            <h4>Student ID: {{ Auth::user()->student_id }}</h4>
            Curious learner exploring the world of numbers and science!
            Currently in {{ $class->name }}.
            </p>

            <div class="profile-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{$profile->no_practise_test ? $profile->no_practise_test : 0}}</div>
                        <div class="stat-label">Videos Watched</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{$profile->total_practise_test_score ? $profile->total_practise_test_score : 0}}</div>
                        <div class="stat-label">Learning Points</div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{$profile->no_practise_test ? $profile->no_practise_test : 0}}</div>
                        <div class="stat-label">Practice Completed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Badges Section -->
    <div class="section">
        <div class="section-header">
            <h2 class="section-title">My Showcase</h2>
        </div>

        <div class="badges-container">

            @forelse($interests as $interest)
            <div class="badge-card">
                <div class="badge-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h3 class="badge-title">{{ $interest }}</h3>
                <p class="badge-description">Hurray! You like {{ $interest }}</p>
            </div>
            @empty
            <p>No interests found.</p>
            @endforelse
        </div>
    </div>

    
</div>




@endsection