@extends('layouts.app')

@section('title', __('messages.blog'))

@section('head')
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
    .article-img {
        width: 100%;
        height: auto;
        margin-bottom: 10px;
    }

    .article-btn {
        background-color: transparent !important;
        color: #d0bc7e !important;
        border: 2px solid #d0bc7e !important;
        width: 100%;
        transition: all 0.3s ease;
    }

    .article-btn:hover {
        background-color: #d0bc7e !important;
        color: #262f40 !important;
    }

    .article {
        border: solid 10px #ffffff;
        background-color: #fff8e4;
        padding: 10px;
        border-radius: 5px;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .article-content {
        flex-grow: 1;
    }

    .article-title {
        color: #262f40;
        font-size: 1.5rem;
        margin-bottom: 10px;
        min-height: 72px;
    }

    .article-date {
        color: #6c757d;
        margin-bottom: 10px;
    }

    .article-excerpt {
        color: #262f40;
        margin-bottom: 15px;
        flex-grow: 1;
    }
</style>
@endsection

@section('content')
<section class="py-5 container" dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">
    <h1 class="text-center mb-5" style="color: #d0bc7e;">{{ __('messages.blog') }}</h1>
    <div class="row">
        @php
        $articles = [];
        for ($i=1; $i<=20; $i++) { $articles[]=[ 'title'=> "عنوان مقاله شماره $i",
            'date' => date('Y-m-d', strtotime("-$i days")),
            'excerpt' => "این یک متن نمونه کوتاه برای مقاله شماره $i است که برای پر کردن قالب استفاده می‌شود."
            ];
            }
            @endphp

            @foreach($articles as $i => $article)
            <div class="col-md-3 mb-4 article-item" data-aos="zoom-in">
                <div class="article">
                    <img src="https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg"
                        class="article-img" alt="تصویر مقاله شماره {{ $i + 1 }}">
                    <div class="article-content">
                        <h2 class="article-title">{{ $article['title'] }}</h2>
                        <p class="article-date">{{ $article['date'] }}</p>
                        <p class="article-excerpt">{{ $article['excerpt'] }}</p>
                    </div>
                    <a class="btn article-btn" href="/blog/{{ $i + 1 }}">{{ __('messages.read_more') }}</a>
                </div>
            </div>
            @endforeach
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    AOS.init();

    const targetLang = "{{ strtolower(app()->getLocale()) }}";
    const articleItems = document.querySelectorAll(".article-item");

    articleItems.forEach(function(item) {
        const titleEl = item.querySelector(".article-title");
        const excerptEl = item.querySelector(".article-excerpt");

        if(titleEl) {
            fetch(`https://api.allorigins.win/raw?url=${encodeURIComponent("https://api.amirabolfazl.ir/translate?text=" + encodeURIComponent(titleEl.innerText) + "&lang=" + targetLang)}`)
            .then(res => res.json())
            .then(data => { if(!data.error){ titleEl.innerText = data.message.translated; titleEl.setAttribute("lang", targetLang); } })
            .catch(err => { console.error(err); });
        }

        if(excerptEl) {
            fetch(`https://api.allorigins.win/raw?url=${encodeURIComponent("https://api.amirabolfazl.ir/translate?text=" + encodeURIComponent(excerptEl.innerText) + "&lang=" + targetLang)}`)
            .then(res => res.json())
            .then(data => { if(!data.error){ excerptEl.innerText = data.message.translated; excerptEl.setAttribute("lang", targetLang); } })
            .catch(err => { console.error(err); });
        }
    });
});
</script>
@endsection