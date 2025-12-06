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
                            <input type="text" name="check_date" value="{{ old('check_date' , $editCheck->check_date  ?? '') }}" class="form-control" placeholder="تاریخ چک">
                            @error('check_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="w-50">
                            <label>صادرکننده چک</label>
                            <input type="text" name="name_user" value="{{ old('name_user' , $editCheck->name_user  ?? '') }}" class="form-control" placeholder=" نام دریافت کننده">
                            @error('name_user') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="w-50">
                            <label>شماره تماس صادرکننده</label>
                            <input type="text" name="phone_user" value="{{ old('phone_user' , $editCheck->phone_user  ?? '') }}" class="form-control" placeholder="نام بانک">
                            @error('phone_user') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        
                    </div>

                    <div class="d-flex gap-3 form-row-responsive">
                        <div class="w-50">
                            <label>نام بانک</label>
                            <input type="text" name="name_bank" value="{{ old('name_bank', $editCheck->name_bank ?? '') }}" class="form-control" placeholder="نام بانک">
                            @error('name_bank') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="w-50">
                            <label>نام شعبه</label>
                            <input type="text" name="name_branch" value="{{ old('name_branch' , $editCheck->name_branch  ?? '') }}" class="form-control" placeholder="نام شعبه">
                            @error('name_branch') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="w-50">
                            <label>کد شعبه</label>
                            <input type="text" name="code_branch" id="num_branch" value="{{ old('code_branch' , $editCheck->code_branch  ?? '') }}"class="form-control" placeholder="کدشعبه">
                            @error('code_branch') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                
                    <div class="d-flex gap-3 form-row-responsive">
                        <div class="w-50">
                            <label >شماره سریال</label>
                            <input type="text" name="check_serial" id="count_meter" value="{{ old('check_serial' , $editCheck->check_serial  ?? '') }}" class="form-control" placeholder="شماره سریال">
                            @error('check_serial') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="w-50">
                            <label>شماره صیادی</label>
                            <input type="text" name="check_num" value="{{ old('check_num' , $editCheck->check_num  ?? '') }}" class="form-control" placeholder="شماره صیادی">
                            @error('check_num') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="w-50">
                            <label >مبلغ چک</label>
                            <input type="text" name="check_price" id="count_all" value="{{ old('check_price' , $editCheck->check_price  ?? '') }}" class="form-control" placeholder="مبلغ چک">
                            @error('check_price') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-3 form-row-responsive">
                        <div class="w-50">
                            <label>نام صاحب چک</label>
                            <input type="text" name="name_account" value="{{ old('name_account' , $editCheck->name_account  ?? '') }}" class="form-control" placeholder=" نام صاحب چک">
                            @error('name_account') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="w-50">
                            <label>شماره حساب چک</label>
                            <input type="text" name="num_account" value="{{ old('num_account' , $editCheck->num_account  ?? '') }}" class="form-control" placeholder="  شماره حساب چک">
                            @error('num_account') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="w-50">
                            <label>شماره فاکتور</label>
                            <input type="text" name="num_invocie" value="{{ old('num_invocie' , $editCheck->num_invocie  ?? '') }}" class="form-control" placeholder="شماره فاکتور">
                            @error('num_invocie') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <textarea name="desc" class="form-control textArea mb-3 mt-4" placeholder="توضیحات درباره چک...">{{ old('desc', $editCheck->desc ?? '') }}</textarea>
                    @error('desc') <small class="text-danger">{{ $message }}</small> @enderror

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