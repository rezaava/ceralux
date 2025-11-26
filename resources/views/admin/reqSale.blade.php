@extends('admin.layout.master')

@section('title-site')
 درخواست فروش
@endsection

@section('onvan')
 درخواست فروش
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

        /* استایل‌های سفارشی برای Select2 */
    .select2-container--default .select2-selection--single {
        background-color: #232323 !important;
        border: none !important;
        color: #fff !important;
        height: 50px;
        border-radius: 10px;
        margin-top: 2rem;
        width: 100%;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #fff !important;
        line-height: 50px;
        padding-right: 15px;
        text-align: right;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 50px;
        left: 10px;
        right: auto;
        top:32px;
    }

    /* Dropdown استایل */
    .select2-container--default .select2-results__option {
        background-color: #151A23 !important;
        color: #fff !important;
        text-align: right;
        padding: 10px 15px;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #3BDE77 !important;
        color: #fff !important;
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #1c2535 !important;
        color: #3BDE77 !important;
    }
    /* جستجو input */
    .select2-container--default .select2-search--dropdown .select2-search__field {
        background-color: #1e2839 !important;
        border: none !important;
        color: #fff !important;
        border-radius: 10px;
        padding: 10px 15px;
        width: 100% !important;
        margin: 0 !important;
    }
    /* Dropdown container */
    .select2-container--default .select2-results > .select2-results__options {
        background-color: #151A23 !important;
        border: 1px solid #444 !important;
        border-bottom-left-radius: 1rem !important;
        border-bottom-right-radius: 1rem !important;
    }

    .select2-dropdown {
        background-color: #151A23 !important;
        border: 1px solid #444 !important;
        border-bottom-left-radius: 1rem !important;
        border-bottom-right-radius: 1rem !important;
    }

    .select2-container--open .select2-dropdown--below {
        border-top: 1px solid #444 !important;
    }


    .select2-results__options::-webkit-scrollbar {
        width: 8px;
        background: transparent !important;
    }

    .select2-results__options::-webkit-scrollbar-track {
        background: transparent !important;
        border-radius: 4px;
    }

    .select2-results__options::-webkit-scrollbar-thumb {
        background: transparent !important;
        border-radius: 4px;
    }

    .select2-results__options::-webkit-scrollbar-thumb:hover {
        background: transparent !important;
    }

    /* برای Firefox */
    .select2-results__options {
        scrollbar-width: thin;
        background: transparent !important;
        scrollbar-color: #3BDE77 transparent;
    }

    @media (max-width: 768px) {
        .form-row-responsive {
            flex-direction: column;
        }


        .form-row-responsive .form-control {
            width: 100% !important;
        }

        .form-row-responsive .form-select {
            width: 100% !important;
        }

        .textArea {
            width: 100%;
        }
    }
</style>
@endsection

@section('main')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="stat-card mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="stat-title" style="font-size: 1.6rem">ثبت فاکتور جدید</div>
                    {{-- <a href="" class="btn btn-success "><i class="fa-solid fa-plus"></i><span class="p-2">تعریف محصول جدید</span></a> --}}
                </div>

                <form action="" method="POST">
                    
                    <div class="d-flex gap-3 form-row-responsive mt-3">
                        <select class="form-select select2-farsi w-50" dir="rtl" name="" id="">
                            <option value="" selected>مشتری را انتخاب کنید</option>
                            @foreach($prods as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                            @endforeach
                        </select>
                        
                        
                    </div>
                    <div class="d-flex gap-3 form-row-responsive mt-3">
                        <input type="text" name="" class="form-control w-50 mb-3" placeholder="شماره تراکنش ">
                        <input type="text" name="" class="form-control w-50 mb-3" placeholder="شماره موبایل ">
                        <input type="text" name="" class="form-control w-50 mb-3" placeholder="تاریخ">
                    </div>

                    <div class="d-flex gap-3 form-row-responsive">
                        <input type="text" name="" class="form-control w-100 mb-3" placeholder="آدرس">
                        <select class="form-select" name="" id="">
                            <option value="" selected>اسم فروشنده</option>
                            <option value=""></option>
                        </select>
                    </div>

                     <div class="text-center"><button class="btn btn-success w-50 mt-3">ثبت </button></div>
                </form>


                <form action="/admin/product/add" method="POST">
                    @csrf


                    <div class="d-flex gap-3 form-row-responsive justify-content-start">

                        <select class="form-select select2-farsi w-50" dir="rtl" name="" id="">
                            <option value="" selected>محصول را انتخاب کنید</option>
                            @foreach($prods as $prod)
                            <option value="{{ $prod->id }}">{{ $prod->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="d-flex gap-3 form-row-responsive mt-3">
                        <input type="text" name="count_box" class="form-control w-50" placeholder="تعداد کارتن">
                        <input type="text" name="count_meter" class="form-control w-50" placeholder="متراژ هر کارتن   ">
                        <input type="text" name="count_palet" class="form-control w-50" placeholder=" تعداد پالت ">
                        <input type="text" name="count_all  " class="form-control w-50" placeholder="  متراژ کل ">
                    </div>

                    <div class="text-center"><button class="btn btn-success w-50 mt-3">افزودن کالا</button></div>
                </form>

                <table class="table table-dark table-hover mt-3 table-borderless" style="table-layout: fixed">
                    <thead class="text-center" style="border-bottom: 2px solid #3BDE77;">
                      <tr>
                        <th>ردیف</th>
                        <th>کد کالا</th>
                        <th>نام محصول</th>
                        <th>تعداد کارتن</th>
                        <th>تعداد پالت</th>
                        <th> متراژ کل</th>
                        <th>  قیمت</th>
                        <th>  قیمت کل</th>
                      </tr>
                    </thead>
                    <tbody class="text-center">
                      <tr>
                        <td>1</td>
                        <td>324fg</td>
                        <td>کاشی</td>
                        <td>3</td>
                        <td>0</td>
                        <td>60M</td>
                        <td>200,000</td>
                        <td>12,000,000</td>
                      </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between" style="padding: 0 4rem;">
                    <p class="m-0 p-0">متراژ کل : <span style="padding-right: 0.5rem">60</span><span style="padding-right: 0.2rem">متر</span></p>
                    <p class="m-0 p-0">تعداد کارتن : <span style="padding-right: 0.5rem">3</span><span style="padding-right: 0.2rem">تعداد</span></p>
                    <p class="m-0 p-0">تعداد پالت ها : <span style="padding-right: 0.5rem">0</span><span style="padding-right: 0.2rem">تعداد</span></p>
                </div>
                <div class="d-flex justify-content mt-3" style="padding: 0 4rem;">
                    <p class="m-0 p-0">قیمت کل  : <span style="padding-right: 0.5rem">10,000,000</span><span style="padding-right: 0.2rem">تومان</span></p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // تنظیمات Select2 برای فارسی
    $('.select2-farsi').select2({
        dir: "rtl", // راست به چپ
        
        language: {
            noResults: function() {
                return "نتیجه‌ای یافت نشد";
            },
            searching: function() {
                return "در حال جستجو...";
            }
        }
    });
});
</script>
@endsection