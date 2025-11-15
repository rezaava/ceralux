@extends('layouts.app')

@section("title", __("messages.contact"))

@section('head')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://unpkg.com/vanilla-tilt@1.7.0/dist/vanilla-tilt.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/splide@4.0.7/dist/css/splide.min.css">
<script src="https://unpkg.com/splide@4.0.7/dist/js/splide.min.js"></script>
<style>
.sellagent, .contact-card { 
    background: linear-gradient(145deg,#fff8e4,#f5e9c6); 
    padding:15px; border-radius:10px; margin-bottom:20px; 
    box-shadow:0 8px 16px rgba(0,0,0,0.15); 
    position:relative; overflow:hidden; font-family:'Vazirmatn',sans-serif; 
    transition: all 0.3s ease; opacity:0; transform:translateY(20px); 
    animation:fadeUp 0.5s ease forwards; animation-delay:calc(0.1s*var(--aos-index));
}
.sellagent:hover, .contact-card:hover { transform: scale(1.02); box-shadow:0 12px 24px rgba(0,0,0,0.2); }
.sellagent::before, .contact-card::before { 
    content:''; position:absolute; top:0; left:-100%; width:100%; height:100%; 
    background:linear-gradient(90deg,transparent,rgba(255,255,255,0.3),transparent); transition:left 0.5s ease;
}
.sellagent:hover::before, .contact-card:hover::before { left:100%; }
.sellagent h2, .contact-card h2 { color:#d0bc7e; font-size:1.8rem; margin-bottom:10px; }
.sellagent p, .contact-card p { color:#262f40; font-size:1rem; }
.sellagent-img { width:100%; height:250px; object-fit:cover; border-radius:8px; }
.contact-btn { background-color: transparent !important; color: #d0bc7e !important; border: 2px solid #d0bc7e !important; border-radius: 8px; padding: 10px 20px; font-family:'Vazirmatn',sans-serif; transition: all 0.3s ease; position: relative; overflow: hidden; margin-top: 10px; }
.contact-btn:hover { background-color:#d0bc7e !important; color:#262f40 !important; transform: scale(1.05); }
.contact-btn::before { content:''; position:absolute; top:0; left:-100%; width:100%; height:100%; background:linear-gradient(90deg,transparent,rgba(255,255,255,0.4),transparent); transition:left 0.5s ease; }
.contact-btn:hover::before { left:100%; }
.video-slider video { width:100%; height:400px; object-fit:cover; }
.slider-global-caption, .slider-global-caption-l { position:absolute; top:50%; transform:translateY(-50%); background: linear-gradient(145deg,#fff8e4,#f5e9c6); padding:20px 30px; border-radius:10px; color:#262f40; text-align:center; width:35%; height:180px; display:flex; flex-direction:column; justify-content:center; align-items:center; box-shadow:0 8px 16px rgba(0,0,0,0.15); font-family:'Vazirmatn',sans-serif; }
.slider-global-caption { right:10%; } .slider-global-caption-l { left:10%; }
.slider-global-caption h2, .slider-global-caption-l h2 { font-size:1.8rem; color:#d0bc7e; margin-bottom:10px; }
.slider-global-caption p, .slider-global-caption-l p { font-size:1rem; color:#262f40; }
.slider-global-caption i, .slider-global-caption-l i { font-size:2.5rem; margin-bottom:10px; }
@keyframes fadeUp { from{opacity:0;transform:translateY(20px);} to{opacity:1;transform:translateY(0);} }
@media (max-width:1185px) { .slider-global-caption, .slider-global-caption-l { width:80%; height:150px; padding:15px; } .slider-global-caption h2, .slider-global-caption-l h2 { font-size:1.5rem; } .slider-global-caption p, .slider-global-caption-l p { font-size:0.9rem; } .video-slider video { height:300px; } }
.search-container { max-width:600px; margin:0 auto 30px; }
.form-control { background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="%23d0bc7e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>'); background-repeat:no-repeat; font-family:'Vazirmatn',sans-serif; font-size:16px; padding:12px 20px 12px 40px; border:2px solid #d0bc7e; border-radius:8px; background:rgba(255,255,255,0.9); margin-bottom:20px; transition:all 0.3s ease; }
[dir="rtl"] .form-control { background-position: left 15px center; padding: 12px 40px 12px 20px; }
[dir="ltr"] .form-control { background-position: right 15px center; padding: 12px 20px 12px 40px; }
</style>
@endsection

@section('content')
<section dir="ltr" class="splide video-slider" aria-label="Video Slider">
    <div class="splide__track">
        <ul class="splide__list">
            <li class="splide__slide">
                <video autoplay muted loop>
                    <source src="https://abadistile.com/wp-content/uploads/2023/11/slider-abadis-tile-4-3.mp4" type="video/mp4">
                </video>
            </li>
            <li class="splide__slide">
                <video autoplay muted loop>
                    <source src="https://abadistile.com/wp-content/uploads/2023/11/slider-abadis-tile-2-3-1.m4v" type="video/mp4">
                </video>
            </li>
        </ul>
    </div>
    <div class="row" id="contact-slider" style="display:none;">
        <div class="col-6">
            <div class="slider-global-caption" data-aos="fade-up" style="--aos-index:1;">
                <i class="fas fa-phone"></i>
                <h2>{{ __('messages.phone_number') }}</h2>
                <p>{{ __('messages.company_phone') }}</p>
            </div>
        </div>
        <div class="col-6">
            <div class="slider-global-caption-l" data-aos="fade-up" style="--aos-index:2;">
                <i class="fas fa-map-marker"></i>
                <h2>{{ __('messages.address') }}</h2>
                <p>{{ __('messages.company_address') }}</p>
            </div>
        </div>
    </div>
</section>

<section class="py-5 container text-center" dir="{{ in_array(app()->getLocale(), ['fa','ar'])?'rtl':'ltr' }}">
    <p class="h1 mb-4" style="color:#d0bc7e; font-family:'Vazirmatn',sans-serif;">{{ __('messages.agents') }}</p>
    <div class="search-container" data-aos="fade-up" data-aos-delay="200">
        <input type="text" id="myInput" class="form-control" onkeyup="searchAgents()" placeholder="{{ __('messages.search_agents') }}">
    </div>
    <div class="row" id="agentsContainer">
        @foreach(__('messages.agents_list') as $key => $agent)
        <div class="col-md-6 agent-item">
            <div class="sellagent" data-aos="fade-up" style="--aos-index: {{ $loop->index + 5 }};">
                <div class="row align-items-center">
                    <div class="col-md-6 text-end">
                        <h2 class="agent-title">{{ $agent['title'] }}</h2>
                        <p class="agent-address">{{ $agent['address'] }}</p>
                        <p class="agent-phone">{{ $agent['phone'] }}</p>
                        <a href="tel:{{ $agent['phone'] }}" class="btn contact-btn">{{ __('messages.contact_agent') }}</a>
                    </div>
                    <div class="col-md-6">
                        <img src="{{ $agent['image'] ?? 'https://abadistile.com/wp-content/uploads/2024/06/eleman-frisco-lobby-120240-ll-1536x1536.jpg' }}" class="sellagent-img">
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Splide('.splide',{type:'fade',autoplay:true,pagination:false,rewind:true,pauseOnHover:false,pauseOnFocus:false,pause:false,speed:800}).mount();
    const contactSlider=document.getElementById("contact-slider");
    function updateDisplay(){contactSlider.style.display=(window.innerWidth>=1185)?"flex":"none";}
    updateDisplay(); window.addEventListener('resize',updateDisplay);
    VanillaTilt.init(document.querySelectorAll(".slider-global-caption, .slider-global-caption-l, .sellagent-img"), { scale:1.05,speed:400,glare:true,maxGlare:0.3 });
    const navbar=document.querySelector('.navbar'); const toggler=document.querySelector('.navbar-toggler');
    navbar.classList.remove('colored'); navbar.classList.remove('sticky-top'); navbar.classList.add('fixed-top');
    window.addEventListener('scroll',()=>{window.scrollY>5?navbar.classList.add('colored'):navbar.classList.remove('colored');});
    toggler.addEventListener('click',()=>{navbar.classList.add('colored');});
    if(typeof AOS!=='undefined') AOS.init();

    // جستجوی نمایندگان
    window.searchAgents=function(){
        let input=document.getElementById("myInput").value.toUpperCase();
        document.querySelectorAll(".agent-item").forEach(item=>{
            let title=item.querySelector(".agent-title").innerText.toUpperCase();
            item.style.display=title.indexOf(input)>-1?"":"none";
        });
    }
});
</script>
@endsection
