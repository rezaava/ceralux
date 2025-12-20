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

    #btn-final {
        width: 30%;
    }

    table {
        table-layout: fixed;
    }

    table th {
        white-space: nowrap;
    }

    .total-section {
        background-color: rgba(67, 233, 123, 0.1);
        border-radius: 10px;
        padding: 20px;
        margin-top: 30px;
        border-right: 4px solid var(--accent-green);
    }
    
    .total-row {
        display: flex;
        justify-content: space-between;
        font-size: 1.1rem;
        margin-bottom: 10px;
    }
    
    .total-amount {
        font-size: 1.8rem;
        font-weight: bold;
        color: var(--accent-green);
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        table {
            table-layout: auto;
        }

        .form-row-responsive {
            flex-direction: column;
        }

        #btn-final {
            width: 100%;
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
        <div class="col-lg-12 col-md-12 col-12">
            <div class="stat-card mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="stat-title" style="font-size: 1.6rem">ثبت فاکتور جدید فروش</div>
                    {{-- <a href="" class="btn btn-success "><i class="fa-solid fa-plus"></i><span class="p-2">تعریف محصول جدید</span></a> --}}
                </div>
                @if(!$order)
                <form action="/admin/crm/reqSale/add" method="POST">
                    @csrf
                    <div class="d-flex gap-3 form-row-responsive mt-3">
                        <select class="form-select select2-farsi w-50" dir="rtl" name="customer" id="customerSelect">
                            <option value="" selected>مشتری را انتخاب کنید</option>
                            @foreach($cuss as $cus)
                            <option value="{{ $cus->id }}">{{ $cus->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('customer')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                    <div class="d-flex gap-3 form-row-responsive mt-3">
                        {{-- <input type="text" name="num_cart"  class="form-control w-50 mb-3" placeholder="شماره تراکنش "> --}}
                        <input type="text" name="phone" id="phone" class="form-control w-50 mb-3" placeholder="شماره موبایل ">
                        {{-- <input type="text" name="" class="form-control w-50 mb-3" placeholder="تاریخ"> --}}
                        <input type="text" id="address" name="address" class="form-control w-50 mb-3" placeholder="آدرس">
                    </div>

                    <div class="d-flex gap-3 form-row-responsive">
                        {{-- <select class="form-select" name="" id="">
                            <option value="" selected>اسم فروشنده</option>
                            <option value=""></option>
                        </select> --}}
                        <input type="text" id="no_customer" name="no_customer" class="form-control w-100 mb-3" placeholder="نوع مشتری">
                        <input type="text" class="form-control" placeholder="شماره  LPO را وارد کنید" name="num_lpo">
                    </div>
                    @error('num_lpo')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                    <div class="text-center"><button class="btn btn-success w-50 mt-3">ثبت </button></div>
                </form>

                @else
                <div class="stat-card mt-3">
                    <div class="row">

                        <div class="col-lg-4 col-md-6">
                            <p class="m-0 p-0">شماره فاکتور : <span>{{$order->num_cart}}</span></p>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <p class="m-0 p-0">نام مشتری : <span>{{$user->name}}</span></p>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <p class="m-0 p-0">تاریخ : <span>{{$date}}</span></p>
                        </div>

                    </div>

                    <div class="row mt-4">

                        <div class="col-lg-4 col-md-6">
                            <p class="m-0 p-0">نام فروشنده : <span> {{Auth::user()->dispaly_name}}</span></p>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <p class="m-0 p-0">آدرس مشتری : <span>{{$user->address}}</span></p>
                        </div>

                    </div>

                </div>
                @if($cart_prods && $cart_prods->count() > 0)
                @else
                <form action="/admin/crm/reqSale/product/add" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="cart_id" value="{{ $order->id }}">

                    @foreach($lpo_prods as $index => $lpo_prod)
                    <div class="d-flex gap-3 form-row-responsive mt-3">
                        <input type="hidden" name="prod_id[{{ $index }}]" value="{{ $lpo_prod->prod->id }}">

    
                        <div class="w-100 w-md-50">
                            <label class="form-label m-0">نام محصول</label>
                            <input type="text" value="{{ $lpo_prod->prod->name }}" class="form-control" readonly>
                        </div>

                        <div class="w-100 w-md-50">
                            <label class="form-label m-0">تعداد کارتن</label> 
                            <input type="text" name="count_box[{{ $index }}]" value="{{ $lpo_prod->count_box }}" class="form-control" placeholder="تعداد کارتن">
                        </div>

  
                        <div class="w-100 w-md-50">
                            <label class="form-label m-0">تعداد پالت</label>
                            <input type="text" name="count_palet[{{ $index }}]" value="{{ $lpo_prod->count_palet }}" class="form-control" placeholder="تعداد پالت">
                        </div>


                        <div class="w-100 w-md-50">
                            <label class="form-label m-0">درصد تخفیف</label>
                            <input type="text" name="off[{{ $index }}]" class="form-control" placeholder="درصد تخفیف (مثلاً 5)">
                        </div>

                    </div>
                    @endforeach
                    @error('count_box')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror

                        @error('count_palet')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror

                        @error('off')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror

                    <div class="text-center"><button class="btn btn-success w-50 mt-3">افزودن کالا</button></div>
                </form>
                @endif

                <div class="table-responsive mt-4">
                    @if($cart_prods)
                    <table class="table table-dark table-hover mt-3 table-borderless">
                        <thead class="text-center" style="border-bottom: 2px solid #3BDE77;">
                            <tr>
                                <th>ردیف</th>
                                <th>کد کالا</th>
                                <th>نام محصول</th>
                                <th>تعداد کارتن</th>
                                <th>متراژ هر کارتن</th>
                                <th>تعداد برگ کاشی</th>
                                <th>تعداد پالت</th>
                                <th> متراژ کل</th>
                                <th> قیمت</th>
                                <th> تحفیف</th>
                                <th> قیمت کل</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($cart_prods as $key => $cart_prod)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$cart_prod->prod->code_prod}}</td>
                                <td>{{$cart_prod->prod->name}}</td>
                                <td>{{$cart_prod->count_box}}</td>
                                <td>{{$cart_prod->prod->count_meter}}</td>
                                <td>{{$cart_prod->prod->count_paper}}</td>
                                <td>{{$cart_prod->count_palet}}</td>
                                <td>{{$cart_prod->count_box * $cart_prod->prod->count_meter}}</td>
                                <td>{{number_format($cart_prod->prod->price)}}</td>
                                <td>{{number_format($cart_prod->off)}}%</td>
                                <td>{{number_format($cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter) - ($cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter)) * ($cart_prod->off/100) )}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>

                <div class="stat-card ">

                    <div class="row">

                        <div class="col-lg-3 col-md-6 col-12">
                            <p class="m-0 p-0">متراژ کل : <span style="padding-right: 0.5rem">{{$meter}}</span><span style="padding-right: 0.2rem">متر</span></p>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12">
                            <p class="m-0 p-0">تعداد کارتن : <span style="padding-right: 0.5rem">{{$box}}</span><span style="padding-right: 0.2rem">عدد     </span></p>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12">
                            <p class="m-0 p-0">تعداد برگ های کاشی : <span style="padding-right: 0.5rem">{{$paper}}</span><span style="padding-right: 0.2rem">عدد</span></p>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12">
                            <p class="m-0 p-0">تعداد پالت ها : <span style="padding-right: 0.5rem">{{$palet}}</span><span style="padding-right: 0.2rem">عدد</span></p>
                        </div>

                    </div>

                    {{-- <div class="row mt-4">
                        <div class="col-lg-4 col-md-6 col-12">
                            <p class="m-0 p-0">قیمت کل : <span style="padding-right: 0.5rem"></span><span style="padding-right: 0.2rem">تومان</span></p>
                        </div>
                    </div> --}}

                </div>

                <form action="/admin/crm/reqSale/rentOrOff/add" method="POST">
                    @csrf
                    <div class="d-flex gap-3 form-row-responsive mt-3">
                        <input type="hidden" name="cart_id" value="{{ $order->id }}">
                        <input type="text" name="price_rent" class="form-control w-50" placeholder="کرایه بار">
                        <input type="text" name="all_off" class="form-control w-50" placeholder="تخفیف روی کل فاکتور">
                    </div>
                    @error('all_off')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                        @error('price_rent')
                        <small class="text-danger d-block">{{ $message }}</small>
                        @enderror
                    <div class="text-center"><button class="btn btn-success w-50 mt-3"> اعمال تغییرات</button></div>
                </form>

                <div class="total-section">
                    <div class="total-row">
                        <span>  کرایه بار : </span>
                        <span>{{number_format($order->price_rent) ?? 'مبلغ کرایه رو از فرم بالا وارد کنید'}}</span>
                    </div>
                    <div class="total-row">
                        <span>تخفیف کل :</span>
                        <span><span>{{$order->off}}</span> درصد</span>
                    </div>
                    <div class="total-row">
                        <span>مبلغ کل بدون مالیات بر ارزش افزوده :</span>
                        <span><span>{{number_format($priceAll)}}</span></span>
                    </div>
                    <div class="total-row">
                        <span>5% مالیات بر ارزش افزوده:</span>
                        <span><span>{{number_format($five)}}</span></span>
                    </div>
                    <div class="total-row total-amount">
                        <span style="font-size: 1.2rem">مبلغ نهایی فاکتور:</span>
                        <span style="font-size: 1rem"><span>{{number_format($finalPrice)}}</span></span>
                    </div>
                </div>

                <form action="/admin/crm/reqSale/pay" method="POST">
                    @csrf
                    <input type="hidden" name="cart_id" value="{{ $order->id }}">
                    <div class="d-flex justify-content-end mt-4"><button class="btn btn-success" id="btn-final">ثبت  فاکتور فروش </button></div>
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
                    return "نتیجه‌ای یافت نشد";
                },
                searching: function() {
                    return "در حال جستجو...";
                }
            }
        });
    });
</script>

<script>
    $('#customerSelect').on('change', function() {
        var customerId = $(this).val();
        if (customerId) {
            $.ajax({
                url: '/get-customer-info/' + customerId,
                method: 'GET',
                success: function(data) {
                    // تبدیل عدد no_customer به متن
                    let customerTypeText = '';
                    switch (data.no_customer) {
                        case '1':
                            customerTypeText = 'متفرقه';
                            break;
                        case '2':
                            customerTypeText = 'مغازه‌دار';
                            break;
                        case '3':
                            customerTypeText = 'ویزیتور';
                            break;
                        default:
                            customerTypeText = '';
                    }

                    $('#phone').val(data.phone);
                    $('#address').val(data.address);
                    $('#no_customer').val(customerTypeText); // نمایش متن به جای عدد
                },
                error: function() {
                    $('#phone').val('');
                    $('#address').val('');
                    $('#no_customer').val('');
                }
            });
        } else {
            $('#phone').val('');
            $('#address').val('');
            $('#no_customer').val('');
        }
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

@if (session('error'))
<script>
    Swal.fire({
        icon: "error",
        title: "خطا LPO پیدا نشد",
        text: '{{ session('error') }}',
        footer: '<a href="/admin/crm/lpo/add/{id}" target="_blank">ثبت LPO</a>',
        showCloseButton: true,
        confirmButtonText:"متوجه شدم",
        background: '#232b39',
        color: '#fff',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>
@endif

@if (session('error2'))
<script>
    Swal.fire({
        icon: "error",
        title: "خطا LPO تکراری",
        text: '{{ session('error2') }}',
        showCloseButton: true,
        confirmButtonText:"متوجه شدم",
        background: '#232b39',
        color: '#fff',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>
@endif

@endsection