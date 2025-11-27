@extends('admin.layout.master')

@section('title-site')
مشاهده عکس کالا
@endsection

@section('onvan')
لیست عکس های محصول {{ $prod->name }}
@endsection

@section('head')

@endsection

@section('main')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="stat-card mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="stat-title" style="font-size: 1.4rem"> عکس های محصول </div>
                    <p class="btn btn-success" id="img_post"> <i class="fa-solid fa-plus"></i><span class="p-1">عکس
                            جدید</span></p>
                </div>

                <div class="row justify-content-start">

                    <div class="col-lg-3 col-md-6 col-6">
                        <div class="card">
                            <img class="card-img-top" src="{{ asset($imgs[0]->img_url) }}" alt="">
                            <div class="card-body text-center">
                                <p class="p-0 m-0"></p>
                                <a href="" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i><span
                                        style="padding-right: 0.6rem">حذف</span></a>
                            </div>
                        </div>
                    </div>

                    @foreach($imgs as $img)
                    <div class="col-lg-3 col-md-6 col-6">
                        <div class="card">
                            <img class="card-img-top" src="{{ asset($img->img_url) }}" alt="">
                            <div class="card-body text-center">
                                <p class="p-0 m-0"></p>
                                <a href="" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i><span
                                        style="padding-right: 0.6rem">حذف</span></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>


            </div>
        </div>
    </div>
</div>

<div id="overlay" style="
    display: none; 
    position: fixed; 
    top: 0; left: 0; 
    width: 100%; height: 100%; 
    background-color: rgba(0,0,0,0.7); 
    z-index: 999;
">
    <div id="img_show" style="
    display: flex; 
    position: fixed; 
    top: 50%; left: 50%; 
    transform: translate(-50%, -50%); 
    background-color: #fff; 
    border-radius: 10px; 
    padding: 20px; 
    z-index: 1000; 
    box-shadow: 0 5px 15px rgba(0,0,0,0.5);
    width: 400px; 
    text-align: center;
">
        <h3>نمایش محتوا</h3>
        <p>این کارت وسط صفحه است.</p>
        <button id="closeImgShow" style="
        margin-top: 15px; 
        padding: 8px 16px; 
        background-color: #333; 
        color: #fff; 
        border: none; 
        border-radius: 5px;
        cursor: pointer;">بستن</button>
    </div>
</div>

<!-- کارت وسط صفحه -->

@endsection

@section('script')
<script>
    let btn = document.querySelector('#img_post');
        let overlay = document.querySelector('#overlay');

        btn.addEventListener('click' , function(){
            let status = true
            overlay.style.display = 'flex'
        })

        overlay.addEventListener('click' , function(e){
            if(e.target===overlay){
                overlay.style.display='none'
            }
        })
</script>
@endsection