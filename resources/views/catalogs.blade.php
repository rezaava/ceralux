@extends('layouts.app')

@section('title', __('messages.catalogs'))

@section('head')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .catalog-card {
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
    .catalog-overlay {
        background: rgba(0, 0, 0, 0.5);
        position: absolute;
        border-radius: 5px;
        inset: 0;
    }
    .catalog-content {
        position: relative;
        text-align: center;
        z-index: 2;
    }
    .catalog-btn {
        background-color: transparent !important;
        color: #d0bc7e !important;
        border: 2px solid #d0bc7e !important;
        transition: all 0.3s ease;
    }
    .catalog-btn:hover {
        background-color: #d0bc7e !important;
        color: #262f40 !important;
    }
    [dir="rtl"] .catalog-title { text-align: right; }
    [dir="ltr"] .catalog-title { text-align: left; }
</style>
@endsection

@section('content')
<section class="py-5 container text-center" dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">
    <p class="h1 mb-1">{{ __('messages.catalogs') }}</p>
    <div class="row">
        @for ($i = 0; $i < 32; $i++)
        <div class="col-md-3 catalog-item" data-aos="zoom-in">
            <div class="catalog-card"
                 style="background-image: url('https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg');">
                <div class="catalog-overlay"></div>
                <div class="catalog-content">
                    <a href="#" class="btn catalog-btn">{{ __('messages.download_catalog') }}</a>
                </div>
            </div>
            <p class="text-black catalog-title">کاتالوگ {{ $i + 1 }}</p>
        </div>
        @endfor
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    VanillaTilt.init(document.querySelectorAll(".catalog-card"), {
        scale: 1.05,
        speed: 400
    });

    const locale = "{{ strtolower(app()->getLocale()) }}";
    const catalogItems = document.querySelectorAll(".catalog-item");
    catalogItems.forEach(function(item, index) {
        const titleEl = item.querySelector(".catalog-title");
        if(titleEl) {
            fetch(`https://api.allorigins.win/raw?url=${encodeURIComponent("https://api.amirabolfazl.ir/translate?text=" + encodeURIComponent(titleEl.innerText) + "&lang=" + locale)}`)
            .then(res => res.json())
            .then(data => {
                if(!data.error) titleEl.innerText = data.message.translated;
            }).catch(err => console.error(err));
        }
    });

    AOS.init();
});
</script>
@endsection
