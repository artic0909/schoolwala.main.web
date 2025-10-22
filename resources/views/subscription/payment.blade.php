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

        .qr-container {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: var(--light);
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .qr-code {
            max-width: 250px;
            width: 100%;
            border-radius: 15px;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .qr-instructions {
            margin-top: 15px;
            font-size: 0.95rem;
            color: var(--dark);
        }

        .form-container {
            background-color: var(--light);
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
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

        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-upload-label {
            display: block;
            padding: 15px;
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

        .file-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
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

        .decoration {
            position: absolute;
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
            <p class="subtitle">Complete your school fee payment easily</p>
        </header>

        <section class="payment-section">
            <div class="qr-container">
                <h2>Scan to Pay</h2>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://schoolwala.com/payment"
                    alt="QR Code for Payment" class="qr-code">
                <p class="qr-instructions">Scan this QR code with any UPI app to make payment</p>
            </div>

            <div class="form-container">
                <h2>Payment Details</h2>
                <p style="margin-bottom: 20px;">Please fill in your details after making the payment</p>

                <form id="payment-form">
                    <div class="form-group">
                        <label for="student-name">Student Name</label>
                        <input type="text" id="student-name" placeholder="Enter your full name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" placeholder="Enter your phone number" required>
                    </div>

                    <div class="form-group">
                        <label for="class">Class Name</label>
                        <input type="text" id="class" placeholder="Class" required>

                    </div>

                    <div class="form-group">
                        <label for="receipt">Upload Payment Screenshot/ Receipt</label>
                        <div class="file-upload">
                            <label class="file-upload-label" for="receipt">
                                <span>Click to upload screenshot of payment</span>
                            </label>
                            <input type="file" id="receipt" accept="image/*" required>
                        </div>
                    </div>

                    <button type="submit" class="continue-btn">Continue</button>
                </form>
            </div>
        </section>
    </div>

    <footer>
        <p>© 2023 Schoolwala. All rights reserved.</p>
    </footer>

</body>

</html>