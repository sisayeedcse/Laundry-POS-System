<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Payment;
use App\Models\Expense;
use App\Models\InventoryItem;
use App\Models\InventoryTransaction;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

class Reports extends Component
{
    public string $activeTab = 'sales';
    public string $dateRange = 'this_month';
    public ?string $startDate = null;
    public ?string $endDate = null;

    /**
     * Mount component with default dates
     */
    public function mount(): void
    {
        $this->setDateRange();
    }

    /**
     * Update date range when filter changes
     */
    public function updatedDateRange(): void
    {
        $this->setDateRange();
    }

    /**
     * Set start and end dates based on range
     */
    private function setDateRange(): void
    {
        $now = Carbon::now();
        
        match($this->dateRange) {
            'today' => [
                $this->startDate = $now->startOfDay()->format('Y-m-d'),
                $this->endDate = $now->endOfDay()->format('Y-m-d'),
            ],
            'yesterday' => [
                $this->startDate = $now->subDay()->startOfDay()->format('Y-m-d'),
                $this->endDate = $now->endOfDay()->format('Y-m-d'),
            ],
            'this_week' => [
                $this->startDate = $now->startOfWeek()->format('Y-m-d'),
                $this->endDate = $now->endOfWeek()->format('Y-m-d'),
            ],
            'last_week' => [
                $this->startDate = $now->subWeek()->startOfWeek()->format('Y-m-d'),
                $this->endDate = $now->endOfWeek()->format('Y-m-d'),
            ],
            'this_month' => [
                $this->startDate = $now->startOfMonth()->format('Y-m-d'),
                $this->endDate = $now->endOfMonth()->format('Y-m-d'),
            ],
            'last_month' => [
                $this->startDate = $now->subMonth()->startOfMonth()->format('Y-m-d'),
                $this->endDate = $now->endOfMonth()->format('Y-m-d'),
            ],
            'this_year' => [
                $this->startDate = $now->startOfYear()->format('Y-m-d'),
                $this->endDate = $now->endOfYear()->format('Y-m-d'),
            ],
            default => [
                $this->startDate = $now->startOfMonth()->format('Y-m-d'),
                $this->endDate = $now->endOfMonth()->format('Y-m-d'),
            ],
        };
    }

    /**
     * Get sales statistics
     */
    #[Computed]
    public function salesStats()
    {
        $orders = Order::whereBetween('created_at', [$this->startDate, $this->endDate])->get();
        
        return [
            'total_orders' => $orders->count(),
            'total_revenue' => $orders->sum('total_amount'),
            'paid_amount' => $orders->where('payment_status', 'paid')->sum('total_amount'),
            'total_items' => $orders->sum(function($order) { return $order->items->sum('quantity'); }),
            'average_order_value' => $orders->count() > 0 ? $orders->avg('total_amount') : 0,
            'completed_orders' => $orders->where('status', 'delivered')->count(),
            'pending_orders' => $orders->where('status', 'pending')->count(),
            'processing_orders' => $orders->where('status', 'processing')->count(),
        ];
    }

    /**
     * Get daily sales for chart
     */
    #[Computed]
    public function dailySales()
    {
        return Order::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get payment method breakdown
     */
    #[Computed]
    public function paymentMethods()
    {
        return Order::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->whereNotNull('payment_method')
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('payment_method')
            ->get();
    }

    /**
     * Get service performance
     */
    #[Computed]
    public function servicePerformance()
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('services', 'order_items.service_id', '=', 'services.id')
            ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
            ->select(
                'services.name',
                'services.category',
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('SUM(order_items.subtotal) as total_revenue'),
                DB::raw('COUNT(DISTINCT orders.id) as order_count')
            )
            ->groupBy('services.id', 'services.name', 'services.category')
            ->orderBy('total_revenue', 'desc')
            ->get();
    }

    /**
     * Get top customers
     */
    #[Computed]
    public function topCustomers()
    {
        return Customer::withCount(['orders' => function($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            }])
            ->withSum(['orders' => function($query) {
                $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            }], 'total_amount')
            ->having('orders_count', '>', 0)
            ->orderBy('orders_sum_total_amount', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get customer statistics
     */
    #[Computed]
    public function customerStats()
    {
        $newCustomers = Customer::whereBetween('created_at', [$this->startDate, $this->endDate])->count();
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::whereHas('orders', function($query) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        })->count();

        return [
            'new_customers' => $newCustomers,
            'total_customers' => $totalCustomers,
            'active_customers' => $activeCustomers,
            'retention_rate' => $totalCustomers > 0 ? round(($activeCustomers / $totalCustomers) * 100, 2) : 0,
        ];
    }

    /**
     * Get order status breakdown
     */
    #[Computed]
    public function orderStatusBreakdown()
    {
        return Order::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();
    }

    /**
     * Get expense statistics
     */
    #[Computed]
    public function expenseStats()
    {
        $expenses = Expense::whereBetween('expense_date', [$this->startDate, $this->endDate])->get();
        
        return [
            'total_expenses' => $expenses->sum('amount'),
            'expense_count' => $expenses->count(),
            'average_expense' => $expenses->count() > 0 ? $expenses->avg('amount') : 0,
            'largest_expense' => $expenses->max('amount') ?? 0,
        ];
    }

    /**
     * Get expense breakdown by category
     */
    #[Computed]
    public function expenseByCategory()
    {
        return Expense::whereBetween('expense_date', [$this->startDate, $this->endDate])
            ->select('category', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->get();
    }

    /**
     * Get daily expense trends
     */
    #[Computed]
    public function dailyExpenses()
    {
        return Expense::whereBetween('expense_date', [$this->startDate, $this->endDate])
            ->select(
                DB::raw('DATE(expense_date) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get profit/loss analysis
     */
    #[Computed]
    public function profitLossAnalysis()
    {
        $salesStats = $this->salesStats;
        $expenseStats = $this->expenseStats;
        
        $revenue = $salesStats['paid_amount'];
        $expenses = $expenseStats['total_expenses'];
        $grossProfit = $revenue - $expenses;
        $profitMargin = $revenue > 0 ? round(($grossProfit / $revenue) * 100, 2) : 0;
        
        return [
            'total_revenue' => $revenue,
            'total_expenses' => $expenses,
            'gross_profit' => $grossProfit,
            'profit_margin' => $profitMargin,
            'net_income' => $grossProfit,
            'expense_ratio' => $revenue > 0 ? round(($expenses / $revenue) * 100, 2) : 0,
        ];
    }

    /**
     * Get monthly comparison
     */
    #[Computed]
    public function monthlyComparison()
    {
        $currentMonth = Carbon::parse($this->startDate);
        $previousMonth = $currentMonth->copy()->subMonth();
        
        // Current month data
        $currentRevenue = Order::whereBetween('created_at', [
            $currentMonth->startOfMonth()->format('Y-m-d'),
            $currentMonth->endOfMonth()->format('Y-m-d')
        ])->where('payment_status', 'paid')->sum('total_amount');
        
        $currentExpenses = Expense::whereBetween('expense_date', [
            $currentMonth->startOfMonth()->format('Y-m-d'),
            $currentMonth->endOfMonth()->format('Y-m-d')
        ])->sum('amount');
        
        // Previous month data
        $previousRevenue = Order::whereBetween('created_at', [
            $previousMonth->startOfMonth()->format('Y-m-d'),
            $previousMonth->endOfMonth()->format('Y-m-d')
        ])->where('payment_status', 'paid')->sum('total_amount');
        
        $previousExpenses = Expense::whereBetween('expense_date', [
            $previousMonth->startOfMonth()->format('Y-m-d'),
            $previousMonth->endOfMonth()->format('Y-m-d')
        ])->sum('amount');
        
        $revenueChange = $previousRevenue > 0 
            ? round((($currentRevenue - $previousRevenue) / $previousRevenue) * 100, 2)
            : 0;
            
        $expenseChange = $previousExpenses > 0 
            ? round((($currentExpenses - $previousExpenses) / $previousExpenses) * 100, 2)
            : 0;
        
        return [
            'current_revenue' => $currentRevenue,
            'previous_revenue' => $previousRevenue,
            'revenue_change' => $revenueChange,
            'current_expenses' => $currentExpenses,
            'previous_expenses' => $previousExpenses,
            'expense_change' => $expenseChange,
            'current_profit' => $currentRevenue - $currentExpenses,
            'previous_profit' => $previousRevenue - $previousExpenses,
        ];
    }

    /**
     * Get top expenses
     */
    #[Computed]
    public function topExpenses()
    {
        return Expense::whereBetween('expense_date', [$this->startDate, $this->endDate])
            ->orderBy('amount', 'desc')
            ->limit(10)
            ->get();
    }

    /**     * Get inventory statistics
     */
    #[Computed]
    public function inventoryStats()
    {
        $totalItems = InventoryItem::count();
        $activeItems = InventoryItem::where('is_active', true)->count();
        $lowStockItems = InventoryItem::whereColumn('current_stock', '<=', 'min_stock')->count();
        $totalValue = InventoryItem::selectRaw('SUM(current_stock * unit_cost) as total')->value('total') ?? 0;
        
        return [
            'total_items' => $totalItems,
            'active_items' => $activeItems,
            'low_stock_items' => $lowStockItems,
            'inactive_items' => $totalItems - $activeItems,
            'total_value' => (float) $totalValue,
        ];
    }

    /**
     * Get inventory by category
     */
    #[Computed]
    public function inventoryByCategory()
    {
        return InventoryItem::select('category', 
            DB::raw('COUNT(*) as item_count'),
            DB::raw('SUM(current_stock) as total_stock'),
            DB::raw('SUM(current_stock * unit_cost) as category_value')
        )
        ->where('is_active', true)
        ->groupBy('category')
        ->get();
    }

    /**
     * Get low stock items
     */
    #[Computed]
    public function lowStockItems()
    {
        return InventoryItem::whereColumn('current_stock', '<=', 'min_stock')
            ->where('is_active', true)
            ->orderBy('current_stock', 'asc')
            ->get();
    }

    /**
     * Get recent inventory transactions
     */
    #[Computed]
    public function recentTransactions()
    {
        return InventoryTransaction::with(['inventoryItem', 'user'])
            ->whereBetween('transaction_date', [$this->startDate, $this->endDate])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();
    }

    /**     * Export sales report to PDF
     */
    public function exportPDF(): mixed
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.sales-pdf', [
            'salesStats' => $this->salesStats,
            'dailySales' => $this->dailySales,
            'paymentMethods' => $this->paymentMethods,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'sales-report-' . $this->startDate . '-to-' . $this->endDate . '.pdf');
    }

    /**
     * Export expense report to PDF
     */
    public function exportExpensePDF(): mixed
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.expense-pdf', [
            'expenseStats' => $this->expenseStats,
            'expenseByCategory' => $this->expenseByCategory,
            'topExpenses' => $this->topExpenses,
            'profitLossAnalysis' => $this->profitLossAnalysis,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'expense-report-' . $this->startDate . '-to-' . $this->endDate . '.pdf');
    }

    /**
     * Export profit/loss report to PDF
     */
    public function exportProfitLossPDF(): mixed
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.profit-loss-pdf', [
            'profitLossAnalysis' => $this->profitLossAnalysis,
            'salesStats' => $this->salesStats,
            'expenseStats' => $this->expenseStats,
            'expenseByCategory' => $this->expenseByCategory,
            'monthlyComparison' => $this->monthlyComparison,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'profit-loss-report-' . $this->startDate . '-to-' . $this->endDate . '.pdf');
    }

    /**
     * Switch active tab
     */
    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    #[Layout('components.layouts.app', ['title' => 'Reports & Analytics'])]
    public function render()
    {
        return view('livewire.reports');
    }
}
