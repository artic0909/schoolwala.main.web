<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment - Schoolwala</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('logofav.png') }}" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --surface: #ffffff;
            --background: #f3f4f6;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border: #e5e7eb;
            --success: #10b981;
            --danger: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--background);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 60px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .header p {
            color: var(--text-muted);
            margin-top: 5px;
            font-size: 0.95rem;
        }

        .payment-container {
            max-width: 600px;
            width: 100%;
            background: var(--surface);
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .order-summary {
            background: #f8fafc;
            padding: 25px 30px;
            border-bottom: 1px solid var(--border);
        }

        .order-summary h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 0.95rem;
        }

        .summary-item:not(:last-child) {
            border-bottom: 1px dashed var(--border);
        }

        .summary-label {
            color: var(--text-muted);
        }

        .summary-value {
            font-weight: 500;
            color: var(--text-main);
            text-align: right;
        }

        .total-row {
            margin-top: 10px;
            padding-top: 15px;
            border-top: 2px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-label {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .total-amount {
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--primary);
        }

        .payment-form-section {
            padding: 30px;
        }

        .payment-form-section h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-main);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--text-main);
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            color: var(--text-main);
            background-color: #f9fafb;
            transition: all 0.2s;
        }

        .form-control[readonly] {
            cursor: not-allowed;
            color: var(--text-muted);
        }

        .pay-btn {
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            padding: 14px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .pay-btn:hover {
            background: var(--primary-hover);
        }

        .secure-badge {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .secure-badge svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }

        /* Alerts */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        footer {
            margin-top: 40px;
            color: var(--text-muted);
            font-size: 0.85rem;
            text-align: center;
        }

        @media (max-width: 640px) {
            body {
                padding: 20px 15px;
            }
            .payment-container {
                border-radius: 10px;
            }
            .order-summary, .payment-form-section {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ asset('img/logo.png') }}" alt="Schoolwala Logo">
        <h1>Secure Checkout</h1>
        <p>Complete your subscription payment to access all course materials</p>
    </div>

    <div class="payment-container">
        
        <div class="order-summary">
            <h3>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
                Order Summary
            </h3>
            
            <div class="summary-item">
                <span class="summary-label">Class Subscription</span>
                <span class="summary-value">{{ $class->name }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Student Name</span>
                <span class="summary-value">{{ $student->student_name }}</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Access Duration</span>
                <span class="summary-value">30 Days</span>
            </div>
            
            <div class="total-row">
                <span class="total-label">Total to Pay</span>
                <span class="total-amount">₹{{ number_format($fees->amount ?? 0, 2) }}</span>
            </div>
        </div>

        <div class="payment-form-section">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <form id="payment-form" action="{{ route('student.razorpay-callback') }}" method="POST">
                @csrf
                <input type="hidden" name="class_id" value="{{ $class->id }}">
                <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                <input type="hidden" name="fees_id" value="{{ $fees->id ?? '' }}">
                
                <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                <input type="hidden" name="razorpay_signature" id="razorpay_signature">

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" value="{{ $student->email }}" readonly>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" class="form-control" id="phone" value="{{ $student->mobile ?? 'N/A' }}" readonly>
                </div>

                <button type="button" class="pay-btn" id="rzp-button1">
                    Pay ₹{{ number_format($fees->amount ?? 0, 2) }} securely
                </button>
            </form>

            <div class="secure-badge">
                <svg viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
                Payments are 100% secure and encrypted
            </div>
        </div>
    </div>

    <footer>
        <p>© {{ date('Y') }} Schoolwala. All rights reserved.</p>
    </footer>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ config('services.razorpay.key') }}", 
            "amount": "{{ ($fees->amount ?? 0) * 100 }}", 
            "currency": "INR",
            "name": "Schoolwala",
            "description": "Subscription for {{ $class->name }}",
            "image": "{{ asset('img/logo.png') }}",
            "order_id": "{{ $razorpayOrderId }}", 
            "handler": function (response){
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                document.getElementById('payment-form').submit();
            },
            "prefill": {
                "name": "{{ $student->student_name }}",
                "email": "{{ $student->email }}",
                "contact": "{{ $student->mobile ?? '' }}"
            },
            "theme": {
                "color": "#4f46e5"
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function (response){
            alert("Payment Failed. Reason: " + response.error.description);
        });
        document.getElementById('rzp-button1').onclick = function(e){
            rzp1.open();
            e.preventDefault();
        }
    </script>
</body>

</html>