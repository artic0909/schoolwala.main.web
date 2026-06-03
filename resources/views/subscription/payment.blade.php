<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Payment - Schoolwala</title>
    <style>
        :root {
            --primary: #5b6bf0;
            --secondary: #ff7b9c;
            --accent: #6bc4a6;
            --light: #f9f7fe;
            --dark: #333366;
            --text: #444444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', 'Comic Sans MS', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #e0f7fa 0%, #f8bbd0 100%);
            color: var(--text);
            min-height: 100vh;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            max-width: 800px;
            width: 100%;
            background-color: white;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-top: 20px;
        }

        header {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            padding: 25px;
            text-align: center;
            position: relative;
        }

        h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .payment-section {
            padding: 30px;
        }

        /* Alert Styles */
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease-out;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }

        .alert ul {
            margin: 10px 0 0 20px;
            padding: 0;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Course Info Box */
        .course-info-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .course-info-box h3 {
            font-size: 1.3rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .course-info-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .course-info-item:last-child {
            border-bottom: none;
        }

        .course-info-label {
            font-weight: 600;
            opacity: 0.9;
        }

        .course-info-value {
            font-weight: 700;
        }

        .qr-container {
            text-align: center;
            margin-bottom: 30px;
            padding: 25px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .qr-container h2 {
            color: var(--dark);
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .qr-code {
            max-width: 250px;
            width: 100%;
            border-radius: 15px;
            border: 5px solid white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            background: white;
            padding: 10px;
        }

        .amount-display {
            margin-top: 20px;
            font-size: 1.8rem;
            font-weight: 800;
            color: #28a745;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .qr-instructions {
            margin-top: 15px;
            font-size: 0.95rem;
            color: var(--dark);
            font-weight: 600;
        }

        .form-container {
            background-color: var(--light);
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .form-container h2 {
            color: var(--dark);
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        label .required {
            color: #dc3545;
            margin-left: 3px;
        }

        input,
        select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: white;
        }

        input:focus,
        select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(91, 107, 240, 0.2);
            outline: none;
        }

        input[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-upload-label {
            display: block;
            padding: 20px;
            background: white;
            border: 2px dashed #e0e0e0;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .file-upload-label:hover {
            border-color: var(--primary);
            background-color: rgba(91, 107, 240, 0.05);
        }

        .file-upload-label span {
            color: var(--text);
            font-weight: 500;
        }

        .file-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-hint {
            display: block;
            margin-top: 8px;
            font-size: 0.85rem;
            color: #666;
        }

        .continue-btn {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 16px 30px;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 50px;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s;
            box-shadow: 0 5px 15px rgba(91, 107, 240, 0.4);
            margin-top: 10px;
        }

        .continue-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(91, 107, 240, 0.6);
        }

        .continue-btn:active {
            transform: translateY(0);
        }

        .continue-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .decoration {
            position: fixed;
            z-index: -1;
        }

        .decoration-1 {
            top: 10%;
            left: 5%;
            width: 100px;
            height: 100px;
            background-color: rgba(255, 123, 156, 0.2);
            border-radius: 50%;
        }

        .decoration-2 {
            bottom: 10%;
            right: 5%;
            width: 150px;
            height: 150px;
            background-color: rgba(91, 107, 240, 0.15);
            border-radius: 50%;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: var(--dark);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .container {
                border-radius: 20px;
            }

            h1 {
                font-size: 1.8rem;
            }

            .payment-section {
                padding: 20px;
            }

            .qr-code {
                max-width: 200px;
            }

            .amount-display {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .container {
                border-radius: 15px;
            }

            header {
                padding: 20px 15px;
            }

            h1 {
                font-size: 1.6rem;
            }

            .payment-section {
                padding: 15px;
            }

            .form-container {
                padding: 20px;
            }
        }

        /* Note Box Style */
        .note-box {
            background-color: #fff9db;
            border-left: 5px solid #fab005;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.5s ease-in;
        }

        .note-icon {
            font-size: 1.5rem;
        }

        .note-text {
            color: #856404;
            font-weight: 600;
            line-height: 1.4;
            font-size: 0.95rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="decoration decoration-1"></div>
    <div class="decoration decoration-2"></div>

    <div class="container">
        <header>
            <div>
                <img src="{{ asset('img/logo.png') }}" alt="logo" width="40">
                <h1>Make Payment</h1>
            </div>
            <p class="subtitle">Complete your subscription payment easily</p>
        </header>

        <section class="payment-section">
            <!-- Success/Error Messages -->
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

            @if($errors->any())
            <div class="alert alert-danger">
                <strong>Please fix the following errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Note Section -->
            <div class="note-box">
                <div class="note-icon">💡</div>
                <div class="note-text">
                    Complete the payment and upload the screenshot or receipt to get one month of access to all videos, notes, tests, and study materials for this class.
                </div>
            </div>

            <!-- Course Information -->
            <div class="course-info-box">
                <h3>📚 Subscription Details</h3>
                <div class="course-info-item">
                    <span class="course-info-label">Class:</span>
                    <span class="course-info-value">{{ $class->name }}</span>
                </div>
                <div class="course-info-item">
                    <span class="course-info-label">Student:</span>
                    <span class="course-info-value">{{ $student->student_name }}</span>
                </div>
                <div class="course-info-item">
                    <span class="course-info-label">Email:</span>
                    <span class="course-info-value">{{ $student->email }}</span>
                </div>
            </div>

            <!-- Removed QR Code Section as it's no longer needed for Razorpay -->

            <!-- Payment Form -->
            <div class="form-container">
                <h2>Payment Details</h2>
                <p style="margin-bottom: 20px; color: #666;">Please verify your details before proceeding to payment.</p>

                <form id="payment-form" action="{{ route('student.razorpay-callback') }}" method="POST">
                    @csrf

                    <!-- Hidden Fields -->
                    <input type="hidden" name="class_id" value="{{ $class->id }}">
                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                    <input type="hidden" name="fees_id" value="{{ $fees->id ?? '' }}">
                    
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                    <input type="hidden" name="razorpay_signature" id="razorpay_signature">

                    <div class="form-group">
                        <label for="student-name">Student Name</label>
                        <input type="text"
                            id="student-name"
                            name="student_name"
                            value="{{ $student->student_name }}"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email"
                            id="email"
                            name="email"
                            value="{{ $student->email }}"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="class">Class Name</label>
                        <input type="text"
                            id="class"
                            value="{{ $class->name }}"
                            readonly>
                    </div>

                    @if($fees)
                    <div class="form-group">
                        <label for="amount">Amount to Pay</label>
                        <input type="text"
                            id="amount"
                            value="₹{{ number_format($fees->amount, 2) }}"
                            readonly
                            style="font-weight: bold; font-size: 1.1rem; color: #28a745;">
                    </div>
                    @endif

                    <button type="button" class="continue-btn" id="rzp-button1">Pay with Razorpay</button>
                </form>
            </div>
        </section>
    </div>

    <footer>
        <p>© 2025 Schoolwala. All rights reserved.</p>
    </footer>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "{{ config('services.razorpay.key') }}", // Enter the Key ID generated from the Dashboard
            "amount": "{{ $fees->amount * 100 }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
            "currency": "INR",
            "name": "Schoolwala",
            "description": "Subscription for {{ $class->name }}",
            "image": "{{ asset('img/logo.png') }}",
            "order_id": "{{ $razorpayOrderId }}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
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
                "color": "#5b6bf0"
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