<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">

    <style>
        @font-face {
            font-family: yekan;
            src: url({{ asset('fonts/YekanBakh-Medium.ttf') }});
        }

        body {
            font-family: yekan;
            font-size: 12px; 
            direction: rtl;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* تنظیمات صفحه و مرکز چین کردن کل فاکتور */
        .page {
            width: 148mm;  /* عرض A5 */
            height: 210mm; /* ارتفاع A5 */
            display: flex;
            justify-content: center; /* وسط افقی */
            align-items: center;     /* وسط عمودی */
            margin: 0 auto;
        }

        .invoice-container {
            width: 100%;
            max-width: 140mm; /* فاصله با حاشیه‌ها */
        }

        .invoice-title {
            font-size: 16px; 
            font-weight: bold;
            margin-bottom: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 12px;
            text-align: right; /* متن‌ها سمت راست */
        }

        th, td {
            border: 1px solid #999;
            padding: 6px;
        }

        th {
            background-color: #f2f2f2;
            font-size: 12px;
        }

        .totals {
            margin-top: 15px;
            font-size: 13px;
            text-align: right;
        }

        .totals p {
            margin: 4px 0;
        }

        .final-price {
            font-size: 16px;
            font-weight: bold;
            margin-top: 8px;
        }

        hr {
            margin: 10px 0;
            border: 0.5px solid #999;
        }

        @page {
            size: A5;
            margin: 10mm;
        }
    </style>
</head>

<body>
<div class="page">
    <div class="invoice-container">
        <!-- بالای فاکتور -->
        <table width="100%" cellspacing="0" cellpadding="0" style="border:none;">
            <tr>
                <td style="border:none; vertical-align: top; font-size:16px; font-weight:bold; padding-bottom:4px;">
                    فاکتور {{ $cart->text_type ?? '-' }}
                </td>
                <td rowspan="3" style="border:none; vertical-align:top;">
                    <img src="{{ asset('images/logo.png') }}" style="width:100px;" alt="Logo">
                </td>
            </tr>
            <tr>
                <td style="border:none; font-size:14px; padding-bottom:2px;">
                    شماره فاکتور: {{ $cart->num_cart ?? '-' }}
                </td>
            </tr>
            <tr>
                <td style="border:none; font-size:14px; padding-bottom:2px;">
                    تاریخ فاکتور: {{ $date ?? '-' }}
                </td>
            </tr>
            <tr>
                <td style="border:none; font-size:14px; padding-bottom:2px;">
                     شماره LPO : {{ $cart->num_lpo ?? '-' }}
                </td>
            </tr>
        </table>

        <hr>

        <!-- اطلاعات خریدار -->
        <table width="100%" cellspacing="0" cellpadding="0" style="border:none;">
            <tr>
                <td style="border:none; font-size:14px; font-weight:bold;">
                       نام خریدار :  <span style="font-weight: normal ; font-size: 14px;">{{ $customer->name ?? '-' }}</span>
                </td>
                <td style="border:none; font-size:14px; font-weight:bold;"> شماره موبایل خریدار : <span style="font-weight: normal ; font-size: 14px;">{{ $customer->phone ?? '-' }}</span> </td>
            </tr>
            <tr>
                <td colspan="2" style="border:none; font-size:14px; font-weight:bold;">
                    آدرس خریدار : <span style="font-weight: normal ; font-size: 14px;">{{ $customer->address ?? '-' }}</span>
                </td>
            </tr>
        </table>

        <hr>

        <!-- جدول اقلام -->
        <table>
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>نام طرح</th>
                    <th>سایز هر طرح</th>
                    <th>متراژ هر کارتن</th>
                    <th>کارتن</th>
                    <th>پالت</th>
                    <th>متراژ کل</th>
                    <th>قیمت</th>
                    <th>تخفیف</th>
                    <th>مبلغ کل</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cart_prods as $key => $item)
                    @php
                        $meter = $item->product->count_meter ?? 0;
                        $price = $item->product->price ?? 0;
                        $box   = $item->count_box ?? 0;
                        $totalMeter = $box * $meter;
                        $totalPrice = $totalMeter * $price;
                    @endphp
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->prod->name ?? '-' }}</td>
                        <td>{{$item->size->name}}</td>
                        <td>{{$item->size_prod->box_meter}}</td>
                        <td>{{ $box }}</td>
                        <td>{{ $item->count_palet ?? 0 }}</td>
                        <td>{{ $item->count_all }}</td>
                        <td>{{ number_format($item->prod->price) }}</td>
                        <td>%{{ $item->off }}</td>
                        <td>{{ number_format($item->prod->price * ($item->count_all) - ($item->prod->price * ($item->count_all)) * ($item->off/100) ) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10">محصولی ثبت نشده است</td>
                    </tr>
                @endforelse
                    <tr>
                        <td colspan="4">جمع کل فاکتور </td>
                        <td>{{ $cart->count_boxs ?? 0 }} عدد</td>
                        <td>{{ $cart->count_palet ?? 0 }} عدد</td>
                        <td>{{ $cart->count_meters ?? 0 }} متر</td>
                        <td></td>
                        <td></td>
                        <td>{{ number_format($cart->price) ?? 0 }}</td>
                    </tr>
            </tbody>
        </table>

        <!-- جمع کل -->
        <div class="totals final-price">
            <p> کرایه بار: {{ number_format($cart->price_rent) ?? 0 }} </p>
            <p>5% مالیات بر ارزش افزوده:{{ number_format($five) ?? 0 }} درهم</p>
            <p> تخفیف کل: % {{ number_format($cart->off) ?? 0 }} </p>
            <div class="final-price">
                مبلغ نهایی: {{ number_format($finalPrice ?? 0) }} درهم
            </div>
        </div>
    </div>
</div>

<script>
    window.print();
</script>
</body>
</html>
