@extends('layouts.app')

@section('title', 'Refund & Cancellation Policy | Schoolwala | Education For All')

<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
<link rel="stylesheet" href="{{ asset('./css/privacy.css') }}" />

<link
    href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />

@section('content')
<!-- REFUND POLICY -->
<div class="container">
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="#"><i class="fas fa-home"></i> Home</a>
        <span>/</span>
        <span class="current">Refund & Cancellation Policy</span>
    </nav>

    <!-- Header -->
    <header class="privacy-header">
        <div class="privacy-element elem-1"></div>
        <div class="privacy-element elem-2"></div>
        <div class="privacy-element elem-3"></div>
        <div class="privacy-element elem-4"></div>

        <h1 class="hero-title">Refund & Cancellation <span>Policy</span></h1>
        <p class="hero-subtitle">
            We want you to be completely satisfied with your learning experience. Here is our policy regarding refunds and cancellations.
        </p>
    </header>

    <!-- Content -->
    <main class="privacy-content">
        <div class="section">
            <div class="section-title">
                <h2>1. Cancellation Policy</h2>
            </div>
            <div class="section-content">
                <p>
                    You may cancel your subscription or service at any time through your account dashboard. However, cancellation does not automatically qualify you for a refund. Upon cancellation, you will continue to have access to the service until the end of your current billing cycle.
                </p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">
                <h2>2. Refund Eligibility</h2>
            </div>
            <div class="section-content">
                <p>
                    Refunds are generally only provided under the following circumstances:
                </p>
                <ul>
                    <li>If a duplicate payment was accidentally made.</li>
                    <li>If you are unable to access the content due to technical issues on our end that we cannot resolve within a reasonable timeframe.</li>
                    <li>If a refund is requested within 3 days of purchase, provided that less than 10% of the course content has been accessed or viewed.</li>
                </ul>
            </div>
        </div>

        <div class="section">
            <div class="section-title">
                <h2>3. Non-Refundable Scenarios</h2>
            </div>
            <div class="section-content">
                <p>
                    We do not offer refunds in the following cases:
                </p>
                <ul>
                    <li>Change of mind after the 3-day grace period.</li>
                    <li>If you have accessed more than 10% of the purchased content.</li>
                    <li>Violation of our Terms and Conditions resulting in account suspension.</li>
                </ul>
            </div>
        </div>

        <div class="section">
            <div class="section-title">
                <h2>4. Refund Process</h2>
            </div>
            <div class="section-content">
                <p>
                    To request a refund, please contact our support team at team.schoolwala@gmail.com with your order details and reason for the request. If approved, refunds will be processed within 5-7 business days and credited back to the original payment method.
                </p>
            </div>
        </div>

        <div class="section">
            <div class="section-title">
                <h2>5. Contact Us</h2>
            </div>
            <div class="section-content">
                <p>
                    If you have any questions about this Refund & Cancellation Policy, please reach out to us at team.schoolwala@gmail.com.
                </p>
            </div>
        </div>
    </main>
    
    <div style="text-align: center; margin-top: 30px; padding: 20px; color: #666; font-size: 0.9rem;">
        <p><strong>Schoolwala</strong> is a Brand of the <strong>Sumatra Sales Private Limited</strong></p>
    </div>
</div>
@endsection
