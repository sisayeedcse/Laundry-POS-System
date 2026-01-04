<?php

declare(strict_types=1);

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;

class OrderDetails extends Component
{
    public int $orderId;
    public bool $showModal = false;
    public bool $showPaymentModal = false;

    /**
     * Mount component
     */
    public function mount(int $orderId): void
    {
        $this->orderId = $orderId;
        $this->showModal = true;
    }

    /**
     * Get order with all relationships
     */
    #[Computed]
    public function order()
    {
        return Order::with([
            'customer',
            'orderItems.service',
            'payments.creator'
        ])->findOrFail($this->orderId);
    }

    /**
     * Update order status
     */
    public function updateStatus(string $status): void
    {
        $validStatuses = ['pending', 'processing', 'ready', 'delivered'];
        
        if (!in_array($status, $validStatuses)) {
            session()->flash('error', 'Invalid status!');
            return;
        }

        $order = Order::findOrFail($this->orderId);
        $order->update(['status' => $status]);

        // When order is delivered, mark payment as completed
        if ($status === 'delivered' && $order->payment_status !== 'paid') {
            $order->update(['payment_status' => 'paid']);
            session()->flash('success', 'Order delivered and payment marked as completed!');
        } else {
            session()->flash('success', 'Order status updated to ' . ucfirst($status) . '!');
        }
        
        // Refresh the computed property
        unset($this->order);
    }

    /**
     * Get status badge color
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
     * Get payment status badge color
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
     * Get next status in workflow
     */
    public function getNextStatus(string $currentStatus): ?string
    {
        $workflow = [
            'pending' => 'processing',
            'processing' => 'ready',
            'ready' => 'delivered',
            'delivered' => null,
        ];

        return $workflow[$currentStatus] ?? null;
    }

    /**
     * Open modal
     */
    public function openModal(): void
    {
        $this->showModal = true;
    }

    /**
     * Open payment modal
     */
    public function openPaymentModal(): void
    {
        $this->showPaymentModal = true;
    }

    /**
     * Payment recorded event handler
     */
    #[On('payment-recorded')]
    public function paymentRecorded(): void
    {
        $this->showPaymentModal = false;
        session()->flash('success', 'Payment recorded successfully!');
        // Refresh the order data
        unset($this->order);
    }

    /**
     * Close modal
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->dispatch('order-details-closed')->to(OrderList::class);
    }

    public function render()
    {
        return view('livewire.orders.order-details');
    }
}
