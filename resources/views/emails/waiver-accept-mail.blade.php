<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiver Accepted - Schoolwala</title>
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
        
        .celebration-banner {
            text-align: center;
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
        }
        
        .celebration-icon {
            font-size: 60px;
            margin-bottom: 15px;
        }
        
        .celebration-banner h1 {
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
        
        .child-highlight {
            text-align: center;
            background-color: #fff9e6;
            border: 2px solid #ff9f43;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .child-avatar {
            width: 80px;
            height: 80px;
            background-color: #6c5ce7;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: white;
        }
        
        .benefits-section {
            margin: 30px 0;
        }
        
        .benefits-title {
            color: #6c5ce7;
            text-align: center;
            font-size: 22px;
            margin-bottom: 20px;
        }
        
        .benefit-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 15px;
            background-color: white;
            border-radius: 10px;
            border-left: 4px solid #4CAF50;
        }
        
        .benefit-icon {
            font-size: 24px;
            margin-right: 15px;
            width: 40px;
            text-align: center;
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
        
        .step {
            display: flex;
            margin-bottom: 15px;
            padding: 12px;
            background-color: white;
            border-radius: 10px;
        }
        
        .step-number {
            background-color: #ff9f43;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .login-details {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background-color: #f0fff0;
            border-radius: 15px;
            border: 2px dashed #4CAF50;
        }
        
        .credentials {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            display: inline-block;
            text-align: left;
        }
        
        .action-button {
            display: inline-block;
            background-color: #ff9f43;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 18px;
            margin-top: 15px;
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
            
            .step {
                flex-direction: column;
            }
            
            .step-number {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">Schoolwala</div>
            <p class="tagline">Congratulations! Your Free Education Apllication is Accepted</p>
        </div>
        
        <div class="content">
            <div class="celebration-banner">
                <div class="celebration-icon">🎉</div>
                <h1>Great News! Your Free Education Apllication is Accepted!</h1>
            </div>
            
            <div class="greeting">
                Dear {{ $p_name }},
            </div>
            
            <div class="message-box">
                <p>We are absolutely thrilled to inform you that your application for free education access has been <strong>approved</strong>!</p>
                
                <p>After careful review of your situation, our committee has decided to grant <strong>{{ $c_name }}</strong> full access to the Schoolwala educational portal at no cost.</p>
                
                <p>We believe every child deserves quality education, and we're honored to support {{ $c_name }}'s learning journey.</p>
            </div>
            
            <div class="child-highlight">
                <div class="child-avatar">👧</div>
                <h2 style="color: #6c5ce7; margin: 0 0 10px;">Welcome to Schoolwala, {{ $c_name }}!</h2>
                <p style="margin: 0;">We're so excited to have you join our learning community!</p>
            </div>
            
            <div class="benefits-section">
                <h3 class="benefits-title">🌈 What's Included in Your Free Access</h3>
                
                <div class="benefit-item">
                    <div class="benefit-icon">📚</div>
                    <div>
                        <strong>Full Curriculum Access</strong><br>
                        Complete educational materials for {{ $class_name }}
                    </div>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">🎨</div>
                    <div>
                        <strong>Interactive Learning Activities</strong><br>
                        Games, quizzes, and creative projects
                    </div>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">👨‍🏫</div>
                    <div>
                        <strong>Teacher Support</strong><br>
                        Access to our educators for questions
                    </div>
                </div>
                
                <div class="benefit-item">
                    <div class="benefit-icon">📱</div>
                    <div>
                        <strong>Mobile & Desktop Access</strong><br>
                        Learn anytime, anywhere
                    </div>
                </div>
            </div>
            
            <div class="next-steps">
                <h3>🚀 Getting Started</h3>
                
                <div class="step">
                    <div class="step-number">1</div>
                    <div>
                        <strong>Access Your Account</strong><br>
                        Use the credentials below to log in to the Schoolwala portal
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <div>
                        <strong>Explore the Dashboard</strong><br>
                        Familiarize yourself with the learning materials and activities
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <div>
                        <strong>Start Learning</strong><br>
                        Begin with the recommended starting point for {{ $class_name }}
                    </div>
                </div>
            </div>
            
            <div class="login-details">
                <h3 style="color: #4CAF50; margin-top: 0;">Your Login Details</h3>
                
                <div class="credentials">
                    <strong>Website:</strong> https://schoolwala.info/student-login<br>
                    <strong>Username:</strong> {{ $email }}<br>
                    <strong>Password:</strong> {{ $password }}
                </div>
                
                <a href="https://schoolwala.info/student-login" class="action-button">
                    🎓 Start Learning Now!
                </a>
                
                <p style="margin-top: 15px; font-size: 14px;">
                    <strong>Note:</strong> For security, please change your password after first login
                </p>
            </div>
            
            <div class="contact-info">
                <p><strong>Need help getting started?</strong></p>
                <p>📞 Call us: (123) 456-7890 | 📧 Email: support@schoolwala.info</p>
                <p>Our team is available Monday-Friday, 9AM-5PM to assist you</p>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <p>We're so excited to welcome {{ $c_name }} to the Schoolwala family!</p>
                <p style="color: #6c5ce7; font-weight: bold;">Happy Learning! 🌟</p>
                <p>The Schoolwala Team</p>
            </div>
        </div>
        
        <div class="footer">
            <p style="margin-top: 15px; font-size: 14px;">&copy; 2025 Schoolwala. All rights reserved.</p>
        </div>
    </div>
</body>
</html>