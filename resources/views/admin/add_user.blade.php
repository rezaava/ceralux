@extends('admin.layout.master')

@section('title-site')
  افزودن مشتری
@endsection

@section('onvan')
  مشتری جدید
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
        height: 150px;
        resize: none;
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

@section('main')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="stat-card mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="stat-title" style="font-size: 1.6rem">افزودن مشتری</div>
                    {{-- <a href="" class="btn btn-success "><i class="fa-solid fa-plus"></i><span class="p-2">تعریف محصول جدید</span></a> --}}
                </div>


                <form action="/admin/user/add" method="POST">
                    @csrf
                    <input type="hidden" name="customer_id" value="{{ $editCus->id ?? '' }}">

                    <div class="d-flex gap-3 form-row-responsive justify-content-center" >
                        <input type="text" name="name" class="form-control w-50" value="{{ old('name' , $editCus->name ?? '') }}"  placeholder="نام و نام خانوادگی ">
                        <input type="text" name="phone" class="form-control w-50" value="{{ old('phone' , $editCus->phone ?? '') }}" placeholder="شماره موبایل">
                    </div>
                    @error('name')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                    @error('phone')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror

                    <div class="d-flex gap-3 form-row-responsive justify-content-center" >
                        <select class="form-select" name="no_customer" id="">
                            <option value="" selected disabled>لطفا نوع مشتری را انتخاب کنید</option>
                            <option value="1" {{ old('no_customer', $editCus->no_customer ?? '') == 1 ? 'selected' : '' }}>متفرقه</option>
                            <option value="2" {{ old('no_customer', $editCus->no_customer ?? '') == 2 ? 'selected' : '' }}>مغازه دار</option>
                            <option value="3" {{ old('no_customer', $editCus->no_customer ?? '') == 3 ? 'selected' : '' }}>ویزیتور</option>
                        </select>
                    </div>
                    @error('no_customer')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror

                    <div class="d-flex gap-3 form-row-responsive">
                        
                        <textarea name="address" class="form-control textArea" placeholder="آدرس  ...">{{ old('address' , $editCus->address ?? '') }}</textarea>
                    </div>
                    @error('address')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror


                    <button class="btn btn-success w-100 mt-3">ثبت </button>
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