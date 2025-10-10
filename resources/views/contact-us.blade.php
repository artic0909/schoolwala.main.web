@extends('layouts.app')

@section('title', 'Schoolwala - Fun Learning for Kids')
<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/about-us.css') }}" />
<link rel="stylesheet" href="{{ asset('css/contact.css') }}" />

<style>
    .sticky-cta {
        display: none !important;
    }

    /* Result Popup */
    .result-popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .result-popup.active {
        opacity: 1;
        visibility: visible;
    }

    .result-content {
        background: var(--white);
        border-radius: var(--radius);
        padding: 40px;
        text-align: center;
        max-width: 500px;
        width: 90%;
        transform: translateY(20px);
        transition: transform 0.5s ease;
        position: relative;
    }

    .result-popup.active .result-content {
        transform: translateY(0);
    }

    .result-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(45deg, var(--mint), var(--sky));
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 3rem;
        color: var(--white);
    }

    .result-title {
        font-family: "Baloo 2", cursive;
        font-size: 2rem;
        margin-bottom: 15px;
        color: var(--text);
    }

    .result-score {
        font-size: 3.5rem;
        font-weight: 800;
        color: var(--accent);
        margin: 20px 0;
        line-height: 1;
    }

    .result-message {
        color: var(--text-light);
        margin-bottom: 30px;
        font-size: 1.1rem;
    }

    .result-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn-result {
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-review {
        background: var(--white);
        color: var(--accent);
        border: 2px solid var(--accent);
    }

    .btn-review:hover {
        background: rgba(255, 138, 0, 0.1);
    }

    .btn-next {
        background: var(--accent);
        color: var(--white);
        border: 2px solid var(--accent);
    }

    .btn-next:hover {
        background: var(--accent-dark);
    }
</style>

@section('content')

<!-- CONTACT US-->
<div class="container">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="#"><i class="fas fa-home"></i> Home</a>
        <span>/</span>
        <span class="current"><i class="fas fa-info-circle"></i> Contact Us</span>
    </div>

    <!-- Hero Section -->
    <div class="contact-hero">
        <h1 class="contact-title">Hello <span>Friends!</span></h1>
        <p class="contact-subtitle">
            Got questions, ideas, or just want to say hi? We're all ears and can't
            wait to hear from you!
        </p>
    </div>

    <!-- Contact Content -->
    <div class="contact-content">
        <!-- Contact Form -->
        <div class="contact-form">
            <div class="form-container">
                <div class="form-header">
                    <h2 class="form-title">Send Us a Message</h2>
                    <p class="form-subtitle">
                        We'll get back to you faster than you can say "Schoolwala!"
                    </p>
                </div>

                @guest
                <form id="contactForm" action="{{ route('student.contact.submit') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="name">
                            <i class="fas fa-user"></i> Your Name
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            placeholder="What should we call you?" />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">
                            <i class="fas fa-envelope"></i> Your Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="Where can we reach you?" />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="subject">
                            <i class="fas fa-star"></i> Subject
                        </label>
                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            class="form-control"
                            placeholder="What's your message about?" />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">
                            <i class="fas fa-comment-dots"></i> Your Message
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            class="form-control"
                            placeholder="Tell us what's on your mind..."></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
                @endguest

                @auth
                <form id="contactForm" action="{{ route('student.contact-us.submit') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="name">
                            <i class="fas fa-user"></i> Your Name
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            placeholder="What should we call you?" />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">
                            <i class="fas fa-envelope"></i> Your Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="Where can we reach you?" />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="subject">
                            <i class="fas fa-star"></i> Subject
                        </label>
                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            class="form-control"
                            placeholder="What's your message about?" />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">
                            <i class="fas fa-comment-dots"></i> Your Message
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            class="form-control"
                            placeholder="Tell us what's on your mind..."></textarea>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
                @endauth
            </div>
        </div>

        <!-- Contact Info -->
        <div class="contact-info">
            <div class="info-box">
                <h2 class="info-title">Find Us Here</h2>

                @foreach ($abouts as $about)
                <div class="contact-details">
                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="detail-content">
                            <h3>Our Treehouse</h3>
                            <p>{{ $about->cm_address }}</p>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="detail-content">
                            <h3>Call Us</h3>
                            <p>+{{ $about->cm_mobile }}<br />Monday-Sunday, 9AM-9PM</p>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="detail-content">
                            <h3>Email Us</h3>
                            <p>{{ $about->cm_email }}</p>
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-content" style="width: 100%">
                            <button class="btn-submit" id="submitTest">
                                <i class="fas fa-user"></i>&nbsp;Waiver Request
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Modal -->
                <div class="result-popup" id="resultPopup">
                    <div class="result-content">
                        <h2 class="result-title">Waiver Request Form</h2>
                        @guest
                        <form action="{{ route('student.waiver.submit') }}" method="POST">
                            @csrf

                            <div
                                class="d-flex"
                                style="
                      display: flex;
                      justify-content: space-between;
                      align-items: center;
                      gap: 5px;
                    ">
                                <div class="form-group">
                                    <label class="form-label" for="name">
                                        <i class="fas fa-user"></i> Parent's Name
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="p_name"
                                        class="form-control"
                                        placeholder="Enter Parent's Name" />
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="name">
                                        <i class="fas fa-user"></i> Child's Name
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="c_name"
                                        class="form-control"
                                        placeholder="Enter Child's Name" />
                                </div>
                            </div>

                            <div
                                class="d-flex"
                                style="
                      display: flex;
                      justify-content: space-between;
                      align-items: center;
                      gap: 5px;
                    ">
                                <div class="form-group">
                                    <label class="form-label" for="name">
                                        <i class="fas fa-calendar"></i> Child's Age
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="c_age"
                                        class="form-control"
                                        placeholder="Age" />
                                </div>

                                <div class="form-group" style="width: 100%">
                                    <label class="form-label" for="name">
                                        <i class="fas fa-table"></i> Choose Class
                                    </label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div
                                class="d-flex"
                                style="
                      display: flex;
                      justify-content: space-between;
                      align-items: center;
                      gap: 5px;
                    ">
                                <div class="form-group">
                                    <label class="form-label" for="name">
                                        <i class="fas fa-envelope"></i> Email
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="email"
                                        class="form-control"
                                        placeholder="Email" />
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="name">
                                        <i class="fas fa-phone"></i> Mobile
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="mobile"
                                        class="form-control"
                                        placeholder="Mobile" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="name">
                                    <i class="fas fa-location-arrow"></i> Address
                                </label>
                                <textarea name="address" id="address" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i> Send Request
                            </button>
                        </form>
                        @endguest

                        @auth
                        <form action="{{ route('student.waiver-student.submit') }}" method="POST">
                            @csrf

                            <div
                                class="d-flex"
                                style="
                      display: flex;
                      justify-content: space-between;
                      align-items: center;
                      gap: 5px;
                    ">
                                <div class="form-group">
                                    <label class="form-label" for="name">
                                        <i class="fas fa-user"></i> Parent's Name
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="p_name"
                                        class="form-control"
                                        placeholder="Enter Parent's Name" />
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="name">
                                        <i class="fas fa-user"></i> Child's Name
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="c_name"
                                        class="form-control"
                                        placeholder="Enter Child's Name" />
                                </div>
                            </div>

                            <div
                                class="d-flex"
                                style="
                      display: flex;
                      justify-content: space-between;
                      align-items: center;
                      gap: 5px;
                    ">
                                <div class="form-group">
                                    <label class="form-label" for="name">
                                        <i class="fas fa-calendar"></i> Child's Age
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="c_age"
                                        class="form-control"
                                        placeholder="Age" />
                                </div>

                                <div class="form-group" style="width: 100%">
                                    <label class="form-label" for="name">
                                        <i class="fas fa-table"></i> Choose Class
                                    </label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div
                                class="d-flex"
                                style="
                      display: flex;
                      justify-content: space-between;
                      align-items: center;
                      gap: 5px;
                    ">
                                <div class="form-group">
                                    <label class="form-label" for="name">
                                        <i class="fas fa-envelope"></i> Email
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="email"
                                        class="form-control"
                                        placeholder="Email" />
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="name">
                                        <i class="fas fa-phone"></i> Mobile
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="mobile"
                                        class="form-control"
                                        placeholder="Mobile" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="name">
                                    <i class="fas fa-location-arrow"></i> Address
                                </label>
                                <textarea name="address" id="address" class="form-control"></textarea>
                            </div>

                            <button type="submit" class="btn-submit">
                                <i class="fas fa-paper-plane"></i> Send Request
                            </button>
                        </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>





<script src="{{ asset('js/script.js') }}"></script>

<script>
    // Initialize variables
    const totalQuestions = 5;
    let answeredQuestions = 0;

    // Update progress bar
    function updateProgress() {
        const percentage = Math.round(
            (answeredQuestions / totalQuestions) * 100
        );
        document.querySelector(
            ".progress-percent"
        ).textContent = `${percentage}%`;
        document.getElementById("progressFill").style.width = `${percentage}%`;
    }

    // Option selection
    const options = document.querySelectorAll(".option");
    options.forEach((option) => {
        option.addEventListener("click", function() {
            const questionNum = this.dataset.question;
            const allQuestionOptions = document.querySelectorAll(
                `.option[data-question="${questionNum}"]`
            );

            // Remove selected class from all options in this question
            allQuestionOptions.forEach((opt) => {
                opt.classList.remove("selected");
            });

            // Add selected class to clicked option
            this.classList.add("selected");

            // Check if this is the first time answering this question
            const wasAnswered = Array.from(allQuestionOptions).some((opt) =>
                opt.classList.contains("selected")
            );
            if (!wasAnswered) {
                answeredQuestions++;
                updateProgress();
            }
        });
    });

    // Submit test
    document
        .getElementById("submitTest")
        .addEventListener("click", function() {
            const selectedOptions =
                document.querySelectorAll(".option.selected").length;

            // Show result popup
            document.getElementById("resultPopup").classList.add("active");
        });

    // Close popup if clicked outside
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("result-popup")) {
            document.getElementById("resultPopup").classList.remove("active");
        }
    });

    // Initialize progress bar
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(() => {
            document.getElementById("progressFill").style.width = "20%";
        }, 300);
    });
</script>

@endsection