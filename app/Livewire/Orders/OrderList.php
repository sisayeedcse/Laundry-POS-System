<?php

declare(strict_types=1);

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class OrderList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = 'all';
    public string $paymentFilter = 'all';
    public ?string $dateFrom = null;
    public ?string $dateTo = null;
    public ?int $selectedOrderId = null;
    public bool $showDetailsModal = false;
    public ?int $pendingOrderId = null;

    /**
     * Reset pagination when filters change
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingPaymentFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Get orders with filters
     */
    #[Computed]
    public function orders()
    {
        $query = Order::with(['customer', 'items.service']);

        // Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('phone', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Payment filter
        if ($this->paymentFilter !== 'all') {
            $query->where('payment_status', $this->paymentFilter);
        }

        // Date range
        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }
        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        return $query->latest()->paginate(20);
    }

    /**
     * View order details
     */
    public function viewOrder(int $orderId): void
    {
        $this->selectedOrderId = $orderId;
        $this->showDetailsModal = true;
    }

    /**
     * Close details modal
     */
    #[On('order-details-closed')]
    public function closeDetailsModal(): void
    {
        $this->showDetailsModal = false;
        $this->selectedOrderId = null;
    }

    /**
     * Update order status
     */
    public function updateStatus(int $orderId, string $status): void
    {
        $order = Order::find($orderId);
        
        if ($order) {
            $updateData = ['status' => $status];
            
            // Set delivered_at timestamp when status changes to delivered
            if ($status === 'delivered' && $order->status !== 'delivered') {
                $updateData['delivered_at'] = now();
            }
            
            $order->update($updateData);
            
            // When order is delivered, show inline payment selection
            if ($status === 'delivered' && $order->payment_status !== 'paid') {
                $this->pendingOrderId = $orderId;
                session()->flash('info', 'Please select payment method to complete the order.');
            } else {
                session()->flash('success', 'Order status updated successfully!');
            }
            
            // Force refresh the orders list by resetting pagination and clearing cache
            $this->resetPage();
            $this->dispatch('$refresh');
        }
    }

    /**
     * Delete order
     */
    public function deleteOrder(int $orderId): void
    {
        $order = Order::find($orderId);
        
        if ($order) {
            if ($order->status === 'delivered') {
                session()->flash('error', 'Cannot delete delivered orders!');
                return;
            }
            
            $order->items()->delete();
            $order->payments()->delete();
            $order->delete();
            
            session()->flash('success', 'Order deleted successfully!');
            $this->resetPage();
        }
    }

    /**
     * Complete payment with selected method
     */
    public function completePayment(int $orderId, string $paymentMethod): void
    {
        $order = Order::find($orderId);
        
        if ($order && $order->status === 'delivered') {
            $order->update([
                'payment_status' => 'paid',
                'payment_method' => $paymentMethod,
            ]);

            $this->pendingOrderId = null;
            session()->flash('success', 'Order delivered and payment recorded as ' . strtoupper($paymentMethod) . '!');
            $this->resetPage();
            $this->dispatch('$refresh');
        }
    }

    /**
     * Clear filters
     */
    public function clearFilters(): void
    {
        $this->search = '';
        $this->statusFilter = 'all';
        $this->paymentFilter = 'all';
        $this->dateFrom = null;
        $this->dateTo = null;
        $this->resetPage();
    }

    #[Layout('components.layouts.app', ['title' => 'Orders Management'])]
    public function render()
    {
        return view('livewire.orders.order-list');
    }
}
