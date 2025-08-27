    <!-- App Promotion Section -->
    <section class="app-section">
      <div
        class="container app-flex"
        style="
          display: flex;
          justify-content: space-between;
          align-items: center;
        ">
        <!-- Left Content -->
        <div class="app-content">
          <h2>Learning At Your Pace<br />Anytime, Anywhere</h2>
          <p>Download the SchoolWala App - India's Popular Learning Platform</p>
          <a href="#" target="_blank">
            <img
              src="{{ asset('./img/play.png') }}"
              alt="Get it on Google Play"
              class="play-btn2"
              style="border-radius: 5px" />
          </a>
        </div>

        <!-- Right Images -->
        <div class="app-images">
          <img
            src="{{ asset('./img/mobile-ad-strip.png') }}"
            alt="App Screenshot"
            class="phone phone-front" />
        </div>
      </div>
    </section>

    <footer>
      <div class="container">
        <div class="footer-content">
          <div class="footer-brand">
            <div class="footer-logo">
              <img src="{{ asset('img/logo.png') }}" class="img-fluid" width="54px" alt="SW" />
            </div>
            <div>
              <div class="brand-name">Schoolwala</div>
              <div class="tagline">Making learning delightful</div>
            </div>
          </div>

          <div class="footer-links">
            <a href="{{ url('privacy-policy') }}">Privacy</a>
            <a href="{{ url('contact') }}">Contact</a>
            <a href="{{ url('aboutus') }}">About Us</a>
            <a href="{{ url('my-class') }}">My Class</a>
          </div>
        </div>

        <div class="footer-bottom">
          <p>&copy; {{ date('Y') }} Schoolwala. All rights reserved.</p>
          <div class="social-links">
            <a href="#"><img src="{{ asset('img/facebook.png') }}" class="img-fluid" width="40" alt="facebook" /></a>
            <a href="#"><img src="{{ asset('img/instagram.png') }}" class="img-fluid" width="40" alt="instagram" /></a>
            <a href="#"><img src="{{ asset('img/social.png') }}" class="img-fluid" width="40" alt="social" /></a>
          </div>
        </div>
      </div>
    </footer>