<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Status Update - Schoolwala</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background-color: #f9f6ff;
            color: #5a4a7a;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #8a6de9 0%, #6c5ce7 100%);
            padding: 30px 20px;
            text-align: center;
            border-bottom-left-radius: 50% 20%;
            border-bottom-right-radius: 50% 20%;
        }
        
        .logo {
            font-size: 36px;
            font-weight: bold;
            color: white;
            margin-bottom: 10px;
        }
        
        .tagline {
            color: #e6e1ff;
            font-size: 18px;
            margin: 0;
        }
        
        .content {
            padding: 30px;
        }
        
        .status-banner {
            text-align: center;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
        }
        
        .status-banner.active {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
        }
        
        .status-banner.inactive {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a5a 100%);
            color: white;
        }
        
        .status-icon {
            font-size: 60px;
            margin-bottom: 15px;
        }
        
        .status-banner h1 {
            margin: 0;
            font-size: 28px;
        }
        
        .greeting {
            font-size: 20px;
            color: #6c5ce7;
            margin-bottom: 20px;
        }
        
        .message-box {
            background-color: #f0edff;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
        }
        
        .subscription-details {
            background-color: #fff9e6;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #ff9f43;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 12px;
            padding: 8px 0;
        }
        
        .detail-label {
            font-weight: bold;
            color: #6c5ce7;
            width: 150px;
            flex-shrink: 0;
        }
        
        .detail-value {
            color: #5a4a7a;
            flex-grow: 1;
        }
        
        .next-steps {
            background-color: #e6f7ff;
            border-radius: 15px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .next-steps h3 {
            color: #6c5ce7;
            margin-top: 0;
            text-align: center;
        }
        
        .action-button {
            display: inline-block;
            background-color: #ff9f43;
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            margin: 10px;
            box-shadow: 0 4px 10px rgba(255, 159, 67, 0.3);
            transition: all 0.3s ease;
        }
        
        .action-button:hover {
            background-color: #ffaf60;
            transform: translateY(-3px);
        }
        
        .contact-info {
            margin-top: 25px;
            padding: 15px;
            background-color: #f0edff;
            border-radius: 10px;
            text-align: center;
        }
        
        .footer {
            background-color: #6c5ce7;
            color: white;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 50% 20%;
            border-top-right-radius: 50% 20%;
        }
        
        .footer-links a {
            color: #e6e1ff;
            margin: 0 10px;
            text-decoration: none;
        }
        
        @media (max-width: 600px) {
            .content {
                padding: 20px;
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
            <p class="tagline">Subscription Status Update</p>
        </div>
        
        <div class="content">
            <!-- Active Status Banner -->
            @if($status == 'active')
            <div class="status-banner active">
                <div class="status-icon">✅</div>
                <h1>Payment Approved! 🎉</h1>
                <p>Your subscription is now active</p>
            </div>
            
            <div class="greeting">
                Dear {{ $student_name }},
            </div>
            
            <div class="message-box">
                <p>Great news! Your payment has been verified and approved by our admin team.</p>
                <p>Your subscription to <strong>{{ $class_name }}</strong> is now <strong style="color: #4CAF50;">ACTIVE</strong> and you can access all the learning materials immediately!</p>
            </div>
            
            <div class="subscription-details">
                <h3 style="color: #6c5ce7; margin-top: 0; text-align: center;">📚 Subscription Details</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Student Name:</span>
                    <span class="detail-value">{{ $student_name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Class:</span>
                    <span class="detail-value">{{ $class_name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value" style="color: #4CAF50; font-weight: bold;">Active ✅</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Activated On:</span>
                    <span class="detail-value">{{ $subscription_date }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Valid Until:</span>
                    <span class="detail-value">{{ $expiry_date }}</span>
                </div>
            </div>
            
            
            <!-- Inactive Status Banner -->
            @elseif($status == 'inactive')
            <div class="status-banner inactive">
                <div class="status-icon">❌</div>
                <h1>Payment Rejected</h1>
                <p>Subscription not activated</p>
            </div>
            
            <div class="greeting">
                Dear {{ $student_name }},
            </div>
            
            <div class="message-box">
                <p>We regret to inform you that your recent payment submission for <strong>{{ $class_name }}</strong> could not be approved.</p>
                <p>After review, our admin team has marked your subscription as <strong style="color: #ff6b6b;">INACTIVE</strong>.</p>
            </div>
            
            <div class="subscription-details">
                <h3 style="color: #6c5ce7; margin-top: 0; text-align: center;">📋 Application Details</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Student Name:</span>
                    <span class="detail-value">{{ $student_name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Class:</span>
                    <span class="detail-value">{{ $class_name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Status:</span>
                    <span class="detail-value" style="color: #ff6b6b; font-weight: bold;">Inactive ❌</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Submission Date:</span>
                    <span class="detail-value">{{ $subscription_date }}</span>
                </div>
            </div>
            
            <div class="next-steps">
                <h3>🔍 What to Do Next?</h3>
                <p>Common reasons for rejection include:</p>
                <ul style="text-align: left;">
                    <li>Unclear payment receipt image</li>
                    <li>Incorrect payment amount</li>
                    <li>Missing transaction details</li>
                </ul>
            </div>
            @endif
            
            <div class="contact-info">
                <p><strong>Need assistance?</strong></p>
                <p>📞 Call us: 6292237210 | 📧 Email: schoolwala.info@gmail.com</p>
                <p>Our support team is here to help you!</p>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <p>Thank you for choosing Schoolwala for your educational journey!</p>
                <p style="color: #6c5ce7; font-weight: bold;">The Schoolwala Team 🌟</p>
            </div>
        </div>
        
        <div class="footer">
            <p style="margin-top: 15px; font-size: 14px;">&copy; {{ date('Y') }} Schoolwala. All rights reserved.</p>
        </div>
    </div>
</body>
</html>