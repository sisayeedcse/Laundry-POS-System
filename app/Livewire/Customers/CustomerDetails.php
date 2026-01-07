<?php

declare(strict_types=1);

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;
use Livewire\Attributes\On;

class CustomerDetails extends Component
{
    public int $customerId;
    public bool $showModal = false;
    public bool $editMode = false;
    
    // Customer data
    public $customer;
    public $orders;
    public $statistics;
    
    // Edit fields
    public string $editName = '';
    public string $editPhone = '';
    public string $editAddress = '';

    /**
     * Mount component
     */
    public function mount(int $customerId): void
    {
        $this->customerId = $customerId;
        $this->showModal = true;
        $this->loadCustomerData();
    }
    
    /**
     * Load customer data
     */
    public function loadCustomerData(): void
    {
        $this->customer = Customer::with(['orders.orderItems.service', 'orders.payments'])
            ->findOrFail($this->customerId);
            
        $this->orders = $this->customer->orders->sortByDesc('created_at')->take(10);
        
        $this->statistics = [
            'total_orders' => $this->customer->orders->count(),
            'total_spent' => $this->customer->orders->where('payment_status', 'paid')->sum('total_amount'),
            'total_pending' => $this->customer->orders->whereIn('payment_status', ['pending', 'partial'])->sum('due_balance'),
            'last_order_date' => $this->customer->orders->sortByDesc('created_at')->first()?->created_at,
            'average_order_value' => $this->customer->orders->count() > 0 
                ? $this->customer->orders->avg('total_amount') 
                : 0,
            'completed_orders' => $this->customer->orders->where('status', 'delivered')->count(),
            'pending_orders' => $this->customer->orders->whereIn('status', ['pending', 'processing', 'ready'])->count(),
        ];
        
        // Load edit fields
        $this->editName = $this->customer->name;
        $this->editPhone = $this->customer->phone;
        $this->editAddress = $this->customer->address ?? '';
    }
    
    /**
     * Enable edit mode
     */
    public function enableEdit(): void
    {
        $this->editMode = true;
    }
    
    /**
     * Cancel edit mode
     */
    public function cancelEdit(): void
    {
        $this->editMode = false;
        // Reload original data
        $this->editName = $this->customer->name;
        $this->editPhone = $this->customer->phone;
        $this->editAddress = $this->customer->address ?? '';
    }
    
    /**
     * Save customer updates
     */
    public function saveCustomer(): void
    {
        // Validate input
        $validated = $this->validate([
            'editName' => 'required|string|max:255',
            'editPhone' => 'required|string|max:20',
            'editAddress' => 'nullable|string|max:500',
        ]);
        
        try {
            // Find and update customer
            $customer = Customer::findOrFail($this->customerId);
            
            $customer->update([
                'name' => trim($this->editName),
                'phone' => trim($this->editPhone),
                'address' => !empty(trim($this->editAddress)) ? trim($this->editAddress) : null,
            ]);
            
            // Disable edit mode
            $this->editMode = false;
            
            // Reload customer data to reflect changes
            $this->loadCustomerData();
            
            // Dispatch event to refresh customer list
            $this->dispatch('customer-updated');
            
            // Show success message
            session()->flash('message', 'Customer details updated successfully!');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update customer: ' . $e->getMessage());
        }
    }

    /**
     * Close modal
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->dispatch('customer-details-closed');
    }

    public function render()
    {
        return view('livewire.customers.customer-details');
    }
}
