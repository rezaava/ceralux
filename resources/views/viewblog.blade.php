@extends('layouts.app')

@section('title', __('messages.blog'))

@section('head')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .article-container {
        background: linear-gradient(145deg, #fff8e4, #f5e9c6);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        margin-bottom: 30px;
        font-family: 'Vazirmatn', sans-serif;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        opacity: 0;
        transform: translateY(20px);
        animation: fadeUp 0.5s ease forwards;
    }

    .article-container:hover {
        transform: scale(1.01);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .article-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s ease;
    }

    .article-container:hover::before {
        left: 100%;
    }

    .article-img {
        width: 100%;
        height: auto;
        margin-bottom: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .article-title {
        color: #d0bc7e;
        font-size: 2.2rem;
        margin-bottom: 15px;
        font-weight: bold;
    }

    .article-date {
        color: #6c757d;
        margin-bottom: 20px;
        font-size: 1.1rem;
    }

    .article-content {
        color: #262f40;
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 25px;
        text-align: justify;
    }

    .article-content p {
        margin-bottom: 15px;
    }

    .back-btn {
        background-color: transparent !important;
        color: #d0bc7e !important;
        border: 2px solid #d0bc7e !important;
        border-radius: 8px;
        padding: 10px 20px;
        font-family: 'Vazirmatn', sans-serif;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .back-btn:hover {
        background-color: #d0bc7e !important;
        color: #262f40 !important;
        transform: scale(1.05);
    }

    .back-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s ease;
    }

    .back-btn:hover::before {
        left: 100%;
    }

    .social-share {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #d0bc7e;
    }

    .share-title {
        color: #d0bc7e;
        margin-bottom: 15px;
        font-size: 1.2rem;
    }

    .share-buttons a {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        background: #d0bc7e;
        color: #262f40;
        border-radius: 50%;
        margin: 0 5px;
        transition: all 0.3s ease;
    }

    .share-buttons a:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(208, 188, 126, 0.4);
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
</style>
@endsection

@section('content')
@php
$articles = [
[
'title' => 'راهنمای نصب کاشی و سرامیک',
'date' => '2025-04-05',
'content' => [
'نصب صحیح کاشی باعث دوام و زیبایی بیشتر محصول می‌شود.',
'استفاده از چسب و ملات استاندارد برای نصب ضروری است.',
'نصب توسط متخصصان، نتیجه نهایی را تضمین می‌کند.'
],
'img' => 'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg'
]
];
@endphp

<section class="py-5 container" dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">
    @foreach($articles as $article)
    <div class="article-container" data-aos="fade-up">
        <img src="{{ $article['img'] }}" class="article-img" alt="{{ __('messages.article_image_alt') }}">
        <h1 class="article-title">{{ $article['title'] }}</h1>
        <p class="article-date">{{ $article['date'] }}</p>
        <div class="article-content">
            @foreach($article['content'] as $para)
            <p>{{ $para }}</p>
            @endforeach
        </div>
        <div class="social-share">
            <h3 class="share-title">{{ __('messages.share_article') }}</h3>
            <div class="share-buttons">
                <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                <a href="#" title="Telegram"><i class="fab fa-telegram-plane"></i></a>
            </div>
        </div>
        <a href="{{ route('blog') }}" class="back-btn mt-4">
            <i class="fas fa-arrow-right me-2"></i>{{ __('messages.back_to_blog') }}
        </a>
    </div>
    @endforeach
</section>
@endsection

@section("scripts")
<script>
    AOS.init();
document.addEventListener('DOMContentLoaded', function() {
    const targetLang = "{{ strtolower(app()->getLocale()) }}";
    document.querySelectorAll('.article-container').forEach(container => {
        const titleEl = container.querySelector('.article-title');
        const contentParas = container.querySelectorAll('.article-content p');

        if(titleEl){
            fetch(`https://api.allorigins.win/raw?url=${encodeURIComponent("https://api.amirabolfazl.ir/translate?text=" + encodeURIComponent(titleEl.innerText) + "&lang=" + targetLang)}`)
            .then(res => res.json())
            .then(data => { if(!data.error){ titleEl.innerText = data.message.translated; titleEl.setAttribute("lang", targetLang); } })
            .catch(err => console.error(err));
        }

        contentParas.forEach(p => {
            fetch(`https://api.allorigins.win/raw?url=${encodeURIComponent("https://api.amirabolfazl.ir/translate?text=" + encodeURIComponent(p.innerText) + "&lang=" + targetLang)}`)
            .then(res => res.json())
            .then(data => { if(!data.error){ p.innerText = data.message.translated; p.setAttribute("lang", targetLang); } })
            .catch(err => console.error(err));
        });
    });
});
</script>
@endsection