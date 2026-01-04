<div>
    @if($showModal)
        <!-- Modal Overlay -->
        <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ open: true }" x-show="open"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <!-- Background Overlay -->
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

            <!-- Modal Content -->
            <div class="flex min-h-screen items-center justify-center p-4">
                <div class="relative w-full max-w-5xl bg-white rounded-2xl shadow-2xl transform transition-all"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    @click.away="$wire.closeModal()">

                    <!-- Header -->
                    <div
                        class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-indigo-50">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Order Details</h2>
                            <p class="text-sm text-gray-600 mt-1">Order #{{ $this->order->order_number }}</p>
                        </div>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="px-6 py-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                        <!-- Flash Messages -->
                        @if (session()->has('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session()->has('error'))
                            <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-lg">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Left Column: Order Info & Customer -->
                            <div class="lg:col-span-2 space-y-6">
                                <!-- Order Information -->
                                <div class="bg-white border border-gray-200 rounded-lg p-5">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Order Information
                                    </h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Order Number</p>
                                            <p class="text-base font-semibold text-gray-900">
                                                {{ $this->order->order_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Order Date</p>
                                            <p class="text-base font-semibold text-gray-900">
                                                {{ $this->order->created_at->format('d M Y, h:i A') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Delivery Date</p>
                                            <p class="text-base font-semibold text-gray-900">
                                                {{ \Carbon\Carbon::parse($this->order->delivery_date)->format('d M Y') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Payment Method</p>
                                            <p class="text-base font-semibold text-gray-900 capitalize">
                                                {{ str_replace('_', ' ', $this->order->payment_method) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Status</p>
                                            <span
                                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $this->getStatusColor($this->order->status) }}">
                                                {{ ucfirst($this->order->status) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Payment Status</p>
                                            <span
                                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $this->getPaymentStatusColor($this->order->payment_status) }}">
                                                {{ ucfirst($this->order->payment_status) }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($this->order->notes)
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <p class="text-sm text-gray-500">Notes</p>
                                            <p class="text-base text-gray-900 mt-1">{{ $this->order->notes }}</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Customer Information -->
                                <div class="bg-white border border-gray-200 rounded-lg p-5">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Customer Information
                                    </h3>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm text-gray-500">Name</p>
                                                <p class="text-base font-semibold text-gray-900">
                                                    {{ $this->order->customer->name }}</p>
                                            </div>
                                        </div>
                                        @if($this->order->customer->phone)
                                            <div class="flex items-center">
                                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                <div>
                                                    <p class="text-sm text-gray-500">Phone</p>
                                                    <p class="text-base font-semibold text-gray-900">
                                                        {{ $this->order->customer->phone }}</p>
                                                </div>
                                            </div>
                                        @endif
                                        @if($this->order->customer->address)
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-gray-400 mr-3 mt-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <div>
                                                    <p class="text-sm text-gray-500">Address</p>
                                                    <p class="text-base text-gray-900">{{ $this->order->customer->address }}</p>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="flex items-center pt-3 border-t border-gray-200">
                                            <span class="text-sm text-gray-500">Total Orders:</span>
                                            <span
                                                class="ml-2 font-semibold text-gray-900">{{ $this->order->customer->total_orders }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Items -->
                                <div class="bg-white border border-gray-200 rounded-lg p-5">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        Order Items
                                    </h3>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th
                                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                        Service</th>
                                                    <th
                                                        class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                        Type</th>
                                                    <th
                                                        class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                        Qty</th>
                                                    <th
                                                        class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                                        Price</th>
                                                    <th
                                                        class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                                        Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($this->order->orderItems as $item)
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $item->service->name }}
                                                        </td>
                                                        <td class="px-4 py-3 text-center">
                                                            <span
                                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded {{ $item->service_type === 'urgent' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                                                {{ ucfirst($item->service_type) }}
                                                            </span>
                                                        </td>
                                                        <td class="px-4 py-3 text-center text-sm text-gray-900">
                                                            {{ $item->quantity }}</td>
                                                        <td class="px-4 py-3 text-right text-sm text-gray-900">QAR
                                                            {{ number_format($item->unit_price, 2) }}</td>
                                                        <td class="px-4 py-3 text-right text-sm font-semibold text-gray-900">QAR
                                                            {{ number_format($item->subtotal, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Summary & Actions -->
                            <div class="space-y-6">
                                <!-- Order Summary -->
                                <div
                                    class="bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-200 rounded-lg p-5">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                                    <div class="space-y-3">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Subtotal</span>
                                            <span class="font-semibold text-gray-900">QAR
                                                {{ number_format($this->order->orderItems->sum('subtotal'), 2) }}</span>
                                        </div>
                                        @if($this->order->discount > 0)
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Discount</span>
                                                <span class="font-semibold text-red-600">- QAR
                                                    {{ number_format($this->order->discount, 2) }}</span>
                                            </div>
                                        @endif
                                        @if($this->order->tax > 0)
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">Tax</span>
                                                <span class="font-semibold text-gray-900">QAR
                                                    {{ number_format($this->order->tax, 2) }}</span>
                                            </div>
                                        @endif
                                        <div class="pt-3 border-t border-purple-200">
                                            <div class="flex justify-between">
                                                <span class="text-base font-semibold text-gray-900">Total Amount</span>
                                                <span class="text-lg font-bold text-purple-600">AED
                                                    {{ number_format($this->order->total_amount, 2) }}</span>
                                            </div>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">Payment Method</span>
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold
                                                        @if($this->order->payment_method === 'cash') bg-emerald-100 text-emerald-800
                                                        @else bg-indigo-100 text-indigo-800
                                                        @endif">
                                                @if($this->order->payment_method === 'cash')
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                                    </svg>
                                                @endif
                                                {{ strtoupper($this->order->payment_method) }}
                                            </span>
                                        </div>
                                        <div class="pt-3 border-t border-purple-200">
                                            <div class="flex justify-between">
                                                <span class="text-base font-semibold text-gray-900">Payment Status</span>
                                                <span class="text-lg font-bold text-green-600">
                                                    PAID
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Workflow -->
                                @if($this->order->status !== 'delivered')
                                    <div class="bg-white border border-gray-200 rounded-lg p-5">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h3>
                                        <div class="space-y-2">
                                            @php
                                                $nextStatus = $this->getNextStatus($this->order->status);
                                            @endphp
                                            @if($nextStatus)
                                                <button wire:click="updateStatus('{{ $nextStatus }}')"
                                                    class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                                    Move to {{ ucfirst($nextStatus) }}
                                                </button>
                                            @endif
                                        </div>

                                        <!-- Status Timeline -->
                                        <div class="mt-6 pt-6 border-t border-gray-200">
                                            <p class="text-sm font-medium text-gray-700 mb-3">Status Progress</p>
                                            <div class="space-y-2">
                                                @foreach(['pending', 'processing', 'ready', 'delivered'] as $status)
                                                    <div class="flex items-center">
                                                        @if($this->order->status === $status)
                                                            <div class="w-3 h-3 bg-purple-600 rounded-full"></div>
                                                            <span
                                                                class="ml-3 text-sm font-semibold text-purple-600">{{ ucfirst($status) }}</span>
                                                        @elseif(array_search($status, ['pending', 'processing', 'ready', 'delivered']) < array_search($this->order->status, ['pending', 'processing', 'ready', 'delivered']))
                                                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                                            <span class="ml-3 text-sm text-gray-500">{{ ucfirst($status) }}</span>
                                                        @else
                                                            <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                                                            <span class="ml-3 text-sm text-gray-400">{{ ucfirst($status) }}</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Payment History -->
                                @if($this->order->payments->count() > 0)
                                    <div class="bg-white border border-gray-200 rounded-lg p-5">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment History</h3>
                                        <div class="space-y-3">
                                            @foreach($this->order->payments as $payment)
                                                <div
                                                    class="flex justify-between items-start py-2 border-b border-gray-100 last:border-0">
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-900">QAR
                                                            {{ number_format($payment->amount, 2) }}</p>
                                                        <p class="text-xs text-gray-500 mt-1">
                                                            {{ $payment->payment_date->format('d M Y') }}</p>
                                                        <p class="text-xs text-gray-400 capitalize">
                                                            {{ str_replace('_', ' ', $payment->payment_method) }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="bg-white border border-gray-200 rounded-lg p-5">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                                    <div class="space-y-2">
                                        <a href="{{ route('orders.receipt.print', $this->order->id) }}" target="_blank"
                                            class="w-full bg-white hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg border border-gray-300 transition-colors flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            Print Receipt
                                        </a>
                                        <a href="{{ route('orders.receipt.download', $this->order->id) }}"
                                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Download PDF
                                        </a>
                                        @if($this->order->due_balance > 0)
                                            <button wire:click="openPaymentModal"
                                                class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Record Payment
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-end px-6 py-4 border-t border-gray-200 bg-gray-50 space-x-3">
                        <button wire:click="closeModal"
                            class="px-5 py-2 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-lg border border-gray-300 transition-colors">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Record Payment Modal --}}
    @if($showPaymentModal)
        @livewire('orders.record-payment', ['orderId' => $orderId])
    @endif
</div>