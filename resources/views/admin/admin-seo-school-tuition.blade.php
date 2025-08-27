@extends('admin.layouts.app')

@section('title', 'School Tuition Page | SEO - Schoolwala')

@section('content')

<style>
  .google-preview {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 8px;
    background: #fff;
    max-width: 600px;
  }

  .google-title {
    color: #1a0dab;
    font-size: 18px;
    margin-bottom: 3px;
  }

  .google-url {
    color: #006621;
    font-size: 14px;
    margin-bottom: 3px;
  }

  .google-description {
    color: #545454;
    font-size: 14px;
  }
</style>

<div class="row">
  <div class="col-lg-12 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary">
              SEO - School Tuition
            </h5>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img
              src="{{ asset('./admin/assets/img/illustrations/man-with-laptop-light.png') }}"
              height="140"
              alt="View Badge User" />
          </div>
        </div>

        <div class="col-lg-12">
          <div class="container">
            <form
              action="/save-seo-home"
              method="POST"
              enctype="multipart/form-data"
              class="p-3">
              <!-- Meta SEO -->
              <div class="mb-3">
                <label class="form-label">Meta Title</label>
                <input
                  type="text"
                  class="form-control"
                  id="seo_title"
                  name="seo_title"
                  maxlength="60"
                  placeholder="Enter meta title (50–60 chars)" />
              </div>
              <div class="mb-3">
                <label class="form-label">Meta Description</label>
                <textarea
                  class="form-control"
                  id="seo_description"
                  name="seo_description"
                  maxlength="160"
                  rows="2"
                  placeholder="Enter meta description (150–160 chars)"></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Meta Keywords</label>
                <input
                  type="text"
                  class="form-control"
                  name="seo_keywords"
                  placeholder="keyword1, keyword2, keyword3" />
              </div>
              <div class="mb-3">
                <label class="form-label">Canonical URL</label>
                <input
                  type="url"
                  class="form-control"
                  id="canonical_url"
                  name="canonical_url"
                  placeholder="https://www.yoursite.com/" />
              </div>

              <!-- Google Search Preview -->
              <h5 class="mt-4 mb-3">Google Search Preview</h5>
              <div class="google-preview mb-4">
                <div class="google-title" id="preview-title">
                  Your Meta Title will appear here
                </div>
                <div class="google-url" id="preview-url">
                  https://www.yoursite.com/
                </div>
                <div
                  class="google-description"
                  id="preview-description">
                  Your meta description will appear here
                </div>
              </div>

              <!-- Open Graph -->
              <h5 class="mt-4 mb-3">
                Open Graph (Social Sharing)
              </h5>
              <div class="mb-3">
                <label class="form-label">OG Title</label>
                <input
                  type="text"
                  class="form-control"
                  name="og_title" />
              </div>
              <div class="mb-3">
                <label class="form-label">OG Description</label>
                <textarea
                  class="form-control"
                  name="og_description"
                  rows="2"></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">OG Image</label>
                <input
                  type="file"
                  class="form-control"
                  name="og_image" />
              </div>
              <div class="mb-3">
                <label class="form-label">OG URL</label>
                <input
                  type="url"
                  class="form-control"
                  name="og_url"
                  placeholder="https://www.yoursite.com/" />
              </div>

              <!-- Twitter Card -->
              <h5 class="mt-4 mb-3">Twitter Card</h5>
              <div class="mb-3">
                <label class="form-label">Twitter Title</label>
                <input
                  type="text"
                  class="form-control"
                  name="twitter_title" />
              </div>
              <div class="mb-3">
                <label class="form-label">Twitter Description</label>
                <textarea
                  class="form-control"
                  name="twitter_description"
                  rows="2"></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Twitter Image</label>
                <input
                  type="file"
                  class="form-control"
                  name="twitter_image" />
              </div>

              <button type="submit" class="btn btn-primary">
                Save Settings
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Live Google Preview Update
  const titleInput = document.getElementById("seo_title");
  const descInput = document.getElementById("seo_description");
  const urlInput = document.getElementById("canonical_url");

  const previewTitle = document.getElementById("preview-title");
  const previewDesc = document.getElementById("preview-description");
  const previewUrl = document.getElementById("preview-url");

  titleInput.addEventListener("input", () => {
    previewTitle.textContent =
      titleInput.value || "Your Meta Title will appear here";
  });
  descInput.addEventListener("input", () => {
    previewDesc.textContent =
      descInput.value || "Your meta description will appear here";
  });
  urlInput.addEventListener("input", () => {
    previewUrl.textContent = urlInput.value || "https://www.yoursite.com/";
  });
</script>

@endsection