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

                    <!-- row 1 -->
                    <div class="d-flex gap-3 form-row-responsive">
                        <div class="w-50">
                            <label>نام طرح</label>
                            <input type="text" name="title" value="{{ old('title' , $editProd->name ?? '') }}" class="form-control" placeholder="نام طرح">
                            @error('title') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="w-50">
                            <label>کد طرح</label>
                            <input type="text" name="code_prod" value="{{ old('code_prod' , $editProd->code_prod ?? '') }}" class="form-control" placeholder="کد طرح">
                            @error('code_prod') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="w-50">
                            <label>قیمت طرح</label>
                            <input type="text" name="price" value="{{ old('price' , $editProd->price ?? '') }}" class="form-control" placeholder="قیمت طرح">
                            @error('price') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <!-- row 2 -->
                    <div class="d-flex gap-3 form-row-responsive mt-2">
                        <div class="w-50">
                            <label>نام کارخانه</label>
                            <input type="text" name="name_company" value="{{ old('name_company' , $editProd->name_company ?? '') }}" class="form-control" placeholder="نام کارخانه">
                            @error('name_company') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="w-50">
                            <label>تعداد کارتن</label>
                            <input type="text" name="count_box" id="count_box" value="{{ old('count_box' , $editProd->count_box ?? '') }}" class="form-control" placeholder="تعداد کارتن">
                            @error('count_box') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="w-50">
                            <label>متراژ هر کارتن</label>
                            <input type="text" name="count_meter" id="count_meter" value="{{ old('count_meter' , $editProd->count_meter ?? '') }}" class="form-control" placeholder="متراژ هر کارتن">
                            @error('count_meter') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <!-- row 3 -->
                    <div class="d-flex gap-3 form-row-responsive mt-2">
                        <div class="w-50">
                            <label>تعداد پالت</label>
                            <input type="text" name="count_palet" value="{{ old('count_palet' , $editProd->count_palet ?? '') }}" class="form-control" placeholder="تعداد پالت">
                            @error('count_palet') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="w-50">
                            <label>متراژ کل</label>
                            <input type="text" name="count_all" id="count_all" value="{{ old('count_all' , $editProd->count_all ?? '') }}" class="form-control" placeholder="متراژ کل">
                            @error('count_all') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="w-50">
                            <label>تعداد فیس</label>
                            <input type="text" name="face" value="{{ old('face' , $editProd->face ?? '') }}" class="form-control" placeholder="تعداد فیس">
                            @error('face') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <!-- row 4 -->
                    <div class="d-flex gap-3 form-row-responsive mt-2">
                        <div class="w-50">
                            <label>درجه کاشی</label>
                            <input type="text" name="count_darageh" value="{{ old('count_darageh' , $editProd->count_darageh ?? '') }}" class="form-control" placeholder="درجه کاشی">
                            @error('count_darageh') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="w-50">
                            <label>نوع محصول</label>
                            <select name="no_product" class="form-select">
                                <option value="" disabled selected>لطفا نوع محصول را انتخاب کنید</option>
                                <option value="1" {{ old('no_product', $editProd->no_product ?? '') == 1 ? 'selected' : '' }}>سرامیک کف بدنه سفید</option>
                                <option value="2" {{ old('no_product', $editProd->no_product ?? '') == 2 ? 'selected' : '' }}>سرامیک کف بدنه قرمز</option>
                                <option value="3" {{ old('no_product', $editProd->no_product ?? '') == 3 ? 'selected' : '' }}>کاشی دیوار بدنه سفید</option>
                                <option value="4" {{ old('no_product', $editProd->no_product ?? '') == 4 ? 'selected' : '' }}>کاشی دیوار بدنه قرمز</option>
                                <option value="5" {{ old('no_product', $editProd->no_product ?? '') == 5 ? 'selected' : '' }}>پرسلان کف</option>
                                <option value="6" {{ old('no_product', $editProd->no_product ?? '') == 6 ? 'selected' : '' }}>پرسلان اسلب</option>
                            </select>
                            @error('no_product') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>

                        <div class="w-50">
                            <label>تعداد برگ کاشی</label>
                            <input type="text" name="count_paper" value="{{ old('count_paper' , $editProd->count_paper ?? '') }}" class="form-control" placeholder="تعداد برگ">
                            @error('count_paper') <small class="text-danger d-block">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <!-- sizes -->
                    <label class="mb-2 mt-3" style="font-size: 1.1rem">لطفا سایز مورد نظر را انتخاب کنید.</label>
                    <div class="d-flex gap-3 flex-wrap">
                        @foreach ($sizes as $size)
                        <div class="d-flex align-items-center mb-2">
                            <input class="form-check-input m-0" type="checkbox" name="sizes[]" value="{{ $size->id }}" @if(in_array($size->id, $size_prod)) checked @endif>
                            <span class="ms-1">{{ $size->name }}</span>
                        </div>
                        @endforeach
                    </div>
                    @error('sizes')
                    <small class="text-danger d-block">{{ $message }}</small>
                    @enderror

                    <textarea name="desc" class="form-control textArea mb-3 mt-4" placeholder="توضیحات درباره محصول...">{{ old('desc' , $editProd->desc ?? '') }}</textarea>

                    <!-- English -->
                    <div class="card mt-3" style="border-radius: 0.4rem; border-color: #394559">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="m-0">Definition in English</p>
                                <a class="btn text-light" data-bs-toggle="collapse" href="#collapseOne"><i class="fa-solid fa-arrow-down"></i></a>
                            </div>
                        </div>

                        <div id="collapseOne" class="collapse">
                            <div class="card-body">
                                <div class="d-flex gap-3 form-row-responsive">
                                    <div class="w-50">
                                        <label class="form-label">نام محصول (انگلیسی)</label>
                                        <input type="text" name="titleEn" value="{{ $editProd->name_en ?? '' }}" class="form-control" placeholder="name">
                                        @error('titleEn') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <label class="form-label">توضیحات (انگلیسی)</label>
                                <textarea name="descEn" class="form-control textArea" placeholder="Enter description...">{{ $editProd->desc_en ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Arabic -->
                    <div class="card mt-3" style="border-radius: 0.4rem; border-color: #394559">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="m-0">التعریف باللغة العربية</p>
                                <a class="btn text-light" data-bs-toggle="collapse" href="#collapseTwo"><i class="fa-solid fa-arrow-down"></i></a>
                            </div>
                        </div>

                        <div id="collapseTwo" class="collapse">
                            <div class="card-body">
                                <div class="d-flex gap-3 form-row-responsive">
                                    <div class="w-50">
                                        <label class="form-label">اسم المنتج (عربی)</label>
                                        <input type="text" name="titleAr" value="{{ $editProd->name_ar ?? '' }}" class="form-control" placeholder="اسم المنتج">
                                        @error('titleAr') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <label class="form-label">توضیحات (عربی)</label>
                                <textarea name="descAr" class="form-control textArea" placeholder="اكتب وصفاً عن المنتج...">{{ $editProd->desc_ar ?? '' }}</textarea>
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
        title: '{{ session('
        message ') }}',
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
    let inputBox = document.querySelector('#count_box')
    let inputMeter = document.querySelector('#count_meter')
    let inputAll = document.querySelector('#count_all')

    function calculateTotal() {
        let box = parseFloat(inputBox.value) || 0; // تبدیل به عدد
        let meter = parseFloat(inputMeter.value) || 0; // تبدیل به عدد
        let all = box * meter;


        // قرار دادن نتیجه در فیلد متراژ کل
        inputAll.value = all.toFixed(2);
    }

    // اضافه کردن Event Listener برای تغییرات
    inputBox.addEventListener('input', calculateTotal);
    inputMeter.addEventListener('input', calculateTotal);

    // محاسبه اولیه در صورت وجود مقادیر
    calculateTotal();
</script>
@endsection