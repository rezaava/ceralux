@extends('admin.layout.master')

@section('title-site')
لیست محصولات
@endsection

@section('onvan')
لیست محصولات
@endsection

@section('title-onvan')
<div class="dashboard-desc">خوش آمدید! امروز <span style="color:var(--accent-green)">۵ اعلان جدید</span> دارید.</div>
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
                <div class="table-responsive mt-3">
                    <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th class="numeric-column">ردیف</th>
                                <th class="hide-on-mobile">کد محصول</th>
                                <th>نام محصول</th>
                                <th class="hide-on-small">نام کارخانه</th>
                                <th class="numeric-column hide-on-medium">تعداد کارتن</th>
                                <th class="numeric-column hide-on-large">متراژ کارتن</th>
                                <th class="numeric-column hide-on-medium">متراژ کل</th>
                                <th class="numeric-column hide-on-large">ضخامت </th>
                                <th class="numeric-column hide-on-large">قیمت خرید</th>
                                <th class="numeric-column hide-on-large">قیمت فروش</th>
                                <th class="numeric-column hide-on-large">تعداد فیس</th>
                                {{-- <th class="hide-on-small">توضیحات</th> --}}
                                <th class="actions-column">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prods as $key => $prod)
                            <tr>
                                <td class="numeric-column">
                                    <div class="description-cell2">{{ $key+1 }}</div>
                                </td>
                                <td class="hide-on-mobile">
                                    <div class="description-cell2">{{ $prod->code_prod }}</div>
                                </td>
                                <td>
                                    <div class="description-cell2">{{ $prod->name }}</div>
                                </td>
                                <td class="hide-on-small">
                                    <div class="description-cell2">{{ $prod->name_company }}</div>
                                </td>
                                <td class="numeric-column hide-on-medium">
                                    <div class="description-cell2">{{ $prod->count_box }}</div>
                                </td>
                                <td class="numeric-column hide-on-large">
                                    <div class="description-cell2">{{ $prod->count_meter }}</div>
                                </td>
                                <td class="numeric-column hide-on-large">
                                    <div class="description-cell2">{{ $prod->count_meli }}</div>
                                </td>
                                <td class="numeric-column hide-on-medium">
                                    <div class="description-cell2">{{ $prod->count_all }}</div>
                                </td>
                                <td class="numeric-column hide-on-large">
                                    <div class="description-cell2">{{ $prod->price }}</div>
                                </td>
                                <td class="numeric-column hide-on-large">
                                    <div class="description-cell2">{{ $prod->price_buy }}</div>
                                </td>
                                <td class="numeric-column hide-on-large">
                                    <div class="description-cell2">{{ $prod->face }}</div>
                                </td>
                                {{-- <td class="hide-on-small">
                                    <div class="description-cell">{{ $prod->desc }}</div>
                                </td> --}}
                                <td class="actions-column" style="white-space: nowrap">
                                    <div class="d-flex flex-wrap justify-content-center">
                                        <a href="/products/img/{{ $prod->id }}" class="btn btn-sm btn-outline-success m-1">
                                            <i class="fas fa-images"></i>
                                        </a>
                                        <a href="/admin/product/add/{{ $prod->id }}" class="btn btn-sm btn-outline-primary m-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/admin/product/list/delete/{{ $prod->id }}" class="btn btn-sm btn-outline-danger m-1">
                                            <i class="fas fa-trash"></i>
                                        </a>
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

@endsection