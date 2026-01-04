<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class CreateService extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|string|max:255')]
    public string $category = '';

    #[Validate('required|numeric|min:0')]
    public string $price_normal = '';

    #[Validate('required|numeric|min:0')]
    public string $price_urgent = '';

    #[Validate('nullable|image|max:2048|mimes:png,jpg,jpeg')]
    public $image;

    public ?string $imagePreview = null;

    public bool $showModal = false;

    /**
     * Update image preview when file is selected
     */
    public function updatedImage(): void
    {
        $this->imagePreview = $this->image?->temporaryUrl();
    }

    /**
     * Save the service to database
     */
    public function save(): void
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
            'category' => $validated['category'] ?? null,
            'price_normal' => (float) $validated['price_normal'],
            'price_urgent' => (float) $validated['price_urgent'],
            'image_path' => $imagePath,
            'is_active' => true,
        ]);

        // Reset form and show success message
        $this->reset(['name', 'category', 'price_normal', 'price_urgent', 'image', 'imagePreview']);
        $this->showModal = false;

        // Dispatch event to parent component
        $this->dispatch('service-created');
    }

    /**
     * Open the create modal
     */
    public function openModal(): void
    {
        $this->showModal = true;
    }

    /**
     * Close the modal
     */
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset(['name', 'category', 'price_normal', 'price_urgent', 'image', 'imagePreview']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.create-service');
    }
}
