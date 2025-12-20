@extends('admin.layout.master')

@section('title-site')
درخواست ها  
@endsection

@section('onvan')
  درخواست ها
@endsection

@section('title-onvan')
<div class="dashboard-desc">خوش آمدید! امروز <span style="color:var(--accent-green)">۵ درخواست جدید</span> دارید.</div>
@endsection

@section('head')
<style>
    /* فرم‌ها */
    .form-control {
        background-color: #232323 !important;
        border: none !important;
        color: #fff !important;
        margin: 1rem 0;
    }

    .form-control::placeholder {
        color: #8ecae6;
        opacity: 0.5;
    }

    .textArea {
        height: 200px;
        resize: none;
    }


    table.dataTable thead th {
        background-color: #151A23;
        color: #43E97B;
        font-size: 0.85rem !important; /* کوچک‌تر کردن فونت هدر */
        text-align: center;
        border: none !important;
        border-bottom: 1px solid #3BDE77 !important;
      
    }

    table.dataTable tbody td {
        background-color: #262F40;
        color: #fff;
        text-align: center;
        font-size: 0.8rem !important; /* کوچک‌تر کردن فونت محتوا */
        border: none !important;
        
    }

    .stat-card{
        padding: 15px 15px 15px 15px; /* کاهش padding کارت */
    }

    .dataTables_info {
        font-size: 0.9rem !important;
    }

    /* فیلد جستجو */
    .dataTables_wrapper .dataTables_filter .form-control {
        background-color: #232323;
        color: #fff;
        border: 1px solid #444;
        border-radius: 0.5rem;
        padding: 10px 10px;
        width: 100%;
        margin-right: 1rem;
    }

    /* حذف پس‌زمینه پیش‌فرض والد Pagination */
    .dataTables_wrapper .dataTables_paginate {
        background: transparent !important;
    }

    /* دکمه‌ها */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: none !important;
        border-radius: 5px !important;
        font-size: 0.8rem !important; 
        margin-top: 1rem;
    }
    div.dataTables_wrapper div.dataTables_info{
        margin-top: 1rem;
    }

    .dataTables_wrapper .dataTables_length .form-select {
        background-color: #232323;
        color: #fff;
        border: 1px solid #444;
        border-radius: 0.5rem;
        padding: 5px 10px;
        width: 50%;
        font-size: 0.9rem;
    }

    /* ترتیب تعداد رکورد و جستجو */
    .dataTables_wrapper .row:first-child {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .dataTables_wrapper .dataTables_length {
        order: 1;
        margin-right: auto;
    }

    div.dataTables_wrapper div.dataTables_filter {
        order: 2;
        margin-left: 60px;
        text-align: left;
    }

    .description-cell2 {
        max-height: 120px;
        min-height: 30px;
        overflow-y: auto;
        display: block;
        text-align: center;
        padding: 4px;
        line-height: 1.4rem;
        white-space: nowrap;
        font-size: 0.9rem;
    }

    .description-cell {
        max-height: 120px;
        min-height: 30px;
        overflow-y: auto;
        width: 180px; /* کاهش عرض */
        display: block;
        word-wrap: break-word;
        text-align: right;
        padding: 4px;
        line-height: 1.4rem;
        font-size: 0.8rem;

        /* استایل اسکرول‌بار */
        &::-webkit-scrollbar {
            width: 6px;
        }

        &::-webkit-scrollbar-track {
            border-radius: 4px;
            margin: 2px;
        }

        &::-webkit-scrollbar-thumb {
            background: var(--accent-green)!important;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        &::-webkit-scrollbar-thumb:hover {
            background: #1f6c3b;
            transform: scale(1.1);
        }

        scrollbar-width: thin;
        scrollbar-color: var(--accent-green) #242D3D;
    }

    th {
        white-space: nowrap;
    }

    .btn-outline-success {
        color: var(--accent-green);
        font-size: 0.75rem !important; /* کوچک‌تر کردن دکمه‌ها */
    }

    .btn-outline-primary, .btn-outline-danger {
        font-size: 0.75rem !important;
    }

    .btn {
        padding: 4px 8px !important;
        margin: 1px !important;
    }
    
    #overlay{
        position: fixed;
        margin: 0;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.605);
        display: none;
        justify-content: center;
        align-items: flex-start; 
        z-index: 9999;
        overflow-y: auto;         
        padding: 2rem 1rem; 
    }
    #overlay1{
        position: fixed;
        margin: 0;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: rgba(0, 0, 0, 0.605);
        display: none;
        justify-content: center;
        align-items: flex-start; 
        z-index: 9999;
        overflow-y: auto;         
        padding: 2rem 1rem; 
    }
    #img_show{
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
        color: #eee;
        padding: 2rem;
        border-radius: 1rem;
        width: 90%;
        max-width: 1000px;
        position: relative;
        transition: all 0.3s ease-in-out;
    }
    .rounded-pill.bg-warning{
        background-color : #3123239e!important;
        color: #fffb07;
        padding: 0.5rem 0.6rem;
    }
    .rounded-pill.bg-success{
        background-color : #3123239e!important;
        color: #07ff5e;
        padding: 0.5rem 0.6rem;
    }
    .rounded-pill.bg-danger{
        background-color : #3123239e!important;
        color: #ff0707;
        padding: 0.5rem 0.6rem;
    }
    .rounded-pill.bg-info{
        background-color : #3123239e!important;
        color: #07ffff;
        padding: 0.5rem 0.6rem;
    }


    /* مخفی کردن ستون‌های کم‌اهمیت در صفحه‌های کوچک */
    @media (max-width: 1400px) {
        .hide-on-large { display: none !important; }
    }

    @media (max-width: 1200px) {
        .hide-on-medium { display: none !important; }
        .description-cell { width: 150px; }
    }

    @media (max-width: 992px) {
        .hide-on-small { display: none !important; }
        .description-cell { width: 120px; }
        table.dataTable thead th { font-size: 0.8rem !important; }
        table.dataTable tbody td { font-size: 0.75rem !important; }
    }

    @media (max-width: 768px) {
        .hide-on-mobile { display: none !important; }
        .description-cell { width: 100px; }
        
        .form-row-responsive {
            flex-direction: column;
        }

        .form-row-responsive .form-control {
            width: 100% !important;
        }

        .textArea {
            width: 100%;
        }

        .dataTables_wrapper .row {
            flex-direction: column;
            align-items: flex-start;
        }

        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length {
            float: none;
            margin: 5px 0;
            order: unset;
        }

        .dataTables_info {
            font-size: 0.8rem !important;
        }
        
        /* کاهش بیشتر سایزها در موبایل */
        table.dataTable thead th { 
            font-size: 0.75rem !important; 
            padding: 6px 3px !important;
        }
        table.dataTable tbody td { 
            font-size: 0.7rem !important; 
            padding: 4px 2px !important;
        }
        .btn { 
            font-size: 0.7rem !important; 
            padding: 3px 6px !important;
        }
    }

    /* بهبود اسکرول برای جدول */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* کاهش عرض ستون‌های عددی */
    .numeric-column {
        min-width: 60px !important;
        max-width: 100px !important;
    }
    
    /* کاهش عرض ستون عملیات */
    .actions-column {
        min-width: 120px !important;
        max-width: 150px !important;
    }
</style>
@endsection

@section('main')
<div class="container py-3"> <!-- کاهش padding -->
    <div class="row justify-content-center">
        <div class="col-12"> <!-- استفاده از کل عرض -->
            <div class="stat-card mt-2"> <!-- کاهش margin -->
                <h2>درخواست فاکتورهای فروش </h2>
                <div class="table-responsive mt-3">
                    <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th class="numeric-column">ردیف</th>
                                <th class="actions-column"> نوع درخواست </th>
                                <th class="actions-column">عنوان در خواست</th>
                                <th class="actions-column">نام درخواست دهنده </th>
                                <th class="actions-column">تاریخ ثبت</th>
                                <th class="actions-column">وضعیت</th>
                                <th class="actions-column">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($carts as $key => $cart)
                            <tr>
                                <td class="numeric-column">
                                    <div class="description-cell2">{{$key+1}}</div>
                                </td>
                                <td class="numeric-column">
                                    <div class="description-cell2">صدور فاکتور</div>
                                </td>
                                <td class="numeric-column">
                                    <div class="description-cell2">فاکتور فروش</div>
                                </td>
                                <td class="numeric-column">
                                    <div class="description-cell2">{{$user->dispaly_name ?? 'موارد پیدا نشد'}}</div>
                                </td>
                                <td class="numeric-column">
                                    <div class="description-cell2">{{$cart->date}}</div>
                                </td>
                                <td class="numeric-column text-center">
                                    @if($cart->status == 1)
                                    <p class="text-center badge rounded-pill bg-warning">درحال بررسی</p>
                                    @elseif ($cart->status == 2)
                                    <p class="text-center badge rounded-pill bg-success">تایید شد</p>
                                    @elseif($cart->status == 3)
                                    <p class="text-center badge rounded-pill bg-danger">رد شد</p>
                                    @else
                                    <p class="text-center badge rounded-pill bg-info">سایر موارد</p>
                                    @endif
                                </td>
                                <td class="actions-column" style="white-space: nowrap">
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <span id="req" class="btn btn-sm btn-outline-success m-1">
                                            <i class="fa-solid fa-eye"></i>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        {{-- <div class="row justify-content-center">
        <div class="col-12"> <!-- استفاده از کل عرض -->
            <div class="stat-card mt-2"> <!-- کاهش margin -->
                <h2>درخواست تولید ها</h2>
                <div class="table-responsive mt-3">
                    <table id="example1" class="table table-striped table-bordered text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th class="numeric-column">ردیف</th>
                                <th class="actions-column"> نوع درخواست </th>
                                <th class="actions-column">عنوان در خواست</th>
                                <th class="actions-column">نام درخواست دهنده </th>
                                <th class="actions-column">تاریخ</th>
                                <th class="actions-column">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reqs as $key => $req)
                            <tr>
                                <td class="numeric-column">
                                    <div class="description-cell2">{{$key+1}}</div>
                                </td>
                                <td class="numeric-column">
                                    <div class="description-cell2">تولید</div>
                                </td>
                                <td class="numeric-column">
                                    <div class="description-cell2"> تولید کاشی</div>
                                </td>
                                <td class="numeric-column">
                                    <div class="description-cell2">{{$user2->name}}</div>
                                </td>
                                <td class="numeric-column">
                                    <div class="description-cell2">{{$date2}}</div>
                                </td>
                                <td class="actions-column" style="white-space: nowrap">
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <span id="req1" class="btn btn-sm btn-outline-success m-1">
                                            <i class="fa-solid fa-eye"></i>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="overlay1">
    <div id="img_show">
        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center justify-content-between mb-3 position-relative">
                <a class="btn btn-danger m-0" id="btn2">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                <h2 class="overlay-title text-center flex-grow-1 m-0">درخواست تولید</h2>
            </div>
                
            <div>
                <div class="table-responsive mt-4">
                    <table class="table table-dark table-hover mt-3 table-borderless">
                        <thead class="text-center" style="border-bottom: 2px solid #3BDE77;">
                          <tr>
                            <th>ردیف</th>
                            <th>کد کالا</th>
                            <th>نام محصول</th>
                            <th>تعداد کارتن</th>
                            <th>تعداد پالت</th>
                            <th> متراژ کل</th>
                          </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($reqs as $key => $req) 
                          <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$req->prod->code_prod}}</td>
                            <td>{{$req->prod->name}}</td>
                            <td>{{$req->count_box}}</td>
                            <td>{{$req->count_palet}}</td>
                            <td>{{$req->count_meter}}</td>
                          </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-center align-items-center">
                <a href="" class="btn btn-success w-50">تایید</a>
                <a href="" class="btn btn-danger w-50">رد</a>
            </div>
        </div>
    </div>
</div> --}}

<div id="overlay">
    <div id="img_show">
        <div class="d-flex flex-column justify-content-center">
            <div class="d-flex align-items-center justify-content-between mb-3 position-relative">
                <a class="btn btn-danger m-0" id="btn2">
                    <i class="fa-solid fa-xmark"></i>
                </a>
                <h2 class="overlay-title text-center flex-grow-1 m-0">درخواست فاکتور فروش</h2>
            </div>
                
            <div>
                <div class="table-responsive mt-4">
                    <table class="table table-dark table-hover mt-3 table-borderless">
                        <thead class="text-center" style="border-bottom: 2px solid #3BDE77;">
                          <tr>
                            <th>ردیف</th>
                            <th>کد کالا</th>
                            <th>نام محصول</th>
                            <th>تعداد کارتن</th>
                            <th>متراژ در هر کارتن </th>
                            <th>تعداد پالت</th>
                            <th> متراژ کل</th>
                            <th>  قیمت</th>
                            <th>  قیمت کل</th>
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
                            <td>{{$cart_prod->count_palet}}</td>
                            <td>{{$cart_prod->count_box * $cart_prod->prod->count_meter}}</td>
                            <td>{{number_format($cart_prod->prod->price)}}</td>
                            <td>{{number_format($cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter))}}</td>
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
                            <p class="m-0 p-0">قیمت کل  : <span style="padding-right: 0.5rem">{{number_format($priceAll)}}</span><span style="padding-right: 0.2rem">تومان</span></p>
                        </div>
                    </div>

                </div>

            </div>

            <div class="d-flex justify-content-center align-items-center">
                <a href="" class="btn btn-success w-50">تایید</a>
                <a href="" class="btn btn-danger w-50">رد</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $('#example').DataTable({
        autoWidth: false, // غیرفعال کردن auto-width برای کنترل بهتر
        scrollX: true, // فعال کردن اسکرول افقی فقط وقتی لازم است
        scrollCollapse: true,
        "pagingType": "full_numbers",
        "language": {
            "search": "جستجو:",
            "lengthMenu": "نمایش _MENU_ رکورد",
            "info": "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
            "infoEmpty": "رکوردی موجود نیست",
            "infoFiltered": "(فیلتر شده از _MAX_ رکورد)",
            "paginate": {
                "first": "اول",
                "last": "آخر",
                "next": "بعدی",
                "previous": "قبلی"
            },
            "zeroRecords": "رکوردی یافت نشد"
        },
        // "columnDefs": [
        //     { "width": "5%", "targets": 0 }, // ردیف
        //     { "width": "10%", "targets": 1 }, // کد محصول
        //     { "width": "12%", "targets": 2 }, // نام محصول
        //     { "width": "10%", "targets": 3 }, // نام کارخانه
        //     { "width": "13%", "targets": [4,5,6,7,8,9] }, // ستون‌های عددی
        //     { "width": "15%", "targets": 10 }, // توضیحات
        //     { "width": "10%", "targets": 11 } // عملیات
        // ]
    });
</script>

<script>
    $('#example1').DataTable({
        autoWidth: false, // غیرفعال کردن auto-width برای کنترل بهتر
        scrollX: true, // فعال کردن اسکرول افقی فقط وقتی لازم است
        scrollCollapse: true,
        "pagingType": "full_numbers",
        "language": {
            "search": "جستجو:",
            "lengthMenu": "نمایش _MENU_ رکورد",
            "info": "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
            "infoEmpty": "رکوردی موجود نیست",
            "infoFiltered": "(فیلتر شده از _MAX_ رکورد)",
            "paginate": {
                "first": "اول",
                "last": "آخر",
                "next": "بعدی",
                "previous": "قبلی"
            },
            "zeroRecords": "رکوردی یافت نشد"
        },
        // "columnDefs": [
        //     { "width": "5%", "targets": 0 }, // ردیف
        //     { "width": "10%", "targets": 1 }, // کد محصول
        //     { "width": "12%", "targets": 2 }, // نام محصول
        //     { "width": "10%", "targets": 3 }, // نام کارخانه
        //     { "width": "13%", "targets": [4,5,6,7,8,9] }, // ستون‌های عددی
        //     { "width": "15%", "targets": 10 }, // توضیحات
        //     { "width": "10%", "targets": 11 } // عملیات
        // ]
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
    let btn = document.querySelector('#req');
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

<script>
    let btn1 = document.querySelector('#req1');
        let overlay1 = document.querySelector('#overlay1');

        btn1.addEventListener('click' , function(){
            let status = true
            overlay1.style.display = 'flex'
        })

        overlay1.addEventListener('click' , function(e){
            if(e.target===overlay1){
                overlay1.style.display='none'
            }
        })
</script>

@endsection