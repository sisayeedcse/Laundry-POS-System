<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'service_id',
        'quantity',
        'service_type',
        'unit_price',
        'subtotal',
        'color',
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
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    /**
     * Get the order that owns the item
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the service for this item
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Calculate subtotal based on quantity and unit price
     */
    public function calculateSubtotal(): float
    {
        return (float) $this->quantity * (float) $this->unit_price;
    }

    /**
     * Set unit price based on service and service type
     */
    public function setUnitPriceFromService(Service $service, string $serviceType): void
    {
        $this->unit_price = $serviceType === 'urgent' 
            ? $service->price_urgent 
            : $service->price_normal;
    }

    /**
     * Boot method to auto-calculate subtotal
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($orderItem) {
            if ($orderItem->quantity && $orderItem->unit_price) {
                $orderItem->subtotal = $orderItem->calculateSubtotal();
            }
        });
    }
}
