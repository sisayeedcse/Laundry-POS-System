<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

class Reports extends Component
{
    public string $reportType = 'daily';
    public string $dateFrom = '';
    public string $dateTo = '';
    public string $selectedDate = '';

    public function mount(): void
    {
        $this->selectedDate = now()->format('Y-m-d');
        $this->dateFrom = now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = now()->format('Y-m-d');
    }

    #[Computed]
    public function salesData()
    {
        $query = Order::query();

        switch ($this->reportType) {
            case 'daily':
                $query->whereDate('created_at', $this->selectedDate);
                break;
            case 'weekly':
                $query->whereBetween('created_at', [
                    Carbon::parse($this->selectedDate)->startOfWeek(),
                    Carbon::parse($this->selectedDate)->endOfWeek()
                ]);
                break;
            case 'monthly':
                $query->whereMonth('created_at', Carbon::parse($this->selectedDate)->month)
                      ->whereYear('created_at', Carbon::parse($this->selectedDate)->year);
                break;
            case 'custom':
                $query->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);
                break;
        }

        return [
            'total_orders' => $query->count(),
            'total_revenue' => $query->sum('total_amount'),
            'paid_orders' => $query->where('payment_status', 'paid')->count(),
            'pending_orders' => $query->where('payment_status', 'pending')->count(),
            'delivered_orders' => $query->where('status', 'delivered')->count(),
        ];
    }

    #[Computed]
    public function paymentMethodData()
    {
        $baseQuery = Order::query()->where('payment_status', 'paid');

        switch ($this->reportType) {
            case 'daily':
                $baseQuery->whereDate('created_at', $this->selectedDate);
                break;
            case 'weekly':
                $baseQuery->whereBetween('created_at', [
                    Carbon::parse($this->selectedDate)->startOfWeek(),
                    Carbon::parse($this->selectedDate)->endOfWeek()
                ]);
                break;
            case 'monthly':
                $baseQuery->whereMonth('created_at', Carbon::parse($this->selectedDate)->month)
                      ->whereYear('created_at', Carbon::parse($this->selectedDate)->year);
                break;
            case 'custom':
                $baseQuery->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);
                break;
        }

        // Clone the query for each payment method to avoid conflicts
        $cashQuery = clone $baseQuery;
        $cardQuery = clone $baseQuery;

        return [
            'cash_amount' => $cashQuery->where('payment_method', 'cash')->sum('total_amount'),
            'cash_count' => $cashQuery->where('payment_method', 'cash')->count(),
            'card_amount' => $cardQuery->where('payment_method', 'card')->sum('total_amount'),
            'card_count' => $cardQuery->where('payment_method', 'card')->count(),
        ];
    }

    #[Computed]
    public function topServices()
    {
        $query = DB::table('order_items')
            ->join('services', 'order_items.service_id', '=', 'services.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->select('services.name', DB::raw('SUM(order_items.quantity) as total_quantity'), DB::raw('SUM(order_items.unit_price * order_items.quantity) as total_revenue'))
            ->groupBy('services.id', 'services.name');

        switch ($this->reportType) {
            case 'daily':
                $query->whereDate('orders.created_at', $this->selectedDate);
                break;
            case 'weekly':
                $query->whereBetween('orders.created_at', [
                    Carbon::parse($this->selectedDate)->startOfWeek(),
                    Carbon::parse($this->selectedDate)->endOfWeek()
                ]);
                break;
            case 'monthly':
                $query->whereMonth('orders.created_at', Carbon::parse($this->selectedDate)->month)
                      ->whereYear('orders.created_at', Carbon::parse($this->selectedDate)->year);
                break;
            case 'custom':
                $query->whereBetween('orders.created_at', [$this->dateFrom, $this->dateTo]);
                break;
        }

        return $query->orderByDesc('total_revenue')->limit(10)->get();
    }

    #[Computed]
    public function recentOrders()
    {
        $query = Order::with('customer');

        switch ($this->reportType) {
            case 'daily':
                $query->whereDate('created_at', $this->selectedDate);
                break;
            case 'weekly':
                $query->whereBetween('created_at', [
                    Carbon::parse($this->selectedDate)->startOfWeek(),
                    Carbon::parse($this->selectedDate)->endOfWeek()
                ]);
                break;
            case 'monthly':
                $query->whereMonth('created_at', Carbon::parse($this->selectedDate)->month)
                      ->whereYear('created_at', Carbon::parse($this->selectedDate)->year);
                break;
            case 'custom':
                $query->whereBetween('created_at', [$this->dateFrom, $this->dateTo]);
                break;
        }

        return $query->orderByDesc('created_at')->limit(10)->get();
    }

    public function getReportTitle(): string
    {
        return match($this->reportType) {
            'daily' => 'Daily Report - ' . Carbon::parse($this->selectedDate)->format('d M Y'),
            'weekly' => 'Weekly Report - ' . Carbon::parse($this->selectedDate)->startOfWeek()->format('d M') . ' to ' . Carbon::parse($this->selectedDate)->endOfWeek()->format('d M Y'),
            'monthly' => 'Monthly Report - ' . Carbon::parse($this->selectedDate)->format('F Y'),
            'custom' => 'Custom Report - ' . Carbon::parse($this->dateFrom)->format('d M Y') . ' to ' . Carbon::parse($this->dateTo)->format('d M Y'),
            default => 'Report',
        };
    }

    #[Layout('components.layouts.app', ['title' => 'Reports & Analytics'])]
    public function render()
    {
        return view('livewire.reports');
    }
}
