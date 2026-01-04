<?php

declare(strict_types=1);

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;

class CustomerList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = 'all';
    public bool $showCreateModal = false;
    public int $selectedCustomerId = 0;
    public bool $showDetailsModal = false;

    /**
     * Reset pagination when search or filter changes
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Get customers with filters
     */
    #[Computed]
    public function customers()
    {
        $query = Customer::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%')
                    ->orWhere('address', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter === 'active') {
            $query->active();
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('is_active', false);
        } elseif ($this->statusFilter === 'regular') {
            $query->regular();
        }

        return $query->latest()->paginate(15);
    }

    /**
     * Open create modal
     */
    public function openCreateModal(): void
    {
        $this->showCreateModal = true;
    }

    /**
     * Close create modal
     */
    #[On('customer-created')]
    public function closeCreateModal(): void
    {
        $this->showCreateModal = false;
        $this->resetPage();
    }

    /**
     * View customer details
     */
    public function viewCustomer(int $customerId): void
    {
        $this->selectedCustomerId = $customerId;
        $this->showDetailsModal = true;
    }

    /**
     * Close customer details modal
     */
    #[On('customer-details-closed')]
    public function closeDetailsModal(): void
    {
        $this->showDetailsModal = false;
        $this->selectedCustomerId = 0;
    }

    /**
     * Refresh customer list when updated
     */
    #[On('customer-updated')]
    public function refreshCustomers(): void
    {
        // This will trigger a re-render
        $this->resetPage();
    }

    /**
     * Toggle customer status
     */
    public function toggleStatus(int $customerId): void
    {
        $customer = Customer::find($customerId);
        
        if ($customer) {
            $customer->update(['is_active' => !$customer->is_active]);
            session()->flash('success', 'Customer status updated successfully!');
        }
    }

    /**
     * Delete customer
     */
    public function deleteCustomer(int $customerId): void
    {
        $customer = Customer::find($customerId);
        
        if ($customer) {
            if ($customer->orders()->exists()) {
                session()->flash('error', 'Cannot delete customer with existing orders!');
                return;
            }
            
            $customer->delete();
            session()->flash('success', 'Customer deleted successfully!');
            $this->resetPage();
        }
    }

    #[Layout('components.layouts.app', ['title' => 'Customers Management'])]
    public function render()
    {
        return view('livewire.customers.customer-list');
    }
}
