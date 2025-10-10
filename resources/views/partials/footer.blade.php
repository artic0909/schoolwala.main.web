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
            <a href="{{route ('student.my-class') }}">My Class</a>
            @guest
            <a href="{{route('student.about.view')}}">About Us</a>
            <a href="{{route('student.contact-us')}}">Contact Us</a>
            <a href="{{route('student.privacy.view')}}">Privacy & Policy</a>
            @endguest
            @auth
            <a href="{{route('student.about-us.view')}}">About Us</a>
            <a href="{{route('student.contact-us.view')}}">Contact Us</a>
            <a href="{{route('student.privacy-policy.view')}}">Privacy & Policy</a>
            @endauth
          </div>

          @guest
          <div class="footer-links">
            <a href="{{route('student.contact-us')}}">Book Demo</a>
            <a href="{{route('student.student-login')}}"> Student Login</a>
            <a href="{{route('student.contact-us')}}">Waiver Request</a>
            <a href="{{route('student.school-tuitions')}}">School Tuition</a>
          </div>
          @endguest

          @auth
          <div class="footer-links">
            <a href="{{route('student.student-profile')}}"> My Profile</a>
            <a href="{{route('student.contact-us.view')}}">Waiver Request</a>
            <a href="{{route('student.school-tuitions.view')}}">School Tuition</a>
            <a href="{{route('student.contact-us.view')}}">Book Demo Class</a>
          </div>
          @endauth

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