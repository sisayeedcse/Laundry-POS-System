<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    {{-- Header Section --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z" />
                        </svg>
                    </div>
                    Due Payments
                </h1>
                <p class="mt-2 text-gray-600">Track and manage all pending customer payments</p>
            </div>
        </div>
    </div>

    {{-- Stats Cards - Minimal Design --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        {{-- Total Due --}}
        <div class="bg-white rounded-lg border-l-4 border-red-500 p-5 shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Total Due Amount</p>
            <p class="text-3xl font-bold text-red-600">{{ number_format($this->dueStats['total_due'], 2) }}</p>
            <p class="text-sm text-gray-600 mt-1">QAR</p>
        </div>

        {{-- Customers --}}
        <div class="bg-white rounded-lg border-l-4 border-purple-500 p-5 shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Customers</p>
            <p class="text-3xl font-bold text-gray-900">{{ $this->dueStats['total_customers'] }}</p>
            <p class="text-sm text-gray-600 mt-1">with due</p>
        </div>

        {{-- Total Orders --}}
        <div class="bg-white rounded-lg border-l-4 border-orange-500 p-5 shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Total Orders</p>
            <p class="text-3xl font-bold text-gray-900">{{ $this->dueStats['total_orders'] }}</p>
            <p class="text-sm text-gray-600 mt-1">unpaid</p>
        </div>

        {{-- Pending --}}
        <div class="bg-white rounded-lg border-l-4 border-yellow-500 p-5 shadow-sm">
            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Pending</p>
            <p class="text-3xl font-bold text-gray-900">{{ $this->dueStats['pending_orders'] }}</p>
            <p class="text-sm text-gray-600 mt-1">not paid</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6 shadow-sm">
        <h3 class="text-sm font-semibold text-gray-700 mb-4">Filter & Sort</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Search --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-2">Search Customer</label>
                <input type="text" wire:model.live.debounce.300ms="dueSearch" placeholder="Name or phone..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm" />
            </div>

            {{-- Sort --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-2">Sort By</label>
                <select wire:model.live="dueSortBy"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm">
                    <option value="amount_desc">Highest Due First</option>
                    <option value="amount_asc">Lowest Due First</option>
                    <option value="name_asc">Name (A-Z)</option>
                    <option value="name_desc">Name (Z-A)</option>
                    <option value="orders_desc">Most Orders</option>
                </select>
            </div>

            {{-- Payment Status --}}
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-2">Payment Status</label>
                <select wire:model.live="duePaymentStatus"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm">
                    <option value="all">All Status</option>
                    <option value="pending">Pending Only</option>
                    <option value="partial">Partial Only</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Due Payments List --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">
        <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-sm font-semibold text-gray-700">Customers with Due Payments</h3>
            <p class="text-xs text-gray-500 mt-1">{{ $this->duePayments->count() }} customer(s) found</p>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($this->duePayments as $customer)
                <div class="p-5">
                    {{-- Customer Header --}}
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="text-base font-semibold text-gray-900">{{ $customer->name }}</h4>
                                <div class="flex items-center gap-3 text-xs text-gray-500 mt-1">
                                    <span>📞 {{ $customer->phone }}</span>
                                    <span>•</span>
                                    <span>{{ $customer->due_orders_count }} order(s)</span>
                                    @if($customer->is_regular)
                                        <span
                                            class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded font-medium">Regular</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Total Due --}}
                        <div class="text-right">
                            <p class="text-xs text-gray-500 mb-1">Total Due</p>
                            <p class="text-2xl font-bold text-red-600">{{ number_format($customer->total_due, 2) }} <span
                                    class="text-sm text-gray-600">QAR</span></p>
                        </div>
                    </div>

                    {{-- Orders List --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 mt-4">
                        @foreach($customer->orders as $order)
                            <div class="border border-gray-200 rounded-lg p-3 bg-gray-50">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <p class="text-sm font-semibold text-purple-600">{{ $order->order_number }}</p>
                                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                                    </div>
                                    <span
                                        class="px-2 py-1 text-xs rounded font-medium
                                                {{ $order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                                <div class="space-y-1 text-xs border-t border-gray-200 pt-2 mt-2">
                                    <div class="flex justify-between text-gray-600">
                                        <span>Total:</span>
                                        <span class="font-medium">{{ number_format((float) $order->total_amount, 2) }}
                                            QAR</span>
                                    </div>
                                    @if($order->advance_payment > 0)
                                        <div class="flex justify-between text-gray-600">
                                            <span>Paid:</span>
                                            <span
                                                class="font-medium text-green-600">{{ number_format((float) $order->advance_payment, 2) }}
                                                QAR</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between font-semibold text-gray-900 pt-1 border-t border-gray-200">
                                        <span>Due:</span>
                                        <span class="text-red-600">{{ number_format($order->due_balance, 2) }} QAR</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 mb-1">No Due Payments Found</h3>
                    <p class="text-sm text-gray-600">
                        @if(!empty($dueSearch) || $duePaymentStatus !== 'all')
                            No customers match your filter criteria.
                        @else
                            All customers have cleared their payments.
                        @endif
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>