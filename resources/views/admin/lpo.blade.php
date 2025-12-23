@extends('admin.layout.master')

@section('title-site')
 LPO  
@endsection

@section('onvan')
    ثبت LPO ها
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
        /* margin: 1rem 0; */
        
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

    table {
        table-layout: fixed;
    }

    table th {
        white-space: nowrap;
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
        .form-row-responsive>div {
            width: 100% !important;
        }

        .textArea {
            width: 100%;
        }

    }

    .preview-container {
        margin-top: 30px;
        display: none;
      }
        
    .preview-image {
        max-width: 100%;
        max-height: 400px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        margin-bottom: 20px;
      }
    .upload-area {
        border: 3px dashed #667eea;
        border-radius: 15px;
        padding: 60px 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 50%;
        display: flex;
        justify-content: center;
      }
    .upload-icon {
        font-size: 48px;
        color: #667eea;
        margin-bottom: 20px;
        text-align: center;
      }
</style>
@endsection

@section('main')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-10 col-12">
            <div class="stat-card mt-3">

               <div class="d-flex justify-content-between align-items-center">
                  <div class="stat-title" style="font-size: 1.6rem">ثبت LPO </div>
                  @if(!$lpo)
                  <a target="_blank" href="/admin/user/add/{id}" class="btn btn-success "><i class="fa-solid fa-plus"></i><span class="p-2" >تعریف مشتری جدید</span></a>
                  @else
                  <a target="_blank" href="/admin/product/add/{id}" class="btn btn-success "><i class="fa-solid fa-plus"></i><span class="p-2" >تعریف محصول جدید</span></a>
                  @endif
               </div>
               @if(!$lpo)
               <form action="/admin/crm/add/cart/lpo" method="POST">
                @csrf
                    <div class="d-flex gap-3 form-row-responsive justify-content-center">
                        <select class="form-select select2-farsi w-100" dir="rtl" name="customer_id" id="customerSelect">
                           <option value="" selected>مشتری را جستجو کنید</option>
                           @foreach($customers as $customer)
                           <option value="{{ $customer->id }}">{{$customer->name}}</option>
                           @endforeach
                        </select>
                    </div>
                    @error('customer_id')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror

                  <div class="d-flex gap-3 form-row-responsive mt-3">
                    <input type="text" value="{{ old('num_lpo') }}" name="num_lpo" class="form-control w-50" placeholder="شماره LPO ">
                  </div>
                    @error('num_lpo')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                   <div class="text-center mt-3"><button class="btn btn-success w-50">ثبت</button></div>
               </form>
               @else
                  <div class="card p-3" style="border-radius: 0.4rem;border:none;color:lightblue;">
                      <div class="row ">
                          <div class="col-12 col-md-6">
                              <p class="m-0"><span>شماره </span> {{$lpo->num_lpo}} : LPO</p>
                          </div>
                          <div class="col-12 col-md-6">
                              <p class="m-0">تاریخ : <span>{{$date}}</span>  </p>
                          </div>
                      </div>
                  </div>
                <form action="/admin/crm/lpo/product/add" method="POST">
                    @csrf
                    <div class="d-flex gap-3 form-row-responsive justify-content-center">
                        <select class="form-select select2-farsi w-100" dir="rtl" name="prod_id" id="productSelect">
                           <option value="" selected>طرح را جستجو کنید</option>
                           @foreach($prods as $prod)
                           <option value="{{ $prod->id }}">{{$prod->code_prod}}--{{$prod->name}}</option>
                           @endforeach
                        </select>
                    </div>

                    @error('prod_id')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror

                    <div class="d-flex gap-3 form-row-responsive justify-content-center mt-3">
                        <input type="hidden" value="{{ $lpo->id }}" name="lpo_id">

                        <div class="w-50">
                            <label for="">سایز کاشی </label>
                            <select name="size_id" id="sizeSelect" class="form-select m-0"
                            onchange="calc()">
                                <option value="" selected disabled>سایز را انتخاب کنید</option>
                            </select>
                        </div>

                        <div class="w-50">
                            <label for="">متراژکل</label>
                            <input type="text" name="count_all" id="all" class="form-control" placeholder="متراژ کل"
                            onkeyup="calc()"
                            >
                        </div>

                        <div class="w-50">
                            <label for="">تعداد کارتن کل</label>
                            <input type="text" name="count_box" id="box" class="form-control" placeholder="  کارتن کل">
                        </div>

                        <div class="w-50">
                            <label for="">تعداد پالت</label>
                            <input type="text" name="count_palet" id="palet" class="form-control" placeholder="  پالت ">
                        </div>

                        <div class="w-50">
                            <label for="">تعداد کارتن خرد</label>
                            <input type="text" name="box_num" id="box_num" class="form-control" placeholder="  کارتن خرد">
                        </div>

                        <div class="w-50">
                            <label for="">تعداد برگ</label>
                            <input type="text" name="count_paper" id="paper" class="form-control" placeholder="  برگ ">
                        </div>

                    </div>
                    @error('count_all')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror
                    @error('count_box')
                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                    @enderror

                    <div class="text-center mt-3"><button class="btn btn-success w-50">اضافه کردن</button></div>

                </form>

                <form action="/admin/crm/lpo/product/img" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" hidden name="lpo_id" value="{{ $lpo->id }}">

                    <div style="display: flex;justify-content: center;margin-top: 1rem;">
                        <div class="upload-area" id="uploadArea">

                            <div >
                              <div class="upload-icon"><i class="fa-solid fa-upload"></i></div>
                              <p>آپلود تصویر LPO</p>
                            </div>

                            <input type="file" id="fileInput" name="img" class="file-input d-none" accept="image/*">
                        </div>
                    </div>

                    <div style="display: flex;justify-content: center;align-items: center">
                    
                        <div class="preview-container" id="previewContainer">
                          <img id="previewImage" class="preview-image" alt="Preview">
                        </div>
                    
                    </div>
                    <div class="text-center mt-4"><button class="btn btn-success">آپلود تصویر LPO</button></div>
                    
                </form>

                <div class="table-responsive mt-4">
                    <table class="table table-dark table-hover mt-3 table-borderless">
                            <thead class="text-center" style="border-bottom: 2px solid #3BDE77;">
                                <tr>
                                    <th>ردیف</th>
                                    <th>کد کالا</th>
                                    <th>نام محصول</th>
                                    <th>سایز </th>
                                    <th>تعداد کارتن</th>
                                    <th>متراژ هر کارتن</th>
                                    <th>تعداد پالت</th>
                                    <th> متراژ کل</th>
                                    <th> قیمت</th>
                                    <th> قیمت کل</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach($lpo_prods as $key => $lpo_prod)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$lpo_prod->prod->code_prod}}</td>
                                    <td>{{$lpo_prod->prod->name}}</td>
                                    <td>{{$lpo_prod->size->name}}</td>
                                    <td>{{$lpo_prod->count_box}}</td>
                                    <td>{{$lpo_prod->size_prod->box_meter}}</td>
                                    <td>{{$lpo_prod->count_palet}}</td>
                                    <td>{{$lpo_prod->count_all}}</td>
                                    <td>{{number_format($lpo_prod->prod->price)}}</td>
                                    <td>{{number_format($lpo_prod->prod->price * $lpo_prod->count_all)}}</td>
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
                            <p class="m-0 p-0">قیمت کل : <span style="padding-right: 0.5rem">{{number_format($priceAll)}}</span><span style="padding-right: 0.2rem">تومان</span></p>
                        </div>
                        {{-- <div class="col-lg-4 col-md-6 col-12">
                            <p class="m-0 p-0">تعداد پالت ها : <span style="padding-right: 0.5rem">{{$palet}}</span><span style="padding-right: 0.2rem">تعداد</span></p>
                        </div> --}}

                    </div>

                </div>

                <form action="/admin/crm/cart/final/lpo" method="POST">
                    @csrf
                    <input type="hidden" name="lpo_id" value="{{ $lpo->id }}">
                    <div class="d-flex justify-content-end mt-4"><button class="btn btn-success" id="btn-final">ثبت   LPO </button></div>
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
                    return "نتیجه‌ای یافت نشد لطفا اول مشتری  یا طرح را اضافه کنید";
                },
                searching: function() {
                    return "در حال جستجو...";
                }
            }
        });
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
        title: "خطا...",
        text: '{{ session('error') }}',
        footer: '<a href="/admin/crm/buy/add/{id}" target="_blank">افزایش موجودی محصول</a>',
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

<script>
    $('#productSelect').on('change', function() {
        let productId = $(this).val();
        if (productId) {
            $.ajax({
                url: '/get-product-info/lpo/' + productId,
                method: 'GET',
                success: function(data) {
                    let sizeSelect = $('#sizeSelect');
                    sizeSelect.empty(); // خالی کردن قبلی‌ها
                                
                    sizeSelect.append('<option value="" selected disabled>سایز را انتخاب کنید</option>');
                                
                    if (data.sizes && data.sizes.length > 0) {
                        data.sizes.forEach(function(size) {
                            sizeSelect.append(
                                `<option value="${size.id}">${size.name}</option>`
                            );
                        });
                    }

                },
                error: function() {
                    $('#sizeSelect').val('');
    
                }
            });
        } else {
            $('#sizeSelect').val('');

        }
    });
</script>
<script>
    function calc(){
        let sizeId = document.getElementById('sizeSelect').value;
        let productId = document.getElementById('productSelect').value;
        let inputAll = document.getElementById('all').value;
        if (sizeId && inputAll) {
            //alert('s')
            $.ajax({
                url: '/get-product-info/lpo/size/' + sizeId + '/' + productId + '/' + inputAll,
                method: 'GET',
                success: function(data) {
                    let inputPalet = document.querySelector('#palet')
                    let inputBox = document.querySelector('#box')
                    let inputAll = document.querySelector('#all')
                    let inputBox_num = document.querySelector('#box_num')
                    let inputPaper = document.querySelector('#paper')

                    inputPaper.value = data.count_paper
                    inputBox_num.value = Math.floor(data.count_num_box)
                    inputPalet.value = data.count_palet
                    inputBox.value = Math.floor(data.count_box)
           
                    
                    // document.getElementById('').value=;hgfgjk
                    // inputAll.addEventListener('input', totalMeter);

                },
                error: function() {
                    $('#count_meter').val('');
                    $('#count_box').val('');
    
                }
            });
        } else {
            $('#count_meter').val('');
            $('#count_box').val('');

        }
    }
</script>



<script>
    $('#sizeSelect').on('change', function() {
        
    });
</script>

<script>
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    // Click to upload
    uploadArea.addEventListener('click', () => fileInput.click());
    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0]);
        }
    });
    // File input change
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0]);
        }
    });
    function handleFile(file) {
        // Check if file is image
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file');
            return;
        }
        // Check file size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            alert('File size must be less than 10MB');
            return;
        }
        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
            
            previewImage.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    function uploadImage() {
        const file = fileInput.files[0];
        if (!file) return;
        // Simulate upload
        const formData = new FormData();
        formData.append('image', file);
        // Here you would normally send to server
        console.log('Uploading:', file.name);
        alert('Image uploaded successfully! (This is just a demo)');
    }
    function clearPreview() {
        previewContainer.style.display = 'none';
        fileInput.value = '';
        previewImage.src = '';
    }
</script>

@endsection