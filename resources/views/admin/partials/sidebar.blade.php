<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.admin-dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('img/logo.png') }}" width="50px" alt="Logo" />
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform: capitalize">
                SW
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('admin.admin-dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.admin-dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Dashboard</div>
            </a>
        </li>


        <!-- SEO -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">SEO</span>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.admin-seo-home-page','admin.admin-seo-school-tuition','admin.admin-seo-my-class','admin.admin-seo-contact','admin.admin-seo-aboutus','admin.admin-seo-privacy-policy') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div>Page SEO</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.admin-seo-home-page') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-seo-home-page') }}" class="menu-link">
                        <div>Home Page</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.admin-seo-school-tuition') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-seo-school-tuition') }}" class="menu-link">
                        <div>School Tuition</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.admin-seo-my-class') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-seo-my-class') }}" class="menu-link">
                        <div>My Class</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.admin-seo-contact') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-seo-contact') }}" class="menu-link">
                        <div>Contact</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.admin-seo-aboutus') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-seo-aboutus') }}" class="menu-link">
                        <div>About Us</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.admin-seo-privacy-policy') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-seo-privacy-policy') }}" class="menu-link">
                        <div>Privacy Policy</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Page Content -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Page Content</span>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.admin-upload-faculties','admin.admin-aboutus','admin.admin-story-tags','admin.admin-stories','admin.admin-faq') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div>Content</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.admin-upload-faculties') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-upload-faculties') }}" class="menu-link">
                        <div>Faculties</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.admin-aboutus') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-aboutus') }}" class="menu-link">
                        <div>About Us</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.admin-story-tags') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-story-tags') }}" class="menu-link">
                        <div>Story Tags</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.admin-stories') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-stories') }}" class="menu-link">
                        <div>Stories</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.admin-faq') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-faq') }}" class="menu-link">
                        <div>FAQ</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Course -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Course</span></li>
        <li class="menu-item {{ request()->routeIs('admin.admin-classes') ? 'active' : '' }}">
            <a href="{{ route('admin.admin-classes') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div>Classes</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.admin-class-faqs') ? 'active' : '' }}">
            <a href="{{ route('admin.admin-class-faqs') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-list-check"></i>
                <div>Class FAQs</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.admin-subjects') ? 'active' : '' }}">
            <a href="{{ route('admin.admin-subjects') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                <div>Subjects</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.admin-chapters') ? 'active' : '' }}">
            <a href="{{ route('admin.admin-chapters') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-open"></i>
                <div>Chapters</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.admin-videos') ? 'active' : '' }}">
            <a href="{{ route('admin.admin-videos') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-video"></i>
                <div>Videos</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.admin-video-feedbacks') ? 'active' : '' }}">
            <a href="{{ route('admin.admin-video-feedbacks') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-like"></i>
                <div>Video Feedbacks</div>
            </a>
        </li>

        <!-- Students -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Students</span></li>
        <li class="menu-item {{ request()->routeIs('admin.admin-students','admin.admin-tuition-fees','admin.admin-fees-report') ? 'open active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div>Students</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.admin-students') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-students') }}" class="menu-link">
                        <div>All Students</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.admin-tuition-fees') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-tuition-fees') }}" class="menu-link">
                        <div>Tuition Fees</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.admin-fees-report') ? 'active' : '' }}">
                    <a href="{{ route('admin.admin-fees-report') }}" class="menu-link">
                        <div>Fees Report</div>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>