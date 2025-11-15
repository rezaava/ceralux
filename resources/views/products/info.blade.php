@extends('layouts.app')

@section('title', __('messages.product_info'))

@section('head')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://unpkg.com/vanilla-tilt@1.7.0/dist/vanilla-tilt.min.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<style>
    /* --- استایل‌ها (مثل قبل) --- */
    .article {
        border: 10px solid #fff;
        background: linear-gradient(145deg, #fff8e4, #f5e9c6);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        font-family: 'Vazirmatn', sans-serif;
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
        font-family: 'Vazirmatn', sans-serif;
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
        font-family: 'Vazirmatn', sans-serif;
        font-weight: bold;
        font-size: 1.1rem;
    }

    .article-btn {
        background-color: transparent !important;
        color: #d0bc7e !important;
        border: 2px solid #d0bc7e !important;
        border-radius: 8px;
        padding: 10px 20px;
        font-family: 'Vazirmatn', sans-serif;
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

@section('content')
@php
$features = explode(',', $product->features);

$data = [
'features' => $features
];
$product = [

'title' => $product->name,
'date' => $product->updated_at,
'description' => $product->desc,
$data,
'price' => $product->price,
'image' => $product->image,
'image_alt' => $product->name
];

$gallery = [
['src'=>'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg','title'=>'کاشی
در لابی مدرن','alt'=>'تصویر کاشی در لابی مدرن'],
['src'=>'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg','title'=>'کاشی
در آشپزخانه لوکس','alt'=>'تصویر کاشی در آشپزخانه لوکس'],
['src'=>'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg','title'=>'کاشی
در حمام مدرن','alt'=>'تصویر کاشی در حمام مدرن'],
['src'=>'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg','title'=>'کاشی
در فضای باز','alt'=>'تصویر کاشی در فضای باز'],
['src'=>'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg','title'=>'کاشی
در سالن پذیرایی','alt'=>'تصویر کاشی در سالن پذیرایی'],
['src'=>'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg','title'=>'کاشی
در دفتر کار','alt'=>'تصویر کاشی در دفتر کار']
];

$sizes = [
'120×240' => ['width'=>'120px','height'=>'240px'],
'60×120' => ['width'=>'60px','height'=>'120px'],
'30×60' => ['width'=>'30px','height'=>'60px']
];
@endphp

<section class="py-5 container" dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">
    <div id="contentContainer">
        <div class="article article-item" data-aos="fade-up" style="--aos-index:1;">
            <div class="overlay-container clickable-img" data-src="{{ $product['image'] }}">
                <img src="{{ $product['image'] }}" class="article-img" alt="{{ $product['image_alt'] }}">
                <div class="overlay"><i class="fa-solid fa-magnifying-glass"></i></div>
            </div>
            <h2 class="article-title" lang="{{ app()->getLocale() }}">{{ $product['title'] }}</h2>
            <p class="article-date text-muted" lang="{{ app()->getLocale() }}">{{ $product['date'] }}</p>
            <p class="article-description" lang="{{ app()->getLocale() }}">{{ $product['description'] }}</p>
            <p class="features-title" lang="{{ app()->getLocale() }}">ویژگی‌ها:</p>
            <ul lang="{{ app()->getLocale() }}">
                @foreach($product['features'] as $feature)
                <li>{{ $feature }}</li>
                @endforeach
            </ul>
            <h5 lang="{{ app()->getLocale() }}">قیمت: {{ $product['price'] }}</h5>
            <div class="d-flex justify-content-start">
                <a href="{{ route('sellagents') }}" class="btn article-btn" lang="{{ app()->getLocale() }}">{{
                    __('messages.view_agents') }}</a>
            </div>
        </div>

        <!-- Gallery -->
        <div class="row gallery-container" data-aos="fade-up" style="--aos-index:2;">
            @foreach($gallery as $index => $item)
            <div class="col-lg-4 mb-4 mb-lg-0">
                <div class="overlay-container clickable-img gallery-item mb-4" data-src="{{ $item['src'] }}"
                    data-title="{{ $item['title'] }}">
                    <img src="{{ $item['src'] }}" alt="{{ $item['alt'] }}" />
                    <div class="overlay"><i class="fa-solid fa-magnifying-glass"></i></div>
                </div>
                <p lang="{{ app()->getLocale() }}">{{ $item['title'] }}</p>
            </div>
            @endforeach
        </div>

        <!-- Sizes -->
        <div class="sizes mt-5" data-aos="fade-up" style="--aos-index:3;">
            @foreach(__('messages.size_options') as $size => $label)
            <div class="tile size-item" style="--aos-index: {{ $loop->index + 4 }};">
                <a href="{{ route('products', ['size'=>$size]) }}">
                    <div class="box {{ $size=='120×240'?'selected-box':'' }}"
                        style="width:{{ $label['width'] }}; height:{{ $label['height'] }};"></div>
                    <div class="label" data-title="{{ $size }}">{{ $size }}</div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Modal for Image Zoom -->
<div class="modal fade" id="myModal">
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
    AOS.init();

document.addEventListener('DOMContentLoaded', async function() {
    const targetLang = "{{ strtolower(app()->getLocale()) }}";

    async function translateText(text) {
        try {
            const url = `https://api.allorigins.win/raw?url=${encodeURIComponent("https://api.amirabolfazl.ir/translate?text=" + encodeURIComponent(text) + "&lang=" + targetLang)}`;
            const response = await fetch(url);
            const data = await response.json();
            return data.error ? text : data.message.translated;
        } catch (err) {
            console.error(err);
            return text;
        }
    }

    const elementsToTranslate = [];

    // مقالات و ویژگی‌ها
    document.querySelectorAll('.article-item').forEach(container => {
        const mainElements = [
            container.querySelector('.article-title'),
            container.querySelector('.article-description'),
            container.querySelector('.article-date'),
            container.querySelector('.features-title'),
            container.querySelector('h5[lang="{{ app()->getLocale() }}"]'),
            container.querySelector('.article-btn')
        ];
        mainElements.forEach(el => { if(el) elementsToTranslate.push(el); });

        // تمام ویژگی‌ها
        container.querySelectorAll('ul[lang="{{ app()->getLocale() }}"] li').forEach(li => elementsToTranslate.push(li));
    });

    // متن‌های گالری و data-title
    document.querySelectorAll('.gallery-item').forEach(item => {
        const p = item.nextElementSibling; // <p> بعد از gallery-item
        if(p) elementsToTranslate.push(p);

        if(item.dataset.title){
            const dummy = document.createElement('span');
            dummy.innerText = item.dataset.title;
            elementsToTranslate.push({
                el: item,
                setText: (text) => { item.dataset.title = text; }
            });
        }
    });

    // سایزها
    document.querySelectorAll('.size-item .label').forEach(label => elementsToTranslate.push(label));

    await Promise.all(elementsToTranslate.map(async item => {
        if(item.el && item.setText){
            const translated = await translateText(item.el.dataset.title);
            item.setText(translated);
        } else {
            const translated = await translateText(item.innerText);
            item.innerText = translated;
            item.setAttribute("lang", targetLang);
        }
    }));

    // مدال تصویر
    document.querySelectorAll('.overlay-container.clickable-img').forEach(img => {
        img.addEventListener('click', function() {
            document.getElementById('modalImage').src = this.dataset.src;
            let modal = new bootstrap.Modal(document.getElementById('myModal'));
            modal.show();
        });
    });
});
</script>
@endsection