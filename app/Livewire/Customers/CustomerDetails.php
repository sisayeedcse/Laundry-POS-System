<?php

declare(strict_types=1);

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;
use Livewire\Attributes\Computed;

class CustomerDetails extends Component
{
    public int $customerId;
    public bool $showModal = false;

    /**
     * Mount component
     */
    public function mount(int $customerId): void
    {
        $this->customerId = $customerId;
        $this->showModal = true;
    }

    /**
     * Get customer with all relationships
     */
    #[Computed]
    public function customer()
    {
        return Customer::with(['orders.orderItems.service', 'orders.payments'])
            ->findOrFail($this->customerId);
    }

    /**
     * Get customer statistics
     */
    #[Computed]
    public function statistics()
    {
        $customer = $this->customer;
        
        return [
            'total_orders' => $customer->orders->count(),
            'total_spent' => $customer->orders->where('payment_status', 'paid')->sum('total_amount'),
            'total_pending' => $customer->orders->whereIn('payment_status', ['pending', 'partial'])->sum('due_balance'),
            'last_order_date' => $customer->orders->sortByDesc('created_at')->first()?->created_at,
            'average_order_value' => $customer->orders->count() > 0 
                ? $customer->orders->avg('total_amount') 
                : 0,
            'completed_orders' => $customer->orders->where('status', 'delivered')->count(),
            'pending_orders' => $customer->orders->whereIn('status', ['pending', 'processing', 'ready'])->count(),
        ];
    }

    /**
     * Get order status color
     */
    public function getStatusColor(string $status): string
    {
        return match($status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'ready' => 'bg-cyan-100 text-cyan-800',
            'delivered' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get payment status color
     */
    public function getPaymentStatusColor(string $status): string
    {
        return match($status) {
            'pending' => 'bg-red-100 text-red-800',
            'partial' => 'bg-orange-100 text-orange-800',
            'paid' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Close modal
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->dispatch('customer-details-closed');
    }

    public function render()
    {
        return view('livewire.customers.customer-details');
    }
}
