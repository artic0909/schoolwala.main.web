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

    /* Modern Upload Box */
    .upload-box {
      border: 2px dashed #d1d5db;
      border-radius: 12px;
      background-color: #f9fafb;
      text-align: center;
      padding: 2rem 1rem;
      position: relative;
      transition: all 0.3s ease;
      cursor: pointer;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 150px;
    }

    .upload-box:hover {
      border-color: #4f46e5;
      background-color: #f3f4f6;
    }

    .upload-box input[type="file"] {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
    }

    .upload-box .upload-icon {
      width: 40px;
      height: 40px;
      color: #9ca3af;
      margin-bottom: 10px;
      transition: color 0.3s ease;
    }

    .upload-box:hover .upload-icon {
      color: #4f46e5;
    }

    .upload-box .upload-text {
      color: #4b5563;
      font-size: 0.9rem;
      font-weight: 500;
      margin-bottom: 0;
    }

    .upload-box .upload-hint {
      color: #9ca3af;
      font-size: 0.8rem;
      margin-top: 5px;
    }

    .preview-container {
      display: none;
      width: 100%;
      margin-top: 15px;
      border-radius: 8px;
      overflow: hidden;
      border: 1px solid #e5e7eb;
      position: relative;
    }

    .preview-container img {
      width: 100%;
      height: auto;
      display: block;
    }

    .remove-preview {
      position: absolute;
      top: 8px;
      right: 8px;
      background: rgba(0,0,0,0.6);
      color: white;
      border: none;
      border-radius: 50%;
      width: 28px;
      height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: background 0.2s;
    }

    .remove-preview:hover {
      background: rgba(220, 38, 38, 0.9);
    }

    .btn-submit {
      background: linear-gradient(135deg, #4f46e5, #4338ca);
      color: white;
      font-weight: 600;
      padding: 0.875rem;
      border-radius: 10px;
      border: none;
      width: 100%;
      margin-top: 1.5rem;
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

    .alert-box {
      padding: 1rem;
      border-radius: 10px;
      margin-bottom: 1.5rem;
      font-size: 0.95rem;
      display: flex;
      align-items: flex-start;
      gap: 12px;
      line-height: 1.5;
    }

    .alert-success {
      background-color: #ecfdf5;
      color: #065f46;
      border: 1px solid #a7f3d0;
    }

    .alert-error {
      background-color: #fef2f2;
      color: #991b1b;
      border: 1px solid #fecaca;
    }

    .alert-error a {
      color: #b91c1c;
      text-decoration: underline;
      font-weight: 600;
    }

    .alert-icon {
      flex-shrink: 0;
      width: 20px;
      height: 20px;
      margin-top: 2px;
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

    <!-- Alerts inside the form card -->
    @if (session('success'))
    <div class="alert-box alert-success">
      <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <div>{{ session('success') }}</div>
    </div>
    @endif

    @if (session('error'))
    <div class="alert-box alert-error">
      <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <div>{!! session('error') !!}</div>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert-box alert-error">
      <svg class="alert-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <div>
        @foreach ($errors->all() as $error)
            <div style="margin-bottom: 4px;">{{ $error }}</div>
        @endforeach
      </div>
    </div>
    @endif

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
        <label class="form-label">Upload Screenshot</label>
        
        <div class="upload-box" id="uploadBox">
          <svg class="upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
          </svg>
          <p class="upload-text">Click or drag image to upload</p>
          <p class="upload-hint">SVG, PNG, JPG or GIF (max. 5MB)</p>
          <input
            type="file"
            id="screenshot"
            name="screenshot"
            accept="image/*"
            required />
        </div>

        <div class="preview-container" id="previewContainer">
          <button type="button" class="remove-preview" id="removePreview" title="Remove image">×</button>
          <img id="imagePreview" src="" alt="Screenshot Preview" />
        </div>
      </div>

      <button type="submit" class="btn-submit">Submit Details</button>
    </form>

    <a href="{{ url('/') }}" class="back-link">
      &larr; Return to Home
    </a>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Image Preview Logic
      const uploadBox = document.getElementById('uploadBox');
      const fileInput = document.getElementById('screenshot');
      const previewContainer = document.getElementById('previewContainer');
      const imagePreview = document.getElementById('imagePreview');
      const removePreviewBtn = document.getElementById('removePreview');

      fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            imagePreview.src = e.target.result;
            uploadBox.style.display = 'none';
            previewContainer.style.display = 'block';
          }
          reader.readAsDataURL(file);
        }
      });

      removePreviewBtn.addEventListener('click', function() {
        fileInput.value = ''; // clear input
        imagePreview.src = '';
        previewContainer.style.display = 'none';
        uploadBox.style.display = 'flex';
      });
    });
  </script>
</body>

</html>
