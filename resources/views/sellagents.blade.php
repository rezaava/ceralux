@extends('layouts.app')

@section('title',  __('messages.sellagents') )

@section('head')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<style>
    .search-container {max-width: 600px;margin: 0 auto 30px;}
    .form-control {background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="%23d0bc7e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>');background-repeat: no-repeat;font-family: 'Vazirmatn', sans-serif;font-size: 16px;padding: 12px 20px 12px 40px;border: 2px solid #d0bc7e;border-radius: 8px;background: rgba(255, 255, 255, 0.9);margin-bottom: 20px;transition: all 0.3s ease;}
    .form-control:focus {border-color: #b89f5e;box-shadow: 0 0 10px rgba(208, 188, 126, 0.5);outline: none;}
    .sellagent {background: linear-gradient(145deg, rgba(208, 188, 126, 0.1), rgba(230, 211, 163, 0.1));padding: 15px;border-radius: 10px;margin-bottom: 20px;box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);transition: all 0.3s ease;position: relative;overflow: hidden;opacity: 0;transform: translateY(20px);animation: fadeUp 0.5s ease forwards;animation-delay: calc(0.1s * var(--aos-index));}
    .sellagent:hover {transform: scale(1.03);box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);}
    .sellagent::before {content: '';position: absolute;top: 0;left: -100%;width: 100%;height: 100%;background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);transition: left 0.5s ease;}
    .sellagent:hover::before {left: 100%;}
    .sellagent-img {height: 250px;width: 100%;object-fit: cover;border-radius: 8px;transition: opacity 0.3s ease;}
    .sellagent:hover .sellagent-img {opacity: 0.9;}
    .sellagent-content {font-family: 'Vazirmatn', sans-serif;color: #262f40;text-align: right;padding: 15px;}
    .sellagent-content h2 {font-size: 1.8rem;margin-bottom: 15px;color: #d0bc7e;}
    .sellagent-content p {font-size: 1rem;margin-bottom: 10px;}
    @keyframes fadeUp {from {opacity: 0; transform: translateY(20px);} to {opacity: 1; transform: translateY(0);}}
    [dir="rtl"] .sellagent-content {text-align: right;}
    [dir="ltr"] .sellagent-content {text-align: left;}
    [dir="rtl"] .form-control {background-position: left 15px center;padding: 12px 40px 12px 20px;}
    [dir="ltr"] .form-control {background-position: right 15px center;padding: 12px 20px 12px 40px;}
</style>
@endsection

@section('content')
<section class="py-5 container text-center" dir="{{ in_array(app()->getLocale(), ['fa','ar']) ? 'rtl' : 'ltr' }}">
    <p class="h1 mb-1" data-aos="fade-down">{{ __('messages.sellagents') }}</p>
    <div class="search-container" data-aos="fade-up" data-aos-delay="200">
        <input type="text" id="myInput" class="form-control" onkeyup="searchAgents()" placeholder="{{ __('messages.search_agents') }}" title="{{ __('messages.search_agents') }}">
    </div>
    <div id="agentsContainer">
        @php
        $agents = [
            ['title' => 'Central Store', 'address' => '123 Main Street', 'phone' => '+982112345678'],
            ['title' => 'West Branch', 'address' => '45 West Avenue', 'phone' => '+982112345679'],
            ['title' => 'East Point', 'address' => '78 East Road', 'phone' => '+982112345680'],
            ['title' => 'North Hub', 'address' => '90 North Street', 'phone' => '+982112345681'],
            ['title' => 'South Corner', 'address' => '12 South Lane', 'phone' => '+982112345682'],
        ];
        @endphp

        @foreach($agents as $index => $agent)
        <div class="row sellagent agent-item" data-aos="zoom-in-down" style="--aos-index: {{ $index + 1 }};">
            <div class="col-md-6 text-end sellagent-content">
                <h2 class="agent-title">{{ $agent['title'] }}</h2>
                <p class="agent-address">{{ $agent['address'] }}</p>
                <p class="agent-phone">{{ $agent['phone'] }}</p>
            </div>
            <div class="col-md-6">
                <img src="https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg" class="sellagent-img" alt="{{ $agent['title'] }}">
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function searchAgents() {
        var input = document.getElementById("myInput");
        var filter = input.value.toUpperCase();
        var container = document.getElementById("agentsContainer");
        var items = container.getElementsByClassName("agent-item");
        for (var i = 0; i < items.length; i++) {
            var title = items[i].getElementsByClassName("agent-title")[0];
            var txtValue = title.textContent || title.innerText;
            items[i].style.display = (txtValue.toUpperCase().indexOf(filter) > -1) ? "" : "none";
        }
    }
    document.getElementById("myInput").addEventListener("keypress", function(event) {
        if (event.key === "Enter") searchAgents();
    });

    if (typeof AOS !== 'undefined') AOS.init();

    const targetLang = "{{ strtolower(app()->getLocale()) }}";
    const agentItems = document.querySelectorAll(".agent-item");

    agentItems.forEach(function(item) {
        const titleEl = item.querySelector(".agent-title");
        const addressEl = item.querySelector(".agent-address");
        const phoneEl = item.querySelector(".agent-phone");

        if(titleEl) {
            fetch(`https://api.allorigins.win/raw?url=${encodeURIComponent("https://api.amirabolfazl.ir/translate?text=" + encodeURIComponent(titleEl.innerText) + "&lang=" + targetLang)}`)
            .then(res => res.json())
            .then(data => { if(!data.error){ titleEl.innerText = data.message.translated; titleEl.setAttribute("lang", targetLang); } })
            .catch(err => { console.error(err); });
        }
        if(addressEl) {
            fetch(`https://api.allorigins.win/raw?url=${encodeURIComponent("https://api.amirabolfazl.ir/translate?text=" + encodeURIComponent(addressEl.innerText) + "&lang=" + targetLang)}`)
            .then(res => res.json())
            .then(data => { if(!data.error){ addressEl.innerText = data.message.translated; addressEl.setAttribute("lang", targetLang); } })
            .catch(err => { console.error(err); });
        }
        if(phoneEl) {
            fetch(`https://api.allorigins.win/raw?url=${encodeURIComponent("https://api.amirabolfazl.ir/translate?text=" + encodeURIComponent(phoneEl.innerText) + "&lang=" + targetLang)}`)
            .then(res => res.json())
            .then(data => { if(!data.error){ phoneEl.innerText = data.message.translated; phoneEl.setAttribute("lang", targetLang); } })
            .catch(err => { console.error(err); });
        }
    });
});
</script>
@endsection
