<div>
    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: true }" x-show="open"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

                <!-- Modal panel -->
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form wire:submit="save">
                        <!-- Modal Header -->
                        <div class="bg-white px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900" id="modal-title">
                                    Add New Service
                                </h3>
                                <button type="button" wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Modal Body -->
                        <div class="bg-white px-6 py-4 space-y-4">
                            <!-- Success Message -->
                            @if (session()->has('success'))
                                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <!-- Service Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Service Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" wire:model="name"
                                    class="input-field @error('name') border-red-500 @enderror"
                                    placeholder="e.g., Shirt Wash">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                    Category
                                </label>
                                <input type="text" id="category" wire:model="category"
                                    class="input-field @error('category') border-red-500 @enderror"
                                    placeholder="e.g., Clothing, Bedding">
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prices Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Normal Price -->
                                <div>
                                    <label for="price_normal" class="block text-sm font-medium text-gray-700 mb-2">
                                        Normal Price (QAR) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="price_normal" wire:model="price_normal" step="0.01" min="0"
                                        class="input-field @error('price_normal') border-red-500 @enderror"
                                        placeholder="0.00">
                                    @error('price_normal')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Urgent Price -->
                                <div>
                                    <label for="price_urgent" class="block text-sm font-medium text-gray-700 mb-2">
                                        Urgent Price (QAR) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="price_urgent" wire:model="price_urgent" step="0.01" min="0"
                                        class="input-field @error('price_urgent') border-red-500 @enderror"
                                        placeholder="0.00">
                                    @error('price_urgent')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Service Image
                                </label>
                                <div class="mt-1 flex items-center gap-4">
                                    <!-- Image Preview -->
                                    @if ($imagePreview)
                                        <div class="relative">
                                            <img src="{{ $imagePreview }}" alt="Preview"
                                                class="h-24 w-24 object-cover rounded-lg border-2 border-gray-300">
                                            <button type="button" wire:click="$set('image', null)"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @else
                                        <div
                                            class="h-24 w-24 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- File Input -->
                                    <div class="flex-1">
                                        <input type="file" wire:model="image" accept="image/png,image/jpeg,image/jpg"
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                        <p class="mt-1 text-xs text-gray-500">PNG or JPG (MAX. 2MB)</p>
                                        @error('image')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Loading indicator -->
                                <div wire:loading wire:target="image" class="mt-2">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="animate-spin h-4 w-4 mr-2 text-purple-600" fill="none"
                                            viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Uploading image...
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="bg-gray-50 px-6 py-4 flex items-center justify-end gap-3">
                            <button type="button" wire:click="closeModal" class="btn-secondary">
                                Cancel
                            </button>
                            <button type="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="save">
                                <span wire:loading.remove wire:target="save">Save Service</span>
                                <span wire:loading wire:target="save">
                                    <svg class="animate-spin h-5 w-5 inline-block" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Saving...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>