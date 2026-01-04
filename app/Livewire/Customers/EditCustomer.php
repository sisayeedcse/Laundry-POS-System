<?php

declare(strict_types=1);

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class EditCustomer extends Component
{
    public bool $showModal = false;
    public int $customerId;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string|max:20')]
    public string $phone = '';

    #[Validate('nullable|email|max:255')]
    public ?string $email = null;

    #[Validate('nullable|string|max:500')]
    public ?string $address = null;

    #[Validate('required|in:active,inactive')]
    public string $status = 'active';

    /**
     * Listen for edit-customer event
     */
    #[On('edit-customer')]
    public function openModal(int $customerId): void
    {
        $this->customerId = $customerId;
        $this->loadCustomer();
        $this->showModal = true;
        $this->resetValidation();
    }

    /**
     * Load customer data
     */
    protected function loadCustomer(): void
    {
        $customer = Customer::findOrFail($this->customerId);
        
        $this->name = $customer->name;
        $this->phone = $customer->phone;
        $this->email = $customer->email ?? '';
        $this->address = $customer->address ?? '';
        $this->status = $customer->status;
    }

    /**
     * Update customer
     */
    public function update(): void
    {
        $this->validate();

        $customer = Customer::findOrFail($this->customerId);

        // Check if phone is already used by another customer
        $existingCustomer = Customer::where('phone', $this->phone)
            ->where('id', '!=', $this->customerId)
            ->first();

        if ($existingCustomer) {
            $this->addError('phone', 'This phone number is already registered to another customer.');
            return;
        }

        $customer->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email ?: null,
            'address' => $this->address ?: null,
            'status' => $this->status,
        ]);

        $this->closeModal();
        $this->dispatch('customer-updated');
        session()->flash('success', 'Customer updated successfully!');
    }

    /**
     * Close modal
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['name', 'phone', 'email', 'address', 'status']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.customers.edit-customer');
    }
}
