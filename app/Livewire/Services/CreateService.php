<?php

declare(strict_types=1);

namespace App\Livewire\Services;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class CreateService extends Component
{
    use WithFileUploads;

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

    /**
     * Mount component
     */
    public function mount(): void
    {
        $this->showModal = true;
    }

    /**
     * Update image preview when file is selected
     */
    public function updatedImage(): void
    {
        $this->imagePreview = $this->image?->temporaryUrl();
    }

    /**
     * Create the service
     */
    public function create(): void
    {
        $validated = $this->validate();

        // Handle image upload
        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('services', 'public');
        }

        // Create service
        Service::create([
            'name' => $validated['name'],
            'category' => $validated['category'] ?: null,
            'price_wash_iron' => (float) $validated['price_wash_iron'],
            'price_iron_only' => !empty($validated['price_iron_only']) ? (float) $validated['price_iron_only'] : null,
            'size_variant' => $validated['size_variant'] ?: null,
            'description' => $validated['description'] ?: null,
            'image_path' => $imagePath,
            'is_active' => true,
        ]);

        // Close modal and notify parent
        $this->showModal = false;
        $this->dispatch('service-created');
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
        return view('livewire.services.create-service');
    }
}
