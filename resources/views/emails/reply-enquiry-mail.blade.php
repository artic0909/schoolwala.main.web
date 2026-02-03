<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Reply</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }

        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 30px 20px;
            color: #333333;
            line-height: 1.6;
        }

        .email-body p {
            margin: 0 0 15px 0;
        }

        .message-content {
            background-color: #f9f9f9;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .email-footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666666;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ $replySubject }}</h1>
        </div>
        <div class="email-body">
            @if($enquiryName)
                <p>Dear {{ $enquiryName }},</p>
            @else
                <p>Hello,</p>
            @endif

            <p>Thank you for reaching out to us. We have reviewed your enquiry and here is our response:</p>

            <div class="message-content">
                {!! nl2br(e($replyMessage)) !!}
            </div>

            <p>If you have any further questions or need additional assistance, please don't hesitate to contact us.</p>

            <p>Best regards,<br>
                <strong>Schoolwala Team</strong>
            </p>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Schoolwala. All rights reserved.</p>
        </div>
    </div>
</body>

</html>