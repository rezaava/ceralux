@extends('layouts.app')

@section("title", __("messages.about_us"))

@section('head')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://unpkg.com/vanilla-tilt@1.7.0/dist/vanilla-tilt.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/splide@4.0.7/dist/css/splide.min.css">
<script src="https://unpkg.com/splide@4.0.7/dist/js/splide.min.js"></script>
@if(app()->getLocale() == 'fa')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
@endif
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
@if(app()->getLocale() == 'fa')
<script src="https://cdn.jsdelivr.net/npm/persian-date@1.0.6/dist/persian-date.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
@endif
<style>
    .about-card,
    .form-container {
        background: linear-gradient(145deg, #fff8e4, #f5e9c6);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        margin-bottom: 20px;
        font-family: 'Vazirmatn', sans-serif;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .about-card:hover,
    .form-container:hover {
        transform: scale(1.02);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .about-card::before,
    .form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s ease;
    }

    .about-card:hover::before,
    .form-container:hover::before {
        left: 100%;
    }

    .about-card h2,
    .form-container h2 {
        color: #d0bc7e;
        font-size: 2rem;
        margin-bottom: 15px;
    }

    .about-card p,
    .form-container p {
        color: #262f40;
        font-size: 1rem;
    }

    .slider-global-caption {
        position: absolute;
        top: 50%;
        right: 10%;
        transform: translateY(-50%);
        background: linear-gradient(145deg, #fff8e4, #f5e9c6);
        padding: 20px 30px;
        border-radius: 10px;
        color: #262f40;
        text-align: right;
        width: 35%;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        font-family: 'Vazirmatn', sans-serif;
    }

    .slider-global-caption h2 {
        font-size: 1.8rem;
        color: #d0bc7e;
        margin-bottom: 10px;
    }

    .slider-global-caption p {
        font-size: 1rem;
        color: #262f40;
    }

    .video-slider video {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .about-btn {
        background-color: transparent !important;
        color: #d0bc7e !important;
        border: 2px solid #d0bc7e !important;
        border-radius: 8px;
        padding: 10px 20px;
        font-family: 'Vazirmatn', sans-serif;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .about-btn:hover {
        background-color: #d0bc7e !important;
        color: #262f40 !important;
        transform: scale(1.05);
    }

    .about-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s ease;
    }

    .about-btn:hover::before {
        left: 100%;
    }

    .form-container .form-control,
    .form-container .form-select {
        border: 2px solid #d0bc7e;
        border-radius: 8px;
        font-family: 'Vazirmatn', sans-serif;
        font-size: 1rem;
        padding: 10px;
        background: rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
    }

    .form-container .form-control:focus,
    .form-container .form-select:focus {
        border-color: #b89f5e;
        box-shadow: 0 0 10px rgba(208, 188, 126, 0.5);
        outline: none;
    }

    .form-container .form-label {
        color: #d0bc7e;
        font-weight: bold;
    }

    .form-container ol {
        color: #262f40;
        font-size: 1rem;
        padding-right: 20px;
    }

    /* انیمیشن AOS */
    .about-card,
    .form-container,
    .form-container .form-group {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.5s ease forwards;
        animation-delay: calc(0.1s * var(--aos-index));
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 1185px) {
        .slider-global-caption {
            width: 80%;
            padding: 15px;
        }

        .slider-global-caption h2 {
            font-size: 1.5rem;
        }

        .slider-global-caption p {
            font-size: 0.9rem;
        }

        .video-slider video {
            height: 300px;
        }

        .form-container .row {
            flex-direction: column;
        }

        .form-container .col-md-6 {
            margin-bottom: 15px;
        }
    }

    [dir="rtl"] .slider-global-caption {
        right: auto;
        left: 10%;
        text-align: right;
    }

    [dir="ltr"] .slider-global-caption {
        right: 10%;
        left: auto;
        text-align: left;
    }
</style>
@endsection

@section('content')
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
    <div class="slider-global-caption" id="aboutus-slider" data-aos="fade-up" style="--aos-index: 1;">
        <h2>{{ __('messages.about_us') }}</h2>
        <p>{{ __('messages.about_us_description') }}</p>
    </div>
</section>

<section class="py-5 container text-center" dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}"
    id="aboutus-section">
    <div class="about-card" data-aos="fade-up" style="--aos-index: 2;">
        <h2>{{ __('messages.about_us') }}</h2>
        <p class="w-75 mx-auto">
            {{ __('messages.about_us_detail') }}
        </p>
        <a href="/contact" class="btn about-btn">{{ __('messages.contact_us') }}</a>
    </div>
</section>

<section class="py-5 container" dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">
    <div class="form-container" data-aos="fade-up" style="--aos-index: 3;">
        <h2 class="text-center">{{ __('messages.job_opportunities') }}</h2>
        <p class="fs-5 mb-4 text-center w-75 mx-auto">
            {!! __('messages.job_intro') !!}
        </p>
        <div class="mb-5 w-75 mx-auto">
            <h4 class="mb-3">{{ __('messages.why_Ceralux') }}</h4>
            <ol class="fs-5">
                @foreach(__('messages.why_Ceralux_list') as $item)
                <li>{{ $item }}</li>
                @endforeach
            </ol>
        </div>

        <form class="w-75 mx-auto" action="/submit-job-application" method="POST">
            @csrf
            <div class="row mb-3 form-group" style="--aos-index: 4;">
                <div class="col-md-6">
                    <label class="form-label">{{ __('messages.first_name') }}</label>
                    <input type="text" class="form-control" name="first_name" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('messages.last_name') }}</label>
                    <input type="text" class="form-control" name="last_name" required>
                </div>
            </div>

            <div class="row mb-3 form-group" style="--aos-index: 5;">
                <div class="col-md-6">
                    <label class="form-label">{{ __('messages.birth_date') }}</label>
                    <input type="text" id="birth_date" class="form-control" name="birth_date"
                        placeholder="{{ __('messages.date_placeholder') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('messages.marital_status') }}</label>
                    <select class="form-select" name="marital_status">
                        @foreach(__('messages.marital_status_options') as $value => $option)
                        <option value="{{ $value }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3 form-group" style="--aos-index: 6;">
                <div class="col-md-6">
                    <label class="form-label">{{ __('messages.phone') }}</label>
                    <input type="tel" class="form-control" name="phone" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('messages.email') }}</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
            </div>

            <div class="mb-3 form-group" style="--aos-index: 7;">
                <label class="form-label">{{ __('messages.address') }}</label>
                <input type="text" class="form-control" name="address">
            </div>

            <div class="row mb-3 form-group" style="--aos-index: 8;">
                <div class="col-md-6">
                    <label class="form-label">{{ __('messages.education_level') }}</label>
                    <select class="form-select" name="education_level">
                        @foreach(__('messages.education_options') as $value => $option)
                        <option value="{{ $value }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('messages.computer_skills') }}</label>
                    <select class="form-select" name="computer_skill">
                        @foreach(__('messages.skill_levels') as $value => $option)
                        <option value="{{ $value }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3 form-group" style="--aos-index: 9;">
                <div class="col-md-6">
                    <label class="form-label">{{ __('messages.english_skills') }}</label>
                    <select class="form-select" name="english_skill">
                        @foreach(__('messages.skill_levels') as $value => $option)
                        <option value="{{ $value }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('messages.specialty') }}</label>
                    <input type="text" class="form-control" name="specialty">
                </div>
            </div>

            <div class="mb-3 form-group" style="--aos-index: 10;">
                <label class="form-label">{{ __('messages.specialty_description') }}</label>
                <textarea class="form-control" name="specialty_description" rows="3"></textarea>
            </div>

            <div class="mb-3 form-group" style="--aos-index: 11;">
                <label class="form-label">{{ __('messages.preferred_department') }}</label>
                <select class="form-select" name="department">
                    @foreach(__('messages.department_options') as $value => $option)
                    <option value="{{ $value }}">{{ $option }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 form-group" style="--aos-index: 12;">
                <label class="form-label">{{ __('messages.salary_request') }}</label>
                <input type="number" class="form-control" name="salary_request">
            </div>

            <div class="mb-3 form-group" style="--aos-index: 13;">
                <label class="form-label">{{ __('messages.work_experience') }}</label>
                <textarea class="form-control" name="work_experience" rows="4"
                    placeholder="{{ __('messages.work_experience_placeholder') }}"></textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn about-btn">{{ __('messages.submit') }}</button>
            </div>
        </form>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // اسلایدر ویدیویی
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

        // مدیریت نمایش اسلایدر و بخش درباره ما
        const aboutusSlider = document.getElementById("aboutus-slider");
        const aboutusSection = document.getElementById("aboutus-section");
        function updateDisplay() {
            if (window.innerWidth >= 1185) {
                aboutusSlider.style.display = "block";
                aboutusSection.style.display = "none";
            } else {
                aboutusSlider.style.display = "none";
                aboutusSection.style.display = "block";
            }
        }
        updateDisplay();
        window.addEventListener('resize', updateDisplay);

        // افکت VanillaTilt برای کپشن اسلایدر
        VanillaTilt.init(document.querySelectorAll(".slider-global-caption"), {
            scale: 1.05,
            speed: 400,
            glare: true,
            maxGlare: 0.3
        });

        // مدیریت نوار نویگیشن
        const navbar = document.querySelector('.navbar');
        const toggler = document.querySelector('.navbar-toggler');
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

        // Datepicker بر اساس زبان
        @if(app()->getLocale() == 'fa')
        $("#birth_date").persianDatepicker({
            format: 'YYYY/MM/DD',
            autoClose: true
        });
        @else
        $("#birth_date").attr('type', 'date');
        @endif

        AOS.init();
    });
</script>
@endsection