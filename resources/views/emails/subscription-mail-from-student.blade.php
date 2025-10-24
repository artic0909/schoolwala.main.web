<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Subscription Payment - Schoolwala</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #8a6de9 0%, #6c5ce7 100%);
            padding: 25px 20px;
            text-align: center;
            color: white;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .tagline {
            font-size: 16px;
            opacity: 0.9;
            margin: 0;
        }
        
        .content {
            padding: 25px;
        }
        
        .alert-banner {
            background-color: #e6f7ff;
            border: 1px solid #b3e0ff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .alert-banner h2 {
            margin: 0 0 10px;
            color: #0066cc;
        }
        
        .details-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .detail-section {
            margin-bottom: 20px;
        }
        
        .detail-section:last-child {
            margin-bottom: 0;
        }
        
        .section-title {
            color: #6c5ce7;
            font-size: 18px;
            margin-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 5px;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 8px;
        }
        
        .detail-label {
            font-weight: bold;
            width: 140px;
            flex-shrink: 0;
        }
        
        .detail-value {
            color: #555;
        }
        
        .receipt-section {
            text-align: center;
            margin: 25px 0;
        }
        
        .receipt-image {
            max-width: 300px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 10px auto;
        }
        
        .action-buttons {
            text-align: center;
            margin: 25px 0;
        }
        
        .action-button {
            display: inline-block;
            background-color: #ff9f43;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            margin: 0 10px;
        }
        
        .footer {
            background-color: #f0f0f0;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
        
        @media (max-width: 600px) {
            .content {
                padding: 15px;
            }
            
            .detail-row {
                flex-direction: column;
            }
            
            .detail-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">Schoolwala</div>
            <p class="tagline">New Subscription Payment Received</p>
        </div>
        
        <div class="content">
            <div class="alert-banner">
                <h2>📬 New Payment Submission</h2>
                <p>A student has submitted a payment receipt for verification</p>
            </div>
            
            <div class="details-card">
                <div class="detail-section">
                    <h3 class="section-title">Student Information</h3>
                    
                    <div class="detail-row">
                        <span class="detail-label">Student Name:</span>
                        <span class="detail-value">{{ $student_name }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">{{ $email }}</span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Phone:</span>
                        <span class="detail-value">{{ $phone }}</span>
                    </div>
                </div>
                
                <div class="detail-section">
                    <h3 class="section-title">Subscription Details</h3>
                    
                    <div class="detail-row">
                        <span class="detail-label">Class:</span>
                        <span class="detail-value">
                            @php
                                $className = \App\Models\Classes::find($class_id)->name ?? 'Class ID: ' . $class_id;
                            @endphp
                            {{ $className }}
                        </span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Fees:</span>
                        <span class="detail-value">
                            @php
                                $feeName = \App\Models\Fees::find($fees_id)->name ?? '₹: ' . $amount;
                            @endphp
                            {{ $feeName }}
                        </span>
                    </div>
                    
                    <div class="detail-row">
                        <span class="detail-label">Submission Date:</span>
                        <span class="detail-value">{{ now()->format('F j, Y \a\t g:i A') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="receipt-section">
                <h3 class="section-title">Payment Receipt</h3>
                
                @if($receipt)
                    <img src="{{ $receipt }}" alt="Payment Receipt" class="receipt-image">
                @else
                    <p style="color: #ff6b6b;">No receipt image provided</p>
                @endif
            </div>

            
            <div style="text-align: center; margin-top: 20px; padding: 15px; background-color: #f0f8f0; border-radius: 8px;">
                <p><strong>Status:</strong> <span style="color: #ff9f43;">Pending Verification</span></p>
                <p>We will verify the payment receipt and activate your subscription.</p>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Schoolwala. All rights reserved.</p>
        </div>
    </div>
</body>
</html>