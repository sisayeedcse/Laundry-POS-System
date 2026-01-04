<div>
    @if($showModal)
        <!-- Modal Overlay -->
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: true }" x-show="open"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <!-- Background Overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

            <!-- Modal Content -->
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl transform transition-all"
                    @click.away="$wire.closeModal()">

                    <form wire:submit="update">
                        <!-- Modal Header -->
                        <div
                            class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-indigo-50">
                            <h3 class="text-xl font-bold text-gray-900">Edit Service</h3>
                            <button type="button" wire:click="closeModal"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="px-6 py-6 space-y-5 max-h-[calc(100vh-250px)] overflow-y-auto">
                            <!-- Service Name -->
                            <div>
                                <label for="edit-name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Service Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="edit-name" wire:model="name"
                                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('name') border-red-500 @enderror"
                                    placeholder="e.g., Shirt Wash">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="edit-category" class="block text-sm font-medium text-gray-700 mb-2">
                                    Category
                                </label>
                                <input type="text" id="edit-category" wire:model="category"
                                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('category') border-red-500 @enderror"
                                    placeholder="e.g., Clothing, Bedding">
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prices Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Wash & Iron Price -->
                                <div>
                                    <label for="edit-price-wash-iron" class="block text-sm font-medium text-gray-700 mb-2">
                                        Wash & Iron Price (AED) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="edit-price-wash-iron" wire:model="price_wash_iron" step="0.01"
                                        min="0"
                                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('price_wash_iron') border-red-500 @enderror"
                                        placeholder="0.00">
                                    @error('price_wash_iron')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Iron Only Price -->
                                <div>
                                    <label for="edit-price-iron-only" class="block text-sm font-medium text-gray-700 mb-2">
                                        Iron Only Price (AED)
                                    </label>
                                    <input type="number" id="edit-price-iron-only" wire:model="price_iron_only" step="0.01"
                                        min="0"
                                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('price_iron_only') border-red-500 @enderror"
                                        placeholder="0.00 (optional)">
                                    @error('price_iron_only')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Leave empty if not applicable</p>
                                </div>
                            </div>

                            <!-- Size Variant -->
                            <div>
                                <label for="edit-size-variant" class="block text-sm font-medium text-gray-700 mb-2">
                                    Size Variant
                                </label>
                                <input type="text" id="edit-size-variant" wire:model="size_variant"
                                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('size_variant') border-red-500 @enderror"
                                    placeholder="e.g., Small, Medium, Large, Big">
                                @error('size_variant')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="edit-description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description
                                </label>
                                <textarea id="edit-description" wire:model="description" rows="3"
                                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 @error('description') border-red-500 @enderror"
                                    placeholder="Optional service description"></textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Service Image
                                </label>

                                <!-- Current Image Preview -->
                                @if($currentImage && !$removeImage && !$imagePreview)
                                    <div class="mb-3 relative inline-block">
                                        <img src="{{ asset('storage/' . $currentImage) }}" alt="Current service image"
                                            class="h-32 w-32 object-cover rounded-lg border-2 border-gray-200">
                                        <button type="button" wire:click="removeCurrentImage"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif

                                <!-- New Image Preview -->
                                @if($imagePreview)
                                    <div class="mb-3 relative inline-block">
                                        <img src="{{ $imagePreview }}" alt="New image preview"
                                            class="h-32 w-32 object-cover rounded-lg border-2 border-purple-500">
                                        <button type="button" wire:click="$set('image', null); $set('imagePreview', null)"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @endif

                                <!-- Upload Input -->
                                <div class="flex items-center justify-center w-full">
                                    <label
                                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500">
                                                <span class="font-semibold">Click to upload</span> new image
                                            </p>
                                            <p class="text-xs text-gray-500">PNG, JPG (MAX. 2MB)</p>
                                        </div>
                                        <input type="file" wire:model="image" class="hidden"
                                            accept="image/png,image/jpeg,image/jpg">
                                    </label>
                                </div>

                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <div wire:loading wire:target="image" class="mt-2 text-sm text-purple-600">
                                    Uploading image...
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end px-6 py-4 border-t border-gray-200 bg-gray-50 space-x-3">
                            <button type="button" wire:click="closeModal"
                                class="px-5 py-2 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-lg border border-gray-300 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-medium rounded-lg transition-all shadow-md hover:shadow-lg"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="update">Update Service</span>
                                <span wire:loading wire:target="update">Updating...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>