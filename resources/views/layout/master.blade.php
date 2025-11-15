<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">
@include('layout.head')


<body>
    <nav class="navbar colored navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('index') }}"><img src="{{ asset('images/logo.png') }}" alt=""></a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link animate__animated" href="{{ route('index') }}">{{
                            __('messages.home') }}</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{
                            __('messages.products') }}</a>
                        <ul class="dropdown-menu">
                            <li style="--aos-index:1"><a class="dropdown-item"
                                    href="{{ route('products',['size'=>'60×120']) }}">{{ __('messages.size_60x120')
                                    }}</a></li>
                            <li style="--aos-index:2"><a class="dropdown-item"
                                    href="{{ route('products',['size'=>'120×240']) }}">{{ __('messages.size_120x240')
                                    }}</a></li>
                            <li style="--aos-index:3"><a class="dropdown-item"
                                    href="{{ route('products',['size'=>'80×60']) }}">{{ __('messages.size_80x60') }}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link animate__animated" href="{{ route('sellagents') }}">{{
                            __('messages.sellagents') }}</a></li>
                    <li class="nav-item"><a class="nav-link animate__animated" href="{{ route('catalogs') }}">{{
                            __('messages.catalogs') }}</a></li>
                    <li class="nav-item"><a class="nav-link animate__animated" href="{{ route('blog') }}">{{
                            __('messages.blog') }}</a></li>
                    <li class="nav-item"><a class="nav-link animate__animated" href="{{ route('aboutus') }}">{{
                            __('messages.about_us') }}</a></li>
                    <li class="nav-item"><a class="nav-link animate__animated" href="{{ route('contact') }}">{{
                            __('messages.contact') }}</a></li>
                </ul>
                <div class="d-flex gap-3 flex-column flex-lg-row align-items-lg-center mx-auto">
                    <a href="/search" class="btn search"><i class="fa-solid fa-magnifying-glass"></i> {{
                        __('messages.search') }}</a>
                    <div class="dropdown lang-dropdown">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown">{{
                            strtoupper(app()->getLocale()) }}</button>
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

    @yield('main')

    <footer>
        <div class="footer-top">
            <div class="container text-center">
                <div class="footer-logo"><img src="{{ asset('images/logo.png') }}" alt="Logo"></div>
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
    <script>
        AOS.init();
    </script>
    @yield('scripts')
</body>

</html>