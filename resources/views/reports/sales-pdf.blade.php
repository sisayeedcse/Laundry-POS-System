<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #7c3aed;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #7c3aed;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
            font-size: 11px;
        }

        .report-info {
            background: #f9fafb;
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .report-info table {
            width: 100%;
        }

        .report-info td {
            padding: 5px;
        }

        .report-info .label {
            font-weight: bold;
            color: #4b5563;
            width: 40%;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }

        .stat-card {
            display: table-cell;
            width: 25%;
            padding: 15px;
            text-align: center;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
        }

        .stat-card:not(:last-child) {
            margin-right: 10px;
        }

        .stat-card .label {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .stat-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #7c3aed;
        }

        .stat-card .subtitle {
            font-size: 9px;
            color: #9ca3af;
            margin-top: 5px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #7c3aed;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        table.data-table th {
            background: #7c3aed;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
        }

        table.data-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        table.data-table tr:nth-child(even) {
            background: #f9fafb;
        }

        .amount {
            font-weight: bold;
            color: #059669;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            color: #9ca3af;
            font-size: 10px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
        }

        .payment-method {
            display: inline-block;
            padding: 4px 8px;
            background: #e0e7ff;
            color: #3730a3;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>Sales Report</h1>
        <p>Laundry POS System - Comprehensive Business Analytics</p>
    </div>

    <!-- Report Information -->
    <div class="report-info">
        <table>
            <tr>
                <td class="label">Report Period:</td>
                <td>{{ \Carbon\Carbon::parse($startDate)->format('F d, Y') }} to
                    {{ \Carbon\Carbon::parse($endDate)->format('F d, Y') }}
                </td>
            </tr>
            <tr>
                <td class="label">Generated On:</td>
                <td>{{ now()->format('F d, Y h:i A') }}</td>
            </tr>
            <tr>
                <td class="label">Currency:</td>
                <td>QAR (Qatari Riyal)</td>
            </tr>
        </table>
    </div>

    <!-- Sales Statistics -->
    <div class="section-title">Sales Summary</div>
    <table style="width: 100%; margin-bottom: 25px;">
        <tr>
            <td
                style="width: 25%; padding: 15px; background: #eff6ff; border: 2px solid #3b82f6; border-radius: 8px; text-align: center;">
                <div style="font-size: 10px; color: #1e40af; margin-bottom: 8px;">TOTAL ORDERS</div>
                <div style="font-size: 24px; font-weight: bold; color: #1e3a8a;">{{ $salesStats['total_orders'] }}</div>
            </td>
            <td style="width: 5%;"></td>
            <td
                style="width: 25%; padding: 15px; background: #f0fdf4; border: 2px solid #22c55e; border-radius: 8px; text-align: center;">
                <div style="font-size: 10px; color: #15803d; margin-bottom: 8px;">TOTAL REVENUE</div>
                <div style="font-size: 20px; font-weight: bold; color: #166534;">
                    {{ number_format($salesStats['total_revenue'], 2) }}
                </div>
                <div style="font-size: 9px; color: #4ade80; margin-top: 3px;">QAR</div>
            </td>
            <td style="width: 5%;"></td>
            <td
                style="width: 25%; padding: 15px; background: #faf5ff; border: 2px solid #a855f7; border-radius: 8px; text-align: center;">
                <div style="font-size: 10px; color: #7e22ce; margin-bottom: 8px;">PAID AMOUNT</div>
                <div style="font-size: 20px; font-weight: bold; color: #6b21a8;">
                    {{ number_format($salesStats['paid_amount'], 2) }}
                </div>
                <div style="font-size: 9px; color: #c084fc; margin-top: 3px;">QAR</div>
            </td>
            <td style="width: 5%;"></td>
            <td
                style="width: 25%; padding: 15px; background: #f0fdfa; border: 2px solid #14b8a6; border-radius: 8px; text-align: center;">
                <div style="font-size: 10px; color: #0f766e; margin-bottom: 8px;">TOTAL SERVICES</div>
                <div style="font-size: 20px; font-weight: bold; color: #115e59;">
                    {{ number_format($salesStats['total_items'], 0) }}
                </div>
                <div style="font-size: 9px; color: #2dd4bf; margin-top: 3px;">Items</div>
            </td>
        </tr>
    </table>

    <!-- Daily Sales Breakdown -->
    <div class="section-title">Daily Sales Breakdown</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Date</th>
                <th style="text-align: center;">Orders</th>
                <th style="text-align: right;">Revenue (QAR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dailySales as $day)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($day->date)->format('l, M d, Y') }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $day->orders }}</td>
                    <td style="text-align: right;" class="amount">{{ number_format($day->revenue, 2) }}</td>
                </tr>
            @endforeach
            <tr style="background: #f3f4f6; font-weight: bold;">
                <td>TOTAL</td>
                <td style="text-align: center;">{{ $dailySales->sum('orders') }}</td>
                <td style="text-align: right;" class="amount">{{ number_format($dailySales->sum('revenue'), 2) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Payment Methods Breakdown -->
    <div class="section-title">Payment Methods Distribution</div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Payment Method</th>
                <th style="text-align: center;">Transactions</th>
                <th style="text-align: right;">Total Amount (QAR)</th>
                <th style="text-align: right;">Percentage</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPayments = $paymentMethods->sum('total');
            @endphp
            @foreach ($paymentMethods as $method)
                <tr>
                    <td>
                        <span class="payment-method">{{ strtoupper($method->payment_method) }}</span>
                    </td>
                    <td style="text-align: center; font-weight: bold;">{{ $method->count }}</td>
                    <td style="text-align: right;" class="amount">{{ number_format($method->total, 2) }}</td>
                    <td style="text-align: right; font-weight: bold;">
                        {{ $totalPayments > 0 ? round(($method->total / $totalPayments) * 100, 1) : 0 }}%
                    </td>
                </tr>
            @endforeach
            <tr style="background: #f3f4f6; font-weight: bold;">
                <td>TOTAL</td>
                <td style="text-align: center;">{{ $paymentMethods->sum('count') }}</td>
                <td style="text-align: right;" class="amount">{{ number_format($totalPayments, 2) }}</td>
                <td style="text-align: right;">100%</td>
            </tr>
        </tbody>
    </table>

    <!-- Order Status Summary -->
    <div class="section-title">Order Status Overview</div>
    <table style="width: 100%; margin-bottom: 25px;">
        <tr>
            <td
                style="width: 30%; padding: 12px; background: #fef3c7; border-left: 4px solid #f59e0b; text-align: center;">
                <div style="font-size: 10px; color: #78350f; margin-bottom: 5px;">PENDING</div>
                <div style="font-size: 22px; font-weight: bold; color: #92400e;">{{ $salesStats['pending_orders'] }}
                </div>
            </td>
            <td style="width: 5%;"></td>
            <td
                style="width: 30%; padding: 12px; background: #dbeafe; border-left: 4px solid #3b82f6; text-align: center;">
                <div style="font-size: 10px; color: #1e40af; margin-bottom: 5px;">PROCESSING</div>
                <div style="font-size: 22px; font-weight: bold; color: #1e3a8a;">{{ $salesStats['processing_orders'] }}
                </div>
            </td>
            <td style="width: 5%;"></td>
            <td
                style="width: 30%; padding: 12px; background: #d1fae5; border-left: 4px solid #10b981; text-align: center;">
                <div style="font-size: 10px; color: #065f46; margin-bottom: 5px;">COMPLETED</div>
                <div style="font-size: 22px; font-weight: bold; color: #047857;">{{ $salesStats['completed_orders'] }}
                </div>
            </td>
        </tr>
    </table>

    <!-- Average Order Value -->
    <div style="background: #f9fafb; padding: 20px; border-radius: 8px; text-align: center; margin-top: 25px;">
        <div style="font-size: 12px; color: #6b7280; margin-bottom: 10px;">AVERAGE ORDER VALUE</div>
        <div style="font-size: 36px; font-weight: bold; color: #7c3aed;">
            {{ number_format($salesStats['average_order_value'], 2) }}
        </div>
        <div style="font-size: 14px; color: #9ca3af; margin-top: 5px;">QAR per order</div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>This report was automatically generated by Laundry POS System</p>
        <p>© {{ now()->year }} Laundry POS. All rights reserved.</p>
    </div>
</body>

</html>