@php
$currentRoute = request()->path();
@endphp

<!-- NAVBAR -->
<nav class="navbar">
  <div class="container" style="display: flex; justify-content: space-between">
    <a class="brand" href="{{route('student.home')}}">
      <div class="logo">
        <img src="{{ asset('img/logo.png') }}" class="img-fluid" width="54px" alt="SW" />
      </div>
      <div>
        <div class="brand-name">Schoolwala</div>
        <small>Fun tuition for curious kids</small>
      </div>
    </a>

    <div class="menu-toggle" id="menuToggle">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <div class="nav-menu" id="navMenu">
      <ul>
        <li>
          @guest
          <a href="{{ url('school-tuitions') }}" class="{{ request()->is('school-tuitions') ? 'active' : '' }}">
            School Tuitions
          </a>
          @endguest
          @auth
          <a href="{{ url('student/school-tuitions') }}" class="{{ request()->is('student/school-tuitions') ? 'active' : '' }}">
            School Tuitions
          </a>
          @endauth
        </li>
        <li>
          <a href="{{ route('student.my-class') }}" class="{{ request()->is('student/my-class') ? 'active' : '' }}">
            My Class
          </a>
        </li>
        <li>
          <a href="#faq" class="{{ request()->is('faq') ? 'active' : '' }}">
            FAQ
          </a>
        </li>
        <li>
          @auth('student')
          <a
            href="{{route('student.student-profile')}}"
            style="
                  max-width: fit-content;
                  max-height: fit-content;
                  margin: 0;
                  padding: 0;
                  display: flex;
                  align-items: center;
                ">
<p
    class="btn-outline"
    style="
        height: 45px;
        width: 45px;
        border-radius: 50%;
        background-size: cover;
        background-position: center;
        margin: 0;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
        @if($profile->profile_image)
            background-image: url('{{ asset('storage/' . $profile->profile_image) }}');
        @else
            background-image: none;
            background-color: orange; /* fallback bg color if you want */
        @endif
    "
>
    @if(!$profile->profile_image && $profile->profile_icon)
        <i class="{{ $profile->profile_icon }}"></i>
    @endif
</p>

          </a>
          @else
          <a class="btn-outline {{ request()->is('student-login') ? 'active' : '' }}" href="{{ url('student-login') }}">
            Login/Reg
          </a>
          @endauth
        </li>
      </ul>
    </div>
  </div>
</nav>