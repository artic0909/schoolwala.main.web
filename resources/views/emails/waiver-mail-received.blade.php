<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Waiver Form Submission - Schoolwala</title>
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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

        .alert-banner {
            background-color: #fff9e6;
            border: 2px dashed #ff9f43;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            margin-bottom: 25px;
        }

        .alert-banner .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .waiver-details {
            background-color: #f0edff;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
        }

        .detail-section {
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px dotted #d1c7ff;
        }

        .detail-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            color: #6c5ce7;
            font-size: 20px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .section-title .icon {
            margin-right: 10px;
            font-size: 24px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 12px;
            padding: 8px 0;
        }

        .detail-label {
            font-weight: bold;
            color: #6c5ce7;
            width: 120px;
            flex-shrink: 0;
        }

        .detail-value {
            color: #5a4a7a;
            flex-grow: 1;
        }

        .address-box {
            background-color: white;
            padding: 12px;
            border-radius: 8px;
            border-left: 4px solid #ff9f43;
            margin-top: 5px;
        }

        .action-buttons {
            text-align: center;
            margin-top: 30px;
        }

        .action-button {
            display: inline-block;
            background-color: #ff9f43;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            margin: 0 10px;
            box-shadow: 0 4px 10px rgba(255, 159, 67, 0.3);
            transition: all 0.3s ease;
        }

        .action-button:hover {
            background-color: #ffaf60;
            transform: translateY(-3px);
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
            <p class="tagline">New Waiver Form Submission!</p>
        </div>

        <div class="content">
            <div class="alert-banner">
                <div class="icon">📝</div>
                <h2 style="margin: 0; color: #ff9f43;">New Waiver Form Received!</h2>
                <p style="margin: 10px 0 0;">A parent has submitted a waiver form for their child.</p>
            </div>

            <h2 class="title">Waiver Form Details</h2>

            <div class="waiver-details">
                <!-- Child Information Section -->
                <div class="detail-section">
                    <h3 class="section-title">
                        <span class="icon">👶</span>
                        Child Information
                    </h3>

                    <div class="detail-row">
                        <span class="detail-label">Child's Name:</span>
                        <span class="detail-value">{{ $c_name }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Age:</span>
                        <span class="detail-value">{{ $c_age }} years old</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Class:</span>
                        <span class="detail-value">
                            @php
                            // Assuming you have a way to get class name from class_id
                            $className = \App\Models\Classes::find($class_id)->name ?? 'Class ID: ' . $class_id;
                            @endphp
                            {{ $className }}
                        </span>
                    </div>
                </div>

                <!-- Parent/Guardian Information Section -->
                <div class="detail-section">
                    <h3 class="section-title">
                        <span class="icon">👨‍👩‍👧‍👦</span>
                        Parent/Guardian Information
                    </h3>

                    <div class="detail-row">
                        <span class="detail-label">Parent's Name:</span>
                        <span class="detail-value">{{ $p_name }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">{{ $email }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">Mobile:</span>
                        <span class="detail-value">{{ $mobile }}</span>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="detail-section">
                    <h3 class="section-title">
                        <span class="icon">🏠</span>
                        Address
                    </h3>

                    <div class="detail-row">
                        <div class="address-box">
                            {{ $address }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="#" class="action-button">View Full Application</a>
                <a href="mailto:{{ $email }}" class="action-button">Contact Parent</a>
            </div>

            <div style="text-align: center; margin-top: 30px; padding: 15px; background-color: #e6f7ff; border-radius: 10px;">
                <p><strong>Submission Time:</strong> {{ now()->format('F j, Y \a\t g:i A') }}</p>
                <p>This waiver form was submitted through the Schoolwala website.</p>
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