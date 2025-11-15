@extends('layout.master')

@section("title", __("messages.home"))

@section('head')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .category-card {
        height: 300px;
        background-size: cover;
        background-position: center;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        border-radius: 5px;
        color: white;
        overflow: hidden;
    }

    .category-overlay {
        background: rgba(0, 0, 0, 0.5);
        position: absolute;
        border-radius: 5px;
        inset: 0;
    }

    .category-content {
        position: relative;
        text-align: center;
        z-index: 2;
    }

    .category-btn {
        background-color: transparent !important;
        color: #d0bc7e !important;
        border: 2px solid #d0bc7e !important;
        transition: all 0.3s ease;
    }

    .category-btn:hover {
        background-color: #d0bc7e !important;
        color: #262f40 !important;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        border-radius: 8px;
        object-fit: cover;
    }
</style>
@endsection

@section('main')
<section dir="ltr" class="splide video-slider" aria-label="Video Slider">
    <div class="splide__track">
        <ul class="splide__list">
            <li class="splide__slide">
                <video autoplay muted loop>
                    <source src="https://abadistile.com/wp-content/uploads/2023/11/slider-abadis-tile-4-3.mp4"
                        type="video/mp4">
                </video>
            </li>
            <li class="splide__slide">
                <video autoplay muted loop>
                    <source src="https://abadistile.com/wp-content/uploads/2023/11/slider-abadis-tile-2-3-1.m4v"
                        type="video/mp4">
                </video>
            </li>
        </ul>
    </div>
</section>

<section class="py-5 container text-center">
    <p class="h1 mb-5">{{ __("messages.about_us") }}</p>
    <p class="fs-5  mb-5 w-75 mx-auto">{{ __("messages.about_us_text") }}</p>
    <a href="/aboutus" class="btn about">{{ __("messages.more_info") }}</a>
</section>

<section class="py-5 container text-center">
    <p class="h1 mb-5">{{ __("messages.products") }}</p>
    <div class="row">
        <div class="col-md-3" data-aos="zoom-in">
            <div class="category-card"
                style="background-image: url('https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg');">
                <div class="category-overlay"></div>
                <div class="category-content">
                    <div class="h1" style="color: #d0bc7e">30×30</div>
                    <a href="#" class="btn category-btn">{{ __("messages.more_info") }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in">
            <div class="category-card"
                style="background-image: url('https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg');">
                <div class="category-overlay"></div>
                <div class="category-content">
                    <div class="h1" style="color: #d0bc7e">60×60</div>
                    <a href="#" class="btn category-btn">{{ __("messages.more_info") }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in">
            <div class="category-card"
                style="background-image: url('https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg');">
                <div class="category-overlay"></div>
                <div class="category-content">
                    <div class="h1" style="color: #d0bc7e">240×120</div>
                    <a href="#" class="btn category-btn">{{ __("messages.more_info") }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in">
            <div class="category-card"
                style="background-image: url('https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg');">
                <div class="category-overlay"></div>
                <div class="category-content">
                    <div class="h1" style="color: #d0bc7e">120×270</div>
                    <a href="#" class="btn category-btn">{{ __("messages.more_info") }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in">
            <div class="category-card"
                style="background-image: url('https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg');">
                <div class="category-overlay"></div>
                <div class="category-content">
                    <div class="h1" style="color: #d0bc7e">240×120</div>
                    <a href="#" class="btn category-btn">{{ __("messages.more_info") }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in">
            <div class="category-card"
                style="background-image: url('https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg');">
                <div class="category-overlay"></div>
                <div class="category-content">
                    <div class="h1" style="color: #d0bc7e">80×60</div>
                    <a href="#" class="btn category-btn">{{ __("messages.more_info") }}</a>
                </div>
            </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in">
            <div class="category-card"
                style="background-image: url('https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg');">
                <div class="category-overlay"></div>
                <div class="category-content">
                    <div class="h1" style="color: #d0bc7e">75×150</div>
                    <a href="#" class="btn category-btn">{{ __("messages.more_info") }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 container text-center">
    <p class="h1 mb-5">{{ __("messages.gallery") }}</p>
    <div class="row gallery-row">
        <div class="col-md-6" data-aos="zoom-in-left">
            <div class="row mb-3">
                <div class="col-6">
                    <img src="https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg"
                        alt="" class="img-fluid">
                </div>
                <div class="col-6">
                    <img src="https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg"
                        alt="" class="img-fluid">
                </div>
            </div>
            <div>
                <img src="https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg"
                    alt="" class="img-fluid">
            </div>
        </div>
        <div class="col-md-6" data-aos="zoom-in-right">
            <div class="row">
                <div class="mb-3">
                    <img src="https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg"
                        alt="" class="img-fluid">
                </div>
                <div class="col-6">
                    <img src="https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg"
                        alt="" class="img-fluid">
                </div>
                <div class="col-6">
                    <img src="https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg"
                        alt="" class="img-fluid">
                </div>
            </div>
        </div>
</section>
@endsection

@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
            new Splide('.splide', {
                type: 'fade',
                autoplay: true,
                pagination: false,
                rewind: true,
                pauseOnHover: false,
                pauseOnFocus: false,
                pause: false,
                speed: 800
            }).mount();

            const navLinks = document.querySelectorAll('.nav-link');
            const videoSection = document.querySelector('.video-slider');
            const videoSectionHeight = videoSection.offsetHeight;

            VanillaTilt.init(document.querySelectorAll(".category-card"), {
                scale: 1.05,
                speed: 400
            });

            navbar.classList.remove('colored');
            navbar.classList.remove('sticky-top');
            navbar.classList.add('fixed-top');

            window.addEventListener('scroll', function () {
                if (window.scrollY > 5) {
                    navbar.classList.add('colored');
                } else {
                    navbar.classList.remove('colored');
                }
            });

            toggler.addEventListener('click', function () {
                navbar.classList.add('colored');
            });
        });
</script>
<script>
    AOS.init();
</script>
@endsection