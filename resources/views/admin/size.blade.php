@extends('admin.layout.master')

@section('title-site')
سایز ها
@endsection

@section('onvan')
سایز ها
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

    .form-control::placeholder {
        color: #8ecae6;
        opacity: 0.5;
    }

    .textArea {
        height: 200px;
        resize: none;
    }

    .table-wrapper {
        overflow-x: auto;
        margin-top: 2.1rem;
        border-radius: 1rem;
        box-shadow: rgba(0, 0, 0, 0.35) 1.95px 1.95px 2.1px;
        margin-bottom: 1rem;
    }

    table {
        width: 100%;
        min-width: 500px;
        border-collapse: collapse;
        table-layout: fixed;
    }

    th,
    td {
        text-align: center;
        padding: 10px;
        border-bottom: 0.09rem solid #cccccc92;
        color: #fff;
        font-size: 1rem;
        background-color: #262F40;
    }

    th {
        background-color: #258745;
        color: #fff;
        font-size: 1rem;

    }

    tr:last-child td {
        border-bottom: none;
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
    }
</style>
@endsection


@section('title-onvan')
<div class="dashboard-desc">خوش آمدید! امروز <span style="color:var(--accent-green)">۵ اعلان جدید</span> دارید.</div>
@endsection


@section('main')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="stat-card mt-3">
                <div class="stat-title" style="font-size: 1.6rem">افزودن سایز جدید</div>


                <form action="/admin/size/add" method="POST">
                    @csrf

                    <div class="d-flex justify-content-center m-0 gap-3 form-row-responsive">

                        <div class="w-50">
                            <input type="text" name="size_name" class="form-control" placeholder="سایز جدید">
                            @error('size_name')
                            <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="w-50">
                            <input type="text" name="meli_name" class="form-control" placeholder="ضخامت">
                            @error('meli_name')
                            <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>


                    <div class="d-flex justify-content-center">
                        <button class="btn btn-success w-50 mt-3">ثبت </button>
                    </div>

                </form>
                <div class="table-wrapper">
                    <table class="">
                        <tr>
                            <th>ردیف </th>
                            <th>سایز ها</th>
                            <th>ضخامت ها</th>
                        </tr>
                        @foreach($sizes as $key => $size)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$size->name}}</td>
                            <td>{{$size->meli}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection