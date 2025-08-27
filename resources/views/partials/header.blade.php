@php
  $currentRoute = request()->path();
@endphp

<!-- NAVBAR -->
<nav class="navbar">
  <div class="container" style="display: flex; justify-content: space-between">
    <a class="brand" href="{{ url('/') }}">
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
          <a href="{{ url('school-tuitions') }}" class="{{ request()->is('school-tuitions') ? 'active' : '' }}">
            School Tuitions
          </a>
        </li>
        <li>
          <a href="{{ url('my-class') }}" class="{{ request()->is('my-class') ? 'active' : '' }}">
            My Class
          </a>
        </li>
        <li>
          <a href="#faq" class="{{ request()->is('faq') ? 'active' : '' }}">
            FAQ
          </a>
        </li>
        <li>
          <a class="btn-outline {{ request()->is('login') ? 'active' : '' }}" href="{{ url('login') }}">
            Login/Reg
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
