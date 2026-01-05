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

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Orders</h1>
            <p class="mt-1 text-sm text-gray-600">Manage all laundry orders</p>
        </div>
        <a href="/pos" class="rounded-lg bg-purple-600 px-4 py-2 text-white hover:bg-purple-700">
            + New Order
        </a>
    </div>

    {{-- Filters --}}
    <div class="mb-6 rounded-lg bg-white p-4 shadow">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-6">
            <div class="md:col-span-2">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by order #, customer..."
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500" />
            </div>
            <div>
                <select wire:model.live="statusFilter"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="ready">Ready</option>
                    <option value="delivered">Delivered</option>
                </select>
            </div>
            <div>
                <select wire:model.live="paymentFilter"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    <option value="all">All Payments</option>
                    <option value="pending">Unpaid</option>
                    <option value="partial">Partial</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <div>
                <input type="date" wire:model.live="dateFrom"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                    placeholder="From" />
            </div>
            <div>
                <input type="date" wire:model.live="dateTo"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                    placeholder="To" />
            </div>
        </div>
        @if($search || $statusFilter !== 'all' || $paymentFilter !== 'all' || $dateFrom || $dateTo)
            <button wire:click="clearFilters" class="mt-3 text-sm text-purple-600 hover:text-purple-700">
                Clear Filters
            </button>
        @endif
    </div>

    {{-- Orders Table --}}
    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Order #
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Customer
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Items
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Total
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Payment
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Method
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Delivery
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($this->orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-semibold text-purple-600">{{ $order->order_number }}</div>
                                <div class="text-xs text-gray-500">{{ $order->created_at->format('d M Y, h:i A') }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ $order->customer->name }}</div>
                                <div class="text-xs text-gray-500">{{ $order->customer->phone }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $order->items->count() }} item(s)</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-semibold text-gray-900">{{ number_format($order->total_amount, 2) }}
                                    AED</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <select wire:change="updateStatus({{ $order->id }}, $event.target.value)"
                                    wire:key="status-{{ $order->id }}" class="rounded-full border-0 text-xs font-semibold cursor-pointer focus:ring-2 focus:ring-purple-500
                                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                                    @elseif($order->status === 'ready') bg-purple-100 text-purple-800
                                                    @else bg-green-100 text-green-800
                                                    @endif">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>
                                        Processing</option>
                                    <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered
                                    </option>
                                </select>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold
                                                @if($order->payment_status === 'pending') bg-red-100 text-red-800
                                                @elseif($order->payment_status === 'partial') bg-orange-100 text-orange-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold
                                                @if($order->payment_method === 'cash') bg-emerald-100 text-emerald-800
                                                @else bg-indigo-100 text-indigo-800
                                                @endif">
                                    @if($order->payment_method === 'cash')
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    @else
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    @endif
                                    {{ strtoupper($order->payment_method) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($order->delivery_date)->format('d M Y') }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="viewOrder({{ $order->id }})"
                                        class="text-purple-600 hover:text-purple-900" title="View Details">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    @if($order->status !== 'delivered')
                                        <button wire:click="deleteOrder({{ $order->id }})"
                                            wire:confirm="Are you sure you want to delete this order?"
                                            class="text-red-600 hover:text-red-900" title="Delete">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="mb-4 h-16 w-16 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-lg font-semibold text-gray-900">No orders found</p>
                                    <p class="mt-1 text-sm text-gray-500">Start creating orders from the POS</p>
                                    <a href="/pos"
                                        class="mt-4 rounded-lg bg-purple-600 px-4 py-2 text-white hover:bg-purple-700">
                                        Go to POS
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="border-t border-gray-200 px-6 py-4">
            {{ $this->orders->links() }}
        </div>
    </div>

    {{-- Order Details Modal --}}
    @if($showDetailsModal && $selectedOrderId)
        @livewire('orders.order-details', ['orderId' => $selectedOrderId])
    @endif
</div>