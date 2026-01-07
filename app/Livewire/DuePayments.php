<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

class DuePayments extends Component
{
    // Due tab filters
    public string $dueSearch = '';
    public string $dueSortBy = 'amount_desc';
    public string $duePaymentStatus = 'all';

    #[Computed]
    public function duePayments()
    {
        $query = Customer::query()
            ->whereHas('orders', function ($q) {
                $q->whereIn('payment_status', ['pending', 'partial']);
            })
            ->with(['orders' => function ($q) {
                $q->whereIn('payment_status', ['pending', 'partial'])
                  ->orderBy('created_at', 'desc');
            }]);

        // Search filter
        if (!empty($this->dueSearch)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->dueSearch . '%')
                  ->orWhere('phone', 'like', '%' . $this->dueSearch . '%');
            });
        }

        // Payment status filter
        if ($this->duePaymentStatus !== 'all') {
            $query->whereHas('orders', function ($q) {
                $q->where('payment_status', $this->duePaymentStatus);
            });
        }

        $customers = $query->get()->map(function ($customer) {
            $totalDue = $customer->orders->sum(fn($order) => $order->due_balance);
            $customer->total_due = $totalDue;
            $customer->due_orders_count = $customer->orders->count();
            return $customer;
        })->filter(fn($customer) => $customer->total_due > 0);

        // Sorting
        return match($this->dueSortBy) {
            'amount_desc' => $customers->sortByDesc('total_due')->values(),
            'amount_asc' => $customers->sortBy('total_due')->values(),
            'name_asc' => $customers->sortBy('name')->values(),
            'name_desc' => $customers->sortByDesc('name')->values(),
            'orders_desc' => $customers->sortByDesc('due_orders_count')->values(),
            default => $customers->sortByDesc('total_due')->values(),
        };
    }

    #[Computed]
    public function dueStats()
    {
        $allDueOrders = Order::whereIn('payment_status', ['pending', 'partial'])->get();
        
        return [
            'total_due' => $allDueOrders->sum(fn($order) => $order->due_balance),
            'total_customers' => $allDueOrders->pluck('customer_id')->unique()->count(),
            'total_orders' => $allDueOrders->count(),
            'pending_orders' => $allDueOrders->where('payment_status', 'pending')->count(),
            'partial_orders' => $allDueOrders->where('payment_status', 'partial')->count(),
        ];
    }

    #[Layout('components.layouts.app', ['title' => 'Due Payments'])]
    public function render()
    {
        return view('livewire.due-payments');
    }
}
