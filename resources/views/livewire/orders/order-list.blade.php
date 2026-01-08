<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="mb-6 rounded-xl bg-green-50 border-l-4 border-green-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 rounded-xl bg-red-50 border-l-4 border-red-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-red-800 font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('info'))
        <div class="mb-6 rounded-xl bg-blue-50 border-l-4 border-blue-500 p-4 shadow-sm animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-blue-800 font-medium">{{ session('info') }}</span>
            </div>
        </div>
    @endif

    {{-- Header Section --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    Orders Management
                </h1>
                <p class="mt-2 text-gray-600">Track and manage all laundry orders</p>
            </div>
            <a href="/pos"
                class="group flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="font-semibold">New Order</span>
            </a>
        </div>
    </div>

    {{-- Filters Card --}}
    <div class="mb-6 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            <h3 class="font-semibold text-gray-900">Filter Orders</h3>
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-6">
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-gray-700 mb-1.5">Search</label>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Order #, customer name..."
                        class="w-full rounded-lg border-gray-300 pl-10 focus:border-purple-500 focus:ring-purple-500 text-sm" />
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">Order Status</label>
                <select wire:model.live="statusFilter"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 text-sm">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="ready">Ready</option>
                    <option value="delivered">Delivered</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">Payment</label>
                <select wire:model.live="paymentFilter"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 text-sm">
                    <option value="all">All Payments</option>
                    <option value="pending">Unpaid</option>
                    <option value="partial">Partial</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">From Date</label>
                <input type="date" wire:model.live="dateFrom"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 text-sm" />
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1.5">To Date</label>
                <input type="date" wire:model.live="dateTo"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 text-sm" />
            </div>
        </div>

        @if($search || $statusFilter !== 'all' || $paymentFilter !== 'all' || $dateFrom || $dateTo)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <button wire:click="clearFilters"
                    class="flex items-center gap-2 text-sm text-purple-600 hover:text-purple-700 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Clear All Filters
                </button>
            </div>
        @endif
    </div>

    {{-- Orders List - Card Layout --}}
    <div class="space-y-4">
        @forelse ($this->orders as $order)
            <div wire:key="order-{{ $order->id }}"
                class="bg-white rounded-2xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200">
                <div class="p-6">
                    {{-- Order Header --}}
                    <div class="flex items-start justify-between mb-4 pb-4 border-b border-gray-100">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-purple-600">{{ $order->order_number }}</h3>
                                <p class="text-sm text-gray-500 mt-0.5">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button wire:click="viewOrder({{ $order->id }})"
                                class="px-4 py-2 text-sm font-medium text-purple-600 hover:bg-purple-50 rounded-lg transition-colors border border-purple-200 hover:border-purple-300">
                                View Details
                            </button>
                            @if($order->status !== 'delivered')
                                <button wire:click="deleteOrder({{ $order->id }})"
                                    wire:confirm="Are you sure you want to delete this order?"
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>

                    {{-- Order Details Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        {{-- Customer Info --}}
                        <div class="space-y-1">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Customer</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $order->customer->name }}</p>
                            <p class="text-xs text-gray-600">{{ $order->customer->phone }}</p>
                            @if($order->notes)
                                <p class="text-xs text-gray-500 mt-2 italic">📝 {{ $order->notes }}</p>
                            @endif
                        </div>

                        {{-- Items & Total --}}
                        <div class="space-y-1">
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Order Details</p>
                            <p class="text-sm text-gray-900">{{ $order->items->count() }} item(s)</p>
                            <p class="text-lg font-bold text-gray-900">{{ number_format($order->total_amount, 2) }} <span
                                    class="text-sm text-gray-600">AED</span></p>
                        </div>

                        {{-- Status & Payment --}}
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Order Status</p>
                                <select wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                                    wire:key="status-{{ $order->id }}" class="w-full rounded-lg border-0 text-xs font-semibold cursor-pointer focus:ring-2 focus:ring-purple-500 px-3 py-2
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'ready') bg-purple-100 text-purple-800
                                            @else bg-green-100 text-green-800 @endif">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ Pending
                                    </option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>🔄
                                        Processing</option>
                                    <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>✅ Ready</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>🚚
                                        Delivered</option>
                                </select>
                            </div>
                        </div>

                        {{-- Payment & Delivery --}}
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Payment</p>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                @if($order->payment_status === 'pending') bg-red-100 text-red-800
                                                @elseif($order->payment_status === 'partial') bg-orange-100 text-orange-800
                                                @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                    @if($order->payment_method)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                                            @if($order->payment_method === 'cash') bg-emerald-100 text-emerald-800
                                                            @else bg-indigo-100 text-indigo-800 @endif">
                                            @if($order->payment_method === 'cash')
                                                💵
                                            @else
                                                💳
                                            @endif
                                            {{ strtoupper($order->payment_method) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Delivery Date</p>
                                <p class="text-sm font-medium text-gray-900 mt-1">
                                    {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Inline Payment Method Selection for Delivered Orders --}}
                    @if($order->status === 'delivered' && $order->payment_status !== 'paid' && $pendingOrderId === $order->id)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-5 border border-purple-200">
                                <div class="flex items-start gap-4">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-base font-semibold text-gray-900 mb-1">Complete Payment</h4>
                                        <p class="text-sm text-gray-600 mb-4">Select the payment method used by the customer</p>

                                        <div class="grid grid-cols-2 gap-3">
                                            {{-- Cash Payment Button --}}
                                            <button wire:click="completePayment({{ $order->id }}, 'cash')"
                                                class="group relative flex items-center justify-center gap-3 p-4 bg-white border-2 border-emerald-300 rounded-xl hover:border-emerald-500 hover:bg-emerald-50 transition-all duration-200 shadow-sm hover:shadow-md">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                        </svg>
                                                    </div>
                                                    <div class="text-left">
                                                        <p
                                                            class="text-base font-bold text-gray-900 group-hover:text-emerald-900">
                                                            Cash</p>
                                                        <p class="text-xs text-gray-600 group-hover:text-emerald-700">Paid in
                                                            cash</p>
                                                    </div>
                                                </div>
                                            </button>

                                            {{-- Card Payment Button --}}
                                            <button wire:click="completePayment({{ $order->id }}, 'card')"
                                                class="group relative flex items-center justify-center gap-3 p-4 bg-white border-2 border-indigo-300 rounded-xl hover:border-indigo-500 hover:bg-indigo-50 transition-all duration-200 shadow-sm hover:shadow-md">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center group-hover:bg-indigo-200 transition-colors">
                                                        <svg class="w-7 h-7 text-indigo-600" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                        </svg>
                                                    </div>
                                                    <div class="text-left">
                                                        <p
                                                            class="text-base font-bold text-gray-900 group-hover:text-indigo-900">
                                                            Card</p>
                                                        <p class="text-xs text-gray-600 group-hover:text-indigo-700">Paid by
                                                            card</p>
                                                    </div>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-12">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No Orders Found</h3>
                        <p class="text-gray-600 mb-6">Start creating orders from the POS system</p>
                        <a href="/pos"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors font-medium">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Go to POS
                        </a>
                    </div>
                </div>
        @endforelse
        </div>

        {{-- Pagination --}}
        @if($this->orders->hasPages())
            <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-200 p-4">
                {{ $this->orders->links() }}
            </div>
        @endif

        {{-- Order Details Modal --}}
        @if($showDetailsModal && $selectedOrderId)
            <div wire:key="order-details-{{ $selectedOrderId }}">
                @livewire('orders.order-details', ['orderId' => $selectedOrderId], key('order-details-' . $selectedOrderId))
            </div>
        @endif
    </div>