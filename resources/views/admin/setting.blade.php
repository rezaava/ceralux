@extends('admin.layout.master')

@section('title-site')
 تنظیمات
@endsection

@section('onvan')
 تنظیمات
@endsection

@section('title-onvan')
<div class="dashboard-desc">خوش آمدید! امروز <span style="color:var(--accent-green)">۵ اعلان جدید</span> دارید.</div>
@endsection

@section('head')
<style>
    .form-control {
        background-color: #232323 !important;
        border: none !important;
        color: #fff !important;
        margin: 1rem 0;
        
    }

    .form-select {
        background-color: #232323 !important;
        border: none !important;
        color: #fff;
        margin: 1rem 0;
    }

    .form-control::placeholder {
        color: #8ecae6;
        opacity: 0.5;
    }

    .form-select::placeholder {
        color: #8ecae6;
        opacity: 0.5;
    }

    .textArea {
        height: 200px;
        resize: none;
    }
</style>
@endsection
@section('main')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="stat-card mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="stat-title" style="font-size: 1.6rem">تنظیمات</div>
                </div>

                <form action="/admin/setting/name/add" method="POST">
                    @csrf
                    <div class="d-flex gap-3 form-row-responsive mt-3">
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? '' }}">
                        <input type="text" name="name_dispaly" id="phone" value="{{ Auth::user()->dispaly_name ?? '' }}" class="form-control w-50 mb-3" placeholder="اسم نمایشی داخل پنل  ">
                        {{-- <input type="text" id="address" name="address" class="form-control w-50 mb-3" placeholder="آدرس"> --}}
                        
                    </div>
                    <div class="text-center mt-3"><button class="btn btn-success w-50">ثبت</button></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection