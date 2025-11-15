@extends('layouts.app')

@section('title', __('messages.products'))

@section('head')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .search-container { max-width: 600px; margin: 0 auto 30px; }
    .form-control { background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="%23d0bc7e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>'); background-position: right 15px center; background-repeat: no-repeat; font-family: 'Vazirmatn', sans-serif; font-size: 16px; padding: 12px 20px 12px 40px; border: 2px solid #d0bc7e; border-radius: 8px; background: rgba(255, 255, 255, 0.9); margin-bottom: 20px; transition: all 0.3s ease; }
    .form-control:focus { border-color: #b89f5e; box-shadow: 0 0 10px rgba(208, 188, 126, 0.5); outline: none; }
    .product-card { height: 300px; background-size: cover; background-position: center; margin-bottom: 20px; display: flex; align-items: center; justify-content: center; position: relative; border-radius: 10px; overflow: hidden; background: linear-gradient(145deg, rgba(208, 188, 126, 0.2), rgba(230, 211, 163, 0.2)); box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15); transition: transform 0.3s ease, box-shadow 0.3s ease; opacity: 0; transform: translateY(20px); animation: fadeUp 0.5s ease forwards; animation-delay: calc(0.1s * var(--aos-index)); }
    .product-card:hover { transform: scale(1.03); box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2); }
    .product-overlay { background: linear-gradient(145deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.3)); position: absolute; border-radius: 10px; inset: 0; transition: opacity 0.3s ease; }
    .product-card:hover .product-overlay { opacity: 0.7; }
    .product-content { position: relative; text-align: center; z-index: 2; padding: 20px; }
    .product-content h3 { font-family: 'Vazirmatn', sans-serif; font-size: 1.5rem; margin-bottom: 15px; }
    .product-btn { background-color: transparent !important; color: #d0bc7e !important; border: 2px solid #d0bc7e !important; border-radius: 8px; padding: 10px 20px; font-family: 'Vazirmatn', sans-serif; transition: all 0.3s ease; position: relative; overflow: hidden; }
    .product-btn:hover { background-color: #d0bc7e !important; color: #262f40 !important; transform: scale(1.05); }
    .product-btn::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent); transition: left 0.5s ease; }
    .product-btn:hover::before { left: 100%; }
    .product-name { font-family: 'Vazirmatn', sans-serif; margin-top: 10px; text-align: end; }
    @keyframes fadeUp { from {opacity:0; transform:translateY(20px);} to {opacity:1; transform:translateY(0);} }
    [dir="rtl"] .form-control { background-position: left 15px center; padding: 12px 40px 12px 20px; }
</style>
@endsection

@section('content')
<section class="py-5 container text-center" dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">
    <p class="h1 mb-1" data-aos="fade-down">{{__("messages.products")}}</p>
    <div class="search-container" data-aos="fade-up" data-aos-delay="200">
        <input type="text" id="myInput" class="form-control" onkeyup="searchProducts()" placeholder="{{__('messages.search_products')}}" title="{{__("messages.search_products")}}">
    </div>
    <div class="row" id="productsContainer">
        @php
        $products = [
            ['title' => 'سرامیک آبی', 'image' => 'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg', 'link' => '/products/info/1'],
            ['title' => 'سرامیک کلاسیک', 'image' => 'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg', 'link' => '/products/info/2'],
            ['title' => 'سرامیک مدرن', 'image' => 'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg', 'link' => '/products/info/3'],
            ['title' => 'سرامیک برنزی', 'image' => 'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg', 'link' => '/products/info/4'],
            ['title' => 'سرامیک لوکس', 'image' => 'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg', 'link' => '/products/info/5'],
            ['title' => 'سرامیک مینیمال', 'image' => 'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg', 'link' => '/products/info/6'],
        ];
        @endphp

        @foreach($products as $index => $product)
        <div class="col-md-3 product-item" data-aos="zoom-in" style="--aos-index: {{ $index + 1 }};">
            <div class="product-card" style="background-image: url('{{ $product['image'] }}');">
                <div class="product-overlay"></div>
                <div class="product-content">
                    <h3 class="product-title">{{ $product['title'] }}</h3>
                    <a href="{{ $product['link'] }}" class="btn product-btn">{{__("product_info")}}</a>
                </div>
            </div>
            <p class="product-name">{{ $product['title'] }}</p>
        </div>
        @endforeach
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

    function searchProducts() {
        var input = document.getElementById("myInput");
        var filter = input.value.toUpperCase();
        var container = document.getElementById("productsContainer");
        var items = container.getElementsByClassName("product-item");
        for (var i = 0; i < items.length; i++) {
            var title = items[i].getElementsByClassName("product-title")[0];
            var txtValue = title.textContent || title.innerText;
            items[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }
    }
    document.getElementById("myInput").addEventListener("keypress", function(event) {
        if (event.key === "Enter") searchProducts();
    });

    @php
        $locale = strtolower(app()->getLocale());
    @endphp

    const productItems = document.querySelectorAll(".product-item");
    productItems.forEach(function(item) {
        const titleEl = item.querySelector(".product-title");
        const nameEl = item.querySelector(".product-name");
        if(titleEl) {
            fetch(`https://api.allorigins.win/raw?url=${encodeURIComponent("https://api.amirabolfazl.ir/translate?text=" + encodeURIComponent(titleEl.innerText) + "&lang=" + "{{ $locale }}")}`)
            .then(res => res.json())
            .then(data => { 
                if(!data.error){ 
                    titleEl.innerText = data.message.translated; 
                    nameEl.innerText = data.message.translated;
                    titleEl.setAttribute("lang", "{{ $locale }}"); 
                    nameEl.setAttribute("lang", "{{ $locale }}"); 
                } 
            }).catch(err => console.error(err));
        }
    });

    if (typeof AOS !== 'undefined') AOS.init();
});
</script>
@endsection
