<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Profit & Loss Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #7c3aed;
        }

        .header h1 {
            color: #7c3aed;
            margin: 0 0 10px 0;
            font-size: 28px;
        }

        .report-info {
            background: #f3f4f6;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .report-info table {
            width: 100%;
        }

        .report-info td {
            padding: 5px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #7c3aed;
            margin: 30px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #e5e7eb;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.data-table th {
            background: #7c3aed;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }

        table.data-table td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        table.data-table tr:nth-child(even) {
            background: #f9fafb;
        }

        .text-right {
            text-align: right;
        }

        .profit-positive {
            color: #10b981;
            font-weight: bold;
        }

        .profit-negative {
            color: #ef4444;
            font-weight: bold;
        }

        .highlight-row {
            background: #f3f4f6 !important;
            font-weight: bold;
            font-size: 14px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
        }

        .comparison-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .comparison-box h3 {
            margin: 0 0 10px 0;
            color: #7c3aed;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Profit & Loss Statement</h1>
        <p>Financial Performance Report</p>
    </div>

    <div class="report-info">
        <table>
            <tr>
                <td><strong>Report Period:</strong></td>
                <td>{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} -
                    {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</td>
                <td><strong>Generated:</strong></td>
                <td>{{ now()->format('M d, Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">Income Statement</div>
    <table class="data-table">
        <tr>
            <th>Account</th>
            <th class="text-right">Amount (QAR)</th>
        </tr>
        <tr class="highlight-row">
            <td><strong>REVENUE</strong></td>
            <td class="text-right"></td>
        </tr>
        <tr>
            <td style="padding-left: 20px;">Total Sales (Paid)</td>
            <td class="text-right">{{ number_format($profitLossAnalysis['total_revenue'], 2) }}</td>
        </tr>
        <tr>
            <td style="padding-left: 20px;">Total Orders</td>
            <td class="text-right">{{ $salesStats['total_orders'] }}</td>
        </tr>
        <tr class="highlight-row">
            <td><strong>TOTAL REVENUE</strong></td>
            <td class="text-right"><strong>{{ number_format($profitLossAnalysis['total_revenue'], 2) }}</strong></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 20px;"></td>
        </tr>
        <tr class="highlight-row">
            <td><strong>EXPENSES</strong></td>
            <td class="text-right"></td>
        </tr>
        @foreach($expenseByCategory as $category)
            <tr>
                <td style="padding-left: 20px;">{{ ucfirst($category->category) }}</td>
                <td class="text-right">{{ number_format($category->total, 2) }}</td>
            </tr>
        @endforeach
        <tr class="highlight-row">
            <td><strong>TOTAL EXPENSES</strong></td>
            <td class="text-right"><strong>{{ number_format($profitLossAnalysis['total_expenses'], 2) }}</strong></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 20px;"></td>
        </tr>
        <tr style="background: #7c3aed; color: white; font-size: 16px;">
            <td><strong>NET INCOME (PROFIT/LOSS)</strong></td>
            <td class="text-right">
                <strong>{{ number_format($profitLossAnalysis['gross_profit'], 2) }}</strong>
            </td>
        </tr>
    </table>

    <div class="section-title">Performance Metrics</div>
    <table class="data-table">
        <tr>
            <th>Metric</th>
            <th class="text-right">Value</th>
        </tr>
        <tr>
            <td>Profit Margin</td>
            <td
                class="text-right {{ $profitLossAnalysis['profit_margin'] >= 0 ? 'profit-positive' : 'profit-negative' }}">
                {{ $profitLossAnalysis['profit_margin'] }}%
            </td>
        </tr>
        <tr>
            <td>Expense Ratio</td>
            <td class="text-right">{{ $profitLossAnalysis['expense_ratio'] }}%</td>
        </tr>
        <tr>
            <td>Average Order Value</td>
            <td class="text-right">{{ number_format($salesStats['average_order_value'], 2) }} QAR</td>
        </tr>
        <tr>
            <td>Average Expense</td>
            <td class="text-right">{{ number_format($expenseStats['average_expense'], 2) }} QAR</td>
        </tr>
    </table>

    <div class="comparison-box">
        <h3>Month-over-Month Comparison</h3>
        <table class="data-table">
            <tr>
                <th>Metric</th>
                <th class="text-right">Current Period</th>
                <th class="text-right">Previous Period</th>
                <th class="text-right">Change</th>
            </tr>
            <tr>
                <td>Revenue</td>
                <td class="text-right">{{ number_format($monthlyComparison['current_revenue'], 2) }}</td>
                <td class="text-right">{{ number_format($monthlyComparison['previous_revenue'], 2) }}</td>
                <td
                    class="text-right {{ $monthlyComparison['revenue_change'] >= 0 ? 'profit-positive' : 'profit-negative' }}">
                    {{ $monthlyComparison['revenue_change'] >= 0 ? '+' : '' }}{{ $monthlyComparison['revenue_change'] }}%
                </td>
            </tr>
            <tr>
                <td>Expenses</td>
                <td class="text-right">{{ number_format($monthlyComparison['current_expenses'], 2) }}</td>
                <td class="text-right">{{ number_format($monthlyComparison['previous_expenses'], 2) }}</td>
                <td
                    class="text-right {{ $monthlyComparison['expense_change'] <= 0 ? 'profit-positive' : 'profit-negative' }}">
                    {{ $monthlyComparison['expense_change'] >= 0 ? '+' : '' }}{{ $monthlyComparison['expense_change'] }}%
                </td>
            </tr>
            <tr class="highlight-row">
                <td>Profit</td>
                <td class="text-right">{{ number_format($monthlyComparison['current_profit'], 2) }}</td>
                <td class="text-right">{{ number_format($monthlyComparison['previous_profit'], 2) }}</td>
                <td
                    class="text-right {{ ($monthlyComparison['current_profit'] - $monthlyComparison['previous_profit']) >= 0 ? 'profit-positive' : 'profit-negative' }}">
                    {{ number_format($monthlyComparison['current_profit'] - $monthlyComparison['previous_profit'], 2) }}
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Laundry POS - Profit & Loss Report | Generated on {{ now()->format('F d, Y \a\t H:i') }}</p>
    </div>
</body>

</html>