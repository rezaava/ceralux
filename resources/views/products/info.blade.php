@extends('layout.master')

@section('title', __('messages.product_info'))

@section('head')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://unpkg.com/vanilla-tilt@1.7.0/dist/vanilla-tilt.min.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<style>
    /* --- استایل‌ها (مثل قبل) --- */
    @font-face {
        font-family: yekan;
        src: url({{ asset('fonts/YekanBakh-Medium.ttf')}});
    }

    body {
        /* font-family: 'Vazirmatn', sans-serif; */
        font-family: yekan, sans-serif !important;
    }

    .article {
        border: 10px solid #fff;
        background: linear-gradient(145deg, #fff8e4, #f5e9c6);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
    }

    .article:hover {
        transform: scale(1.03);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .article::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s ease;
    }

    .article:hover::before {
        left: 100%;
    }

    .overlay-container {
        position: relative;
        display: inline-block;
        cursor: pointer;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
    }

    .overlay-container img {
        display: block;
        width: 100%;
        height: 350px;
        object-fit: cover;
        border-radius: 10px;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(0, 0, 0, 0.5) 70%, rgba(0, 0, 0, 0) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .overlay i {
        font-size: 40px;
        color: #d0bc7e;
    }

    .overlay-container:hover .overlay {
        opacity: 1;
    }

    .article h2 {
        color: #d0bc7e;
        font-size: 2rem;
        margin: 15px 0;
    }

    .article p {
        color: #262f40;
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .article ul {
        color: #262f40;
        font-size: 1rem;
        margin-bottom: 15px;
        padding-right: 20px;
    }

    .article h5 {
        color: #b89f5e;
        font-weight: bold;
        font-size: 1.3rem;
        margin: 15px 0;
    }

    .article .text-muted {
        font-size: 0.9rem;
        color: #666;
    }

    .gallery-container {
        margin-bottom: 40px;
    }

    .gallery-item {
        position: relative;
        margin-bottom: 20px;
    }

    .gallery-item p {
        color: #262f40;
        text-align: center;
        margin-top: 10px;
        font-size: 0.9rem;
    }

    .sizes {
        display: flex;
        justify-content: center;
        align-items: end;
        gap: 25px;
        flex-wrap: wrap;
        margin-top: 40px;
    }

    .tile {
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: all 0.3s ease;
    }

    .tile:hover {
        transform: scale(1.05);
    }

    .tile a {
        text-decoration: none;
        color: inherit;
    }

    .box {
        border: 2px solid #d0bc7e;
        background: linear-gradient(145deg, #fff8e4, #f5e9c6);
        border-radius: 8px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .box:hover::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s ease;
        left: 100%;
    }

    .selected-box {
        border: 4px solid #b89f5e;
        box-shadow: 0 0 10px rgba(208, 188, 126, 0.5);
    }

    .label {
        margin-top: 12px;
        color: #d0bc7e;
        font-weight: bold;
        font-size: 1.1rem;
        font-family: yekan, sans-serif;
    }

    .article-btn {
        background-color: transparent !important;
        color: #d0bc7e !important;
        border: 2px solid #d0bc7e !important;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        margin: 5px;
    }

    .article-btn:hover {
        background-color: #d0bc7e !important;
        color: #262f40 !important;
        transform: scale(1.05);
    }

    .article-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s ease;
    }

    .article-btn:hover::before {
        left: 100%;
    }

    .article,
    .gallery-item,
    .tile {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.5s ease forwards;
        animation-delay: calc(0.1s*var(--aos-index));
    }

    .slide-in-left {
        animation: slideInLeft 2s ease-out forwards;
        opacity: 0;
        transform: translateX(-100%);
    }

    .slide-in-right {
        animation: slideInRight 2s ease-out forwards;
        opacity: 0;
        transform: translateX(100%);
    }
    .title-info{
        background-color: #F9F9F9 ; 
        box-shadow: rgba(0, 0, 0, 0.10) 1.95px 1.95px 3px;
        border-radius: 0.3rem;
        width: 100%;
        max-width: 600px;
    }
    .title-header{
        font-family: pinar;
        color: #E1BB87;
        font-size: 4rem;
        font-weight: bold;
    }

    @keyframes slideInLeft {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    [dir="rtl"] .article ul {
        padding-right: 20px;
        padding-left: 0;
    }

    [dir="ltr"] .article ul {
        padding-left: 20px;
        padding-right: 0;
    }

</style>
@endsection

@section('main')

<section class="py-5 container" dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">
    <div id="contentContainer">
        <div class="row" data-aos="fade-up" style="--aos-index:1;">
            <h1 class="text-center mb-5 title-header"> {{$product->name_en}}</h1>
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="overlay-container clickable-img gallery-item mb-4 slide-in-right">
                    <img src="{{ asset('img/test1.jpg') }}" alt="">
                </div>
            </div>
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="overlay-container clickable-img gallery-item mb-4 slide-in-left">
                    <img src="{{ asset('img/test2.jpg') }}" alt="">
                </div>
            </div>
        </div>
        {{-- <div class="article article-item" data-aos="fade-up" style="--aos-index:1;">
            <div class="overlay-container clickable-img">
                <img src="{{ asset($imgs[0]->img_url) }}" class="article-img" alt="">
                <div class="overlay"><i class="fa-solid fa-magnifying-glass"></i></div>
            </div>
            <h2 class="article-title" lang="{{ app()->getLocale() }}">{{ $product->name }}</h2>
            <p class="article-date text-muted" lang="{{ app()->getLocale() }}">{{ $product['date'] }}</p>
            <p class="article-description" lang="{{ app()->getLocale() }}">توضیحات : {{ $product->desc }}</p>
            <p class="features-title" lang="{{ app()->getLocale() }}">اندازه 60x60</p>
            <p class="features-title" lang="{{ app()->getLocale() }}">ویژگی های محصول </p>
            <ul lang="{{ app()->getLocale() }}">
                <li></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <h5 lang="{{ app()->getLocale() }}">قیمت: {{ number_format($product->price) }}</h5>
            <div class="d-flex justify-content-start">
                <a href="{{ route('sellagents') }}" class="btn article-btn" lang="{{ app()->getLocale() }}">{{
                    __('messages.view_agents') }}</a>
            </div>
        </div> --}}

        <!-- Gallery -->
        <div class="row gallery-container" data-aos="fade-up" style="--aos-index:2;">
            @foreach($imgs as $img)
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="overlay-container clickable-img gallery-item mb-4 shadow-sm">
                    <img src="{{ asset($img->img_url) }}" alt="" />
                    <div class="overlay"><i class="fa-solid fa-magnifying-glass"></i></div>
                </div>
                <p lang="{{ app()->getLocale() }}">{{ $img->img_name }}</p>
            </div>
            @endforeach
        </div>

        <div class="row justify-content-center">
            <div class="mb-5 mt-3 p-4 title-info">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="m-0 p-0" style="font-size: 1.6rem;">{{ $product->name }}</p>
                    <div>
                        <p class="m-0 p-0" style="font-size: 0.7rem;"> {{__('messages.name_price')}} </p>
                        <p class="m-0 p-0" style="font-size: 1.3rem;">{{ number_format($product->price) }}</p>
                    </div>
                    <div>
                        <p class="m-0 p-0" style="font-size: 0.7rem;"> {{__('messages.name_size_text')}} </p>
                        <p class="m-0 p-0" style="font-size: 1.3rem;">{{$size->name}}</p>
                    </div>
                    <div class="text-center">
                        <p class="m-0 p-0" style="font-size: 0.7rem;"> {{__('messages.name_face')}}</p>
                        <p class="m-0 p-0" style="font-size: 1.3rem;">{{$product->face}}</p>
                    </div>
                </div>
            </div>
        </div>

                <div class="row justify-content-center">
            <div class="mb-5 mt-3 p-4 title-info">
                <div class="d-flex justify-content-start align-items-center">
                    <p class="m-0 p-0" style="font-size: 1.6rem;">توضیحات :</p>
                </div>
                <div class="d-flex justify-content-start align-items-center mt-2">
                    <p class="m-0 p-0" style="font-size: 1.1rem;">{{$product->desc}}</p>
                </div>
            </div>
        </div>

        <!-- Sizes -->
        <h3 class="mt-4">{{__('messages.name_size')}}</h3>
        <div class="sizes mt-5" data-aos="fade-up" style="--aos-index:3;">
            @foreach($size_prods as $size_prod)
            <div class="tile size-item" style="">
                <a href="/">
                    <div class="box " style="width: {{ $size_prod->width }}px ; height: {{ $size_prod->height }}px"></div>
                    <div class="label">{{$size_prod->name}}</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    {{-- selected-box --}}
</section>

<!-- Modal for Image Zoom -->
<div class="modal " id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" />
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const clickableImages = document.querySelectorAll(".clickable-img");
    const modalElement = document.querySelector("#myModal");
    const modalImage = document.querySelector("#modalImage");
    const modal = new bootstrap.Modal(modalElement);

    clickableImages.forEach(img => {
        img.addEventListener("click", function () {

            const src = this.querySelector("img").getAttribute("src");

            const dataSrc = this.getAttribute("data-src");
            
            modalImage.src = dataSrc ? dataSrc : src;

            modal.show();
        });
    });

</script>
@endsection