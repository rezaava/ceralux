@extends('admin.layout.master')

@section('title-site')
محصولات
@endsection

@section('onvan')
محصولات
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
                <div class="stat-title" style="font-size: 1.6rem">افزودن محصول جدید</div>


                <form action="/admin/product/add" method="POST">
                    @csrf
                    <input type="hidden" name="prod_id" value="{{ $editProd->id ?? '' }}">

                    <div class="d-flex gap-3 form-row-responsive">
                        <input type="text" name="title" value="{{ $editProd->name ?? '' }}" class="form-control w-50" placeholder="نام محصول">
                        <input type="text" name="code_prod" value="{{ $editProd->code_prod ?? '' }}" class="form-control w-50" placeholder="کد محصول">
                        <input type="text" name="price" value="{{ $editProd->price ?? '' }}" class="form-control w-50" placeholder="قیمت محصول">
                    </div>

                    <div class="d-flex gap-3 form-row-responsive">
                        <input type="text" name="name_company" value="{{ $editProd->name_company ?? '' }}" class="form-control w-50" placeholder="نام کارخانه">
                        <input type="text" name="count_box" value="{{ $editProd->count_box ?? '' }}" class="form-control w-50" placeholder="تعداد کارتن">
                        <input type="text" name="count_meter" value="{{ $editProd->count_meter ?? '' }}" class="form-control w-50" placeholder="متراژ هر کارتن">
                    </div>
                
                    <div class="d-flex gap-3 form-row-responsive">
                        <input type="text" name="count_palet" value="{{ $editProd->count_palet ?? '' }}" class="form-control w-50" placeholder="تعداد پالت">
                        <input type="text" name="count_all" value="{{ $editProd->count_all ?? '' }}" class="form-control w-50" placeholder="متراژ کل">
                        <input type="text" name="face" value="{{ $editProd->face ?? '' }}" class="form-control w-50" placeholder="تعداد فیس">
                    </div>


                    <label for="" class="mb-2">لطفا سایز مورد نظر را انتخاب کنید.</label>
                    <div class="d-flex gap-3  flex-wrap">
                        @foreach ($sizes as $key => $size )
                        <div class="d-flex justify-content-center align-items-center mb-2">
                            <input name="sizes[]" class="form-check-input m-0" type="checkbox" value="{{ $size->id }}" @if(in_array($size->id, $size_prod)) checked @endif>
                            <span style="margin-right: 0.3rem">{{$size->name}}</span>
                        </div>
                        @endforeach
                    </div>

                    <textarea name="desc" class="form-control textArea"
                        placeholder="توضیحات درباره محصول...">{{ $editProd->desc ?? '' }}</textarea>

                    <div class="card mt-3" style="border-radius: 0.4rem ; border-color: #394559">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="p-0 m-0">Definition in English</p>
                                <a class="btn text-light" data-bs-toggle="collapse" href="#collapseOne"><i
                                        class="fa-solid fa-arrow-down"></i></a>
                            </div>
                        </div>
                        <div id="collapseOne" class="collapse" data-bs-parent="#accordion">
                            <div class="card-body">

                               
                                    <div class="d-flex gap-3 form-row-responsive">
                                        <input type="text" name="titleEn" value="{{ $editProd->name_en ?? '' }}" class="form-control w-50" placeholder="name ">
                                    </div>

                                    <textarea name="descEn" class="form-control textArea"
                                        placeholder="Enter the product name...">{{ $editProd->desc_en ?? '' }}</textarea>

                            </div>
                        </div>
                    </div>

                    <div class="card mt-3" style="border-radius: 0.4rem;border-color: #394559">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="p-0 m-0">التعریف باللغة العربية</p>
                                <a class="btn text-light" data-bs-toggle="collapse" href="#collapseTwo"><i
                                        class="fa-solid fa-arrow-down"></i></a>
                            </div>
                        </div>

                        <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                            <div class="card-body">

                                
                                    <div class="d-flex gap-3 form-row-responsive">
                                        <input type="text" value="{{ $editProd->name_ar ?? '' }}" name="titleAr" class="form-control w-50" placeholder="اسم المنتج ">
                                    </div>

                                    <textarea name="descAr" class="form-control textArea"
                                        placeholder="اكتب وصفاً عن المنتج...">{{ $editProd->desc_en ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-success w-100 mt-3">ثبت محصول</button>
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