@extends('admin.layout.master')

@section('title-site')
داشبورد
@endsection

@section('onvan')
داشبورد
@endsection

@section('title-onvan')
<div class="dashboard-desc">خوش آمدید! امروز <span style="color:var(--accent-green)">۵ اعلان جدید</span> دارید.</div>
@endsection

@section('main')
@if(Auth::user()->hasRole('manager'))
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-title">مجموع فروش امروز</div>
            <div class="stat-value text-primary">۲,۳۵۰,۰۰۰ تومان</div>
            <div class="stat-desc">+۹% نسبت به دیروز</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-title">تعداد سفارشات</div>
            <div class="stat-value text-primary">۸۷</div>
            <div class="stat-desc">+۵ سفارش جدید</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-title">کاربران جدید</div>
            <div class="stat-value text-primary">۲۳</div>
            <div class="stat-desc">+۳ کاربر امروز</div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="stat-card">
            <div class="stat-title">بازدید امروز</div>
            <div class="stat-value text-primary">۱۲,۴۰۰</div>
            <div class="stat-desc">+۲% نسبت به دیروز</div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-lg-8 mb-3">
        <div class="chart-card">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span style="color:var(--accent-green);font-weight:600">نمودار فروش هفتگی</span>
                <span class="text-secondary" style="font-size:0.95rem">۱۴۰۳</span>
            </div>
            <div class="chart-placeholder">
                (جایگاه نمودار فروش - قابل اتصال به Chart.js)
            </div>
        </div>
    </div>
    <div class="col-md-4">
      <div class="notification-card">
        <h6><i class="fas fa-bell text-warning"></i> اعلانات محصول</h6>
        <ul class="list-unstyled mt-3">
          <li class="mb-2">
            <i class="fas fa-exclamation-circle text-danger"></i> موجودی
            محصول "لپ‌تاپ" در حال اتمام است
          </li>
          <li class="mb-2">
            <i class="fas fa-info-circle text-info"></i> محصول جدید "ماوس
            بی‌سیم" اضافه شد
          </li>
          <li>
            <i class="fas fa-check-circle text-success"></i> موجودی محصول
            "کیبورد" تکمیل شد
          </li>
        </ul>
      </div>
    </div>
</div>
<div class="row g-3">
    <div class="col-lg-4 col-md-6">
        <div class="card p-3">
            <div class="d-flex align-items-center mb-2">
                <div class="activity-icon"><i class="fas fa-box"></i></div>
                <div class="ms-3">
                    <div class="fw-bold">محصول جدید: هدفون بی‌سیم</div>
                    <div class="text-secondary" style="font-size:0.95rem">۵ دقیقه پیش</div>
                </div>
            </div>
            <div class="text-success">موجودی: ۲۵ عدد</div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card p-3">
            <div class="d-flex align-items-center mb-2">
                <div class="activity-icon"><i class="fas fa-user-plus"></i></div>
                <div class="ms-3">
                    <div class="fw-bold">ثبت نام کاربر جدید: علی محمدی</div>
                    <div class="text-secondary" style="font-size:0.95rem">۱۰ دقیقه پیش</div>
                </div>
            </div>
            <div class="text-success">سطح: مشتری ویژه</div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card p-3">
            <div class="d-flex align-items-center mb-2">
                <div class="activity-icon"><i class="fas fa-shopping-cart"></i></div>
                <div class="ms-3">
                    <div class="fw-bold">سفارش جدید: #۱۲۳۴۵</div>
                    <div class="text-secondary" style="font-size:0.95rem">۲۰ دقیقه پیش</div>
                </div>
            </div>
            <div class="text-success">مبلغ: ۱,۲۵۰,۰۰۰ تومان</div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card p-3">
            <div class="d-flex align-items-center mb-2">
                <div class="activity-icon"><i class="fas fa-credit-card"></i></div>
                <div class="ms-3">
                    <div class="fw-bold">پرداخت موفق: #۹۸۷۶۵</div>
                    <div class="text-secondary" style="font-size:0.95rem">۴۰ دقیقه پیش</div>
                </div>
            </div>
            <div class="text-success">درگاه: زرین‌پال</div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card p-3">
            <div class="d-flex align-items-center mb-2">
                <div class="activity-icon"><i class="fas fa-comment"></i></div>
                <div class="ms-3">
                    <div class="fw-bold">نظر جدید: عالی بود!</div>
                    <div class="text-secondary" style="font-size:0.95rem">۱ ساعت پیش</div>
                </div>
            </div>
            <div class="text-success">کاربر: سارا احمدی</div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card p-3">
            <div class="d-flex align-items-center mb-2">
                <div class="activity-icon"><i class="fas fa-truck"></i></div>
                <div class="ms-3">
                    <div class="fw-bold">ارسال سفارش: #۱۲۳۴۵</div>
                    <div class="text-secondary" style="font-size:0.95rem">۲ ساعت پیش</div>
                </div>
            </div>
            <div class="text-success">وضعیت: ارسال شد</div>
        </div>
    </div>
</div>
@endif
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
            timer: 3000,
            timerProgressBar: true,
            background: '#e6ffed',
            color: '#000',
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
    </script>
@endif
@endsection