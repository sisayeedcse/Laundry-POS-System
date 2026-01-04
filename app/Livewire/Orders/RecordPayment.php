<?php

declare(strict_types=1);

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\Payment;
use Livewire\Component;
use Livewire\Attributes\Validate;

class RecordPayment extends Component
{
    public int $orderId;
    public Order $order;
    public bool $showModal = false;

    #[Validate('required|numeric|min:0.01')]
    public string $amount = '';

    #[Validate('required|in:cash,card')]
    public string $payment_method = 'cash';

    #[Validate('required|date')]
    public string $payment_date = '';

    #[Validate('nullable|string|max:500')]
    public string $notes = '';

    public float $remainingBalance = 0;

    /**
     * Mount component
     */
    public function mount(int $orderId): void
    {
        $this->orderId = $orderId;
        $this->order = Order::with(['payments'])->findOrFail($orderId);
        $this->payment_date = now()->format('Y-m-d');
        $this->remainingBalance = $this->order->due_balance;
        $this->showModal = true;
    }

    /**
     * Set amount to remaining balance (pay full)
     */
    public function payFull(): void
    {
        $this->amount = (string) $this->remainingBalance;
    }

    /**
     * Record the payment
     */
    public function record(): void
    {
        $this->validate();

        $amount = (float) $this->amount;

        // Validate amount doesn't exceed due balance
        if ($amount > $this->order->due_balance) {
            $this->addError('amount', 'Payment amount cannot exceed the remaining balance of QAR ' . number_format($this->order->due_balance, 2));
            return;
        }

        // Create payment record
        Payment::create([
            'order_id' => $this->orderId,
            'amount' => $amount,
            'payment_method' => $this->payment_method,
            'payment_date' => $this->payment_date,
            'notes' => $this->notes ?: null,
            'created_by' => auth()->id(),
        ]);

        // Update order payment status
        $this->order->refresh();
        $this->order->updatePaymentStatus();

        // Close modal and notify parent
        $this->showModal = false;
        $this->dispatch('payment-recorded')->to(OrderDetails::class);
    }

    /**
     * Close modal
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['amount', 'payment_method', 'notes']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.orders.record-payment');
    }
}
