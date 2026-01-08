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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-lg font-semibold text-gray-700 mb-2">🔢 Order ID *</label>
                    <input type="text" wire:model="customOrderId"
                        placeholder="{{ $selectedCustomerId && $this->selectedCustomer?->customer_order_number ? 'Auto-filled for existing customer' : 'Enter Order ID' }}"
                        class="w-full rounded-xl border-2 border-gray-300 px-6 py-4 text-lg font-bold focus:border-purple-500 focus:ring-2 focus:ring-purple-200 {{ $selectedCustomerId && $this->selectedCustomer?->customer_order_number ? 'bg-gray-100' : '' }}"
                        {{ $selectedCustomerId && $this->selectedCustomer?->customer_order_number ? 'readonly' : '' }} />
                    @error('customOrderId')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($selectedCustomerId && $this->selectedCustomer?->customer_order_number)
                        <p class="mt-1 text-xs text-purple-600">✓ Existing customer order ID</p>
                    @endif
                </div>

                <div>
                    <label class="block text-lg font-semibold text-gray-700 mb-2">👤 Customer Name</label>
                    <input type="text" wire:model="customerName" placeholder="Leave empty for auto-generated"
                        class="w-full rounded-xl border-2 border-gray-300 px-6 py-4 text-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200"
                        {{ $this->selectedCustomer ? 'disabled' : '' }} />
                    @if($this->selectedCustomer)
                        <p class="mt-2 text-sm text-gray-500">Name locked for existing customer</p>
                    @else
                        <p class="mt-2 text-sm text-gray-500">Auto: Customer-{phone}</p>
                    @endif
                </div>

                <div>
                    <label class="block text-lg font-semibold text-gray-700 mb-2">📱 Phone Number *</label>
                    <input type="tel" wire:model.live="customerPhone" wire:blur="searchCustomer"
                        placeholder="0501234567" pattern="[0-9]*" inputmode="numeric"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                        class="w-full rounded-xl border-2 border-gray-300 px-6 py-4 text-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200" />
                    @if($this->selectedCustomer)
                        <p class="mt-2 text-base font-medium text-green-600">✓ Existing: {{ $this->selectedCustomer->name }}
                        </p>
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
            <div
                class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-6 mb-6 border-2 border-dashed border-purple-300">
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
                        <input type="number" wire:model.live="quantity" min="1"
                            class="w-full rounded-lg border-2 border-gray-300 px-4 py-3 text-base text-center font-bold focus:border-purple-500" />
                    </div>

                    <div>
                        <label class="block text-base font-semibold text-gray-700 mb-2">Price (AED)</label>
                        <input type="number" wire:model.live="price" step="0.01" min="0"
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
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-sm font-bold
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
                                    <p class="text-lg font-bold text-purple-600">{{ number_format($item['subtotal'], 2) }}
                                        AED</p>
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

    {{-- Step 3: Notes & Discount (Optional) --}}
    <div class="max-w-6xl mx-auto mb-6">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">📝 Step 3: Additional Details (Optional)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-lg font-semibold text-gray-700 mb-2">Special Notes</label>
                    <textarea wire:model="notes" rows="4"
                        placeholder="Any special instructions? (e.g., Extra starch, no hangers, etc.)"
                        class="w-full rounded-xl border-2 border-gray-300 px-6 py-4 text-base focus:border-purple-500 focus:ring-2 focus:ring-purple-200"></textarea>
                </div>
                <div>
                    <label class="block text-lg font-semibold text-gray-700 mb-2">💰 Discount (Optional)</label>
                    <input type="number" wire:model.live="discount" step="0.01" min="0"
                        placeholder="Enter discount amount in AED"
                        class="w-full rounded-xl border-2 border-gray-300 px-6 py-4 text-lg font-semibold text-green-600 focus:border-green-500 focus:ring-2 focus:ring-green-200" />
                    <p class="mt-2 text-sm text-gray-600">
                        <span class="inline-block">Maximum discount available:
                            <strong>{{ number_format(array_sum(array_column($items, 'subtotal')), 2) }}
                                AED</strong></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Total & Submit --}}
    <div class="max-w-6xl mx-auto">
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl shadow-2xl p-8">
            <div class="flex items-center justify-between gap-8">
                <div>
                    {{-- Subtotal --}}
                    <div class="mb-4">
                        <p class="text-white text-sm opacity-75">Subtotal</p>
                        <p class="text-white text-2xl font-bold">
                            {{ number_format(array_sum(array_column($items, 'subtotal')), 2) }} <span
                                class="text-lg">AED</span>
                        </p>
                    </div>

                    {{-- Discount (if any) --}}
                    @if($discount > 0)
                        <div class="mb-4 pb-4 border-b border-white border-opacity-30">
                            <p class="text-white text-sm opacity-75">Discount</p>
                            <p class="text-green-300 text-lg font-bold">
                                -{{ number_format($discount, 2) }} <span class="text-sm">AED</span>
                            </p>
                        </div>
                    @endif

                    {{-- Total Amount --}}
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
                💡 <strong>Tip:</strong> Select payment method after clicking Create Order button.
            </p>
        </div>
    </div>

    {{-- Payment Selection Modal --}}
    @if($showPaymentModal)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-75 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-4xl p-8">
                {{-- Header --}}
                <div class="text-center mb-8">
                    <div class="inline-block p-4 bg-purple-100 rounded-full mb-4">
                        <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">💳 Select Payment Method</h2>
                    <p class="text-lg text-gray-600">Choose how the customer will pay</p>
                    <div class="mt-4 inline-block bg-purple-50 rounded-lg px-6 py-3">
                        <div class="text-center">
                            @if($discount > 0)
                                <p class="text-sm text-gray-600 mb-1">Subtotal:
                                    {{ number_format(array_sum(array_column($items, 'subtotal')), 2) }} QAR | Discount:
                                    -{{ number_format($discount, 2) }} QAR
                                </p>
                            @endif
                            <p class="text-purple-900 text-2xl font-bold">
                                Total: {{ number_format($this->totalAmount, 2) }} QAR
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Payment Options --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    {{-- Card Payment --}}
                    <button type="button" wire:click="processOrderWithPayment('card')"
                        class="group bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 border-4 border-blue-300 hover:border-blue-500 rounded-2xl p-8 transition-all transform hover:scale-105 hover:shadow-2xl">
                        <div class="text-center">
                            <div
                                class="inline-block p-4 bg-blue-500 rounded-full mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-blue-900 mb-2">💳 Card</h3>
                            <p class="text-blue-700 text-sm mb-4">Payment via Card</p>
                            <div class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full inline-block">
                                ✓ PAID
                            </div>
                        </div>
                    </button>

                    {{-- Cash Payment --}}
                    <button type="button" wire:click="processOrderWithPayment('cash')"
                        class="group bg-gradient-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 border-4 border-green-300 hover:border-green-500 rounded-2xl p-8 transition-all transform hover:scale-105 hover:shadow-2xl">
                        <div class="text-center">
                            <div
                                class="inline-block p-4 bg-green-500 rounded-full mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-green-900 mb-2">💵 Cash</h3>
                            <p class="text-green-700 text-sm mb-4">Payment via Cash</p>
                            <div class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full inline-block">
                                ✓ PAID
                            </div>
                        </div>
                    </button>

                    {{-- Due Payment --}}
                    <button type="button" wire:click="processOrderWithPayment('due')"
                        class="group bg-gradient-to-br from-red-50 to-red-100 hover:from-red-100 hover:to-red-200 border-4 border-red-300 hover:border-red-500 rounded-2xl p-8 transition-all transform hover:scale-105 hover:shadow-2xl">
                        <div class="text-center">
                            <div
                                class="inline-block p-4 bg-red-500 rounded-full mb-4 group-hover:scale-110 transition-transform">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-red-900 mb-2">⏰ Due</h3>
                            <p class="text-red-700 text-sm mb-4">Pay on Delivery</p>
                            <div
                                class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full inline-block">
                                ⏳ PENDING
                            </div>
                        </div>
                    </button>
                </div>

                {{-- Cancel Button --}}
                <div class="text-center">
                    <button type="button" wire:click="$set('showPaymentModal', false)"
                        class="px-8 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-xl font-semibold transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>