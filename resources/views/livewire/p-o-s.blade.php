<div class="min-h-screen bg-gray-50 p-4">
    {{-- Simple Header --}}
    <div class="mb-6 text-center">
        <h1 class="text-4xl font-bold text-purple-600">🧺 New Order</h1>
        <p class="mt-2 text-lg text-gray-600">Simple & Fast Entry</p>
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

    {{-- Step 1: Customer Info --}}
    <div class="max-w-6xl mx-auto mb-6">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">📞 Step 1: Order Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-lg font-semibold text-gray-700 mb-2">🔢 Order ID *</label>
                    <input type="text" wire:model="customOrderId"
                        placeholder="Enter Order ID"
                        class="w-full rounded-xl border-2 border-gray-300 px-6 py-4 text-lg font-bold focus:border-purple-500 focus:ring-2 focus:ring-purple-200" />
                    @error('customOrderId')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-lg font-semibold text-gray-700 mb-2">📱 Phone Number *</label>
                    <input type="text" wire:model.live="customerPhone" wire:blur="searchCustomer"
                        placeholder="0501234567"
                        class="w-full rounded-xl border-2 border-gray-300 px-6 py-4 text-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200" />
                    @if($this->selectedCustomer)
                        <p class="mt-2 text-base font-medium text-green-600">✓ Existing: {{ $this->selectedCustomer->name }}</p>
                    @else
                        @if(!empty($customerPhone))
                            <p class="mt-2 text-base font-medium text-blue-600">ℹ️ New customer will be created</p>
                        @endif
                    @endif
                    @error('customerPhone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-lg font-semibold text-gray-700 mb-2">📅 Delivery Date *</label>
                    <input type="date" wire:model="deliveryDate" min="{{ date('Y-m-d') }}"
                        class="w-full rounded-xl border-2 border-gray-300 px-6 py-4 text-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200" />
                    @error('deliveryDate')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Step 2: Add Items --}}
    <div class="max-w-6xl mx-auto mb-6">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">👕 Step 2: Add Laundry Items</h2>
            
            {{-- Simple Add Item Card --}}
            <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-6 mb-6 border-2 border-dashed border-purple-300">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="lg:col-span-2">
                        <label class="block text-base font-semibold text-gray-700 mb-2">Item</label>
                        <select wire:model.live="selectedServiceId"
                            class="w-full rounded-lg border-2 border-gray-300 px-4 py-3 text-base focus:border-purple-500">
                            <option value="">Choose item...</option>
                            @foreach($this->services as $service)
                                <option value="{{ $service->id }}">
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-base font-semibold text-gray-700 mb-2">Service</label>
                        <select wire:model.live="serviceType"
                            class="w-full rounded-lg border-2 border-gray-300 px-4 py-3 text-base focus:border-purple-500">
                            <option value="wash_iron">🧼 Wash & Iron</option>
                            <option value="iron_only">🔥 Iron Only</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-base font-semibold text-gray-700 mb-2">Qty</label>
                        <input type="number" wire:model="quantity" min="1"
                            class="w-full rounded-lg border-2 border-gray-300 px-4 py-3 text-base text-center font-bold focus:border-purple-500" />
                    </div>

                    <div>
                        <label class="block text-base font-semibold text-gray-700 mb-2">Price (AED)</label>
                        <input type="number" wire:model="price" step="0.01" min="0"
                            class="w-full rounded-lg border-2 border-purple-300 px-4 py-3 text-base font-bold text-purple-600 focus:border-purple-500" />
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between">
                    <div class="text-xl font-bold text-gray-700">
                        Subtotal: <span class="text-purple-600">{{ number_format($price * $quantity, 2) }} AED</span>
                    </div>
                    <button type="button" wire:click="addItem"
                        class="rounded-xl bg-green-600 px-8 py-3 text-lg font-bold text-white hover:bg-green-700 shadow-lg hover:shadow-xl transform hover:scale-105">
                        ➕ Add Item
                    </button>
                </div>
            </div>

            {{-- Added Items List --}}
            <div class="space-y-3">
                @forelse($items as $index => $item)
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 hover:border-purple-300 transition-all">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 grid grid-cols-4 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Item</p>
                                    <p class="text-lg font-bold text-gray-800">{{ $item['service_name'] }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Service</p>
                                    <span class="inline-flex rounded-full px-3 py-1 text-sm font-bold
                                        {{ $item['service_type'] === 'wash_iron' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                        {{ $item['service_type'] === 'wash_iron' ? 'Wash & Iron' : 'Iron Only' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Quantity</p>
                                    <p class="text-lg font-bold text-gray-800">{{ $item['quantity'] }} pcs</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Amount</p>
                                    <p class="text-lg font-bold text-purple-600">{{ number_format($item['subtotal'], 2) }} AED</p>
                                </div>
                            </div>
                            <button type="button" wire:click="removeItem({{ $index }})"
                                class="ml-4 rounded-lg bg-red-500 px-4 py-2 text-sm font-bold text-white hover:bg-red-600">
                                🗑️ Remove
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="bg-gray-100 rounded-xl p-8 text-center">
                        <p class="text-gray-500 text-lg">No items added yet</p>
                        <p class="text-gray-400 text-sm mt-1">Use the form above to add laundry items</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Step 3: Notes (Optional) --}}
    <div class="max-w-6xl mx-auto mb-6">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">📝 Step 3: Special Notes (Optional)</h2>
            <textarea wire:model="notes" rows="3" placeholder="Any special instructions? (e.g., Extra starch, no hangers, etc.)"
                class="w-full rounded-xl border-2 border-gray-300 px-6 py-4 text-base focus:border-purple-500 focus:ring-2 focus:ring-purple-200"></textarea>
        </div>
    </div>

    {{-- Total & Submit --}}
    <div class="max-w-6xl mx-auto">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl shadow-2xl p-8">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white text-lg opacity-90 mb-2">Total Amount</p>
                    <p class="text-white text-5xl font-bold">
                        {{ number_format($this->totalAmount, 2) }} <span class="text-2xl">AED</span>
                    </p>
                    <p class="text-white text-base opacity-75 mt-2">{{ count($items) }} item(s) added</p>
                </div>

                <button type="button" wire:click="createOrder"
                    class="rounded-2xl bg-white px-12 py-6 text-2xl font-bold text-purple-600 hover:bg-gray-100 shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all">
                    ✅ Create Order
                </button>
            </div>
        </div>

        <div class="mt-4 bg-blue-50 border-l-4 border-blue-400 rounded-lg p-4">
            <p class="text-blue-800 text-base">
                💡 <strong>Tip:</strong> Order will be saved as <strong>PENDING</strong>. Payment collected when customer picks up.
            </p>
        </div>
    </div>
</div>
