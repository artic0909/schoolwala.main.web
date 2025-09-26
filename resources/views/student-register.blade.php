<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Schoolwala — Sign Up</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&family=Inter:wght@300;400;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('./css/auth.css') }}" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('logofav.png') }}" />
    <style>
        .custom-success-popup,
        .custom-error-popup {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 5px;
            color: white;
            z-index: 9999;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            animation: fadeInOut 4s ease-in-out forwards;
        }

        .custom-success-popup {
            background-color: #4CAF50;
        }

        .custom-error-popup {
            background-color: #f44336;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }

            10% {
                opacity: 1;
                transform: translateY(0);
            }

            90% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                transform: translateY(-10px);
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <!-- Left Illustration -->
            <div class="auth-illustration">
                <div class="shape star"></div>
                <div class="shape pencil"></div>
                <div class="text-center text-white px-4">
                    <h2 class="fw-bold mb-4" style="font-size: 2.2rem">
                        Start your child's fun learning journey!
                    </h2>
                    <p style="font-size: 1.1rem; max-width: 400px">
                        Interactive lessons, progress tracking, and personalized learning
                        plans
                    </p>

                    <div class="mt-4 text-start d-inline-block">
                        <p>
                            🎯 <strong>Personalized Learning</strong><br /><span>Tailored to your child's pace</span>
                        </p>
                        <p>
                            🏆 <strong>Progress Tracking</strong><br /><span>See your child's improvement</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Form -->
            <div class="auth-content">
                <div class="auth-header">
                    <div class="logo">
                        <img src="{{ asset('img/logo.png') }}" class="img-fluid" alt="SW" />
                    </div>
                    <h1 class="brand">Create your account</h1>
                    <p>Join the Schoolwala community</p>
                </div>

                <form id="signupForm" action="{{ route('student.student-register.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Parent's Name</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter Parent's Name"
                            name="parent_name"
                            value="{{ old('parent_name') }}"
                            required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input
                            type="email"
                            class="form-control"
                            placeholder="your@email.com"
                            name="email"
                            value="{{ old('email') }}"
                            required />
                    </div>
                    <div class="form-group">
                        <label class="form-label">Mobile Number</label>
                        <input
                            type="number"
                            class="form-control"
                            placeholder="1234567890"
                            value="{{ old('mobile') }}"
                            name="mobile"
                            required />
                    </div>

                    <div class="form-group">
                        <label class="form-label">Child's Name</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Enter Student's Name"
                            name="student_name"
                            value="{{ old('student_name') }}"
                            required />
                    </div>

                    <div class="form-group">
                        <label class="form-label">Child's Age</label>
                        <input
                            type="number"
                            class="form-control"
                            placeholder="Enter Student's Age"
                            name="age"
                            value="{{ old('age') }}"
                            required />
                    </div>

                    <div class="form-group">
                        <label class="form-label">Select Class</label>
                        <select name="class_id" id="class_id" class="form-control">
                            <option value="" selected>Choose Class</option>
                            @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <label class="form-label">Password</label>
                    <div class="form-group password-toggle" style="display: flex; align-items: center; justify-content: center;">
                        <input
                            type="password"
                            class="form-control"
                            placeholder="••••••••"
                            name="password"
                            value="{{ old('password') }}"
                            required />
                        <button type="button" class="toggle-password">👁️</button>
                    </div>

                    <label class="form-label">Confirm Password</label>
                    <div class="form-group password-toggle" style="display: flex; align-items: center; justify-content: center;">
                        <input
                            type="password"
                            class="form-control"
                            placeholder="••••••••"
                            name="password_confirmation"
                            value="{{ old('password_confirmation') }}"
                            required />
                        <button type="button" class="toggle-password">👁️</button>
                    </div>
                    <div class="form-check my-3">
                        <input
                            type="checkbox"
                            class="form-check-input"
                            id="terms"
                            required />
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#">Terms & Conditions</a>
                        </label>
                    </div>
                    <button type="submit" class="btn-auth">Sign Up</button>
                </form>

                <div class="auth-footer">
                    Already have an account? <a href="{{ url('student-login') }}">Login</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/auth.js') }}"></script>



    @if (session('success'))
    <div id="successPopup" class="custom-success-popup">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div id="errorPopup" class="custom-error-popup">
        {{ session('error') }}
    </div>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successPopup = document.getElementById('successPopup');
            const errorPopup = document.getElementById('errorPopup');

            if (successPopup) setTimeout(() => successPopup.remove(), 4000);
            if (errorPopup) setTimeout(() => errorPopup.remove(), 4000);
        });
    </script>
</body>

</html>