<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Schoolwala!</title>
    <style>
        /* Base styles */
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Header section */
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

        /* Content sections */
        .content {
            padding: 30px;
        }

        .welcome-message {
            text-align: center;
            margin-bottom: 30px;
        }

        .welcome-message h1 {
            color: #6c5ce7;
            font-size: 28px;
            margin-bottom: 15px;
        }

        .welcome-message p {
            font-size: 16px;
            line-height: 1.6;
        }

        .features {
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin: 30px 0;
        }

        .feature {
            flex-basis: 48%;
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f0edff;
            border-radius: 15px;
        }

        .feature-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .feature h3 {
            margin: 10px 0;
            color: #6c5ce7;
        }

        .cta-section {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background-color: #f9f6ff;
            border-radius: 15px;
        }

        .cta-button {
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

        .cta-button:hover {
            background-color: #ffaf60;
            transform: translateY(-3px);
        }

        /* Footer */
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

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .feature {
                flex-basis: 100%;
            }

            .content {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">Schoolwala</div>
            <p class="tagline">Fun tuition for curious kids</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="welcome-message">
                <h1>Welcome to Schoolwala!</h1>
                <p>Hello {{ $student->parent_name }},</p>
                <p>We're so excited to welcome {{ $student->student_name }} to our Schoolwala family! Get ready for a wonderful
                    learning adventure filled with fun activities, creative projects, and new friends.</p>
            </div>

            <div class="cta-section">
                <h2>Student Details</h2>
                <p style="margin: 0;">Student ID: {{ $student->student_id }}</p>
                <p style="margin: 0;">Name: {{ $student->student_name }}</p>
                <p style="margin: 0;">Email: {{ $student->email }}</p>
            </div>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon">🎓</div>
                    <h3>Fun Learning</h3>
                    <p>Interactive lessons that make education exciting</p>
                </div>

                <div class="feature">
                    <div class="feature-icon">🧩</div>
                    <h3>Practice & Play</h3>
                    <p>Quiz-based learning and interactive activities</p>
                </div>

                <div class="feature">
                    <div class="feature-icon">🎨</div>
                    <h3>Creative Activities</h3>
                    <p>Arts, crafts, and projects to spark imagination</p>
                </div>

                <div class="feature">
                    <div class="feature-icon">📚</div>
                    <h3>Learning Resources</h3>
                    <p>Access to our extensive library of materials</p>
                </div>
            </div>



            <div style="text-align: center; margin-top: 30px;">
                <p><strong>Need help?</strong> Our friendly team is here to assist you!</p>
                <p>Email: help@schoolwala.info | Phone: (123) 456-7890</p>
            </div>
        </div>

        <!-- Footer -->
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