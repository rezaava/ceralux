@extends('layout.master')

@section('title', __('messages.products'))

@section('head')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/vanilla-tilt@1.7.0/dist/vanilla-tilt.min.js"></script>
<style>
    .product-card {
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
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: scale(1.03);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .product-overlay {
        background: rgba(0, 0, 0, 0.5);
        position: absolute;
        border-radius: 5px;
        inset: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .product-overlay {
        opacity: 0.5;
    }

    .product-content {
        position: relative;
        text-align: center;
        z-index: 2;
    }

    .product-btn {
        background-color: transparent !important;
        color: #d0bc7e !important;
        border: 2px solid #d0bc7e !important;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .product-btn:hover {
        background-color: #d0bc7e !important;
        color: #262f40 !important;
        transform: scale(1.05);
    }

    .product-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s ease;
    }

    .product-btn:hover::before {
        left: 100%;
    }

    .product-name {
        font-family: 'Vazirmatn', sans-serif;
        color: #262f40;
        margin-top: 10px;
    }

    [dir="rtl"] .product-name {
        text-align: right;
    }

    [dir="ltr"] .product-name {
        text-align: left;
    }

    .size-title {
        color: #d0bc7e;
        font-family: 'Vazirmatn', sans-serif;
        width: 15%;
        background: radial-gradient(circle, rgba(124, 58, 237, 1) 0%, rgba(30, 41, 59, 1) 100%); 
        box-shadow: rgba(0,0,0,0.2) 0px 3px 5px -1px,rgba(0,0,0,0.14) 0px 6px 10px 0px; 
        text-align: center ; 
        border-radius: 0.6rem;
    }

    .product-card {
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

    @media (max-width: 768px) {
        .size-title {
            width: 35%;
        }
    }

</style>
@endsection

@section('main')
<section class="py-3 container text-center" dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">
    <p class="h1 mb-1" style="font-size: 3.5rem">{{ __('messages.products') }}</p>
    <p class="h2 mb-5 py-2  m-0 mx-auto size-title" style="">{{$nameSize->name}}</p>
    <div class="row">
        @if($prods->count() > 0)
            @foreach($prods as $prod)
                <div class="col-md-3 mb-4" data-aos="zoom-in" style="--aos-index:1;">
                    <div class="product-card" style="@if(!empty($prod->img) && !empty($prod->img->img_url))
                        background-image: url('{{ asset($prod->img->img_url) }}');
                        @else
                            background-image: url('{{ asset('images/imgNot.jpg') }}');
                        @endif">
                        <div class="product-overlay"></div>
                        <div class="product-content">
                            <a href="/products/info/{{$nameSize->id}}/{{ $prod->id }}" class="btn product-btn">{{__('messages.product_info') }}</a>
                        </div>
                    </div>
                    <p class="product-name" id="pname">{{ $prod->name }} </p>
                </div>
            @endforeach
        @else
            <p style="background-color: #262F40 ; color:#ADD8E6 ; border-radius: 0.7rem ; font-size: 1.1rem" class="p-3">محصولی وجود ندارد</p>
        @endif


    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    if (typeof VanillaTilt !== 'undefined') {
        VanillaTilt.init(document.querySelectorAll(".product-card"), {
            scale: 1.05,
            speed: 400,
            glare: true,
            maxGlare: 0.3
        });
    }
    if (typeof AOS !== 'undefined') {
        AOS.init();
    }

    const targetLang = "{{ strtolower(app()->getLocale()) }}";

    @for ($i = 0; $i < 32; $i++)
        (function(i){
            const btnEl = document.getElementById("p" + i);
            const nameEl = document.getElementById("pname" + i);

            fetch(`https://api.allorigins.win/raw?url=${encodeURIComponent("https://api.amirabolfazl.ir/translate?text=" + encodeURIComponent(btnEl.innerText) + "&lang=" + targetLang)}`)
            .then(res => res.json())
            .then(data => {
                if(!data.error){
                    btnEl.innerText = data.message.translated;
                    btnEl.setAttribute("lang", targetLang);
                } else {
                    btnEl.innerText = "⚠️ خطا در ترجمه!";
                }
            })
            .catch(err => {
                btnEl.innerText = "❌ خطا در ارتباط با سرور!";
            });

            fetch(`https://api.allorigins.win/raw?url=${encodeURIComponent("https://api.amirabolfazl.ir/translate?text=" + encodeURIComponent(nameEl.innerText) + "&lang=" + targetLang)}`)
            .then(res => res.json())
            .then(data => {
                if(!data.error){
                    nameEl.innerText = data.message.translated;
                    nameEl.setAttribute("lang", targetLang);
                } else {
                    nameEl.innerText = "⚠️ خطا در ترجمه!";
                }
            })
            .catch(err => {
                nameEl.innerText = "❌ خطا در ارتباط با سرور!";
            });
        })({{$i}});
    @endfor
});
</script>
@endsection