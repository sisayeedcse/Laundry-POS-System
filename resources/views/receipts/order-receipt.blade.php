<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: 80mm auto;
            margin: 0;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
            width: 80mm;
            margin: 0 auto;
            padding: 5mm;
            background: #fff;
        }

        .receipt {
            width: 100%;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .company-info {
            font-size: 9px;
            margin-bottom: 2px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .divider-double {
            border-top: 1px solid #000;
            margin: 5px 0;
        }

        .info-line {
            display: flex;
            justify-content: space-between;
            margin: 2px 0;
            font-size: 10px;
        }

        .section-title {
            font-weight: bold;
            margin: 8px 0 4px 0;
            font-size: 10px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 10px;
        }

        .item-name {
            flex: 1;
        }

        .item-details {
            display: flex;
            gap: 8px;
            font-size: 10px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
            font-size: 10px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 12px;
            font-weight: bold;
        }

        .footer-text {
            font-size: 9px;
            margin-top: 3px;
        }

        .qr-code {
            text-align: center;
            margin: 10px 0;
        }

        @media print {
            body {
                width: 80mm;
                margin: 0;
                padding: 5mm;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <!-- Header -->
        <div class="center">
            <div class="company-name">Amazing Laundry</div>
            <div class="company-info">Street 18, Al-Attiya Market</div>
            <div class="company-info">Industrial Area, Doha, Qatar</div>
            <div class="company-info">Tel: 33813886</div>
            <div class="company-info">Email: amazinglaundry82@gmail.com</div>
        </div>

        <div class="divider"></div>

        <!-- Order Info with Big Order Number -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
            <div style="flex: 1;">
                <div class="info-line">
                    <span>Order:</span>
                    <span class="bold" style="font-size: 14px;">#{{ $order->order_number }}</span>
                </div>
                <div class="info-line">
                    <span>Date:</span>
                    <span>{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="info-line">
                    <span>Customer:</span>
                    <span>{{ $order->customer->name }}</span>
                </div>
                @if($order->customer->phone)
                    <div class="info-line">
                        <span>Phone:</span>
                        <span>{{ $order->customer->phone }}</span>
                    </div>
                @endif
                <div class="info-line">
                    <span>Delivery:</span>
                    <span>{{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}</span>
                </div>
            </div>
            <div style="border: 2px solid #000; padding: 8px 12px; text-align: center; min-width: 60px;">
                <div style="font-size: 24px; font-weight: bold; line-height: 1;">{{ str_replace('#', '', $order->order_number) }}</div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Items -->
        <div class="section-title center">ITEMS</div>

        @foreach($order->orderItems as $item)
            <div class="item-row">
                <div class="item-name">{{ $item->service->name }}</div>
            </div>
            <div class="item-row" style="margin-top: -2px; padding-left: 5px;">
                <div class="item-details">
                    <span>{{ $item->quantity }}x</span>
                    <span>{{ $item->service_type == 'wash_iron' ? 'W&I' : 'Iron' }}</span>
                    <span>{{ number_format($item->unit_price, 2) }}</span>
                </div>
                <div class="bold">{{ number_format($item->subtotal, 2) }}</div>
            </div>
        @endforeach

        <div class="divider"></div>

        <!-- Summary -->
        <div class="summary-row">
            <span>Sub Total</span>
            <span>AED {{ number_format($order->orderItems->sum('subtotal'), 2) }}</span>
        </div>
        @if($order->discount > 0)
            <div class="summary-row">
                <span>Discount</span>
                <span>- AED {{ number_format($order->discount, 2) }}</span>
            </div>
        @endif
        @if($order->tax > 0)
            <div class="summary-row">
                <span>Tax</span>
                <span>AED {{ number_format($order->tax, 2) }}</span>
            </div>
        @endif

        <div class="divider-double"></div>

        <div class="total-row">
            <span>Total</span>
            <span>AED {{ number_format($order->total_amount, 2) }}</span>
        </div>

        <div class="divider-double"></div>

        <!-- Payment Info -->
        <div class="summary-row bold">
            <span>Paid ({{ ucfirst($order->payment_method) }})</span>
            <span>AED {{ number_format($order->total_amount, 2) }}</span>
        </div>

        <div class="divider"></div>

        <!-- Order Number for reference -->
        <div class="center">
            <div style="font-size: 10px; margin: 8px 0;">#{{ strtoupper($order->order_number) }}</div>
        </div>

        <!-- Footer -->
        <div class="center">
            <div class="bold" style="margin: 8px 0;">Thank you!</div>
            <div class="footer-text">{{ $order->created_at->format('d M Y, H:i') }}</div>
        </div>

        <div class="divider"></div>

        <!-- QR Code placeholder -->
        <div class="qr-code">
            <div style="font-size: 9px; color: #666;">Scan to view order details</div>
            <div style="margin-top: 5px;">
                <svg width="80" height="80" viewBox="0 0 100 100" style="margin: 0 auto; display: block;">
                    <rect width="100" height="100" fill="white" />
                    <!-- Simple QR-like pattern -->
                    <rect x="10" y="10" width="20" height="20" fill="black" />
                    <rect x="70" y="10" width="20" height="20" fill="black" />
                    <rect x="10" y="70" width="20" height="20" fill="black" />
                    <rect x="15" y="15" width="10" height="10" fill="white" />
                    <rect x="75" y="15" width="10" height="10" fill="white" />
                    <rect x="15" y="75" width="10" height="10" fill="white" />
                    <rect x="40" y="20" width="5" height="5" fill="black" />
                    <rect x="50" y="20" width="5" height="5" fill="black" />
                    <rect x="40" y="40" width="5" height="5" fill="black" />
                    <rect x="60" y="40" width="5" height="5" fill="black" />
                    <rect x="50" y="50" width="5" height="5" fill="black" />
                    <rect x="40" y="60" width="5" height="5" fill="black" />
                    <rect x="60" y="60" width="5" height="5" fill="black" />
                </svg>
            </div>
            <div class="footer-text" style="margin-top: 5px;">{{ $order->order_number }}</div>
        </div>

        <div style="margin-top: 10px;"></div>
    </div>

    <script>
        // Auto-print when loaded
        window.onload = function () {
            setTimeout(function () {
                window.print();
            }, 250);
        };
    </script>
</body>

</html>