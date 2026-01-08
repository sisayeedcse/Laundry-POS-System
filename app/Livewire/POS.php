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
    public string $customerName = ''; // Optional customer name
    public ?int $selectedCustomerId = null;
    public array $items = []; // Multiple items array
    public ?int $selectedServiceId = null;
    public string $customOrderId = '';
    public int $quantity = 1;
    public float $price = 0;
    public string $serviceType = 'wash_iron';
    public ?string $deliveryDate = null;
    public string $notes = '';
    public float $discount = 0; // Discount amount (optional)
    
    // Payment modal
    public bool $showPaymentModal = false;
    
    // No customer modal needed
    public bool $showCustomerModal = false;
    public string $customerAddress = '';

    /**
     * Mount component with default delivery date (tomorrow)
     */
    public function mount(): void
    {
        $this->deliveryDate = now()->addDay()->format('Y-m-d');
    }
    
    /**
     * Search for existing customer by phone number (no auto-create)
     */
    public function searchCustomer(): void
    {
        if (empty($this->customerPhone)) {
            $this->selectedCustomerId = null;
            return;
        }
        
        $customer = Customer::where('phone', $this->customerPhone)->first();
        
        if ($customer) {
            $this->selectedCustomerId = $customer->id;
        } else {
            $this->selectedCustomerId = null;
        }
    }

    /**
     * Get all active services
     */
    #[Computed]
    public function services()
    {
        // Define custom order for best-selling items
        $customOrder = [
            'shirt' => 1,
            'tshirt' => 2,
            't-shirt' => 2,
            'pant' => 3,
            'u pant' => 4,
            'upant' => 4,
            'thobe' => 5,
            'salwar kameez' => 6,
            'baniyan' => 7,
            'coat pants' => 8,
            'coat only' => 9,
            'jacket' => 10,
            'sweter' => 11,
            'sweater' => 11,
            'apron' => 12,
            'blanket big' => 13,
            'blanket medium' => 14,
            'blanket small' => 15,
        ];
        
        $services = Service::active()->get();
        
        // Sort services by custom order
        return $services->sort(function ($a, $b) use ($customOrder) {
            $aName = strtolower($a->name);
            $bName = strtolower($b->name);
            
            $aOrder = $customOrder[$aName] ?? 999;
            $bOrder = $customOrder[$bName] ?? 999;
            
            if ($aOrder === $bOrder) {
                // If both have same order or both not in list, sort alphabetically
                return strcmp($aName, $bName);
            }
            
            return $aOrder <=> $bOrder;
        })->values();
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
     * Handle customer phone input - auto-fill order number for existing customers
     */
    public function updatedCustomerPhone($value): void
    {
        if (!empty($value)) {
            $customer = Customer::where('phone', $value)->first();
            
            if ($customer) {
                // Existing customer - auto-fill their details and order number
                $this->selectedCustomerId = $customer->id;
                $this->customerName = $customer->name;
                
                if ($customer->customer_order_number) {
                    $this->customOrderId = $customer->customer_order_number;
                }
            } else {
                // New customer - clear fields
                $this->selectedCustomerId = null;
                $this->customerName = '';
                // customOrderId can be manually entered by user
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
     * Get total amount for all items (minus discount)
     */
    public function getTotalAmountProperty(): float
    {
        $subtotal = array_sum(array_column($this->items, 'subtotal'));
        return max(0, $subtotal - $this->discount);
    }

    /**
     * Create new order (Entry button) - Shows payment modal
     */
    public function createOrder(): void
    {
        // Validation
        $this->validate([
            'customerPhone' => 'required|string',
            'customOrderId' => 'required|string|max:50',
            'deliveryDate' => 'required|date|after_or_equal:today',
        ]);

        if (empty($this->items)) {
            session()->flash('error', 'Please add at least one service item!');
            return;
        }

        // Check if Order ID belongs to another customer
        $existingCustomerWithOrderId = Customer::where('customer_order_number', $this->customOrderId)->first();
        
        if ($existingCustomerWithOrderId) {
            // Order ID exists - check if it matches current customer
            $currentCustomer = Customer::where('phone', $this->customerPhone)->first();
            
            if ($currentCustomer && $currentCustomer->id !== $existingCustomerWithOrderId->id) {
                // Order ID belongs to a different customer
                session()->flash('error', 'Order ID "' . $this->customOrderId . '" belongs to another customer (' . $existingCustomerWithOrderId->name . ', ' . $existingCustomerWithOrderId->phone . '). Please verify customer details or use a different Order ID.');
                return;
            }
            
            if (!$currentCustomer) {
                // New customer trying to use existing order ID
                session()->flash('error', 'Order ID "' . $this->customOrderId . '" is already assigned to customer ' . $existingCustomerWithOrderId->name . ' (' . $existingCustomerWithOrderId->phone . '). Please use a different Order ID for new customer.');
                return;
            }
        }

        // Show payment selection modal
        $this->showPaymentModal = true;
    }

    /**
     * Process order with selected payment method
     */
    public function processOrderWithPayment(string $paymentMethod): void
    {

        // Create or find customer when creating order
        if (!$this->selectedCustomerId) {
            // Check if customer exists
            $customer = Customer::where('phone', $this->customerPhone)->first();
            
            if (!$customer) {
                // New customer - create with custom order number
                $customer = Customer::create([
                    'name' => !empty($this->customerName) ? $this->customerName : 'Customer-' . $this->customerPhone,
                    'phone' => $this->customerPhone,
                    'customer_order_number' => $this->customOrderId,
                    'address' => null,
                ]);
            } else {
                // Existing customer - use their existing order number
                $this->customOrderId = $customer->customer_order_number;
            }
            
            $this->selectedCustomerId = $customer->id;
        } else {
            // Customer already selected - use their order number
            $customer = Customer::find($this->selectedCustomerId);
            if ($customer && $customer->customer_order_number) {
                $this->customOrderId = $customer->customer_order_number;
            } elseif ($customer) {
                // Customer exists but no order number - assign one
                $customer->update(['customer_order_number' => $this->customOrderId]);
            }
        }

        // Calculate total
        $totalAmount = $this->totalAmount;

        // Determine payment status based on payment method
        $paymentStatus = 'pending';
        $paymentMethodValue = null;
        
        if ($paymentMethod === 'card' || $paymentMethod === 'cash') {
            $paymentStatus = 'paid';
            $paymentMethodValue = $paymentMethod;
        }

        // Create order with custom order ID (required)
        $order = Order::create([
            'customer_id' => $this->selectedCustomerId,
            'order_number' => $this->customOrderId,
            'total_amount' => $totalAmount,
            'discount' => $this->discount,
            'tax' => 0,
            'status' => 'pending',
            'payment_status' => $paymentStatus,
            'payment_method' => $paymentMethodValue,
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

        // Close payment modal
        $this->showPaymentModal = false;

        // Success message based on payment method
        $paymentMsg = $paymentMethod === 'due' 
            ? 'Payment: Due' 
            : 'Payment: ' . ucfirst($paymentMethod) . ' (Paid)';
        
        session()->flash('success', 'Order #' . $order->order_number . ' created successfully! ' . $paymentMsg);

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
        $this->discount = 0;
        $this->deliveryDate = now()->addDay()->format('Y-m-d');
    }

    #[Layout('components.layouts.app', ['title' => 'POS - Point of Sale'])]
    public function render()
    {
        return view('livewire.p-o-s');
    }
}
