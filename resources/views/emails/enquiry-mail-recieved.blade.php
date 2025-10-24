<!-- enquiry-mail-received.blade.php - User Confirmation -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Received - Schoolwala</title>
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
            text-align: center;
        }
        
        .title {
            color: #6c5ce7;
            font-size: 28px;
            margin-bottom: 20px;
        }
        
        .confirmation-icon {
            font-size: 80px;
            margin: 20px 0;
        }
        
        .message-box {
            background-color: #f0edff;
            border-radius: 15px;
            padding: 25px;
            margin: 25px 0;
            text-align: left;
        }
        
        .thank-you {
            font-size: 20px;
            color: #6c5ce7;
            margin-bottom: 15px;
        }
        
        .next-steps {
            margin-top: 30px;
            padding: 20px;
            background-color: #fff9e6;
            border-radius: 15px;
            border-left: 4px solid #ff9f43;
        }
        
        .next-steps h3 {
            color: #ff9f43;
            margin-top: 0;
        }
        
        .contact-info {
            margin-top: 25px;
            padding: 15px;
            background-color: #e6f7ff;
            border-radius: 10px;
        }
        
        .footer {
            background-color: #6c5ce7;
            color: white;
            padding: 20px;
            text-align: center;
            border-top-left-radius: 50% 20%;
            border-top-right-radius: 50% 20%;
        }
        
        .social-icons {
            margin: 15px 0;
        }
        
        .social-icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: white;
            border-radius: 50%;
            margin: 0 8px;
            text-align: center;
            line-height: 40px;
            color: #6c5ce7;
            font-weight: bold;
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
            <p class="tagline">We've Received Your Message!</p>
        </div>
        
        <div class="content">
            <div class="confirmation-icon">✅</div>
            
            <h2 class="title">Hello {{ $name }}!</h2>
            
            <div class="message-box">
                <p class="thank-you">Thank you for contacting Schoolwala!</p>
                <p>We have successfully received your enquiry and our team is already looking into it.</p>
                
                <div style="margin: 20px 0; padding: 15px; background-color: white; border-radius: 10px;">
                    <p><strong>Your Enquiry Details:</strong></p>
                    <p><strong>Subject:</strong> {{ $subject }}</p>
                    <p><strong>Message:</strong> {{ $messageContent }}</p>
                </div>
                
                <p>We appreciate you taking the time to reach out to us. Our team will get back to you as soon as possible.</p>
            </div>
            
            <div class="next-steps">
                <h3>What Happens Next?</h3>
                <p>1. Our team will review your message</p>
                <p>2. We'll contact you within 24-48 hours</p>
                <p>3. We'll provide the information or assistance you need</p>
            </div>
            
            <div class="contact-info">
                <p><strong>Need immediate assistance?</strong></p>
                <p>📞 Call us: (123) 456-7890</p>
                <p>📧 Email: help@schoolwala.info</p>
            </div>
        </div>
        
        <div class="footer">
            <!-- <p>Stay connected with us:</p> -->
            <!-- <div class="social-icons">
                <div class="social-icon">f</div>
                <div class="social-icon">t</div>
                <div class="social-icon">in</div>
                <div class="social-icon">ig</div>
            </div> -->
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