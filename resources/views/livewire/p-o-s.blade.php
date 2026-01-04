<div class="p-6">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Point of Sale (POS)</h1>
        <p class="mt-2 text-sm text-gray-600">Create new laundry orders</p>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('info'))
        <div class="mb-4 rounded-lg bg-blue-50 p-4 text-blue-800">
            {{ session('info') }}
        </div>
    @endif

    {{-- Order Entry Form --}}
    <div class="rounded-lg bg-white shadow-lg">
        <div class="border-b border-gray-200 bg-purple-600 p-4 rounded-t-lg">
            <h2 class="text-xl font-bold text-white">New Order Entry</h2>
        </div>

        <div class="p-6">
            {{-- Customer Phone and Order ID Row --}}
            <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-lg">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer Phone *</label>
                    <input type="text" wire:model.live="customerPhone" wire:blur="searchCustomer"
                        placeholder="Enter phone number"
                        class="w-full rounded border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500" />
                    @if($this->selectedCustomer)
                        <p class="mt-1 text-xs text-green-600">✓ {{ $this->selectedCustomer->name }}</p>
                    @endif
                    @error('customerPhone')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Custom Order ID (Optional)</label>
                    <input type="text" wire:model="customOrderId" placeholder="Auto-generate if empty"
                        class="w-full rounded border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500" />
                    @error('customOrderId')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Delivery Date *</label>
                    <input type="date" wire:model="deliveryDate" min="{{ date('Y-m-d') }}"
                        class="w-full rounded border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500" />
                    @error('deliveryDate')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Add Service Items --}}
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                Laundry Items
                            </th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                Service Type
                            </th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                Quantity
                            </th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                Price (AED)
                            </th>
                            <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                Subtotal
                            </th>
                            <th class="border border-gray-300 px-4 py-3 text-center text-sm font-semibold text-gray-700">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Input Row --}}
                        <tr class="bg-blue-50">
                            <td class="border border-gray-300 px-4 py-3">
                                <select wire:model.live="selectedServiceId"
                                    class="w-full rounded border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                                    <option value="">Select Service</option>
                                    @foreach($this->services as $service)
                                        <option value="{{ $service->id }}">
                                            {{ $service->name }} ({{ $service->category }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('selectedServiceId')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </td>

                            <td class="border border-gray-300 px-4 py-3">
                                <select wire:model.live="serviceType"
                                    class="w-full rounded border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                                    <option value="wash_iron">Wash & Iron</option>
                                    <option value="iron_only">Iron Only</option>
                                </select>
                            </td>

                            <td class="border border-gray-300 px-4 py-3">
                                <input type="number" wire:model="quantity" min="1"
                                    class="w-20 rounded border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500" />
                                @error('quantity')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </td>

                            <td class="border border-gray-300 px-4 py-3">
                                <input type="number" wire:model="price" step="0.01" min="0"
                                    class="w-24 rounded border-gray-300 text-sm font-semibold focus:border-purple-500 focus:ring-purple-500" />
                                @error('price')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </td>

                            <td class="border border-gray-300 px-4 py-3 text-center">
                                <span class="font-semibold text-purple-600">
                                    {{ number_format($price * $quantity, 2) }}
                                </span>
                            </td>

                            <td class="border border-gray-300 px-4 py-3 text-center">
                                <button type="button" wire:click="addItem"
                                    class="rounded bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                                    + Add
                                </button>
                            </td>
                        </tr>

                        {{-- Added Items --}}
                        @forelse($items as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-3">
                                    {{ $item['service_name'] }}
                                </td>
                                <td class="border border-gray-300 px-4 py-3">
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold
                                        {{ $item['service_type'] === 'wash_iron' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ $item['service_type'] === 'wash_iron' ? 'Wash & Iron' : 'Iron Only' }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-4 py-3 text-center">
                                    {{ $item['quantity'] }}
                                </td>
                                <td class="border border-gray-300 px-4 py-3 text-right">
                                    {{ number_format($item['unit_price'], 2) }}
                                </td>
                                <td class="border border-gray-300 px-4 py-3 text-right font-semibold">
                                    {{ number_format($item['subtotal'], 2) }}
                                </td>
                                <td class="border border-gray-300 px-4 py-3 text-center">
                                    <button type="button" wire:click="removeItem({{ $index }})"
                                        class="rounded bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border border-gray-300 px-4 py-8 text-center text-gray-500">
                                    No items added yet. Use the form above to add services.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Notes --}}
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional):</label>
                <textarea wire:model="notes" rows="2" placeholder="Special instructions..."
                    class="w-full rounded border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
            </div>

            {{-- Total and Entry Button --}}
            <div class="mt-6 flex items-center justify-between border-t pt-4">
                <div class="text-lg">
                    <span class="text-gray-700 font-medium">Total Amount:</span>
                    <span class="ml-2 text-3xl font-bold text-purple-600">
                        {{ number_format($this->totalAmount, 2) }} AED
                    </span>
                    <span class="ml-2 text-sm text-gray-500">({{ count($items) }} item(s))</span>
                </div>

                <button type="button" wire:click="createOrder"
                    class="rounded-lg bg-purple-600 px-8 py-3 text-lg font-semibold text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                    📥 Entry Order
                </button>
            </div>

            <div class="mt-4 rounded-lg bg-yellow-50 p-4">
                <p class="text-sm text-yellow-800">
                    <strong>Note:</strong> Order will be saved as <strong>PENDING</strong> status. Payment will be calculated when status changes to <strong>DELIVERED</strong>.
                </p>
            </div>
        </div>
    </div>
</div>
