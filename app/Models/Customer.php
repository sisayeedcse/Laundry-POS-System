<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'customer_order_number',
        'address',
        'total_orders',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'total_orders' => 'integer',
        ];
    }

    /**
     * Get all orders for this customer
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get total due amount across all orders
     */
    public function getTotalDueAttribute(): float
    {
        return (float) $this->orders()
            ->whereIn('payment_status', ['pending', 'partial'])
            ->get()
            ->sum(fn($order) => $order->due_balance);
    }

    /**
     * Check if customer is a regular customer (>5 orders)
     */
    public function getIsRegularAttribute(): bool
    {
        return $this->total_orders >= 5;
    }

    /**
     * Get order history with latest first
     */
    public function getOrderHistory()
    {
        return $this->orders()->latest()->get();
    }

    /**
     * Increment total orders count
     */
    public function incrementOrders(): void
    {
        $this->increment('total_orders');
    }

    /**
     * Scope to get only active customers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get regular customers
     */
    public function scopeRegular($query)
    {
        return $query->where('total_orders', '>=', 5);
    }
}
