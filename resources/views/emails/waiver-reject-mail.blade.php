<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiver Update - Schoolwala</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background-color: #f9f6ff;
            color: #5a4a7a;
        }
        
        .email-container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #8a6de9 0%, #6c5ce7 100%);
            padding: 25px 20px;
            text-align: center;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: white;
            margin-bottom: 5px;
        }
        
        .content {
            padding: 25px;
            text-align: center;
        }
        
        .status-icon {
            font-size: 50px;
            margin: 15px 0;
        }
        
        .message-box {
            background-color: #fff0f0;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #ff6b6b;
        }
        
        .child-name {
            color: #6c5ce7;
            font-weight: bold;
        }
        
        .alternative {
            background-color: #f0edff;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
        }
        
        .contact {
            margin-top: 20px;
            padding: 10px;
            background-color: #e6f7ff;
            border-radius: 10px;
            font-size: 14px;
        }
        
        .footer {
            background-color: #6c5ce7;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">Schoolwala</div>
            <p style="color: #e6e1ff; margin: 0; font-size: 14px;">Waiver Application Update</p>
        </div>
        
        <div class="content">
            <div class="status-icon">💌</div>
            
            <h2 style="color: #6c5ce7; margin: 0 0 15px;">Update on Your Application</h2>
            
            <div class="message-box">
                <p style="margin: 0 0 10px;">Dear <strong>{{ $p_name }}</strong>,</p>
                
                <p style="margin: 0 0 15px;">Thank you for applying for our free education program for <span class="child-name">{{ $c_name }}</span>.</p>
                
                <p style="margin: 0; color: #ff6b6b;">
                    <strong>Unfortunately, we're unable to approve your waiver application at this time.</strong>
                </p>
            </div>
            
            <p>We received many applications and had to make difficult decisions based on our current capacity and criteria.</p>
            
            <div class="contact">
                <p style="margin: 0;"><strong>Have questions?</strong></p>
                <p style="margin: 5px 0 0;">📧 waivers@schoolwala.info</p>
            </div>
            
            <p style="margin-top: 20px; font-size: 14px;">We wish {{ $c_name }} all the best in their learning journey! 🌟</p>
        </div>
        
        <div class="footer">
            <p style="margin: 0;">Schoolwala - Where Learning is Fun!</p>
            <p style="margin: 5px 0 0; font-size: 11px;">&copy; 2023 Schoolwala. All rights reserved.</p>
        </div>
    </div>
</body>
</html>