<!-- enquiry-mail-send.blade.php - Admin Notification -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Enquiry - Schoolwala</title>
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
        
        .title {
            text-align: center;
            color: #6c5ce7;
            font-size: 24px;
            margin-bottom: 25px;
        }
        
        .enquiry-details {
            background-color: #f0edff;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .detail-row {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #d1c7ff;
        }
        
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .detail-label {
            font-weight: bold;
            color: #6c5ce7;
            display: block;
            margin-bottom: 5px;
        }
        
        .detail-value {
            color: #5a4a7a;
        }
        
        .message-content {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #ff9f43;
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
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">Schoolwala</div>
            <p class="tagline">New Contact Enquiry Received!</p>
        </div>
        
        <div class="content">
            <h2 class="title">📬 New Contact Enquiry</h2>
            
            <div class="enquiry-details">
                <div class="detail-row">
                    <span class="detail-label">👤 Name:</span>
                    <span class="detail-value">{{ $name }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">📧 Email:</span>
                    <span class="detail-value">{{ $email }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">📋 Subject:</span>
                    <span class="detail-value">{{ $subject }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">💌 Message:</span>
                    <div class="message-content">
                        {{ $messageContent }}
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <p>This enquiry was received through the Schoolwala contact form.</p>
                <p><strong>Please respond within 24 hours.</strong></p>
            </div>
        </div>
        
        <div class="footer">
            <div class="footer-links">
                <a href="www.schoolwala.info">Website</a> | 
                <a href="www.schoolwala.info">Privacy Policy</a> | 
                <a href="www.schoolwala.info">Contact Us</a>
            </div>
            <p style="margin-top: 15px; font-size: 14px;">&copy; 2025 Schoolwala. All rights reserved.</p>
        </div>
    </div>
</body>
</html>