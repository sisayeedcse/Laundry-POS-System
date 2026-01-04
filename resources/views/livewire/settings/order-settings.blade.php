<div class="bg-white rounded-lg shadow-sm p-6">
    @if (session()->has('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        {{-- Order Numbering --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Numbering</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Order Number Prefix *</label>
                    <input type="text" wire:model="order_prefix"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                        placeholder="ORD">
                    @error('order_prefix')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Example: {{ $order_prefix }}-001, {{ $order_prefix }}-002
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Default Order Status *</label>
                    <select wire:model="default_order_status"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="ready">Ready for Delivery</option>
                        <option value="delivered">Delivered</option>
                    </select>
                    @error('default_order_status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Delivery Settings --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Delivery Settings</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Default Delivery Days *</label>
                    <input type="number" wire:model="default_delivery_days" min="1" max="30"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    @error('default_delivery_days')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Standard turnaround time in days</p>
                </div>
            </div>
        </div>

        {{-- Order Options --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Options</h3>
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" wire:model="require_customer" id="require_customer"
                        class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <label for="require_customer" class="ml-2 block text-sm text-gray-700">
                        Require customer selection for all orders
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" wire:model="enable_express_service" id="enable_express_service"
                        class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <label for="enable_express_service" class="ml-2 block text-sm text-gray-700">
                        Enable express service option
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" wire:model="auto_print_receipt" id="auto_print_receipt"
                        class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <label for="auto_print_receipt" class="ml-2 block text-sm text-gray-700">
                        Automatically print receipt after creating order
                    </label>
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                Save Order Settings
            </button>
        </div>
    </form>
</div>