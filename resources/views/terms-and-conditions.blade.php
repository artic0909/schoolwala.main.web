@extends('layouts.app')

@section('title', 'Terms & Conditions | Schoolwala | Education For All')

<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('./css/privacy.css') }}" />

<link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

@section('content')
<!-- TERMS & CONDITIONS -->
<div class="container">
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="#"><i class="fas fa-home"></i> Home</a>
        <span>/</span>
        <span class="current">Terms & Conditions</span>
    </nav>

    <!-- Header -->
    <header class="privacy-header">
        <div class="privacy-element elem-1"></div>
        <div class="privacy-element elem-2"></div>
        <div class="privacy-element elem-3"></div>
        <div class="privacy-element elem-4"></div>

        <h1 class="hero-title">Terms & <span>Conditions</span></h1>
        <p class="hero-subtitle">
            Welcome to Schoolwala! Please read these terms and conditions carefully before using our platform.
        </p>
    </header>

    <!-- Content -->
    <main class="privacy-content">
        <div class="section">
            <div class="section-title">
                <h2>1. Acceptance of Terms</h2>
            </div>
            <div class="section-content">
                <p>
                    By accessing and using the Schoolwala website and app, you agree to be bound by these Terms and Conditions. If you do not agree to these terms, please do not use our services.
                </p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">
                <h2>2. User Accounts</h2>
            </div>
            <div class="section-content">
                <p>
                    You must register an account to access certain features. You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.
                </p>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">
                <h2>3. Use of Services</h2>
            </div>
            <div class="section-content">
                <p>
                    Our services are designed for educational purposes. Users agree not to misuse our content, distribute it without permission, or engage in any behavior that disrupts the learning environment.
                </p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">
                <h2>4. Payments & Subscriptions</h2>
            </div>
            <div class="section-content">
                <p>
                    Some of our courses or materials require payment. By purchasing, you agree to our pricing, payment terms, and our Refund & Cancellation Policy. All payments are securely processed through third-party gateways.
                </p>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">
                <h2>5. Intellectual Property</h2>
            </div>
            <div class="section-content">
                <p>
                    All content, including videos, text, graphics, and interactive materials, are the property of Schoolwala and are protected by copyright laws. Unauthorized use or distribution is strictly prohibited.
                </p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">
                <h2>6. Limitation of Liability</h2>
            </div>
            <div class="section-content">
                <p>
                    Schoolwala is not liable for any direct, indirect, incidental, or consequential damages resulting from your use of our platform. We strive to provide accurate educational content but do not guarantee specific academic results.
                </p>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">
                <h2>7. Contact Information</h2>
            </div>
            <div class="section-content">
                <p>
                    If you have any questions about these Terms and Conditions, please contact us at team.schoolwala@gmail.com.
                </p>
            </div>
        </div>
    </main>
    
    <div style="text-align: center; margin-top: 30px; padding: 20px; color: #666; font-size: 0.9rem;">
        <p><strong>Schoolwala</strong> is a Brand of the <strong>Sumatra Sales Private Limited</strong></p>
    </div>
</div>
@endsection
