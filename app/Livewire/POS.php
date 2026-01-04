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
    // Customer fields
    public ?int $selectedCustomerId = null;
    public string $customerName = '';
    public string $customerPhone = '';
    public string $customerAddress = '';
    public bool $showCustomerModal = false;

    // Order fields
    public array $cart = [];
    public float $discount = 0;
    public float $tax = 0;
    public string $paymentMethod = 'cash';
    public ?string $deliveryDate = null;
    public string $notes = '';

    // Search
    public string $search = '';
    public string $selectedCategory = 'all';

    /**
     * Mount component with default delivery date (tomorrow)
     */
    public function mount(): void
    {
        $this->deliveryDate = now()->addDay()->format('Y-m-d');
    }

    /**
     * Get all services
     */
    #[Computed]
    public function services()
    {
        $query = Service::active();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedCategory !== 'all') {
            $query->where('category', $this->selectedCategory);
        }

        return $query->get();
    }

    /**
     * Get all categories
     */
    #[Computed]
    public function categories()
    {
        return Service::active()
            ->select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');
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
        $this->customerPhone = '';
        $this->customerAddress = '';
    }

    /**
     * Create order
     */
    public function createOrder(): void
    {
        // Validation
        if (empty($this->cart)) {
            session()->flash('error', 'Cart is empty!');
            return;
        }

        if (!$this->selectedCustomerId) {
            session()->flash('error', 'Please select a customer!');
            return;
        }

        $this->validate([
            'deliveryDate' => 'required|date|after_or_equal:today',
            'paymentMethod' => 'required|in:cash,card',
        ]);

        // Create order
        $order = Order::create([
            'customer_id' => $this->selectedCustomerId,
            'order_number' => Order::generateOrderNumber(),
            'total_amount' => $this->total,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'advance_payment' => $this->total,
            'status' => 'pending',
            'payment_status' => 'paid',
            'payment_method' => $this->paymentMethod,
            'delivery_date' => $this->deliveryDate,
            'notes' => $this->notes,
        ]);

        // Create order items
        foreach ($this->cart as $item) {
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
        $order->customer->incrementOrders();

        // Reset form
        $this->resetOrder();

        session()->flash('success', 'Order created successfully! Order #' . $order->order_number);
        
        // Redirect to orders page
        $this->redirect('/orders');
    }

    /**
     * Reset order form
     */
    private function resetOrder(): void
    {
        $this->cart = [];
        $this->selectedCustomerId = null;
        $this->discount = 0;
        $this->tax = 0;
        $this->paymentMethod = 'cash';
        $this->deliveryDate = now()->addDay()->format('Y-m-d');
        $this->notes = '';
    }

    /**
     * Clear cart
     */
    /**
     * Clear cart
     */
    public function clearCart(): void
    {
        $this->cart = [];
    }

    #[Layout('components.layouts.app', ['title' => 'POS - Point of Sale'])]
    public function render()
    {
        return view('livewire.p-o-s');
    }
}
