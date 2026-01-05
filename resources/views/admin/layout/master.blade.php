<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    @include('admin.layout.head')
    @yield('head')
    <style>

    </style>
</head>
<body>
   @include('admin.layout.header')

    <!-- Main Content -->
    
        <div class="main-content" id="mainContent">
            <div class="header d-flex justify-content-between align-items-center mb-5 mt-md-0" style="margin-top: 3.5rem">
                <div>
                    <h2 class="page-title">@yield('onvan') </h2>
                    @yield('title-onvan')
                </div>
                <div class="user-info">
                    <div class="dropdown lang-dropdown">
                        <button class="btn dropdown-toggle text-light" type="button" data-bs-toggle="dropdown">{{strtoupper(app()->getLocale()) }}</button>
                        <ul class="dropdown-menu text-center">
                            <li><a class="dropdown-item" href="{{ route('lang.switch', 'fa') }}">فارسی</a></li>
                            <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">English</a></li>
                            <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">عربي</a></li>
                        </ul>
                    </div>

                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="user-avatar" alt="User">
                    @if(Auth::user())
                        @if(Auth::user()->dispaly_name)
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <span class="user-name">{{Auth::user()->dispaly_name}}</span>
                                <span style="background-color: rgba(173, 216, 230, 0.248);color:#ccc;border-radius: 1rem ; padding:0 0.5rem;font-size: 0.76rem;margin-top: 0.5rem">
                                    @if(app()->getLocale() == 'fa')
                                        {{Auth::user()->roles->first()?->display_name_fa}}
                                    @elseif(app()->getLocale() == 'en')
                                        {{Auth::user()->roles->first()?->display_name_en}}
                                    @elseif(app()->getLocale() == 'ar')
                                        {{Auth::user()->roles->first()?->display_name_ar}}
                                    @endif
                                </span>
                            </div>
                        @else
                        <small style="color: lightblue;">در داخل تنظیمات اسم را وارد کنید</small>
                        @endif
                    @endif
                </div>
            </div>
            <main>
                @yield('main')
            </main>
        </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- cdn sweet alert 2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- Custom JS -->
    @yield('script')
    <script>
        // Sidebar toggle for desktop
        document.getElementById('sidebarLogo').addEventListener('click', function() {
            if(window.innerWidth >= 768) {
                document.getElementById('sidebar').classList.toggle('collapsed');
                document.getElementById('mainContent').classList.toggle('expanded');
            }
        });
        // Mobile offcanvas menu
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const offcanvasSidebar = document.getElementById('offcanvasSidebar');
        const closeOffcanvasBtn = document.getElementById('closeOffcanvasBtn');
        function showOffcanvas() {
            offcanvasSidebar.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        function hideOffcanvas() {
            offcanvasSidebar.classList.remove('show');
            document.body.style.overflow = '';
        }
        mobileMenuBtn.addEventListener('click', showOffcanvas);
        closeOffcanvasBtn.addEventListener('click', hideOffcanvas);
        // Show hamburger only on mobile
        function handleMobileMenuBtn() {
            if(window.innerWidth < 768) {
                mobileMenuBtn.style.display = 'inline-flex';
                hideOffcanvas();
            } else {
                mobileMenuBtn.style.display = 'none';
                hideOffcanvas();
            }
        }
        window.addEventListener('resize', handleMobileMenuBtn);
        handleMobileMenuBtn();
    </script>
</body>
</html>
