<div>
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-gray-900 bg-opacity-50 p-4">
            <div class="w-full max-w-2xl rounded-lg bg-white shadow-xl">
                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-gray-200 p-6">
                    <h3 class="text-2xl font-bold text-gray-900">Create New Service</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Form --}}
                <form wire:submit.prevent="create" class="p-6">
                    <div class="space-y-6">
                        {{-- Service Name --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">
                                Service Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model="name" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500
                                    @error('name') border-red-500 @enderror" placeholder="e.g., Shirt, Pant, Thobe" />
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Category</label>
                            <input type="text" wire:model="category" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500
                                    @error('category') border-red-500 @enderror"
                                placeholder="e.g., Clothing, Traditional Wear, Bedding" />
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Pricing --}}
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            {{-- Wash & Iron Price --}}
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Wash & Iron Price (AED) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" wire:model="price_wash_iron" step="0.01" min="0" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500
                                        @error('price_wash_iron') border-red-500 @enderror" placeholder="0.00" />
                                @error('price_wash_iron')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Iron Only Price --}}
                            <div>
                                <label class="mb-2 block text-sm font-medium text-gray-700">
                                    Iron Only Price (AED)
                                </label>
                                <input type="number" wire:model="price_iron_only" step="0.01" min="0" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500
                                        @error('price_iron_only') border-red-500 @enderror"
                                    placeholder="0.00 (optional)" />
                                @error('price_iron_only')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Leave empty if not applicable</p>
                            </div>
                        </div>

                        {{-- Size Variant --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Size Variant</label>
                            <input type="text" wire:model="size_variant" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500
                                    @error('size_variant') border-red-500 @enderror"
                                placeholder="e.g., Small, Medium, Large, Big" />
                            @error('size_variant')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Description</label>
                            <textarea wire:model="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500
                                    @error('description') border-red-500 @enderror"
                                placeholder="Optional service description..."></textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Image Upload --}}
                        <div>
                            <label class="mb-2 block text-sm font-medium text-gray-700">Service Image</label>
                            <input type="file" wire:model="image" accept="image/png,image/jpeg,image/jpg" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500
                                    @error('image') border-red-500 @enderror" />
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, JPEG - Max 2MB</p>

                            {{-- Image Preview --}}
                            @if ($imagePreview)
                                <div class="mt-3">
                                    <img src="{{ $imagePreview }}" alt="Preview" class="h-32 w-32 rounded-lg object-cover" />
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                            class="flex-1 rounded-lg bg-purple-600 px-4 py-2.5 font-semibold text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                            Create Service
                        </button>
                        <button type="button" wire:click="closeModal"
                            class="rounded-lg border border-gray-300 px-4 py-2.5 font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>