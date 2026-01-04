<div class="rounded-lg bg-white shadow-xl">
    {{-- Header --}}
    <div class="flex items-center justify-between border-b p-6">
        <h3 class="text-xl font-bold text-gray-900">Add New Customer</h3>
        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Form --}}
    <form wire:submit.prevent="createCustomer" class="p-6">
        <div class="space-y-4">
            {{-- Name --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Name <span class="text-red-600">*</span>
                </label>
                <input type="text" wire:model="name"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                    placeholder="Enter customer name" />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Phone <span class="text-red-600">*</span>
                </label>
                <input type="text" wire:model="phone"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                    placeholder="Enter phone number" />
                @error('phone')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Address --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">
                    Address (Optional)
                </label>
                <textarea wire:model="address" rows="3"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                    placeholder="Enter customer address"></textarea>
                @error('address')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-6 flex gap-3">
            <button type="submit"
                class="flex-1 rounded-lg bg-purple-600 px-4 py-2 font-semibold text-white hover:bg-purple-700">
                Create Customer
            </button>
            <button type="button" wire:click="closeModal"
                class="rounded-lg border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
        </div>
    </form>
</div>