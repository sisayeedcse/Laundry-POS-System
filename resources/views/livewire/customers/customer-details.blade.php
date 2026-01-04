<div>
    @if($showModal)
        <div x-data="{ show: @entangle('showModal') }" x-show="show" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="$wire.closeModal()"></div>

                <!-- Modal panel -->
                <div x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-6xl sm:w-full">

                    <!-- Header -->
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-full bg-white/20 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-white" id="modal-title">
                                        {{ $this->customer->name }}
                                    </h3>
                                    <p class="text-purple-100 text-sm">Customer Details & Order History</p>
                                </div>
                            </div>
                            <button type="button" @click="$wire.closeModal()"
                                class="rounded-md text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white p-2">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="px-6 py-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                            <!-- Customer Information -->
                            <div class="lg:col-span-1">
                                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h4>

                                    <div class="space-y-4">
                                        <div>
                                            <div class="flex items-center text-gray-500 text-sm mb-1">
                                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                Phone
                                            </div>
                                            <p class="text-gray-900 font-medium">{{ $this->customer->phone }}</p>
                                        </div>

                                        @if($this->customer->email)
                                            <div>
                                                <div class="flex items-center text-gray-500 text-sm mb-1">
                                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    Email
                                                </div>
                                                <p class="text-gray-900">{{ $this->customer->email }}</p>
                                            </div>
                                        @endif

                                        @if($this->customer->address)
                                            <div>
                                                <div class="flex items-center text-gray-500 text-sm mb-1">
                                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    Address
                                                </div>
                                                <p class="text-gray-900">{{ $this->customer->address }}</p>
                                            </div>
                                        @endif

                                        <div>
                                            <div class="flex items-center text-gray-500 text-sm mb-1">
                                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Status
                                            </div>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->customer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($this->customer->status) }}
                                            </span>
                                        </div>

                                        <div>
                                            <div class="flex items-center text-gray-500 text-sm mb-1">
                                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                Customer Since
                                            </div>
                                            <p class="text-gray-900">{{ $this->customer->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>

                                    <!-- Edit Button -->
                                    <div class="mt-6">
                                        <button type="button"
                                            wire:click="$dispatch('edit-customer', { customerId: {{ $this->customer->id }} })"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-purple-600 text-sm font-medium rounded-md text-purple-600 bg-white hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit Customer
                                        </button>
                                    </div>
                                </div>

                                <!-- Statistics Cards -->
                                <div class="mt-6 grid grid-cols-2 gap-4">
                                    <div
                                        class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                                        <div class="text-blue-600 text-xs font-medium mb-1">Total Orders</div>
                                        <div class="text-2xl font-bold text-blue-900">
                                            {{ $this->statistics['total_orders'] }}</div>
                                    </div>
                                    <div
                                        class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                                        <div class="text-green-600 text-xs font-medium mb-1">Completed</div>
                                        <div class="text-2xl font-bold text-green-900">
                                            {{ $this->statistics['completed_orders'] }}</div>
                                    </div>
                                    <div
                                        class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                                        <div class="text-purple-600 text-xs font-medium mb-1">Total Spent</div>
                                        <div class="text-lg font-bold text-purple-900">
                                            {{ number_format($this->statistics['total_spent'], 2) }} QAR</div>
                                    </div>
                                    <div
                                        class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border border-orange-200">
                                        <div class="text-orange-600 text-xs font-medium mb-1">Pending</div>
                                        <div class="text-lg font-bold text-orange-900">
                                            {{ number_format($this->statistics['total_pending'], 2) }} QAR</div>
                                    </div>
                                </div>

                                @if($this->statistics['last_order_date'])
                                    <div class="mt-4 bg-gray-50 rounded-lg p-4 border border-gray-200">
                                        <div class="text-gray-500 text-xs font-medium mb-1">Last Order</div>
                                        <div class="text-gray-900 font-medium">
                                            {{ $this->statistics['last_order_date']->diffForHumans() }}</div>
                                        <div class="text-gray-500 text-sm">
                                            {{ $this->statistics['last_order_date']->format('M d, Y h:i A') }}</div>
                                    </div>
                                @endif
                            </div>

                            <!-- Order History -->
                            <div class="lg:col-span-2">
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <h4 class="text-lg font-semibold text-gray-900">Order History</h4>
                                        <p class="text-sm text-gray-500 mt-1">All orders from this customer</p>
                                    </div>

                                    <div class="overflow-x-auto">
                                        @if($this->customer->orders->count() > 0)
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Order #</th>
                                                        <th
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Date</th>
                                                        <th
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Items</th>
                                                        <th
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Amount</th>
                                                        <th
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Status</th>
                                                        <th
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Payment</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach($this->customer->orders->sortByDesc('created_at') as $order)
                                                        <tr class="hover:bg-gray-50">
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm font-medium text-purple-600">
                                                                    #{{ $order->order_number }}</div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm text-gray-900">
                                                                    {{ $order->created_at->format('M d, Y') }}</div>
                                                                <div class="text-xs text-gray-500">
                                                                    {{ $order->created_at->format('h:i A') }}</div>
                                                            </td>
                                                            <td class="px-6 py-4">
                                                                <div class="text-sm text-gray-900">
                                                                    {{ $order->orderItems->count() }} item(s)
                                                                </div>
                                                                <div class="text-xs text-gray-500">
                                                                    {{ $order->orderItems->pluck('service.name')->take(2)->join(', ') }}
                                                                    @if($order->orderItems->count() > 2)
                                                                        <span>+{{ $order->orderItems->count() - 2 }} more</span>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm font-semibold text-gray-900">
                                                                    {{ number_format($order->total_amount, 2) }} AED</div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <span
                                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusColor($order->status) }}">
                                                                    {{ ucfirst($order->status) }}
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <span
                                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getPaymentStatusColor($order->payment_status) }}">
                                                                    {{ ucfirst($order->payment_status) }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="px-6 py-12 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <p class="mt-2 text-sm text-gray-500">No orders yet</p>
                                                <p class="text-xs text-gray-400">This customer hasn't placed any orders</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Average Order Value -->
                                @if($this->statistics['total_orders'] > 0)
                                    <div
                                        class="mt-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-4 border border-indigo-200">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="text-indigo-600 text-sm font-medium mb-1">Average Order Value</div>
                                                <div class="text-2xl font-bold text-indigo-900">
                                                    {{ number_format($this->statistics['average_order_value'], 2) }} QAR</div>
                                            </div>
                                            <div class="bg-indigo-100 rounded-full p-3">
                                                <svg class="h-8 w-8 text-indigo-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3 border-t border-gray-200">
                        <button type="button" wire:click="closeModal"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>