@extends('admin.layout.master')

@section('title-site')
 ثبت چک
@endsection

@section('onvan')
 ثبت چک ها
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
        margin: 0.5rem 0;
    }

    .form-select {
        background-color: #232323 !important;
        border: none !important;
        color: #fff;
        margin: 0.5rem 0;
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

    @media (max-width: 768px) {
        .form-row-responsive {
            flex-direction: column;
        }

        .form-row-responsive > div {
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
        <div class="col-lg-8 col-md-10 col-12">
            <div class="stat-card mt-3">
                <div class="stat-title" style="font-size: 1.6rem">افزودن چک جدید</div>

                <form action="/admin/financial/submit/add" method="POST">
                    @csrf
                    <input type="hidden" name="check_id" value="{{ $editCheck->id  ?? '' }}">

                    <div class="d-flex gap-3 form-row-responsive">
                        <div class="w-50">
                            <label>تاریخ چک</label>
                            <input type="text" name="check_date" value="{{ $editCheck->check_date  ?? '' }}" class="form-control" placeholder="تاریخ چک">
                        </div>
                        <div class="w-50">
                            <label>صادرکننده چک</label>
                            <input type="text" name="name_user" value="{{ $editCheck->name_user  ?? '' }}" class="form-control" placeholder=" نام دریافت کننده">
                        </div>
                        <div class="w-50">
                            <label>شماره تماس صادرکننده</label>
                            <input type="text" name="phone_user" value="{{ $editCheck->phone_user  ?? '' }}" class="form-control" placeholder="نام بانک">
                        </div>
                    </div>

                    <div class="d-flex gap-3 form-row-responsive">
                        <div class="w-50">
                            <label>نام بانک</label>
                            <input type="text" name="name_bank" value="{{ $editCheck->name_bank  ?? '' }}" class="form-control" placeholder="نام بانک">
                        </div>
                        <div class="w-50">
                            <label>نام شعبه</label>
                            <input type="text" name="name_branch" value="{{ $editCheck->name_branch  ?? '' }}" class="form-control" placeholder="نام شعبه">
                        </div>
                        <div class="w-50">
                            <label>کد شعبه</label>
                            <input type="text" name="code_branch" id="num_branch" value="{{ $editCheck->code_branch  ?? '' }}"class="form-control" placeholder="کدشعبه">
                        </div>
                    </div>
                
                    <div class="d-flex gap-3 form-row-responsive">
                        <div class="w-50">
                            <label >شماره سریال</label>
                            <input type="text" name="check_serial" id="count_meter" value="{{ $editCheck->check_serial  ?? '' }}" class="form-control" placeholder="شماره سریال">
                        </div>
                        <div class="w-50">
                            <label>شماره صیادی</label>
                            <input type="text" name="check_num" value="{{ $editCheck->check_num  ?? '' }}" class="form-control" placeholder="شماره صیادی">
                        </div>
                        <div class="w-50">
                            <label >مبلغ چک</label>
                            <input type="text" name="check_price" id="count_all" value="{{ $editCheck->check_price  ?? '' }}" class="form-control" placeholder="مبلغ چک">
                        </div>
                    </div>

                    <div class="d-flex gap-3 form-row-responsive">
                        <div class="w-50">
                            <label>نام صاحب چک</label>
                            <input type="text" name="name_account" value="{{ $editCheck->name_account  ?? '' }}" class="form-control" placeholder=" نام صاحب چک">
                        </div>
                        <div class="w-50">
                            <label>شماره حساب چک</label>
                            <input type="text" name="num_account" value="{{ $editCheck->num_account  ?? '' }}" class="form-control" placeholder="  شماره حساب چک">
                        </div>
                        <div class="w-50">
                            <label>شماره فاکتور</label>
                            <input type="text" name="num_invocie" value="{{ $editCheck->num_invocie  ?? '' }}" class="form-control" placeholder="شماره فاکتور">
                        </div>
                    </div>

                    <textarea name="desc" class="form-control textArea mb-3 mt-4" placeholder="توضیحات درباره چک...">{{ $editCheck->desc  ?? '' }}</textarea>

                    @if($editCheck)
                    <button class="btn btn-success w-100 mt-3">ثبت ویرایش چک</button>
                    @else
                    <button class="btn btn-success w-100 mt-3">ثبت  چک</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
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