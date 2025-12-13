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
        color: #fff !important;
    }
</style>
@endsection

@section('main')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="stat-card mt-3">

                <div class="d-flex justify-content-between align-items-center">
                    <div class="stat-title" style="font-size:1.4rem">
                        عکس های محصول
                    </div>
                    <button class="btn btn-success" id="img_post">
                        <i class="fa-solid fa-plus"></i>
                        <span class="p-1">عکس جدید</span>
                    </button>
                </div>

                <div class="row mt-3">
                    @forelse($imgs as $img)
                        <div class="col-lg-3 col-md-6 col-6 mb-3">
                            <div class="card">
                                <img src="{{ asset($img->img_url) }}" class="card-img-top">
                                <div class="card-body text-center">
                                    <form action="{{ route('products.delete-img',$img->id) }}"
                                          method="POST"
                                          class="delete-img-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center mt-3">عکسی ثبت نشده است</p>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ================= MODAL ================= -->
<div id="overlay" style="
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.6);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:9999;
">
    <div style="
        background:rgba(24,31,42,.95);
        padding:25px;
        border-radius:15px;
        width:450px;
        position:relative;

        max-height:90vh;
        overflow-y:auto;
    ">


        <button id="closeModal" type="button" style="
            position:absolute;
            top:10px;
            left:10px;
            width:32px;
            height:32px;
            border-radius:50%;
            border:none;
            background:rgba(255,255,255,.15);
            color:white;
            font-size:20px;
            cursor:pointer;
        ">×</button>

        <h4 class="text-center mb-3 text-white">افزودن عکس جدید</h4>

        <!-- upload area -->
        <div id="uploadArea" style="
            border:3px dashed rgba(102,126,234,.6);
            border-radius:15px;
            padding:40px 20px;
            cursor:pointer;
            text-align:center;
            color:white;
        ">
            <div style="font-size:40px">📁</div>
            <div class="mt-2">برای انتخاب عکس کلیک کنید</div>
        </div>

        <!-- preview -->
        <div id="previewContainer" style="display:none;margin-top:15px">
            <img id="previewImage" style="
    width:100%;
    border-radius:12px;
    max-height:50vh;
    object-fit:contain;
">

        </div>

        <form action="/admin/product/add-img/{{ $prod->id }}"
              method="POST"
              enctype="multipart/form-data"
              class="mt-3">
            @csrf

            <input type="file"
                   name="img"
                   id="fileInput"
                   accept="image/*"
                   hidden>

            <button class="btn btn-success w-100 mt-3">
                ثبت عکس
            </button>
        </form>

    </div>
</div>
@endsection

@section('script')
<script>
    // ===== MODAL =====
    const btn = document.getElementById('img_post');
    const overlay = document.getElementById('overlay');
    const closeModal = document.getElementById('closeModal');

    btn.onclick = () => overlay.style.display = 'flex';
    closeModal.onclick = () => overlay.style.display = 'none';

    overlay.onclick = (e) => {
        if (e.target === overlay) overlay.style.display = 'none';
    };

    // ===== UPLOAD + PREVIEW =====
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');

    uploadArea.onclick = () => fileInput.click();

    fileInput.onchange = function () {
        if (this.files.length === 0) return;

        const file = this.files[0];

        if (!file.type.startsWith('image/')) {
            alert('فقط عکس مجاز است');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = e => {
            previewImage.src = e.target.result;
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    };

    // ===== DELETE CONFIRM =====
    document.querySelectorAll('.delete-img-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'حذف عکس؟',
                text: 'این عملیات قابل بازگشت نیست',
                icon: 'warning',
                background: '#181f2a',
                color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#BF092F',
                cancelButtonColor: '#4E56C0',
                confirmButtonText: 'بله حذف شود',
                cancelButtonText: 'خیر'
            }).then(result => {
                if (result.isConfirmed) form.submit();
            });
        });
    });
</script>
@endsection
