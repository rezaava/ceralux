@extends('admin.layout.master')

@section('title-site')
مشاهده عکس کالا
@endsection

@section('onvan')
لیست عکس های محصول {{ $prod->name }}
@endsection

@section('head')
<style>
    select option {
        background: #1e1e1e !important;
        /* پس‌زمینه تیره */
        color: #fff !important;
        /* متن سفید */
    }
</style>
@endsection
@section('main')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="stat-card mt-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="stat-title" style="font-size: 1.4rem"> عکس های محصول </div>
                    <p class="btn btn-success" id="img_post"> <i class="fa-solid fa-plus"></i><span class="p-1">عکس
                            جدید</span></p>
                </div>

                <div class="row justify-content-start">
                    @if(empty($imgs))
                        <p>عکسی موجود نمیباشد</p>
                    @else
                        @foreach($imgs as $img)
                            <div class="col-lg-3 col-md-6 col-6">
                                <div class="card">
                                    <img class="card-img-top" src="{{ asset($img->img_url) }}" alt="">
                                    <div class="card-body text-center">
                                        <form action="{{ url('/products/delete-img/'.$img->id) }}" method="POST" class="delete-img-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa-solid fa-trash-can"></i>
                                                <span style="padding-right: 0.6rem">حذف</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>


            </div>
        </div>
    </div>
</div>



<div id="overlay" style="
    position: fixed; top:0; left:0;
    width:100%; height:100%;
    background: rgba(0,0,0,0.6);
    display:none; justify-content:center; align-items:center;
    z-index:9999;
">
    <div style="
    background: rgba(24, 31, 42, 0.90);
    padding: 25px;
    border-radius: 15px;
    width: 450px;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    
">

        <h4 class="mb-3 text-center">افزودن عکس جدید</h4>

        <!-- ناحیه آپلود + پری‌ویو -->
        <div class="upload-area" id="uploadArea" style="
    border: 3px dashed rgba(102, 126, 234, 0.5);
    border-radius: 15px;
    padding: 40px 20px;
    cursor: pointer;
    text-align:center;
    
    background: rgba(255, 255, 255, 0.18);   /* ← شفاف لازم است */
    backdrop-filter: blur(14px);             /* تاری پشت */
    -webkit-backdrop-filter: blur(14px);

    box-shadow: 0 8px 30px rgba(0,0,0,0.15); /* شیشه‌ای واقعی */
    transition: 0.3s;
">

            <div style="font-size:40px; color:#667eea;">📁</div>
            <div style="color:white; margin-top:10px;">برای انتخاب عکس کلیک کنید</div>
            <input type="file" name="img" id="fileInput2" class="file-input" accept="image/*" style="display:none;">
        </div>

        <!-- پریویو -->
        <div class="preview-container" id="previewContainer" style="display:none; margin-top:20px;">
            <img id="previewImage" style="
                max-width:100%; border-radius:12px; box-shadow:0 5px 20px rgba(0,0,0,0.15);
            ">

            <!-- <div style="background:#f3f4ff; padding:10px; margin-top:15px; border-radius:10px;">
                <div id="fileName" style="font-weight:bold;"></div>
                <div id="fileSize" style="font-size:14px; color:#555;"></div>
            </div> -->
        </div>

        <form action="/products/add-img/{{ $prod->id }}" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf

            <input type="file" id="fileInput" name="img_file" hidden>


            <!-- ورودی متن -->
            {{-- <input
                type="text"
                name="img_name"
                placeholder="اسم مکان عکس کاشی (اختیاری)"
                style="
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.25);
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            color: #fff;
            font-size: 14px;
        "> --}}

            <!-- انتخاب نوع عکس -->
            {{-- <select
                name="type_img"
                style="
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 15px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.25);
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            color: #fff;
            font-size: 14px;
        ">
                <option value="1">عکس روی کارت محصول</option>
                <option value="2">عکس بنر سمت راست</option>
                <option value="3">عکس بنر سمت چپ</option>
                <option value="4">عکس کاشی در حمام</option>
                <option value="5">عکس کاشی در آشپزخانه</option>
                <option value="6">عکس کاشی در پذیرایی</option>
                <option value="7">عکس کاشی در کف</option>
            </select> --}}

            <!-- دکمه‌ها -->
            <div class="text-center mt-4">
                <button
                    class="btn btn-success"
                    style="
                padding: 10px 25px;
                border-radius: 10px;
                font-size: 15px;
            ">
                    ثبت
                </button>

                <button id="closeModal" type="button" style="
                position:absolute;
                top:10px;
                left:10px;
                background: rgba(255,255,255,0.15);
                border:none;
                width:32px;
                height:32px;
                border-radius:50%;
                color:white;
                font-size:20px;
                cursor:pointer;
                backdrop-filter: blur(6px);
                -webkit-backdrop-filter: blur(6px);
                display:flex;
                justify-content:center;
                align-items:center;
                transition:0.2s;
            ">×</button>

            </div>
        </form>


    </div>
</div>


@endsection

@section('script')
<script>
    // ---------- MODAL ----------
    let btn = document.querySelector('#img_post');
    let overlay = document.querySelector('#overlay');
    let closeModal = document.querySelector('#closeModal');

    btn.addEventListener('click', () => {
        overlay.style.display = 'flex';
    });

    closeModal.addEventListener('click', () => {
        overlay.style.display = 'none';
    });

    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) overlay.style.display = 'none';
    });

    // ---------- PREVIEW SCRIPT ----------
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');

    uploadArea.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0]);
        }
    });

    function handleFile(file) {
        if (!file.type.startsWith("image/")) {
            alert("فقط عکس انتخاب کنید");
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            previewContainer.style.display = "block";
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / 1024).toFixed(1) + " KB";
        };
        reader.readAsDataURL(file);
    }


    const imgHidden = document.getElementById('fileInput2');

    function handleFile(file) {
        if (!file.type.startsWith("image/")) {
            alert("فقط عکس انتخاب کنید");
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            previewContainer.style.display = "block";
            fileName.textContent = file.name;
            fileSize.textContent = (file.size / 1024).toFixed(1) + " KB";

            imgHidden.value = e.target.result; // ⬅ این خط مهم است
        };
        reader.readAsDataURL(file);
    }
</script>
<script>
    // گرفتن همه فرم‌های حذف
    const deleteForms = document.querySelectorAll('.delete-img-form');

    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // جلوگیری از ارسال فرم قبل از تأیید

            Swal.fire({
                title: 'آیا از حذف عکس مطمئن هستید؟',
                text: "این عملیات قابل بازگشت نیست!",
                icon: 'warning',
                background: '#181f2a' ,
                color: 'white' ,
                showCancelButton: true,
                confirmButtonColor: '#BF092F',
                cancelButtonColor: '#4E56C0',
                confirmButtonText: 'بله، حذف شود!',
                cancelButtonText: 'خیر',
                background: '#181f2a',
                color: '#ffffff'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // اگر تأیید شد، فرم ارسال می‌شود
                }
            })
        });
    });
</script>


@endsection