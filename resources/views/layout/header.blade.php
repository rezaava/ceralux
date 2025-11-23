<nav class="navbar colored navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}"><img style="width: 250px" src="{{ asset('images/logo.png') }}" alt=""></a>
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" style="color: #fff!important">
            <span ><i class="fa-solid fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link animate__animated" href="{{ route('index') }}">{{
                        __('messages.home') }}</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">{{
                        __('messages.products') }}</a>
                    <ul class="dropdown-menu">
                        @foreach($sizes as $size)
                            <li style="--aos-index:1"><a href="/products/{{ $size->id }}" class="dropdown-item">{{$size->name}}</a></li>
                        @endforeach
                        
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
                    <a href="/admin/dashboard" class="btn search"><i class="fa-solid fa-right-to-bracket"></i> {{__('messages.login') }}</a>
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