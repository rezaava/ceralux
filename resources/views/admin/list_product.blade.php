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
        background-color: #258745;
        color: #fff;
        font-size: 1rem;
        text-align: center;
        border: none !important;
    }

    table.dataTable tbody td {
        background-color: #262F40;
        color: #fff;
        text-align: center;
        font-size: 0.95rem;
        border: none !important;
    }



    .dataTables_info {
        font-size: 1rem !important;
        word-break: none;
    }

    /* فیلد جستجو */
    .dataTables_wrapper .dataTables_filter .form-control {
        background-color: #232323;
        color: #fff;
        border: 1px solid #444;
        border-radius: 0.5rem;
        padding: 5px 10px;
        width: 100%;
        margin-right: 1rem;
    }

    /* حذف پس‌زمینه پیش‌فرض والد Pagination */
    .dataTables_wrapper .dataTables_paginate {
        background: transparent !important;
        /* یا رنگ دلخواه */
    }

    /* دکمه‌ها */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background-color: #258745 !important;
        /* رنگ پس‌زمینه دلخواه */
        color: #fff !important;
        /* رنگ متن */
        border: none !important;
        border-radius: 5px !important;
        margin: 0 2px;
    }

    /* دکمه فعال */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #1f6c3b !important;
        color: #fff !important;
    }

    /* حالت هاور */
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #19632d !important;
        color: #fff !important;
    }

    .dataTables_wrapper .dataTables_length .form-select {
        background-color: #232323;
        color: #fff;
        border: 1px solid #444;
        border-radius: 0.5rem;
        padding: 5px 10px;
        width: 50%;
    }

    /* ترتیب تعداد رکورد و جستجو */
    #example_wrapper .row {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;

    }

    .dataTables_wrapper .dataTables_length {
        order: 1;
        /* سمت چپ */
    }

    .dataTables_wrapper .dataTables_filter {
        order: 2;
        /* سمت راست */
        margin-left: auto;
    }

    td {
        word-wrap: break-word;
        /* قدیمی اما کار می‌کنه */
        word-break: break-word;
        /* برای مرورگرهای مدرن */
    }

    th {
        white-space: nowrap;
    }
    @media (max-width: 768px) {
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
            font-size: 1rem !important;
        }
    }
</style>
@endsection

@section('main')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="stat-card mt-3">
                {{-- <div class="stat-title" style="font-size: 1.6rem">لیست محصولات </div> --}}

                <div class="table-responsive mt-4">
                    <table id="example" class="table table-striped table-bordered text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>نام محصول</th>
                                <th>سایز</th>
                                <th>عکس</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prods as $key => $prod)
                            <tr>
                                <td class="ss01">{{ $key + 1 }}</td>
                                <td>{{ $prod->name }}</td>
                                <td>{{ $prod->desc }}</td>
                                <td style="white-space: nowrap">
                                    <button class="btn btn-primary btn-sm">مشاهده</button>
                                </td>
                                <td>
                                    <button class="btn btn-success btn-sm">ویرایش</button>
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
    "pagingType": "full_numbers",
    "language": {
        "search": "جستجو:",
        "lengthMenu": "نمایش _MENU_ رکورد",
        "info": "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
        "infoEmpty": "رکوردی موجود نیست",
        "infoFiltered": "(فیلتر شده از _MAX_ رکورد)", // <-- این اضافه شد
        "paginate": {
            "first": "اول",
            "last": "آخر",
            "next": "بعدی",
            "previous": "قبلی"
        },
        "zeroRecords": "رکوردی یافت نشد"
    },
});
</script>



@endsection