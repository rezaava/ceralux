<!-- Mobile Hamburger Button -->
<button class="mobile-menu-btn" id="mobileMenuBtn" style="display:none;">
    <i class="fas fa-bars"></i>
</button>
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo" id="sidebarLogo">
            <i class="fas fa-store"></i>
            <span class="sidebar-title">پنل فروشگاه</span>
        </div>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="#">
                <i class="fas fa-home"></i>
                <span class="menu-label">داشبورد</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-users"></i>
                <span class="menu-label">کاربران</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-flask"></i>
                <span class="menu-label">آزمایشات</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-file-alt"></i>
                <span class="menu-label">گزارشات</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-percent"></i>
                <span class="menu-label">درصدها</span>
            </a>
        </li>
    </ul>
</div>
<!-- Offcanvas Sidebar for Mobile -->
<div class="sidebar offcanvas-mobile" id="offcanvasSidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <i class="fas fa-store"></i>
            <span class="sidebar-title">پنل فروشگاه</span>
        </div>
        <button class="close-offcanvas d-md-none" id="closeOffcanvasBtn"><i class="fas fa-times"></i></button>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="/admin/dashboard">
                <i class="fas fa-home"></i>
                <span class="menu-label">داشبورد</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('size') ? 'active' : '' }}" href="/admin/size">
                <i class="fa-solid fa-maximize"></i>
                <span class="menu-label">سایز ها</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('product') ? 'active' : '' }}" href="/admin/product">
                <i class="fa-solid fa-boxes-stacked"></i>
                <span class="menu-label">محصولات</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('catalog') ? 'active' : '' }}" href="/admin/catalog">
                <i class="fas fa-file-alt"></i>
                <span class="menu-label">کاتالوگ ها</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('setting') ? 'active' : '' }}" href="/admin/setting">
                <i class="fa-solid fa-sliders"></i>
                <span class="menu-label">تنظیمات</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="fa-solid fa-reply-all"></i>
                <span class="menu-label">بازگشت به سایت</span>
            </a>
        </li>
        <li class="nav-item text-center mt-3 mb-3">
            <a class="btn btn-danger" href="/logout">
                <i class="fa-solid fa-right-to-bracket"></i>
                <span class="menu-label mx-2">خروج</span>
            </a>
        </li>
    </ul>
</div>