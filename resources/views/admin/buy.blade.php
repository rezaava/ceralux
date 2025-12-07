@extends('admin.layout.master')

@section('title-site')
 فاکتور خرید 
@endsection

@section('onvan')
   فاکتور خرید
@endsection

{{-- @section('title-onvan')
<div class="dashboard-desc">خوش آمدید! امروز <span style="color:var(--accent-green)">۵ اعلان جدید</span> دارید.</div>
@endsection --}}

@section('head')
<style>
       .form-control {
        background-color: #232323 !important;
        border: none !important;
        color: #fff !important;
        /* margin: 1rem 0; */
        
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
        top: 32px;
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
    .select2-container--default .select2-results>.select2-results__options {
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
</style>
@endsection

@section('main')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="stat-card mt-3">

               <div class="d-flex justify-content-between align-items-center">
                  <div class="stat-title" style="font-size: 1.6rem">ثبت فاکتور خرید</div>
                  <a href="/admin/product/add/{id}" class="btn btn-success "><i class="fa-solid fa-plus"></i><span class="p-2">تعریف محصول جدید</span></a>
               </div>
               @if(!$cart)
               <form action="/admin/crm/add/cart/buy" method="GET">
                  <div class="d-flex gap-3 form-row-responsive mt-3">
                     <input type="text" value="" name="date_buy" class="form-control w-50" placeholder=" تاریخ فاکتور خرید">
                     <input type="text" value="" name="code_buy" class="form-control w-50" placeholder="شماره فاکتور خرید">
                  </div>
                   <div class="text-center mt-3"><button class="btn btn-success w-50">ثبت</button></div>
               </form>
               @else
                  <div class="card p-3" style="border-radius: 0.4rem;border:none;color:lightblue;">
                      <div class="row ">
                          <div class="col-12 col-md-6">
                              <p class="m-0">شماره فاکتور خرید : {{$cart->num_cart}}</p>
                          </div>
                          <div class="col-12 col-md-6">
                              <p class="m-0">تاریخ فاکتور خرید : {{$cart->date}}</p>
                          </div>
                      </div>
                  </div>
                <form action="/admin/crm/buy/product/add" method="GET">

                    <div class="d-flex gap-3 form-row-responsive justify-content-center">
                        <select class="form-select select2-farsi w-100" dir="rtl" name="prod_id" id="customerSelect">
                           <option value="" selected>طرح را جستجو کنید</option>
                           @foreach($prods as $prod)
                           <option value="{{ $prod->id }}">{{$prod->code_prod}}--{{ $prod->name }}</option>
                           @endforeach
                        </select>
                    </div>

                    <div class="d-flex gap-3 form-row-responsive justify-content-center mt-3">
                        <input type="hidden" value="{{ $cart->id }}" name="cart_id">
                        <input type="text" name="count_palet" class="form-control w-50" placeholder=" تعداد پالت ">
                        <input type="text" name="count_box" class="form-control w-50" placeholder=" تعداد کارتن در پالت ">
                        <input type="text" name="count_all" class="form-control w-50" placeholder="متراژ کل" readonly>
                    </div>

                    <div class="text-center mt-3"><button class="btn btn-success w-50">اضافه کردن</button></div>

                </form>
                @foreach($cart_prods as $cart_prod)
                <div class="row">
                   <div class="col-6">
                        <div class="card p-0" style="border-radius: 0.4rem;border:none;color:#43E97B;border-right: 3px solid #43E97B;">
                            <div class="card-body">
                                <p>نام محصول :   کاشی ماربل</p>
                                <p>نام محصول :   کاشی ماربل</p>
                            </div>
                         </div>
                   </div>
                </div>
                @endforeach
               @endif
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
                    return "نتیجه‌ای یافت نشد لطفا اول کالا را اضافه کنید";
                },
                searching: function() {
                    return "در حال جستجو...";
                }
            }
        });
    });
</script>
@endsection