@extends('layouts.app')

@section('title', Auth::user()->student_name . ' - ' . 'Update Profile - Schoolwala')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/student-profile-edit.css') }}" />
<style>
    .sticky-cta {
        display: none !important;
    }
</style>

@section('content')
<!-- PROFILE EDIT-->
<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span><a href="{{ route('student.student-profile') }}" class="current"><i class="fas fa-user"></i>&nbsp;My Profile</a></span>
        <span>/</span>
        <span class="btn-outline current"><a href="#"><i class="fas fa-edit"></i>&nbsp;Update Profile</a></span>
        <span>/</span>
        <span class="btn-outline"><a href="{{ route('student.student-logout') }}"><i class="fas fa-power-off"></i>&nbsp;Logout</a></span>
    </div>

    <!-- Edit Profile Header -->
    <div class="edit-header">
        <h1>Customize Your Profile!</h1>
        <p>
            Make your profile uniquely yours! Choose a fun avatar and tell us
            about yourself.
        </p>
    </div>

    <!-- Avatar Upload -->
    <form id="profileForm" action="{{ route('student.profile-image.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Avatar Upload -->
        <div class="avatar-section">
            <div class="avatar-container">
                <div class="avatar-preview">
                    @if ($profile->profile_image)
                    <img src="{{ asset('storage/' . $profile->profile_image) }}" alt="Profile Image">
                    @elseif($profile->profile_icon)
                    <i class="{{ $profile->profile_icon }}"></i>
                    @endif
                </div>
                <label class="avatar-edit" for="avatar-upload" style="z-index: 11">
                    <i class="fas fa-camera"></i>
                </label>
                <input type="hidden" name="student_id" value="{{ auth()->guard('student')->user()->id }}">
                <input type="file" id="avatar-upload" name="profile_image" style="display: none;">
                <input type="hidden" name="profile_icon" id="profile_icon" value="">
            </div>
            <p class="upload-text">Choose a fun avatar:</p>
            <div class="avatar-options">
                <div class="avatar-option selected">
                    <i class="fas fa-user-astronaut" style="font-size: 2.5rem; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(45deg, #ffc857, #ff8a00); color: white;"></i>
                </div>
                <div class="avatar-option selected">
                    <i class="fas fa-robot" style="font-size: 2.5rem; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(45deg, #60c2ff, #7ef6b5); color: white;"></i>
                </div>
                <div class="avatar-option selected">
                    <i class="fas fa-cat" style="font-size: 2.5rem; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(45deg, #ff7aa2, #ffb98a); color: white;"></i>
                </div>
                <div class="avatar-option selected">
                    <i class="fas fa-dragon" style="font-size: 2.5rem; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(45deg, #a78bfa, #60c2ff); color: white;"></i>
                </div>
                <div class="avatar-option selected">
                    <i class="fas fa-hat-wizard" style="font-size: 2.5rem; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(45deg, #7ef6b5, #60c2ff); color: white;"></i>
                </div>
            </div>
        </div>
    </form>


    <!-- Form Section -->
    <div class="form-section">
        <div id="profileFormName">


            <div class="form-group">
                <label class="form-label" for="class">
                    <i class="fas fa-graduation-cap"></i> Your Grade/Class
                </label>
                <input type="text" id="class" class="form-control" value="{{ $class->name }}" readonly>
            </div>

            <!-- Avatar Upload -->
            <form class="form-group" action="{{ route('student.profile-name.update') }}" method="POST">
                @csrf

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <label class="form-label" for="student_name">
                        <i class="fas fa-signature"></i> Your Full Name
                    </label>
                    <button type="submit" class="btn btn-outline" style="cursor: pointer;">Save</button>
                </div>
                <input type="hidden" value="{{ Auth::guard('student')->user()->id }}" name="id">
                <input
                    type="text"
                    id="student_name"
                    name="student_name"
                    class="form-control"
                    placeholder="Enter your name"
                    value="{{ Auth::guard('student')->user()->student_name }}"
                    style="margin-top: 10px;" />
            </form>



            <!-- Interest Update -->
            <form class="form-group" style="margin-top: 20px;" action="{{ route('student.profile-interest.update', $profile->id) }}" method="POST">
                @csrf
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <label class="form-label">
                        <i class="fas fa-heart"></i> Your Interests
                    </label>
                    <button type="submit" class="btn btn-outline" style="cursor: pointer;">Save</button>
                </div>
                <p class="form-hint" style="margin-top: 10px;">
                    Select what you're interested in learning about:
                </p>
                @php
                $selectedInterests = json_decode($profile->interest_in, true) ?? [];
                @endphp

                <div class="interests-container">
                    @php
                    $allInterests = [
                    'Mathematics', 'Science', 'Art & Drawing', 'Reading', 'Coding', 'Music', 'History', 'Geography',
                    'Physics', 'Chemistry', 'Biology', 'English Literature', 'Hindi', 'Sanskrit', 'Drawing & Craft',
                    'Dance (Classical)', 'Dance (Western)', 'Photography', 'Chess', 'Cricket', 'Football', 'Basketball',
                    'Robotics & AI', 'Gardening', 'Yoga & Meditation', 'Debate & Public Speaking', 'Storytelling',
                    'Vocal Music', 'Instrumental Music', 'Photography & Videography', 'Cooking', 'Magic & Tricks',
                    'Science Experiments', 'Languages (French, Spanish, etc.)', 'Environment & Nature'
                    ];
                    @endphp

                    @foreach ($allInterests as $interest)
                    <div class="interest-item {{ in_array($interest, $selectedInterests) ? 'selected' : '' }}">
                        <span>{{ $interest }}</span>
                        <i class="fas fa-check check-icon" style="display: {{ in_array($interest, $selectedInterests) ? 'block' : 'none' }};"></i>
                    </div>
                    @endforeach
                </div>


                <!-- Hidden container for selected interests -->
                <div id="hidden-interests"></div>
            </form>


            <!-- Security Update -->
            <form class="form-group" action="{{ route('student.profile-password.update') }}" method="POST">
                @csrf

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> Security
                    </label>
                    <button type="submit" class="btn btn-outline" style="cursor: pointer;">Save</button>
                </div>

                <div class="form-group" style="margin-top: 20px;">
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ Auth::guard('student')->user()->email }}"
                        readonly />
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                    <input
                        type="password"
                        name="password"
                        class="form-control"
                        placeholder="Set New Password" value="{{ old('password') }}" />
                </div>

                <div class="form-group">
                    <input
                        type="password"
                        name="password_confirmation"
                        class="form-control"
                        placeholder="Confirm Password" />
                </div>
            </form>

        </div>
    </div>

    <!-- Submit Button -->
    <!-- <div class="submit-section">
        <button class="btn-submit" id="saveProfile">
            <i class="fas fa-save"></i> Save Profile
        </button>
    </div> -->
</div>






<script src="{{ asset('js/script.js') }}"></script>

<script>
    const avatarOptions = document.querySelectorAll(".avatar-option");
    const avatarPreview = document.querySelector(".avatar-preview");
    const profileIconInput = document.getElementById("profile_icon");
    const profileForm = document.getElementById("profileForm");
    const avatarUpload = document.getElementById("avatar-upload");

    // Avatar icon click
    avatarOptions.forEach(option => {
        option.addEventListener("click", function() {
            avatarOptions.forEach(opt => opt.classList.remove("selected"));
            this.classList.add("selected");

            const icon = this.querySelector("i").cloneNode(true);
            avatarPreview.innerHTML = "";
            avatarPreview.appendChild(icon);

            // Set hidden input
            profileIconInput.value = this.querySelector("i").className;

            // Clear file input if previously uploaded
            avatarUpload.value = '';

            // Submit form automatically
            profileForm.submit();
        });
    });

    // Image upload click
    avatarUpload.addEventListener("change", function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;border-radius:50%;">`;
            }
            reader.readAsDataURL(this.files[0]);

            // Clear selected avatar icons
            avatarOptions.forEach(opt => opt.classList.remove("selected"));
            profileIconInput.value = '';

            // Submit form automatically
            profileForm.submit();
        }
    });

    // Interest selection
    const interestItems = document.querySelectorAll(".interest-item");
    const hiddenContainer = document.getElementById("hidden-interests");

    function updateHiddenInputs() {
        hiddenContainer.innerHTML = ""; // Clear old inputs
        interestItems.forEach((item) => {
            if (item.classList.contains("selected")) {
                const input = document.createElement("input");
                input.type = "hidden";
                input.name = "interest_in[]";
                input.value = item.textContent.trim();
                hiddenContainer.appendChild(input);
            }
        });
    }

    // Initialize hidden inputs on page load
    updateHiddenInputs();

    // Update hidden inputs when user clicks an interest
    interestItems.forEach((item) => {
        item.addEventListener("click", function() {
            this.classList.toggle("selected");
            const checkIcon = this.querySelector(".check-icon");
            checkIcon.style.display = this.classList.contains("selected") ? "block" : "none";

            updateHiddenInputs();
        });
    });


    // Color selection
    const colorOptions = document.querySelectorAll(".color-option");

    colorOptions.forEach((option) => {
        option.addEventListener("click", function() {
            // Remove selected class from all options
            colorOptions.forEach((opt) => opt.classList.remove("selected"));

            // Add selected class to clicked option
            this.classList.add("selected");

            // Update UI with selected color
            document.documentElement.style.setProperty(
                "--accent",
                this.dataset.color
            );
            document.documentElement.style.setProperty(
                "--accent-dark",
                this.dataset.color + "cc"
            );
        });
    });
</script>
@endsection