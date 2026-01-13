<?php

declare(strict_types=1);

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

class OrderDetails extends Component
{
    public int $orderId;
    public bool $showModal = false;
    public bool $showPaymentModal = false;
    public string $selectedPaymentMethod = 'cash';
    public bool $editingNotes = false;
    public string $orderNotes = '';

    /**
     * Mount component
     */
    public function mount(int $orderId): void
    {
        $this->orderId = $orderId;
        $this->showModal = true;
        $this->orderNotes = $this->order->notes ?? '';
    }

    /**
     * Get order with all relationships
     */
    public function getOrderProperty()
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
        
        $updateData = ['status' => $status];
        
        // Set delivered_at timestamp when status changes to delivered
        if ($status === 'delivered' && $order->status !== 'delivered') {
            $updateData['delivered_at'] = now();
        }
        
        $order->update($updateData);

        // When order is delivered, show payment modal instead of auto-marking as paid
        if ($status === 'delivered' && $order->payment_status !== 'paid') {
            $this->showPaymentModal = true;
            session()->flash('success', 'Order delivered! Please select payment method.');
        } else {
            session()->flash('success', 'Order status updated to ' . ucfirst($status) . '!');
        }
    }

    /**
     * Complete payment with selected method
     */
    public function completePayment(): void
    {
        $order = Order::findOrFail($this->orderId);
        
        $order->update([
            'payment_status' => 'paid',
            'payment_method' => $this->selectedPaymentMethod,
        ]);

        $this->showPaymentModal = false;
        
        session()->flash('success', 'Payment completed via ' . strtoupper($this->selectedPaymentMethod) . '!');
        
        // Dispatch event to refresh other components
        $this->dispatch('order-updated');
    }

    /**
     * Toggle payment status between paid and pending
     */
    public function togglePaymentStatus(): void
    {
        $order = Order::findOrFail($this->orderId);
        
        if ($order->payment_status === 'paid') {
            // Mark as unpaid - clear payment method since payment is being reversed
            $order->update([
                'payment_status' => 'pending',
                'payment_method' => null, // Clear payment method when marking as unpaid
            ]);
            
            session()->flash('success', 'Order marked as UNPAID. Amount will appear in Due Payments and will not be counted in revenue.');
            
            // Dispatch event to refresh other components
            $this->dispatch('order-updated');
        } else {
            // Mark as paid
            $this->showPaymentModal = true;
            return;
        }
    }

    /**
     * Close payment modal
     */
    public function closePaymentModal(): void
    {
        $this->showPaymentModal = false;
    }

    /**
     * Toggle notes editing mode
     */
    public function toggleEditNotes(): void
    {
        if ($this->editingNotes) {
            // Cancel editing - reset to original
            $this->orderNotes = $this->order->notes ?? '';
            $this->editingNotes = false;
        } else {
            $this->editingNotes = true;
        }
    }

    /**
     * Save notes
     */
    public function saveNotes(): void
    {
        $order = Order::findOrFail($this->orderId);
        $order->update(['notes' => $this->orderNotes]);
        
        $this->editingNotes = false;
        session()->flash('success', 'Notes updated successfully!');
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
