<div class="p-6">
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

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        {{-- Left Section: Services Grid --}}
        <div class="lg:col-span-2">
            <div class="rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 p-4">
                    <h2 class="text-xl font-bold text-gray-900">Services</h2>

                    {{-- Search & Filter --}}
                    <div class="mt-4 flex flex-col gap-4 sm:flex-row">
                        <input type="text" wire:model.live="search" placeholder="Search services..."
                            class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" />

                        <select wire:model.live="selectedCategory"
                            class="rounded-lg border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="all">All Categories</option>
                            @foreach ($this->categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Services List --}}
                <div class="divide-y divide-gray-100 p-4">
                    @forelse ($this->services as $service)
                        <div
                            class="group flex items-center gap-4 py-3 px-4 rounded-lg transition-all hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 hover:shadow-sm">
                            {{-- Service Icon --}}
                            <div class="flex-shrink-0">
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center shadow-sm group-hover:shadow-md transition-shadow">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                    </svg>
                                </div>
                            </div>

                            {{-- Service Details --}}
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-gray-900 truncate group-hover:text-purple-700 transition-colors">
                                    {{ $service->name }}
                                </h3>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        {{ $service->category }}
                                    </span>
                                    @if($service->size_variant)
                                        <span class="text-xs text-gray-500">• {{ $service->size_variant }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Pricing & Actions --}}
                            <div class="flex items-center gap-3">
                                {{-- Wash & Iron Price --}}
                                <div class="text-right">
                                    <div class="text-xs text-gray-500 font-medium">Wash & Iron</div>
                                    <div class="text-lg font-bold text-purple-600">{{ $service->price_wash_iron }} <span class="text-sm">AED</span></div>
                                </div>
                                <button wire:click="addToCart({{ $service->id }}, 'wash_iron')"
                                    class="flex items-center gap-2 px-4 py-2.5 rounded-lg bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-medium hover:from-purple-700 hover:to-indigo-700 shadow-sm hover:shadow-md transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add
                                </button>

                                @if($service->price_iron_only)
                                    {{-- Iron Only Price --}}
                                    <div class="text-right ml-2">
                                        <div class="text-xs text-gray-500 font-medium">Iron Only</div>
                                        <div class="text-lg font-bold text-green-600">{{ $service->price_iron_only }} <span class="text-sm">AED</span></div>
                                    </div>
                                    <button wire:click="addToCart({{ $service->id }}, 'iron_only')"
                                        class="flex items-center gap-2 px-4 py-2.5 rounded-lg bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium hover:from-green-700 hover:to-emerald-700 shadow-sm hover:shadow-md transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Add
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-gray-500">
                            No services found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Right Section: Cart & Billing --}}
        <div class="lg:col-span-1">
            <div class="rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 p-4">
                    <h2 class="text-xl font-bold text-gray-900">Current Order</h2>
                </div>

                {{-- Customer Selection --}}
                <div class="border-b border-gray-200 p-4">
                    <div class="mb-2 flex items-center justify-between">
                        <label class="text-sm font-medium text-gray-700">Customer</label>
                        <button wire:click="openCustomerModal" class="text-sm text-purple-600 hover:text-purple-700">
                            + New
                        </button>
                    </div>

                    @if ($this->selectedCustomer)
                        <div class="rounded-lg bg-purple-50 p-3">
                            <p class="font-semibold text-gray-900">{{ $this->selectedCustomer->name }}</p>
                            <p class="text-sm text-gray-600">{{ $this->selectedCustomer->phone }}</p>
                            <button wire:click="selectCustomer(null)"
                                class="mt-2 text-xs text-purple-600 hover:text-purple-700">
                                Change Customer
                            </button>
                        </div>
                    @else
                        <button wire:click="openCustomerModal"
                            class="w-full rounded-lg border-2 border-dashed border-gray-300 p-4 text-center text-gray-500 hover:border-purple-500 hover:text-purple-600">
                            Select or Create Customer
                        </button>
                    @endif
                </div>

                {{-- Cart Items --}}
                <div class="max-h-64 overflow-y-auto border-b border-gray-200 p-4">
                    @if (count($cart) > 0)
                        @foreach ($cart as $key => $item)
                            <div class="mb-3 rounded-lg border border-gray-200 p-3">
                                <div class="mb-2 flex items-start justify-between">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $item['service_name'] }}</h4>
                                        <p class="text-xs text-gray-500">
                                            @if ($item['service_type'] === 'wash_iron')
                                                <span class="text-purple-600">Wash & Iron</span>
                                            @else
                                                <span class="text-green-600">Iron Only</span>
                                            @endif
                                        </p>
                                    </div>
                                    <button wire:click="removeFromCart('{{ $key }}')" class="text-red-600 hover:text-red-700">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})"
                                            class="rounded bg-gray-200 px-2 py-1 text-sm hover:bg-gray-300">
                                            -
                                        </button>
                                        <span class="w-8 text-center font-semibold">{{ $item['quantity'] }}</span>
                                        <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})"
                                            class="rounded bg-gray-200 px-2 py-1 text-sm hover:bg-gray-300">
                                            +
                                        </button>
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ number_format($item['subtotal'], 2) }}
                                        QAR</span>
                                </div>
                            </div>
                        @endforeach

                        <button wire:click="clearCart"
                            class="mt-2 w-full rounded-lg border border-red-300 bg-red-50 px-3 py-2 text-sm text-red-600 hover:bg-red-100">
                            Clear Cart
                        </button>
                    @else
                        <div class="py-8 text-center text-gray-400">
                            <svg class="mx-auto mb-2 h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <p class="text-sm">Cart is empty</p>
                        </div>
                    @endif
                </div>

                {{-- Billing Summary --}}
                <div class="space-y-3 p-4">
                    {{-- Subtotal --}}
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-semibold text-gray-900">{{ number_format($this->subtotal, 2) }} QAR</span>
                    </div>

                    {{-- Discount --}}
                    <div class="flex items-center justify-between">
                        <label class="text-sm text-gray-600">Discount:</label>
                        <input type="number" wire:model.live="discount" min="0" step="0.01"
                            class="w-28 rounded border-gray-300 px-2 py-1 text-right text-sm focus:border-purple-500 focus:ring-purple-500" />
                    </div>

                    {{-- Tax --}}
                    <div class="flex items-center justify-between">
                        <label class="text-sm text-gray-600">Tax:</label>
                        <input type="number" wire:model.live="tax" min="0" step="0.01"
                            class="w-28 rounded border-gray-300 px-2 py-1 text-right text-sm focus:border-purple-500 focus:ring-purple-500" />
                    </div>

                    {{-- Total --}}
                    <div class="flex justify-between border-t pt-2 text-lg font-bold">
                        <span class="text-gray-900">Total to Pay:</span>
                        <span class="text-purple-600">{{ number_format($this->total, 2) }} AED</span>
                    </div>

                    {{-- Payment Method --}}
                    <div>
                        <label class="mb-1 block text-sm text-gray-600">Payment Method:</label>
                        <select wire:model="paymentMethod"
                            class="w-full rounded border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                        </select>
                    </div>

                    {{-- Delivery Date --}}
                    <div>
                        <label class="mb-1 block text-sm text-gray-600">Delivery Date:</label>
                        <input type="date" wire:model="deliveryDate" min="{{ date('Y-m-d') }}"
                            class="w-full rounded border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500" />
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label class="mb-1 block text-sm text-gray-600">Notes (Optional):</label>
                        <textarea wire:model="notes" rows="2" placeholder="Special instructions..."
                            class="w-full rounded border-gray-300 text-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                    </div>

                    {{-- Create Order Button --}}
                    <button wire:click="createOrder"
                        class="w-full rounded-lg bg-purple-600 px-4 py-3 font-semibold text-white hover:bg-purple-700 disabled:cursor-not-allowed disabled:opacity-50"
                        @disabled(count($cart) === 0 || !$selectedCustomerId)>
                        Create Order
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Customer Modal --}}
    @if ($showCustomerModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-gray-900 bg-opacity-50 p-4">
            <div class="w-full max-w-md rounded-lg bg-white shadow-xl">
                <div class="flex items-center justify-between border-b p-4">
                    <h3 class="text-lg font-bold text-gray-900">Customer Selection</h3>
                    <button wire:click="closeCustomerModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-4">
                    {{-- Quick Add Customer Form --}}
                    <form wire:submit.prevent="createCustomer" class="space-y-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Name *</label>
                            <input type="text" wire:model="customerName" required
                                class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500" />
                            @error('customerName')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Phone *</label>
                            <input type="text" wire:model="customerPhone" required
                                class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500" />
                            @error('customerPhone')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Address (Optional)</label>
                            <textarea wire:model="customerAddress" rows="2"
                                class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"></textarea>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit"
                                class="flex-1 rounded-lg bg-purple-600 px-4 py-2 text-white hover:bg-purple-700">
                                Create & Select
                            </button>
                            <button type="button" wire:click="closeCustomerModal"
                                class="rounded-lg border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-50">
                                Cancel
                            </button>
                        </div>
                    </form>

                    {{-- Or Select Existing --}}
                    <div class="mt-6 border-t pt-4">
                        <p class="mb-2 text-sm font-medium text-gray-700">Or select existing customer:</p>
                        <div class="max-h-48 space-y-2 overflow-y-auto">
                            @foreach (App\Models\Customer::active()->latest()->limit(10)->get() as $customer)
                                <button wire:click="selectCustomer({{ $customer->id }})"
                                    class="w-full rounded-lg border border-gray-200 p-3 text-left hover:border-purple-500 hover:bg-purple-50 transition-colors">
                                    <p class="font-semibold text-gray-900">{{ $customer->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $customer->phone }}</p>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>