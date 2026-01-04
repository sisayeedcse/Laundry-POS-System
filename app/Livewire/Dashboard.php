<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Payment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

class Dashboard extends Component
{
    public string $dateRange = 'this_month';
    public ?string $startDate = null;
    public ?string $endDate = null;

    /**
     * Mount component
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
        Cache::forget('dashboard_stats_' . $this->dateRange);
    }

    /**
     * Set start and end dates based on range
     */
    private function setDateRange(): void
    {
        match($this->dateRange) {
            'today' => [
                $this->startDate = Carbon::now()->startOfDay()->format('Y-m-d H:i:s'),
                $this->endDate = Carbon::now()->endOfDay()->format('Y-m-d H:i:s'),
            ],
            'this_week' => [
                $this->startDate = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'),
                $this->endDate = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s'),
            ],
            'this_month' => [
                $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s'),
                $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s'),
            ],
            'last_month' => [
                $this->startDate = Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d H:i:s'),
                $this->endDate = Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d H:i:s'),
            ],
            default => [
                $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s'),
                $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s'),
            ],
        };
    }

    /**
     * Get order statistics
     */
    #[Computed]
    public function orderStats()
    {
        return [
            'pending' => Order::whereBetween('created_at', [$this->startDate, $this->endDate])
                ->where('status', 'pending')->count(),
            'processing' => Order::whereBetween('created_at', [$this->startDate, $this->endDate])
                ->where('status', 'processing')->count(),
            'ready' => Order::whereBetween('created_at', [$this->startDate, $this->endDate])
                ->where('status', 'ready')->count(),
            'delivered' => Order::whereBetween('created_at', [$this->startDate, $this->endDate])
                ->where('status', 'delivered')->count(),
            'total' => Order::whereBetween('created_at', [$this->startDate, $this->endDate])->count(),
        ];
    }

    /**
     * Get financial statistics
     */
    #[Computed]
    public function financialStats()
    {
        $orders = Order::whereBetween('created_at', [$this->startDate, $this->endDate])->get();
        
        $totalRevenue = $orders->sum('total_amount');
        $paidRevenue = $orders->where('payment_status', 'paid')->sum('total_amount');
        $profit = $paidRevenue;
        $averageOrderValue = $orders->count() > 0 ? $orders->avg('total_amount') : 0;
        
        return [
            'total_revenue' => $totalRevenue,
            'paid_revenue' => $paidRevenue,
            'total_expenses' => 0,
            'gross_profit' => $profit,
            'profit_margin' => $paidRevenue > 0 ? round(($profit / $paidRevenue) * 100, 2) : 0,
            'average_order_value' => $averageOrderValue,
        ];
    }

    /**
     * Get daily revenue and expenses for chart
     */
    #[Computed]
    public function dailyFinancials()
    {
        $dailyRevenue = Order::whereBetween('created_at', [$this->startDate, $this->endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $dates = collect($dailyRevenue->keys()->unique()->sort()->values());
        
        return $dates->map(function($date) use ($dailyRevenue) {
            return [
                'date' => $date,
                'revenue' => $dailyRevenue->get($date)?->revenue ?? 0,
                'expenses' => 0,
                'profit' => $dailyRevenue->get($date)?->revenue ?? 0,
            ];
        });
    }

    /**
     * Get today's deliveries
     */
    #[Computed]
    public function todayDeliveries()
    {
        return Order::with('customer')
            ->whereDate('delivery_date', today())
            ->latest()
            ->limit(5)
            ->get();
    }

    /**
     * Get quick stats
     */
    #[Computed]
    public function quickStats()
    {
        return Cache::remember('dashboard_quick_stats', 300, function() {
            return [
                'total_customers' => Customer::count(),
                'active_customers' => Customer::where('is_active', true)->count(),
                'total_services' => Service::count(),
                'active_services' => Service::where('is_active', true)->count(),
            ];
        });
    }

    /**
     * Get recent orders
     */
    #[Computed]
    public function recentOrders()
    {
        return Order::with('customer')
            ->latest()
            ->limit(5)
            ->get();
    }

    /**
     * Refresh dashboard data
     */
    public function refresh(): void
    {
        Cache::forget('dashboard_order_stats_' . $this->dateRange);
        Cache::forget('dashboard_quick_stats');
        $this->dispatch('dashboard-refreshed');
    }

    #[Layout('components.layouts.app', ['title' => 'Dashboard'])]
    public function render()
    {
        return view('livewire.dashboard');
    }
}
