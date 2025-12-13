<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">

    <style>
        @font-face {
            font-family: yekan;
            src: url({{ public_path('fonts/YekanBakh-Medium.ttf') }});
        }

        body {
            font-family: yekan;
            font-size: 14px;
            direction: rtl;
            color: #000;
        }

        .invoice-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .invoice-info p {
            font-size: 15px;
        }

        .logo-box {
            text-align: left;
        }

        .logo-box img {
            width: 120px;
            height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-size: 14px;
        }

        .totals {
            margin-top: 20px;
            font-size: 15px;
        }

        .totals p {
            margin: 6px 0;
        }

        .final-price {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>

<body>

<table width="100%" cellspacing="0" cellpadding="0" style="border:none;">
    <tr>
        <td style="border:none; vertical-align: top; font-size:18px; font-weight:bold; padding-bottom:6px;text-align: right">
            فاکتور {{ $cart->text_type ?? '-' }}
        </td>
        <td rowspan="3" style="border:none; text-align:left; width:120px; vertical-align:top;">
            <img src="{{ public_path('images/logo.png') }}" style="width:160px;" alt="Logo">
        </td>
    </tr>
    <tr>
        <td style="border:none; font-size:15px; padding-bottom:4px;text-align: right">
            شماره فاکتور: {{ $cart->num_cart ?? '-' }}
        </td>
    </tr>
    <tr>
        <td style="border:none; font-size:15px; padding-bottom:4px;text-align: right">
            تاریخ: {{ $date ?? '-' }}
        </td>
    </tr>
</table>




<hr>

{{-- جدول اقلام --}}
<table>
    <thead>
        <tr>
            <th>ردیف</th>
            <th>نام کالا</th>
            <th>کارتن</th>
            <th>پالت</th>
            <th>متراژ کل</th>
            <th>قیمت</th>
            <th>مبلغ</th>
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
                <td>{{ $box }}</td>
                <td>{{ $item->count_palet ?? 0 }}</td>
                <td>{{ $totalMeter }}</td>
                <td>{{ number_format($price) }}</td>
                <td>{{ number_format($totalPrice) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">محصولی ثبت نشده است</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- جمع کل --}}
<div class="totals">
    <p>تعداد کل کارتن: {{ $cart->count_boxs ?? 0 }}</p>
    <p>تعداد کل پالت: {{ $cart->count_palet ?? 0 }}</p>
    <p>متراژ کل: {{ $cart->count_meters ?? 0 }} متر</p>

    <div class="final-price">
        مبلغ نهایی: {{ number_format($cart->price ?? 0) }} تومان
    </div>
</div>

</body>
</html>
