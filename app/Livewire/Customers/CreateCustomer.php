<?php

declare(strict_types=1);

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class CreateCustomer extends Component
{
    public string $name = '';
    public string $phone = '';
    public string $address = '';

    /**
     * Validation rules
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'address' => 'nullable|string|max:500',
        ];
    }

    /**
     * Create customer
     */
    public function createCustomer(): void
    {
        $validated = $this->validate();

        Customer::create($validated);

        session()->flash('success', 'Customer created successfully!');
        
        $this->dispatch('customer-created');
        $this->reset();
    }

    /**
     * Close modal
     */
    public function closeModal(): void
    {
        $this->dispatch('customer-created');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.customers.create-customer');
    }
}
