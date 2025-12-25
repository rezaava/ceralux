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
            border: 2px solid #232323;
            border-radius: 10px;
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

<div>
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
                تاریخ فاکتور: {{ $date ?? '-' }}
            </td>
        </tr>
        <tr>
            @if($cart->num_lpo == 0)
            <td style="border:none; font-size:15px; padding-bottom:4px;text-align: right">متفرقه</td>
            @else
            <td style="border:none; font-size:15px; padding-bottom:4px;text-align: right">
                 شماره LPO : {{ $cart->num_lpo ?? '-' }}
            </td>
            @endif
        </tr>
    </table>
    
    
    
    
    <hr>
    <table width="100%" cellspacing="0" cellpadding="0" style="border:none;">
        <tr>
            <td style="border:none; vertical-align: top; font-size:16px; font-weight:bold;text-align: right;padding-top: 0">
                   نام خریدار :  <span style="font-weight: normal ; font-size: 16px;">{{ $customer->name ?? '-' }}</span>
            </td>
            <td style="border:none; vertical-align: top; font-size:16px; font-weight:bold;text-align: center;padding-top: 0"> شماره  موبایل خریدار :    <span style="font-weight: normal ; font-size: 16px;">{{ $customer->phone ?? '-' }}</span> </td>
        </tr>
        <tr>
            <td style="border:none; vertical-align: top; font-size:16px; font-weight:bold;text-align: right;padding-top: 6px;">
                آدرس خریدار : <span style="font-weight: normal ; font-size: 16px;">{{ $customer->address ?? '-' }}</span>
            </td>
        </tr>
    </table>
    <hr>
    
    {{-- جدول اقلام --}}
    <table>
        <thead>
            <tr>
                <th>ردیف</th>
                <th>نام طرح</th>
                <th>  سایز هر طرح </th>
                <th> متراژ هر کارتن</th>
                <th>کارتن خرد</th>
                <th>کارتن کل</th>
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
                    $box_num   = $item->count_box_num ?? 0;
                    $box   = $item->count_box ?? 0;
                    $totalMeter = $box * $meter;
                    $totalPrice = $totalMeter * $price;
                @endphp
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->prod->name ?? '-' }}</td>
                    <td>{{$item->size->name}}</td>
                    <td>{{$item->size_prod->box_meter}}</td>
                    <td>{{ $item->count_box_num ?? 0 }}</td>
                    <td>{{ $item->count_box ?? 0 }}</td>
                    <td>{{ $item->count_palet ?? 0 }}</td>
                    <td>{{ $item->count_all }}</td>
                    <td>{{ number_format($item->prod->price) }}</td>
                    <td>%{{ $item->off }}</td>
                    <td>{{ number_format($item->prod->price * ($item->count_all) - ($item->prod->price * ($item->count_all)) * ($item->off/100) ) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">محصولی ثبت نشده است</td>
                </tr>
            @endforelse
                <tr>
                    <td colspan="4">جمع کل فاکتور </td>
                    <td>{{ $cart->box_num ?? 0 }} عدد</td>
                    <td>{{ $cart->count_boxs ?? 0 }} عدد</td>
                    <td>{{ $cart->count_palet ?? 0 }} عدد</td>
                    <td>{{ $cart->count_meters ?? 0 }} متر</td>
                    <td></td>
                    <td></td>
                    <td>{{ number_format($cart->price) ?? 0 }}</td>
                </tr>
        </tbody>
    </table>
    
    {{-- جمع کل --}}
    <div class="totals final-price" style="padding-right: 10px;padding-bottom: 30px;">
        <p> کرایه بار: {{ number_format($cart->price_rent) ?? 0 }} <span>درهم</span></p>
        @if($cart->no_tax == 1)
        <p>5% مالیات بر ارزش افزوده:{{ number_format($five) ?? 0 }} درهم</p>
        @endif
        <p> تخفیف کل: % {{ number_format($cart->off) ?? 0 }} </p>
        <div class="final-price">
            مبلغ نهایی: {{ number_format($finalPrice ?? 0) }} درهم
        </div>
    </div>
</div>
<script>
    window.print();
</script>

</body>
</html>