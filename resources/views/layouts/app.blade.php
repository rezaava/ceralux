<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.home'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-Variable-font-face.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link href="{{ asset('/styles/app.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    @yield('head')
    <style>
        body { font-family: 'Vazirmatn', sans-serif; }
        .navbar { transition: all 0.3s; }
        .dropdown-menu { opacity: 0; visibility: hidden; transform: translateY(10px); transition: opacity 0.4s, transform 0.4s, visibility 0.4s; display: block; background: linear-gradient(145deg, #d0bc7e, #e6d3a3); border: none; border-radius: 12px; box-shadow: 0 10px 20px rgba(0,0,0,0.15); overflow: hidden; }
        .dropdown:hover .dropdown-menu, .dropdown-menu.show { opacity: 1; visibility: visible; transform: translateY(0); }
        .dropdown-item { font-family: 'Vazirmatn', sans-serif; color: #2c2c2c; padding: 14px 22px; transition: all 0.3s ease; position: relative; overflow: hidden; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .dropdown-item:last-child { border-bottom: none; }
        .dropdown-item:hover { background: #d0bc7e; color: #fff; transform: scale(1.03); border-radius: 8px; }
        .dropdown-item::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent); transition: left 0.5s ease; }
        .dropdown-item:hover::before { left: 100%; }
        .lang-dropdown .dropdown-menu { min-width: 130px; background: linear-gradient(145deg, #e6d3a3, #d0bc7e); }
        .lang-dropdown .dropdown-item:hover { background: #b89f5e; color: #fff; }
        .dropdown-menu li { opacity: 0; transform: translateX(20px); animation: slideIn 0.4s ease forwards; animation-delay: calc(0.1s * var(--aos-index)); }
        @keyframes slideIn { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
        .dropdown-menu.show { animation: fadeInDown 0.4s ease forwards; }
        @keyframes fadeInDown { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
    </style>
</head>
<body>
    <nav class="navbar colored navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}"><img src="{{ asset('/images/logo.png') }}" alt=""></a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link animate__animated" href="{{ route('index') }}">{{ __('messages.home') }}</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{ __('messages.products') }}</a>
                        <ul class="dropdown-menu">
                            <li style="--aos-index:1"><a class="dropdown-item" href="{{ route('products',['size'=>'120×270']) }}">{{ __('messages.size_120x270') }}</a></li>
                            <li style="--aos-index:2"><a class="dropdown-item" href="{{ route('products',['size'=>'240×120']) }}">{{ __('messages.size_240x120') }}</a></li>
                            <li style="--aos-index:3"><a class="dropdown-item" href="{{ route('products',['size'=>'80×60']) }}">{{ __('messages.size_80x60') }}</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link animate__animated" href="{{ route('sellagents') }}">{{ __('messages.sellagents') }}</a></li>
                    <li class="nav-item"><a class="nav-link animate__animated" href="{{ route('catalogs') }}">{{ __('messages.catalogs') }}</a></li>
                    <li class="nav-item"><a class="nav-link animate__animated" href="{{ route('blog') }}">{{ __('messages.blog') }}</a></li>
                    <li class="nav-item"><a class="nav-link animate__animated" href="{{ route('aboutus') }}">{{ __('messages.about_us') }}</a></li>
                    <li class="nav-item"><a class="nav-link animate__animated" href="{{ route('contact') }}">{{ __('messages.contact') }}</a></li>
                </ul>
                <div class="d-flex gap-3 flex-column flex-lg-row align-items-lg-center mx-auto">
                    <a href="/search" class="btn search"><i class="fa-solid fa-magnifying-glass"></i> {{ __('messages.search') }}</a>
                    <div class="dropdown lang-dropdown">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">{{ strtoupper(app()->getLocale()) }}</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('lang.switch', 'fa') }}">فارسی</a></li>
                            <li><a class="dropdown-item" href="{{ route('lang.switch', 'en') }}">English</a></li>
                            <li><a class="dropdown-item" href="{{ route('lang.switch', 'ar') }}">عربي</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer>
        <div class="footer-top">
            <div class="container text-center">
                <div class="footer-logo"><img src="{{ asset('/images/logo.png') }}" alt="Logo"></div>
                <div class="footer-slogan">{{ __('messages.footer_slogan') }}</div>
                <div class="footer-icons">
                    <a href="#"><i class="fas fa-phone"></i></a>
                    <a href="#"><i class="fas fa-envelope"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center py-3">
            <p>{{ __('messages.footer_rights') }}</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="https://unpkg.com/headroom.js@0.12.0/dist/headroom.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script>
        const navbar = document.querySelector('.navbar');
        const headroom = new Headroom(navbar);
        headroom.init();
    </script>
    <script>AOS.init();</script>
    @yield('scripts')
</body>
</html>
