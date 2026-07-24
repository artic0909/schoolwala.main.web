<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Schoolwala — Referral Submission</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('logofav.png') }}" />
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
      padding: 2rem;
    }

    .referral-card {
      background: #ffffff;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
      padding: 3rem 2.5rem;
      width: 100%;
      max-width: 480px;
      position: relative;
      overflow: hidden;
    }

    .referral-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 6px;
      background: linear-gradient(90deg, #4f46e5, #ec4899);
    }

    .brand-logo {
      width: 80px;
      height: auto;
      margin-bottom: 1.5rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .page-title {
      font-size: 1.75rem;
      font-weight: 700;
      color: #111827;
      margin-bottom: 0.5rem;
      letter-spacing: -0.025em;
    }

    .page-subtitle {
      font-size: 0.95rem;
      color: #6b7280;
      margin-bottom: 2.5rem;
      line-height: 1.5;
    }

    .form-label {
      font-weight: 500;
      color: #374151;
      font-size: 0.9rem;
      margin-bottom: 0.5rem;
    }

    .form-control {
      border: 1.5px solid #e5e7eb;
      border-radius: 10px;
      padding: 0.75rem 1rem;
      font-size: 0.95rem;
      transition: all 0.2s ease;
      background-color: #f9fafb;
    }

    .form-control:focus {
      border-color: #4f46e5;
      box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
      background-color: #ffffff;
    }

    .form-control::file-selector-button {
      background-color: #f3f4f6;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 6px;
      color: #374151;
      font-weight: 500;
      margin-right: 1rem;
      transition: background-color 0.2s ease;
      cursor: pointer;
    }

    .form-control::file-selector-button:hover {
      background-color: #e5e7eb;
    }

    .btn-submit {
      background: linear-gradient(135deg, #4f46e5, #4338ca);
      color: white;
      font-weight: 600;
      padding: 0.875rem;
      border-radius: 10px;
      border: none;
      width: 100%;
      margin-top: 1rem;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 16px rgba(79, 70, 229, 0.4);
      background: linear-gradient(135deg, #4338ca, #3730a3);
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 1.5rem;
      color: #6b7280;
      text-decoration: none;
      font-size: 0.9rem;
      font-weight: 500;
      transition: color 0.2s ease;
    }

    .back-link:hover {
      color: #111827;
    }

    /* Popup Animations */
    .custom-popup {
      position: fixed;
      top: 24px;
      right: 24px;
      padding: 1rem 1.25rem;
      border-radius: 12px;
      color: white;
      z-index: 9999;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      animation: slideInRight 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards, fadeOut 0.4s ease 5.6s forwards;
      max-width: 380px;
      font-size: 0.95rem;
      line-height: 1.5;
      display: flex;
      align-items: flex-start;
      gap: 12px;
    }

    .popup-success {
      background-color: #10b981;
      border-left: 4px solid #059669;
    }

    .popup-error {
      background-color: #ef4444;
      border-left: 4px solid #b91c1c;
    }

    .popup-error a {
      color: #fef08a;
      text-decoration: underline;
      font-weight: 500;
    }

    .popup-icon {
      flex-shrink: 0;
      width: 20px;
      height: 20px;
      margin-top: 2px;
    }

    @keyframes slideInRight {
      0% {
        opacity: 0;
        transform: translateX(50px);
      }
      100% {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @keyframes fadeOut {
      0% {
        opacity: 1;
        transform: translateY(0);
      }
      100% {
        opacity: 0;
        transform: translateY(-20px);
      }
    }
  </style>
</head>

<body>

  <div class="referral-card">
    <div class="text-center">
      <img src="{{ asset('img/logo.png') }}" class="brand-logo" alt="Schoolwala" />
      <h1 class="page-title">Submit Details</h1>
      <p class="page-subtitle">Provide your information below to proceed with your request.</p>
    </div>

    <form id="referralForm" action="{{ route('referral.submit') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="mb-4">
        <label class="form-label" for="student_id">Student ID</label>
        <input
          type="text"
          id="student_id"
          class="form-control"
          placeholder="e.g. 25-SW-CLASS8-02"
          name="student_id"
          value="{{ old('student_id') }}"
          required />
      </div>

      <div class="mb-4">
        <label class="form-label" for="screenshot">Upload Screenshot</label>
        <input
          type="file"
          id="screenshot"
          class="form-control"
          name="screenshot"
          accept="image/*"
          required />
      </div>

      <button type="submit" class="btn-submit">Submit Details</button>
    </form>

    <a href="{{ url('/') }}" class="back-link">
      &larr; Return to Home
    </a>
  </div>


  <!-- Alerts -->
  @if (session('success'))
  <div id="successPopup" class="custom-popup popup-success">
    <svg class="popup-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <div>{{ session('success') }}</div>
  </div>
  @endif

  @if (session('error'))
  <div id="errorPopup" class="custom-popup popup-error">
    <svg class="popup-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <div>{!! session('error') !!}</div>
  </div>
  @endif

  @if ($errors->any())
  <div id="validationPopup" class="custom-popup popup-error">
    <svg class="popup-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <div>
      @foreach ($errors->all() as $error)
          <div style="margin-bottom: 4px;">{{ $error }}</div>
      @endforeach
    </div>
  </div>
  @endif

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Popups automatically fade out via CSS animation, but we can clean them up from DOM
      const popups = document.querySelectorAll('.custom-popup');
      popups.forEach(popup => {
        setTimeout(() => {
          popup.remove();
        }, 6000); // 6s matches the CSS animation duration
      });
    });
  </script>
</body>

</html>
