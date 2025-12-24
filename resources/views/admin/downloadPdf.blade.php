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
            background: #eee;
        }

        /* ===== نمایش عادی ===== */
        .page {
            width: 148mm;
            min-height: 210mm;
            margin: 20px auto;
            background: #fff;
            padding: 10mm;
            box-sizing: border-box;
        }

        /* ===== مخصوص چاپ ===== */
        @media print {
            body {
                background: #fff;
            }

            @page {
                size: A5;
                margin: 10mm;
            }

            .page {
                margin: 0 auto;
                padding: 0;
                width: auto;
                min-height: auto;
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
            white-space: nowrap;
            text-align: center;
        }

        th {
            background: #f2f2f2;
            font-weight: bold;
        }

        hr {
            border: none;
            border-top: 1px solid #000;
            margin: 6px 0;
        }

        .final-price {
            font-size: 14px;
            font-weight: bold;
            margin-top: 8px;
        }
    </style>
</head>

<body>

<div class="page">

    <!-- هدر -->
    <table style="border:none;">
        <tr>
            <td style="border:none; font-size:16px; font-weight:bold;">
                فاکتور {{ $cart->text_type ?? '-' }}
            </td>
            <td rowspan="3" style="border:none; text-align:left;">
                <img src="{{ asset('images/logo.png') }}" style="width:90px">
            </td>
        </tr>
        <tr>
            <td style="border:none;">شماره فاکتور: {{ $cart->num_cart ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:none;">تاریخ فاکتور: {{ $date ?? '-' }}</td>
        </tr>
        <tr>
            <td style="border:none;">شماره LPO: {{ $cart->num_lpo ?? '-' }}</td>
        </tr>
    </table>

    <hr>

    <!-- اطلاعات خریدار -->
    <table style="border:none;">
        <tr>
            <td style="border:none;">نام خریدار: {{ $customer->name ?? '-' }}</td>
            <td style="border:none;">شماره موبایل: {{ $customer->phone ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="2" style="border:none;">
                آدرس: {{ $customer->address ?? '-' }}
            </td>
        </tr>
    </table>

    <hr>

    <!-- جدول محصولات -->
    <table>
        <thead>
        <tr>
            <th>ردیف</th>
            <th>نام طرح</th>
            <th>سایز</th>
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
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->prod->name ?? '-' }}</td>
                <td>{{ $item->size->name ?? '-' }}</td>
                <td>{{ $item->size_prod->box_meter ?? 0 }}</td>
                <td>{{ $item->count_box ?? 0 }}</td>
                <td>{{ $item->count_palet ?? 0 }}</td>
                <td>{{ $item->count_all ?? 0 }}</td>
                <td>{{ number_format($item->prod->price ?? 0) }}</td>
                <td>%{{ $item->off ?? 0 }}</td>
                <td>
                    {{ number_format(
                        ($item->prod->price ?? 0) * ($item->count_all ?? 0)
                        - (($item->prod->price ?? 0) * ($item->count_all ?? 0) * ($item->off ?? 0) / 100)
                    ) }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10">محصولی ثبت نشده</td>
            </tr>
        @endforelse

        <tr>
            <td colspan="4">جمع کل فاکتور</td>
            <td>{{ $cart->count_boxs ?? 0 }}</td>
            <td>{{ $cart->count_palet ?? 0 }}</td>
            <td>{{ $cart->count_meters ?? 0 }}</td>
            <td colspan="2"></td>
            <td>{{ number_format($cart->price ?? 0) }}</td>
        </tr>
        </tbody>
    </table>

    <!-- جمع نهایی -->
    <div class="final-price">
        <p>کرایه بار: {{ number_format($cart->price_rent ?? 0) }}</p>
        <p>۵٪ مالیات بر ارزش افزوده: {{ number_format($five ?? 0) }}</p>
        <p>تخفیف کل: %{{ $cart->off ?? 0 }}</p>
        <p>مبلغ نهایی: {{ number_format($finalPrice ?? 0) }} درهم</p>
    </div>

</div>
<script>
    window.print();
</script>

</body>
</html>
