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
        /* margin: 1rem 0; */
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

    table {
        table-layout: fixed;
    }

    table th {
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        table {
            table-layout: auto;
        }

        #btn-final {
            width: 100%;
        }

        .form-row-responsive {
            flex-direction: column;
        }

        .form-row-responsive>div {
            width: 100% !important;
        }

        .form-row-responsive .form-control,
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
        <div class="col-lg-10 col-md-10 col-12">
            <div class="stat-card mt-3">

               <div class="d-flex justify-content-between align-items-center">
                  <div class="stat-title" style="font-size: 1.6rem">ثبت فاکتور خرید</div>
                  <a target="_blank" href="/admin/product/add/{id}" class="btn btn-success "><i class="fa-solid fa-plus"></i><span class="p-2" >تعریف محصول جدید</span></a>
               </div>
               @if(!$cart)
               <form action="/admin/crm/add/cart/buy" method="GET">
                  <div class="d-flex gap-3 form-row-responsive mt-3">
                    <input type="text" value="{{ old('date_buy') }}" name="date_buy" class="form-control w-50" placeholder=" تاریخ فاکتور خرید">
                    <input type="text" value="{{ old('code_buy') }}" name="code_buy" class="form-control w-50" placeholder="شماره فاکتور خرید">
                  </div>
                    @error('date_buy')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                    @error('code_buy')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
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
                        <select class="form-select select2-farsi w-100" dir="rtl" name="prod_id" id="productSelect">
                           <option value="" selected>طرح را جستجو کنید</option>
                           @foreach($prods as $prod)
                           <option value="{{ $prod->id }}">{{$prod->code_prod}}--{{ $prod->name }}</option>
                           @endforeach
                        </select>

                        {{-- <select class="form-select select2-farsi w-50" dir="rtl" name="prod_id" id="productSelect">
                           <option value="" selected>سایز را جستجو کنید</option>
                           @foreach($prods as $prod)
                           <option value="{{ $prod->id }}">{{$prod->code_prod}}--{{ $prod->name }}</option>
                           @endforeach
                        </select> --}}
                    </div>
                    @error('prod_id')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror

                    <div class="d-flex gap-3 form-row-responsive mt-3">
                        <input type="hidden" value="{{ $cart->id }}" name="cart_id">

                        <div class="w-50">
                            <label for="">سایز کاشی </label>
                            <select name="size_id" id="sizeSelect" class="form-select m-0">
                                <option value="" selected disabled>سایز را انتخاب کنید</option>
                            </select>
                            @error('size_id')
                                <small class="text-danger d-block mt-2">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="w-50">
                            <label for="">متراژ کل</label>
                            <input type="text" name="count_all" id="all" class="form-control" placeholder="متراژ کل" >
                        </div>

                        <div class="w-50">
                            <label for="">تعداد کارتن</label>
                            <input type="text" name="count_box" id="box" class="form-control" placeholder=" تعداد کارتن">
                            @error('count_box')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                        </div>

                        <div class="w-50">
                            <label for="">تعداد پالت</label>
                            <input type="text" name="count_palet" id="palet" class="form-control" placeholder=" تعداد پالت ">
                            @error('count_palet')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                        </div>

                        <div class="w-50">
                            <label>واحد ارزی</label>
                            <select name="no_price" class="form-select">
                                <option value="" disabled selected> نوع ارز را انتخاب کنید</option>
                                <option value="1" {{ old('no_price', $editProd->no_price ?? '') == 1 ? 'selected' : '' }}>تومان</option>
                                <option value="2" {{ old('no_price', $editProd->no_price ?? '') == 2 ? 'selected' : '' }}>درهم</option>
                                <option value="3" {{ old('no_price', $editProd->no_price ?? '') == 3 ? 'selected' : '' }}>دلار</option>
                            </select>
                            @error('no_price') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

                    </div>

                    <div class="text-center mt-3"><button class="btn btn-success w-50">اضافه کردن</button></div>

                </form>
                <div class="table-responsive mt-4">
                    <table class="table table-dark table-hover mt-3 table-borderless">
                            <thead class="text-center" style="border-bottom: 2px solid #3BDE77;">
                                <tr>
                                    <th>ردیف</th>
                                    <th>کد کالا</th>
                                    <th>نام محصول</th>
                                    <th> سایز محصول</th>
                                    <th>تعداد کارتن</th>
                                    <th>متراژ هر کارتن</th>
                                    <th>تعداد پالت</th>
                                    <th> متراژ کل</th>
                                    <th> قیمت</th>
                                    <th> قیمت کل</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($cart_prods as $key => $cart_prod)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$cart_prod->prod->code_prod}}</td>
                                    <td>{{$cart_prod->prod->name}}</td>
                                    <td>{{$cart_prod->size->name}}</td>
                                    <td>{{$cart_prod->count_box}}</td>
                                    <td>{{$cart_prod->meter->box_meter}}</td>
                                    <td>{{$cart_prod->count_palet}}</td>
                                    <td>{{$cart_prod->count_all}}</td>
                                    <td>{{number_format($cart_prod->prod->price)}}</td>
                                    <td>{{number_format($cart_prod->prod->price * ($cart_prod->count_all))}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>

                <div class="stat-card ">

                    <div class="row">

                        <div class="col-lg-4 col-md-6 col-12">
                            <p class="m-0 p-0">متراژ کل : <span style="padding-right: 0.5rem">{{$meter}}</span><span style="padding-right: 0.2rem">متر</span></p>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <p class="m-0 p-0">تعداد کارتن : <span style="padding-right: 0.5rem">{{$box}}</span><span style="padding-right: 0.2rem">تعداد</span></p>
                        </div>

                        <div class="col-lg-4 col-md-6 col-12">
                            <p class="m-0 p-0">تعداد پالت ها : <span style="padding-right: 0.5rem">{{$palet}}</span><span style="padding-right: 0.2rem">تعداد</span></p>
                        </div>

                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-4 col-md-6 col-12">
                            <p class="m-0 p-0">قیمت کل : <span style="padding-right: 0.5rem">{{number_format($priceAll)}}</span>
                                @if($cart->no_price == 1)
                                <span style="padding-right: 0.2rem">تومان</span></p>
                                @elseif($cart->no_price == 2)
                                <span style="padding-right: 0.2rem">درهم</span></p>
                                @elseif($cart->no_price == 3)
                                <span style="padding-right: 0.2rem">دلار</span></p>
                                @endif
                        </div>
                    </div>

                </div>

                <form action="/admin/crm/cart/final/buy" method="POST">
                    @csrf
                    <input type="hidden" name="cart_id" value="{{ $cart->id }}">
                    <div class="d-flex justify-content-end mt-4"><button class="btn btn-success" id="btn-final">ثبت  فاکتور خرید </button></div>
                </form>
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

@if (session('message'))
<script>
    Swal.fire({
        toast: true,
        position: 'top-start',
        icon: 'success',
        title: '{{ session('message') }}',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 3000,
        timerProgressBar: true,
        background: '#ffe6e6',
        color: '#000',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>
@endif

<script>
    $('#productSelect').on('change', function() {
        let productId = $(this).val();
        if (productId) {
            $.ajax({
                url: '/get-product-info/' + productId,
                method: 'GET',
                success: function(data) {
                    let sizeSelect = $('#sizeSelect');
                    sizeSelect.empty(); // خالی کردن قبلی‌ها
                                
                    sizeSelect.append('<option value="" selected disabled>سایز را انتخاب کنید</option>');
                                
                    if (data.sizes && data.sizes.length > 0) {
                        data.sizes.forEach(function(size) {
                            sizeSelect.append(
                                `<option value="${size.id}">${size.name}</option>`
                            );
                        });
                    }

                },
                error: function() {
                    $('#sizeSelect').val('');
    
                }
            });
        } else {
            $('#sizeSelect').val('');

        }
    });
</script>

<script>
    $('#sizeSelect').on('change', function() {
        let sizeId = $(this).val();
        let productId = $('#productSelect').val();
        if (sizeId) {
            $.ajax({
                url: '/get-product-info/lpo/size/' + sizeId + '/' + productId,
                method: 'GET',
                success: function(data) {
                    let inputPalet = document.querySelector('#palet')
                    let inputBox = document.querySelector('#box')
                    let inputAll = document.querySelector('#all')
                    let meterInBox = data.count_meter;
                    // alert(meterInBox)
                    let boxInPalet = data.count_box;

                    function totalMeter(){
                         let all = inputAll.value
                    
                        let box = all / meterInBox
                        inputBox.value = box.toFixed(2)
                    }

                    function totalPalet(){
                        let all = inputAll.value
                    
                        let palet = inputBox.value / boxInPalet
                        inputPalet.value = palet.toFixed(2)
                    }

                    inputAll.addEventListener('input', totalMeter);
                    inputAll.addEventListener('input', totalPalet);

                },
                error: function() {
                    $('#count_meter').val('');
                    $('#count_box').val('');
    
                }
            });
        } else {
            $('#count_meter').val('');
            $('#count_box').val('');

        }
    });
</script>
@endsection