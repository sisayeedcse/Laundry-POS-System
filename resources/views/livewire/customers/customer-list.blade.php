<div class="min-h-screen bg-gray-50 p-4">
    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="mb-4 rounded-xl bg-green-50 border-l-4 border-green-500 p-4 text-green-800">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 rounded-xl bg-red-50 border-l-4 border-red-500 p-4 text-red-800">
            {{ session('error') }}
        </div>
    @endif

    {{-- Simple Header --}}
    <div class="mb-6 text-center">
        <h1 class="text-4xl font-bold text-purple-600">👥 Customers</h1>
        <p class="mt-2 text-lg text-gray-600">Manage your customer database</p>
    </div>

    {{-- Search & Filter Card --}}
    <div class="max-w-7xl mx-auto mb-6">
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Search by name or phone number..."
                            class="w-full rounded-xl border-2 border-gray-300 pl-12 pr-4 py-3 text-base focus:border-purple-500 focus:ring-2 focus:ring-purple-200" />
                    </div>
                </div>
                <div>
                    <select wire:model.live="statusFilter"
                        class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-base focus:border-purple-500 focus:ring-2 focus:ring-purple-200">
                        <option value="all">🔍 All Customers</option>
                        <option value="active">✅ Active Only</option>
                        <option value="inactive">❌ Inactive Only</option>
                        <option value="regular">⭐ Regular Customers</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    <strong>{{ $this->customers->total() }}</strong> customer(s) found
                </p>
                <button wire:click="openCreateModal"
                    class="rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-3 text-base font-bold text-white hover:from-purple-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transform hover:scale-105 transition-all">
                    ➕ Add New Customer
                </button>
            </div>
        </div>
    </div>

    {{-- Customers List Layout --}}
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            @forelse ($this->customers as $customer)
                <div class="border-b border-gray-200 hover:bg-purple-50 transition-colors duration-150">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            {{-- Left: Avatar + Info --}}
                            <div class="flex items-center space-x-6 flex-1">
                                {{-- Avatar --}}
                                <div class="relative flex-shrink-0">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center shadow-lg">
                                        <span class="text-2xl font-bold text-white">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    @if ($customer->isRegular)
                                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center border-2 border-white" title="Regular Customer">
                                            <span class="text-xs">⭐</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Customer Details --}}
                                <div class="flex-1 min-w-0">
                                    {{-- Name & Status --}}
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-xl font-bold text-gray-900 truncate">{{ $customer->name }}</h3>
                                        @if ($customer->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-300">
                                                ✓ Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800 border border-gray-300">
                                                ✗ Inactive
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Contact Info Grid --}}
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        {{-- Phone --}}
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs text-gray-500">Phone</p>
                                                <p class="text-sm font-semibold text-gray-900">{{ $customer->phone }}</p>
                                            </div>
                                        </div>

                                        {{-- Address --}}
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs text-gray-500">Address</p>
                                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $customer->address ?? 'No address' }}</p>
                                            </div>
                                        </div>

                                        {{-- Total Orders --}}
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs text-gray-500">Orders</p>
                                                <p class="text-sm font-bold text-purple-600">{{ $customer->total_orders }} orders</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Right: Actions --}}
                            <div class="flex items-center space-x-2 ml-6">
                                <button wire:click="viewCustomer({{ $customer->id }})"
                                    class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold text-sm transition-colors shadow-md hover:shadow-lg flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span>View</span>
                                </button>

                                <button wire:click="toggleStatus({{ $customer->id }})"
                                    class="p-2.5 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-lg transition-colors" 
                                    title="Toggle Status">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                </button>

                                <button wire:click="deleteCustomer({{ $customer->id }})"
                                    wire:confirm="Are you sure you want to delete this customer?"
                                    class="p-2.5 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors" 
                                    title="Delete Customer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="p-12 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">No Customers Found</h3>
                        <p class="text-gray-600 mb-6">Get started by adding your first customer to the system</p>
                        <button wire:click="openCreateModal"
                            class="rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-4 text-lg font-bold text-white hover:from-purple-700 hover:to-indigo-700 shadow-lg">
                            ➕ Add First Customer
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($this->customers->hasPages())
            <div class="mt-6 bg-white rounded-2xl shadow-lg p-6">
                {{ $this->customers->links() }}
            </div>
        @endif
    </div>

    {{-- Create Customer Modal --}}
    @if ($showCreateModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-gray-900 bg-opacity-50 p-4">
            <div class="w-full max-w-lg">
                <livewire:customers.create-customer />
            </div>
        </div>
    @endif

    {{-- Customer Details Modal --}}
    @if($showDetailsModal && $selectedCustomerId > 0)
        @livewire('customers.customer-details', ['customerId' => $selectedCustomerId], key('customer-details-' . $selectedCustomerId . '-' . now()->timestamp))
    @endif

    {{-- Edit Customer Modal --}}
    @livewire('customers.edit-customer')
</div>