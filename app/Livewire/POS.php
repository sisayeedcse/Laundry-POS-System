<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;

class POS extends Component
{
    // Form fields
    public string $customerPhone = '';
    public ?int $selectedCustomerId = null;
    public array $items = []; // Multiple items array
    public ?int $selectedServiceId = null;
    public string $customOrderId = '';
    public int $quantity = 1;
    public float $price = 0;
    public string $serviceType = 'wash_iron';
    public ?string $deliveryDate = null;
    public string $notes = '';
    
    // No customer modal needed
    public bool $showCustomerModal = false;
    public string $customerName = '';
    public string $customerAddress = '';

    /**
     * Mount component with default delivery date (tomorrow)
     */
    public function mount(): void
    {
        $this->deliveryDate = now()->addDay()->format('Y-m-d');
    }
    
    /**
     * Search or auto-create customer by phone number
     */
    public function searchCustomer(): void
    {
        if (empty($this->customerPhone)) {
            $this->selectedCustomerId = null;
            return;
        }
        
        $customer = Customer::where('phone', $this->customerPhone)->first();
        
        if (!$customer) {
            // Auto-create customer with just phone number
            $customer = Customer::create([
                'name' => 'Customer-' . $this->customerPhone,
                'phone' => $this->customerPhone,
                'address' => null,
            ]);
            
            session()->flash('info', 'New customer created automatically with phone: ' . $this->customerPhone);
        }
        
        $this->selectedCustomerId = $customer->id;
    }

    /**
     * Get all active services
     */
    #[Computed]
    public function services()
    {
        return Service::active()->orderBy('category')->orderBy('name')->get();
    }
    
    /**
     * Update price when service is selected
     */
    public function updatedSelectedServiceId($value): void
    {
        if ($value) {
            $service = Service::find($value);
            if ($service) {
                $this->price = $this->serviceType === 'iron_only'
                    ? (float) $service->price_iron_only
                    : (float) $service->price_wash_iron;
            }
        }
    }
    
    /**
     * Update price when service type changes
     */
    public function updatedServiceType(): void
    {
        if ($this->selectedServiceId) {
            $service = Service::find($this->selectedServiceId);
            if ($service) {
                $this->price = $this->serviceType === 'iron_only'
                    ? (float) $service->price_iron_only
                    : (float) $service->price_wash_iron;
            }
        }
    }

    /**
     * Get selected customer
     */
    #[Computed]
    public function selectedCustomer()
    {
        return $this->selectedCustomerId 
            ? Customer::find($this->selectedCustomerId) 
            : null;
    }

    /**
     * Add service to cart
     */
    public function addToCart(int $serviceId, string $serviceType = 'wash_iron'): void
    {
        $service = Service::find($serviceId);
        
        if (!$service) {
            return;
        }

        $cartKey = $serviceId . '_' . $serviceType;

        if (isset($this->cart[$cartKey])) {
            $this->cart[$cartKey]['quantity']++;
        } else {
            $price = $serviceType === 'iron_only' 
                ? (float) $service->price_iron_only 
                : (float) $service->price_wash_iron;

            $this->cart[$cartKey] = [
                'service_id' => $serviceId,
                'service_name' => $service->name,
                'service_type' => $serviceType,
                'quantity' => 1,
                'unit_price' => $price,
                'subtotal' => $price,
            ];
        }

        $this->calculateCartSubtotals();
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(string $cartKey, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->removeFromCart($cartKey);
            return;
        }

        if (isset($this->cart[$cartKey])) {
            $this->cart[$cartKey]['quantity'] = $quantity;
            $this->calculateCartSubtotals();
        }
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(string $cartKey): void
    {
        unset($this->cart[$cartKey]);
        $this->calculateCartSubtotals();
    }

    /**
     * Add item to list
     */
    public function addItem(): void
    {
        // Validate item
        $this->validate([
            'selectedServiceId' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $service = Service::find($this->selectedServiceId);
        
        $this->items[] = [
            'service_id' => $this->selectedServiceId,
            'service_name' => $service->name,
            'service_type' => $this->serviceType,
            'quantity' => $this->quantity,
            'unit_price' => $this->price,
            'subtotal' => $this->price * $this->quantity,
        ];

        // Reset item fields
        $this->selectedServiceId = null;
        $this->quantity = 1;
        $this->price = 0;
        $this->serviceType = 'wash_iron';
    }

    /**
     * Remove item from list
     */
    public function removeItem(int $index): void
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // Re-index array
    }

    /**
     * Get total amount for all items
     */
    public function getTotalAmountProperty(): float
    {
        return array_sum(array_column($this->items, 'subtotal'));
    }

    /**
     * Create new order (Entry button)
     */
    public function createOrder(): void
    {
        // Validation
        $this->validate([
            'customerPhone' => 'required|string',
            'customOrderId' => 'nullable|string|max:50|unique:orders,order_number',
            'deliveryDate' => 'required|date|after_or_equal:today',
        ]);

        if (empty($this->items)) {
            session()->flash('error', 'Please add at least one service item!');
            return;
        }

        // Ensure customer exists
        if (!$this->selectedCustomerId) {
            $this->searchCustomer();
            if (!$this->selectedCustomerId) {
                session()->flash('error', 'Failed to create/find customer!');
                return;
            }
        }

        // Calculate total
        $totalAmount = $this->totalAmount;

        // Create order
        $order = Order::create([
            'customer_id' => $this->selectedCustomerId,
            'order_number' => !empty($this->customOrderId) ? $this->customOrderId : Order::generateOrderNumber(),
            'total_amount' => $totalAmount,
            'discount' => 0,
            'tax' => 0,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => null,
            'delivery_date' => $this->deliveryDate,
            'notes' => $this->notes,
        ]);

        // Create order items
        foreach ($this->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'service_id' => $item['service_id'],
                'quantity' => $item['quantity'],
                'service_type' => $item['service_type'],
                'unit_price' => $item['unit_price'],
                'subtotal' => $item['subtotal'],
            ]);
        }

        // Update customer total orders
        $order->customer->increment('total_orders');

        session()->flash('success', 'Order #' . $order->order_number . ' created successfully! Status: Pending');

        // Reset form
        $this->resetForm();
    }

    /**
     * Calculate subtotals for all cart items
     */
    private function calculateCartSubtotals(): void
    {
        foreach ($this->cart as $key => $item) {
            $this->cart[$key]['subtotal'] = $item['quantity'] * $item['unit_price'];
        }
    }

    /**
     * Get cart subtotal
     */
    public function getSubtotalProperty(): float
    {
        return array_sum(array_column($this->cart, 'subtotal'));
    }

    /**
     * Get cart total
     */
    public function getTotalProperty(): float
    {
        return max(0, $this->subtotal - $this->discount + $this->tax);
    }

    /**
     * Select customer
     */
    public function selectCustomer(?int $customerId): void
    {
        if ($customerId === null) {
            $this->selectedCustomerId = null;
            $this->showCustomerModal = true;
        } else {
            $this->selectedCustomerId = $customerId;
            $this->showCustomerModal = false;
        }
        $this->resetCustomerFields();
    }

    /**
     * Create new customer
     */
    public function createCustomer(): void
    {
        $this->validate([
            'customerName' => 'required|string|max:255',
            'customerPhone' => 'required|string|max:20',
            'customerAddress' => 'nullable|string',
        ]);

        $customer = Customer::create([
            'name' => $this->customerName,
            'phone' => $this->customerPhone,
            'address' => $this->customerAddress,
        ]);

        $this->selectedCustomerId = $customer->id;
        $this->closeCustomerModal();
        session()->flash('success', 'Customer created successfully!');
    }

    /**
     * Open customer modal
     */
    public function openCustomerModal(): void
    {
        $this->showCustomerModal = true;
        $this->resetCustomerFields();
    }

    /**
     * Close customer modal
     */
    public function closeCustomerModal(): void
    {
        $this->showCustomerModal = false;
        $this->resetCustomerFields();
    }

    /**
     * Reset customer fields
     */
    private function resetCustomerFields(): void
    {
        $this->customerName = '';
        $this->customerAddress = '';
    }

    /**
     * Reset form after successful order creation
     */
    private function resetForm(): void
    {
        $this->customerPhone = '';
        $this->selectedCustomerId = null;
        $this->selectedServiceId = null;
        $this->customOrderId = '';
        $this->items = [];
        $this->quantity = 1;
        $this->price = 0;
        $this->serviceType = 'wash_iron';
        $this->notes = '';
        $this->deliveryDate = now()->addDay()->format('Y-m-d');
    }

    #[Layout('components.layouts.app', ['title' => 'POS - Point of Sale'])]
    public function render()
    {
        return view('livewire.p-o-s');
    }
}
