<?php

declare(strict_types=1);

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class ServiceList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $categoryFilter = 'all';
    public string $statusFilter = 'all';
    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public ?int $editingServiceId = null;

    /**
     * Reset pagination when filters change
     */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Get services with filters
     */
    #[Computed]
    public function services()
    {
        $query = Service::query();

        // Search
        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        // Category filter
        if ($this->categoryFilter !== 'all') {
            $query->where('category', $this->categoryFilter);
        }

        // Status filter
        if ($this->statusFilter !== 'all') {
            $isActive = $this->statusFilter === 'active';
            $query->where('is_active', $isActive);
        }

        return $query->latest()->paginate(12);
    }

    /**
     * Get all unique categories
     */
    #[Computed]
    public function categories()
    {
        return Service::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');
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
    #[On('service-created')]
    public function closeCreateModal(): void
    {
        $this->showCreateModal = false;
        session()->flash('success', 'Service created successfully!');
        $this->resetPage();
    }

    /**
     * Open edit modal
     */
    public function editService(int $serviceId): void
    {
        $this->editingServiceId = $serviceId;
        $this->showEditModal = true;
    }

    /**
     * Close edit modal
     */
    #[On('service-updated')]
    public function closeEditModal(): void
    {
        $this->showEditModal = false;
        $this->editingServiceId = null;
        session()->flash('success', 'Service updated successfully!');
    }

    /**
     * Toggle service active status
     */
    public function toggleStatus(int $serviceId): void
    {
        $service = Service::findOrFail($serviceId);
        $service->update(['is_active' => !$service->is_active]);
        
        $status = $service->is_active ? 'activated' : 'deactivated';
        session()->flash('success', "Service {$status} successfully!");
    }

    /**
     * Delete service
     */
    public function deleteService(int $serviceId): void
    {
        $service = Service::findOrFail($serviceId);
        
        // Check if service is used in any orders
        if ($service->orderItems()->count() > 0) {
            session()->flash('error', 'Cannot delete service that has been used in orders!');
            return;
        }

        // Delete image if exists
        if ($service->image_path) {
            Storage::disk('public')->delete($service->image_path);
        }

        $service->delete();
        
        session()->flash('success', 'Service deleted successfully!');
        $this->resetPage();
    }

    /**
     * Clear filters
     */
    public function clearFilters(): void
    {
        $this->search = '';
        $this->categoryFilter = 'all';
        $this->statusFilter = 'all';
        $this->resetPage();
    }

    #[Layout('components.layouts.app', ['title' => 'Services Management'])]
    public function render()
    {
        return view('livewire.services.service-list');
    }
}
