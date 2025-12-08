<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جزئیات فاکتور</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>

    @font-face {
        font-family: yekan;
        src: url({{ asset('fonts/YekanBakh-Medium.ttf') }});
    }
        :root {
            --main-bg: #181f2a;
            --card-bg: #232b39;
            --accent-green: #43e97b;
            --text-main: #e6eaf1;
            --text-secondary: #89a5c5;
            --card-radius: 18px;
        }
        
        body {
            background-color: var(--main-bg);
            color: var(--text-main);
            font-family: yekan;
            padding: 20px;
        }
        
        .invoice-container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .invoice-card {
            background-color: var(--card-bg);
            border-radius: var(--card-radius);
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }
        
        .header-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }
        
        .invoice-id {
            color: var(--accent-green);
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .invoice-status {
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: bold;
            font-size: 0.9rem;
        }
        
        .status-paid {
            background-color: rgba(67, 233, 123, 0.15);
            color: var(--accent-green);
        }
        
        .info-section {
            margin-bottom: 30px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 15px;
        }
        
        .info-label {
            color: var(--text-secondary);
            min-width: 150px;
        }
        
        .info-value {
            font-weight: 500;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .items-table th {
            background-color: rgba(0, 0, 0, 0.2);
            color: var(--text-secondary);
            padding: 15px;
            text-align: right;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .items-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .total-section {
            background-color: rgba(67, 233, 123, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            border-right: 4px solid var(--accent-green);
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 1.1rem;
            margin-bottom: 10px;
        }
        
        .total-amount {
            font-size: 1.8rem;
            font-weight: bold;
            color: var(--accent-green);
            margin-top: 10px;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn-print {
            background-color: var(--accent-green);
            color: #000;
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-print:hover {
            background-color: #38d16c;
            transform: translateY(-2px);
        }
        
        .btn-back {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-main);
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-back:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .company-logo {
            background: linear-gradient(45deg, var(--accent-green), #2ecc71);
            width: 70px;
            height: 70px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: bold;
            color: #000;
        }
        
        .invoice-title {
            color: var(--accent-green);
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .invoice-date {
            color: var(--text-secondary);
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="container invoice-container">
        <!-- کارت اصلی فاکتور -->
        <div class="invoice-card">
            <!-- هدر فاکتور -->
            <div class="header-card">
                <div>
                    <div class="invoice-id"> شماره فاکتور: <span>{{$cart->num_cart}}</span></div>
                    <div class="invoice-title">نوع فاکتور : <span>{{$cart->text_type}}</span></div>
                    <div class="invoice-date">تاریخ فاکتور: <span>{{$date}}</span></div>
                </div>
                {{-- <div class="text-end">
                    <div class="company-logo mb-3">F</div>
                    <span class="invoice-status status-paid">پرداخت شده</span>
                </div> --}}
            </div>
            
            <!-- اطلاعات فاکتور -->
            {{-- <div class="row">
                <div class="col-md-6">
                    <div class="info-section">
                        <h5 class="mb-3" style="color: var(--accent-green);">اطلاعات فروشنده</h5>
                        <div class="info-row">
                            <div class="info-label">نام شرکت:</div>
                            <div class="info-value">شرکت فناوری پردازش</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">شناسه ملی:</div>
                            <div class="info-value">۱۴۰۰۵۵۵۵۵۵۵</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">آدرس:</div>
                            <div class="info-value">تهران، خیابان ولیعصر، پلاک ۱۲۳۴</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">تلفن:</div>
                            <div class="info-value">۰۲۱-۸۸۸۸۸۸۸۸</div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-section">
                        <h5 class="mb-3" style="color: var(--accent-green);">اطلاعات مشتری</h5>
                        <div class="info-row">
                            <div class="info-label">نام مشتری:</div>
                            <div class="info-value">شرکت نوآوران فناوری</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">شناسه ملی:</div>
                            <div class="info-value">۱۴۰۰۱۱۱۱۱۱۱</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">آدرس:</div>
                            <div class="info-value">اصفهان، خیابان شهید بهشتی، پلاک ۵۶۷</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">تلفن:</div>
                            <div class="info-value">۰۳۱-۷۷۷۷۷۷۷۷</div>
                        </div>
                    </div>
                </div>
            </div> --}}
            
            <!-- جدول آیتم‌های فاکتور -->
            <div>
                <h5 class="mb-3" style="color: var(--accent-green);">آیتم‌های فاکتور</h5>
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شرح کالا  </th>
                            <th>تعداد کارتن</th>
                            <th>تعداد پالت</th>
                            <th>متراژکل</th>
                            <th>قیمت</th>
                            <th>مبلغ (تومان)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart_prods as $key => $cart_prod)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$cart_prod->prod->name}}</td>
                                <td>{{ $cart_prod->count_box }}</td>
                                <td>{{ $cart_prod->count_palet }}</td>
                                <td>{{ $cart_prod->count_box * $cart_prod->prod->count_meter }}</td>
                                <td>{{number_format($cart_prod->prod->price)}}</td>
                                <td>{{number_format($cart_prod->prod->price * ($cart_prod->count_box * $cart_prod->prod->count_meter))}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- بخش جمع‌کل و مالیات -->
            <div class="total-section">
                <div class="total-row">
                    <span>تعداد کل کارتن:</span>
                    <span>{{$cart->count_boxs}}</span>
                </div>
                <div class="total-row">
                    <span>تعداد کل پالت :</span>
                    <span>{{ $cart->count_palet }} <span>تعداد</span> </span>
                </div>
                <div class="total-row">
                    <span>متراژکل:</span>
                    <span><span>{{$cart->count_meters}} </span>متر</span>
                </div>
                <div class="total-row total-amount">
                    <span>مبلغ نهایی فاکتور:</span>
                    <span><span>{{number_format($cart->price)}} </span>تومان</span>
                </div>
            </div>
            
            <!-- اطلاعات پرداخت -->
            {{-- <div class="info-section mt-4">
                <h5 class="mb-3" style="color: var(--accent-green);">اطلاعات پرداخت</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">تاریخ پرداخت:</div>
                            <div class="info-value">۱۴۰۲/۰۵/۱۶</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">روش پرداخت:</div>
                            <div class="info-value">کارت به کارت</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-row">
                            <div class="info-label">شماره تراکنش:</div>
                            <div class="info-value">TRX-2023-001-456</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">وضعیت پرداخت:</div>
                            <div class="info-value">تکمیل شده</div>
                        </div>
                    </div>
                </div>
            </div> --}}
            
            <!-- دکمه‌های اقدام -->
            <div class="action-buttons">
                {{-- <button class="btn-print">
                    <i class="bi bi-printer me-2"></i> چاپ فاکتور
                </button> --}}
                <a class="btn-back btn" href="/admin/crm/listInvocie">
                    <i class="bi bi-arrow-right me-2"></i> بازگشت به لیست
                </a>
                {{-- <button class="btn-back">
                    <i class="bi bi-download me-2"></i> دانلود PDF
                </button> --}}
            </div>
        </div>
        
        <!-- کارت توضیحات اضافی -->
        {{-- <div class="invoice-card">
            <h5 class="mb-3" style="color: var(--accent-green);">توضیحات و یادداشت‌ها</h5>
            <div class="info-row">
                <div class="info-label">توضیحات:</div>
                <div class="info-value">طراحی وبسایت شرکتی با امکانات مدیریت محتوا، سیستم عضویت و پنل مدیریت پیشرفته</div>
            </div>
            <div class="info-row">
                <div class="info-label">یادداشت:</div>
                <div class="info-value">پشتیبانی فنی به مدت ۶ ماه پس از تحویل پروژه شامل می‌شود.</div>
            </div>
            <div class="info-row">
                <div class="info-label">مهلت تحویل:</div>
                <div class="info-value">۱۴۰۲/۰۶/۱۵</div>
            </div>
            <div class="info-row">
                <div class="info-label">تحویل‌دهنده:</div>
                <div class="info-value">علی محمدی (کارشناس فنی)</div>
            </div>
        </div> --}}
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>