<?php

declare(strict_types=1);

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;

class EditService extends Component
{
    use WithFileUploads;

    public int $serviceId;
    public Service $service;
    public bool $showModal = false;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|string|max:255')]
    public string $category = '';

    #[Validate('required|numeric|min:0')]
    public string $price_wash_iron = '';

    #[Validate('nullable|numeric|min:0')]
    public string $price_iron_only = '';

    #[Validate('nullable|string|max:255')]
    public string $size_variant = '';

    #[Validate('nullable|string|max:1000')]
    public string $description = '';

    #[Validate('nullable|image|max:2048|mimes:png,jpg,jpeg')]
    public $image;

    public ?string $imagePreview = null;
    public ?string $currentImage = null;
    public bool $removeImage = false;

    /**
     * Mount component with service data
     */
    public function mount(int $serviceId): void
    {
        $this->serviceId = $serviceId;
        $this->service = Service::findOrFail($serviceId);
        
        // Populate form fields
        $this->name = $this->service->name;
        $this->category = $this->service->category ?? '';
        $this->price_wash_iron = (string) $this->service->price_wash_iron;
        $this->price_iron_only = $this->service->price_iron_only ? (string) $this->service->price_iron_only : '';
        $this->size_variant = $this->service->size_variant ?? '';
        $this->description = $this->service->description ?? '';
        $this->currentImage = $this->service->image_path;
        
        $this->showModal = true;
    }

    /**
     * Update image preview when file is selected
     */
    public function updatedImage(): void
    {
        $this->imagePreview = $this->image?->temporaryUrl();
        $this->removeImage = false;
    }

    /**
     * Mark image for removal
     */
    public function removeCurrentImage(): void
    {
        $this->removeImage = true;
        $this->currentImage = null;
        $this->image = null;
        $this->imagePreview = null;
    }

    /**
     * Update the service
     */
    public function update(): void
    {
        $validated = $this->validate();

        // Handle image upload/removal
        $imagePath = $this->service->image_path;
        
        if ($this->removeImage && $imagePath) {
            // Delete old image
            Storage::disk('public')->delete($imagePath);
            $imagePath = null;
        }
        
        if ($this->image) {
            // Delete old image if exists
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            // Upload new image
            $imagePath = $this->image->store('services', 'public');
        }

        // Update service
        $this->service->update([
            'name' => $validated['name'],
            'category' => $validated['category'] ?: null,
            'price_wash_iron' => (float) $validated['price_wash_iron'],
            'price_iron_only' => !empty($validated['price_iron_only']) ? (float) $validated['price_iron_only'] : null,
            'size_variant' => $validated['size_variant'] ?: null,
            'description' => $validated['description'] ?: null,
            'image_path' => $imagePath,
        ]);

        // Close modal and notify parent
        $this->showModal = false;
        $this->dispatch('service-updated');
    }

    /**
     * Close the modal
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset([
            'name', 
            'category', 
            'price_wash_iron', 
            'price_iron_only', 
            'size_variant',
            'description', 
            'image', 
            'imagePreview'
        ]);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.services.edit-service');
    }
}
