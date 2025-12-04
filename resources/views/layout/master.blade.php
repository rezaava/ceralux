<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">
@include('layout.head')

<body>
    @include('layout.header')

    <main>
        @yield('main')
    </main>

    <footer>
        <div class="footer-top">
            <div class="container text-center">
                <div class="footer-logo"><img src="{{ asset('images/logo.png') }}" alt="Logo"></div>
                <div class="footer-slogan">{{ __('messages.footer_slogan') }}</div>
                <div class="footer-icons">
                    <a href="/aboutus"><i class="fas fa-phone"></i></a>
                    <a href="/aboutus"><i class="fas fa-envelope"></i></a>
                    <a href="/aboutus"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center py-3" style="font-family: yekan;">
            <p>{{ __('messages.footer_rights') }}</p>
        </div>
    </footer>

    {{-- همه اسکریپت‌ها سر جای خودشون --}}
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
