@extends('admin.layout.master')

@section('title-site')
 مشاهده عکس کالا 
@endsection

@section('onvan')
  لیست عکس های محصول  {{ $prod->name }}
@endsection

@section('head')

@endsection

@section('main')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="stat-card mt-3">
                <div class="stat-title" style="font-size: 1.4rem"> عکس های محصول </div>

                <div class="row justify-content-start">

                    <div class="col-lg-3 col-md-6 col-6">
                        <div class="card">
                            <img class="card-img-top" src="{{ asset($imgs[0]->img_url) }}" alt="">
                            <div class="card-body text-center">
                                <p class="p-0 m-0"></p>
                                <a href="" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i><span style="padding-right: 0.6rem">حذف</span></a>
                            </div>
                        </div>
                    </div>

                    @foreach($imgs as $img)
                    <div class="col-lg-3 col-md-6 col-6">
                        <div class="card">
                            <img class="card-img-top" src="{{ asset($img->img_url) }}" alt="">
                            <div class="card-body text-center">
                                <p class="p-0 m-0"></p>
                                <a href="" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i><span style="padding-right: 0.6rem">حذف</span></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection