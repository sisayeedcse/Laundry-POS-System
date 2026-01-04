<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'order_number',
        'total_amount',
        'discount',
        'tax',
        'advance_payment',
        'status',
        'payment_status',
        'payment_method',
        'delivery_date',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'discount' => 'decimal:2',
            'tax' => 'decimal:2',
            'advance_payment' => 'decimal:2',
            'delivery_date' => 'date',
        ];
    }

    /**
     * Get the customer that owns the order
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the order items
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Alias for orderItems (backward compatibility)
     */
    public function items(): HasMany
    {
        return $this->orderItems();
    }

    /**
     * Get the payments for this order
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Calculate total from order items
     */
    public function calculateTotal(): float
    {
        $subtotal = (float) $this->orderItems->sum('subtotal');
        $discount = (float) $this->discount;
        $tax = (float) $this->tax;
        
        return $subtotal - $discount + $tax;
    }

    /**
     * Get due balance (total - advance - paid)
     */
    public function getDueBalanceAttribute(): float
    {
        $total = (float) $this->total_amount;
        $advance = (float) $this->advance_payment;
        $paid = (float) $this->payments->sum('amount');
        
        return max(0, $total - $advance - $paid);
    }

    /**
     * Get total paid amount (advance + payments)
     */
    public function getTotalPaidAttribute(): float
    {
        return (float) $this->advance_payment + (float) $this->payments->sum('amount');
    }

    /**
     * Check if order can be delivered
     */
    public function canBeDelivered(): bool
    {
        return $this->status === 'ready' && $this->payment_status === 'paid';
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', today())->count() + 1;
        
        return sprintf('%s-%s-%04d', $prefix, $date, $count);
    }

    /**
     * Update payment status based on paid amount
     */
    public function updatePaymentStatus(): void
    {
        $dueBalance = $this->due_balance;
        
        if ($dueBalance <= 0) {
            $this->payment_status = 'paid';
        } elseif ($this->total_paid > 0) {
            $this->payment_status = 'partial';
        } else {
            $this->payment_status = 'pending';
        }
        
        $this->save();
    }

    /**
     * Scope for pending orders
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for processing orders
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    /**
     * Scope for ready orders
     */
    public function scopeReady($query)
    {
        return $query->where('status', 'ready');
    }

    /**
     * Scope for delivered orders
     */
    public function scopeDelivered($query)
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Scope for orders due today
     */
    public function scopeDueToday($query)
    {
        return $query->whereDate('delivery_date', today());
    }
}
