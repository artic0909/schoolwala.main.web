@extends('layouts.app')

@section('title', 'Privacy & Policy - Schoolwala')

<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('./css/privacy.css') }}" />

<link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

@section('content')
<!-- PRIVACY & POLICY -->
<div class="container">
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="#"><i class="fas fa-home"></i> Home</a>
        <span>/</span>
        <span class="current">Privacy Promise</span>
    </nav>

    <!-- Header -->
    <header class="privacy-header">
        <div class="privacy-element elem-1"></div>
        <div class="privacy-element elem-2"></div>
        <div class="privacy-element elem-3"></div>
        <div class="privacy-element elem-4"></div>

        <h1 class="hero-title">Our <span>Privacy Promise</span></h1>
        <p class="hero-subtitle">
            We take your safety seriously! Here's how we protect your information
            and keep your learning experience fun and secure.
        </p>
        <div style="font-size: 5rem; color: var(--accent); margin-top: 20px">
            <i class="fas fa-lock"></i>
            <i class="fas fa-shield-alt" style="margin: 0 20px"></i>
            <i class="fas fa-user-secret"></i>
        </div>
    </header>

    <!-- Privacy Content -->
    <main class="privacy-content">
        <div class="section">
            <div class="section-title">
                <i class="fas fa-info-circle"></i>
                <h2>What We Collect</h2>
            </div>
            <div class="section-content">
                <p>
                    We only collect information that helps make Schoolwala awesome for
                    you:
                </p>
                <div class="info-bubbles">
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-user"></i> Your Profile
                        </div>
                        <div class="bubble-content">
                            Your name, grade, and school (so we know who's learning!)
                        </div>
                    </div>
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-star"></i> Your Progress
                        </div>
                        <div class="bubble-content">
                            How you're doing on lessons and activities
                        </div>
                    </div>
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-tablet-alt"></i> Your Device
                        </div>
                        <div class="bubble-content">
                            What kind of device you're using to learn
                        </div>
                    </div>
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-heart"></i> Your Favorites
                        </div>
                        <div class="bubble-content">
                            Subjects and activities you love most
                        </div>
                    </div>
                </div>
                <p>
                    We never collect your home address or phone number without your
                    parents' permission.
                </p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">
                <i class="fas fa-book"></i>
                <h2>How We Use Information</h2>
            </div>
            <div class="section-content">
                <p>Your information helps us create the best learning adventure:</p>
                <div class="info-bubbles">
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-magic"></i> Personalize
                        </div>
                        <div class="bubble-content">
                            Create activities just right for you
                        </div>
                    </div>
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-chart-line"></i> Track Progress
                        </div>
                        <div class="bubble-content">Show how much you're learning</div>
                    </div>
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-gamepad"></i> Make Fun
                        </div>
                        <div class="bubble-content">
                            Design games you'll love to play
                        </div>
                    </div>
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-shield"></i> Keep Safe
                        </div>
                        <div class="bubble-content">Protect your learning space</div>
                    </div>
                </div>
                <p>We promise never to sell your information to anyone!</p>
            </div>
        </div>

        <div class="privacy-shield">
            <div class="shield-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h2 class="shield-title">Superhero Security</h2>
            <p class="shield-text">
                We use special tools to protect your information like a superhero
                shield! Our security team works 24/7 to keep your data safe from any
                baddies.
            </p>
            <div
                style="
              display: flex;
              justify-content: center;
              gap: 20px;
              flex-wrap: wrap;
            ">
                <div style="font-size: 2rem; color: var(--accent)">
                    <i class="fas fa-lock"></i> Encryption
                </div>
                <div style="font-size: 2rem; color: var(--sky)">
                    <i class="fas fa-user-shield"></i> Protection
                </div>
                <div style="font-size: 2rem; color: var(--mint)">
                    <i class="fas fa-eye-slash"></i> Privacy
                </div>
            </div>
        </div>

        <div class="section">
            <div class="section-title">
                <i class="fas fa-cookie-bite"></i>
                <h2>Cookies & Tracking</h2>
            </div>
            <div class="section-content">
                <p>
                    We use cookies - but not the chocolate chip kind! These are tiny
                    helpers that:
                </p>
                <div class="info-bubbles">
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-sign-in-alt"></i> Remember You
                        </div>
                        <div class="bubble-content">
                            So you don't have to login every time
                        </div>
                    </div>
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-thumbs-up"></i> Know Preferences
                        </div>
                        <div class="bubble-content">
                            Remember your favorite settings
                        </div>
                    </div>
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-chart-pie"></i> Improve
                        </div>
                        <div class="bubble-content">
                            Make Schoolwala better for everyone
                        </div>
                    </div>
                </div>
                <p>
                    You can control cookies in your browser, but some features might
                    not work without them.
                </p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">
                <i class="fas fa-user-astronaut"></i>
                <h2>Your Space Powers</h2>
            </div>
            <div class="section-content">
                <p>You're the captain of your privacy spaceship! You can:</p>
                <div class="info-bubbles" style="margin-bottom: 30px">
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-eye"></i> See Data
                        </div>
                        <div class="bubble-content">Ask to see what info we have</div>
                    </div>
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-edit"></i> Fix Mistakes
                        </div>
                        <div class="bubble-content">Tell us if something's wrong</div>
                    </div>
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-pause"></i> Take Breaks
                        </div>
                        <div class="bubble-content">Pause your account anytime</div>
                    </div>
                    <div class="info-bubble">
                        <div class="bubble-title">
                            <i class="fas fa-trash"></i> Delete
                        </div>
                        <div class="bubble-content">Ask us to delete your info</div>
                    </div>
                </div>
                <p>
                    Just ask your parents to help with these - they're your co-pilots!
                </p>
            </div>
        </div>
    </main>

    <!-- Contact Section -->
    <section class="contact-section">
        <h2 class="contact-title">Have Privacy Questions?</h2>
        <p class="contact-text" style="color: white;">
            Our friendly Privacy Guardians are here to help! If you or your
            parents have any questions about how we protect your information, just
            reach out.
        </p>
        <a href="#" class="contact-btn">Contact Our Privacy Team <i class="fas fa-arrow-right"></i></a>
    </section>
</div>


<script>
    // Simple animation effects
    document.addEventListener("DOMContentLoaded", function() {
        // Add animation to info bubbles on scroll
        const bubbles = document.querySelectorAll(".info-bubble");

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = "translateY(0)";
                    }
                });
            }, {
                threshold: 0.1
            }
        );

        bubbles.forEach((bubble) => {
            bubble.style.opacity = 0;
            bubble.style.transform = "translateY(20px)";
            bubble.style.transition = "opacity 0.6s ease, transform 0.6s ease";
            observer.observe(bubble);
        });

        // Add hover effect to section icons
        const sectionIcons = document.querySelectorAll(".section-title i");
        sectionIcons.forEach((icon) => {
            icon.addEventListener("mouseenter", function() {
                this.style.transform = "scale(1.1) rotate(5deg)";
            });

            icon.addEventListener("mouseleave", function() {
                this.style.transform = "scale(1) rotate(0)";
            });
        });
    });
</script>



@endsection