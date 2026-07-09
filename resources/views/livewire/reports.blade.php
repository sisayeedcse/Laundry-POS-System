<div wire:poll.10s class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
    {{-- Header Section --}}
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    Reports & Analytics
                </h1>
                <p class="mt-2 text-gray-600">{{ $this->getReportTitle() }}</p>
            </div>
        </div>
    </div>

    {{-- Report Type & Date Filters --}}
    <div class="mb-6 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
            <h3 class="font-semibold text-gray-900">Report Filters</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Report Type Buttons --}}
            <div class="md:col-span-4">
                <label class="block text-xs font-medium text-gray-700 mb-2">Report Period</label>
                <div class="flex gap-2 flex-wrap">
                    <button wire:click="$set('reportType', 'daily')"
                        class="px-4 py-2 rounded-lg font-medium text-sm transition-all {{ $reportType === 'daily' ? 'bg-purple-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        📅 Daily
                    </button>
                    <button wire:click="$set('reportType', 'weekly')"
                        class="px-4 py-2 rounded-lg font-medium text-sm transition-all {{ $reportType === 'weekly' ? 'bg-purple-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        📆 Weekly
                    </button>
                    <button wire:click="$set('reportType', 'monthly')"
                        class="px-4 py-2 rounded-lg font-medium text-sm transition-all {{ $reportType === 'monthly' ? 'bg-purple-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        📊 Monthly
                    </button>
                    <button wire:click="$set('reportType', 'custom')"
                        class="px-4 py-2 rounded-lg font-medium text-sm transition-all {{ $reportType === 'custom' ? 'bg-purple-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        🔧 Custom Range
                    </button>
                </div>
            </div>

            {{-- Date Selection --}}
            @if($reportType === 'custom')
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">From Date</label>
                    <input type="date" wire:model.live="dateFrom"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 text-sm" />
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">To Date</label>
                    <input type="date" wire:model.live="dateTo"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 text-sm" />
                </div>
            @else
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-700 mb-1.5">Select Date</label>
                    <input type="date" wire:model.live="selectedDate"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500 text-sm" />
                </div>
            @endif
        </div>
    </div>

    {{-- Sales Overview Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Orders</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $this->salesData['total_orders'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Total Revenue</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ number_format((float) $this->salesData['total_revenue'], 2) }} <span
                            class="text-lg text-gray-600">QAR</span>
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Paid Orders</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $this->salesData['paid_orders'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Pending Payment</p>
                    <p class="text-3xl font-bold text-orange-600 mt-2">{{ $this->salesData['pending_orders'] }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide">Delivered</p>
                    <p class="text-3xl font-bold text-cyan-600 mt-2">{{ $this->salesData['delivered_orders'] }}</p>
                </div>
                <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Payment Method Comparison --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">Cash Payments</h3>
                    <p class="text-xs text-gray-500">💵 Cash transactions</p>
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <div class="flex items-baseline justify-between mb-2">
                        <span class="text-sm font-medium text-gray-600">Total Amount</span>
                        <span
                            class="text-3xl font-bold text-emerald-600">{{ number_format((float) $this->paymentMethodData['cash_amount'], 2) }}
                            <span class="text-sm text-gray-600">QAR</span></span>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline justify-between">
                        <span class="text-sm font-medium text-gray-600">Number of Orders</span>
                        <span
                            class="text-2xl font-bold text-gray-900">{{ $this->paymentMethodData['cash_count'] }}</span>
                    </div>
                </div>
                @if($this->paymentMethodData['cash_count'] > 0)
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex items-baseline justify-between">
                            <span class="text-xs font-medium text-gray-500">Average per Order</span>
                            <span
                                class="text-lg font-semibold text-emerald-600">{{ number_format((float) $this->paymentMethodData['cash_amount'] / $this->paymentMethodData['cash_count'], 2) }}
                                QAR</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-lg">Card Payments</h3>
                    <p class="text-xs text-gray-500">💳 Card transactions</p>
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <div class="flex items-baseline justify-between mb-2">
                        <span class="text-sm font-medium text-gray-600">Total Amount</span>
                        <span
                            class="text-3xl font-bold text-indigo-600">{{ number_format((float) $this->paymentMethodData['card_amount'], 2) }}
                            <span class="text-sm text-gray-600">QAR</span></span>
                    </div>
                </div>
                <div>
                    <div class="flex items-baseline justify-between">
                        <span class="text-sm font-medium text-gray-600">Number of Orders</span>
                        <span
                            class="text-2xl font-bold text-gray-900">{{ $this->paymentMethodData['card_count'] }}</span>
                    </div>
                </div>
                @if($this->paymentMethodData['card_count'] > 0)
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex items-baseline justify-between">
                            <span class="text-xs font-medium text-gray-500">Average per Order</span>
                            <span
                                class="text-lg font-semibold text-indigo-600">{{ number_format((float) $this->paymentMethodData['card_amount'] / $this->paymentMethodData['card_count'], 2) }}
                                QAR</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Delivered Orders & All Orders --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Delivered Orders --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <h3 class="font-bold text-gray-900">Delivered Orders</h3>
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                    {{ $this->deliveredOrders->total() }}
                </span>
            </div>
            <div class="space-y-3">
                @forelse($this->deliveredOrders as $order)
                    <div
                        class="flex items-center justify-between p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="flex-1">
                            <p class="font-semibold text-green-700 text-sm">{{ $order->order_number }}</p>
                            <p class="text-xs text-gray-600">{{ $order->customer->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900 text-sm">{{ number_format((float) $order->total_amount, 2) }}
                                QAR</p>
                            <p class="text-xs text-gray-500">{{ $order->delivered_at->format('d M, h:i A') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-sm">No delivered orders yet</p>
                    </div>
                @endforelse
            </div>
            @if($this->deliveredOrders->hasPages())
                <div class="mt-6 pt-4 border-t border-gray-100">
                    {{ $this->deliveredOrders->links() }}
                </div>
            @endif
        </div>

        {{-- All Orders --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="font-bold text-gray-900">All Orders</h3>
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                    {{ $this->allOrders->total() }}
                </span>
            </div>
            <div class="space-y-3">
                @forelse($this->allOrders as $order)
                    <div
                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <p class="font-semibold text-purple-600 text-sm">{{ $order->order_number }}</p>
                            <p class="text-xs text-gray-600">{{ $order->customer->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900 text-sm">{{ number_format((float) $order->total_amount, 2) }}
                                QAR</p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->format('d M, h:i A') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-sm">No orders found</p>
                    </div>
                @endforelse
            </div>
            @if($this->allOrders->hasPages())
                <div class="mt-6 pt-4 border-t border-gray-100">
                    {{ $this->allOrders->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- ===== PRINT RECEIPTS BY DATE ===== --}}
    <div class="mt-4 bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

        {{-- Section Header --}}
        <div class="bg-purple-600 px-6 py-5 flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Print Receipts by Date</h2>
                    <p class="text-white text-xs mt-0.5">Select a date and filter to preview and print all receipts at once</p>
                </div>
            </div>

            {{-- Print All button --}}
            @if($this->receiptsForDate->total() > 0)
                <a href="{{ $this->getBulkPrintUrl() }}"
                   target="_blank"
                   id="btn-bulk-print"
                   class="inline-flex items-center gap-2 bg-white text-purple-700 font-semibold text-sm px-5 py-2.5 rounded-xl shadow hover:bg-purple-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print All {{ $this->receiptsForDate->total() }} Receipt{{ $this->receiptsForDate->total() === 1 ? '' : 's' }}
                </a>
            @endif
        </div>

        <div class="p-6">

            {{-- Controls row: date picker + filter tabs --}}
            <div class="flex flex-wrap items-end gap-4 mb-6">

                {{-- Date picker --}}
                <div class="flex-1 min-w-[180px] max-w-xs">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Select Date</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="date"
                               wire:model.live="receiptDate"
                               id="receipt-date-picker"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 text-sm transition-all" />
                    </div>
                </div>

                {{-- Filter tabs --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5 uppercase tracking-wide">Payment Status</label>
                    <div class="flex gap-1.5 bg-gray-100 p-1 rounded-xl">
                        <button wire:click="$set('receiptFilter', 'all')"
                            class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all {{ $receiptFilter === 'all' ? 'bg-white text-purple-700 shadow-sm font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                            All
                        </button>
                        <button wire:click="$set('receiptFilter', 'paid')"
                            class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all {{ $receiptFilter === 'paid' ? 'bg-white text-emerald-700 shadow-sm font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                            Paid
                        </button>
                        <button wire:click="$set('receiptFilter', 'pending')"
                            class="px-4 py-1.5 rounded-lg text-sm font-medium transition-all {{ $receiptFilter === 'pending' ? 'bg-white text-amber-700 shadow-sm font-semibold' : 'text-gray-600 hover:text-gray-900' }}">
                            Unpaid
                        </button>
                    </div>
                </div>

                {{-- Result count badge --}}
                <div class="ml-auto self-center">
                    @if($this->receiptsForDate->total() > 0)
                        <span class="inline-flex items-center gap-1.5 bg-purple-100 text-purple-800 text-sm font-semibold px-3 py-1.5 rounded-full">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                            {{ $this->receiptsForDate->total() }} order{{ $this->receiptsForDate->total() === 1 ? '' : 's' }}
                        </span>
                    @endif
                </div>
            </div>

            {{-- Receipt Table --}}
            @if($this->receiptsForDate->total() > 0)
                <div class="overflow-x-auto rounded-xl border border-gray-200">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="px-4 py-3 text-left font-semibold text-gray-600 text-xs uppercase tracking-wide">Order #</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600 text-xs uppercase tracking-wide">Customer</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-600 text-xs uppercase tracking-wide hidden sm:table-cell">Time</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-600 text-xs uppercase tracking-wide">Amount</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-600 text-xs uppercase tracking-wide">Status</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-600 text-xs uppercase tracking-wide">Print</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($this->receiptsForDate as $order)
                                <tr class="hover:bg-purple-50/40 transition-colors">
                                    <td class="px-4 py-3">
                                        <span class="font-bold text-purple-700">{{ $order->order_number }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-gray-900">{{ $order->customer->name }}</div>
                                        @if($order->customer->phone)
                                            <div class="text-xs text-gray-500">{{ $order->customer->phone }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-500 text-xs hidden sm:table-cell">
                                        {{ $order->created_at->format('h:i A') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-gray-900">
                                        {{ number_format((float) $order->total_amount, 2) }}
                                        <span class="font-normal text-xs text-gray-500">QAR</span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($order->payment_status === 'paid')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                ✓ Paid
                                            </span>
                                        @elseif($order->payment_status === 'partial')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                ⬤ Partial
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                                ⏳ Pending
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('orders.receipt.print', $order) }}"
                                           target="_blank"
                                           title="Print receipt for {{ $order->order_number }}"
                                           class="inline-flex items-center gap-1 text-xs font-semibold text-purple-600 hover:text-purple-800 bg-purple-100 hover:bg-purple-200 px-3 py-1.5 rounded-lg transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                            Print
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($this->receiptsForDate->hasPages())
                    <div class="mt-5 pt-4 border-t border-gray-100">
                        {{ $this->receiptsForDate->links() }}
                    </div>
                @endif

                {{-- Summary footer strip --}}
                <div class="mt-4 bg-purple-50 rounded-xl px-5 py-3 flex flex-wrap gap-4 items-center justify-between">
                    <div class="flex items-center gap-5 text-sm">
                        <span class="text-gray-600">
                            <span class="font-semibold text-gray-900">{{ $this->receiptsForDate->total() }}</span> order{{ $this->receiptsForDate->total() === 1 ? '' : 's' }}
                        </span>
                        <span class="text-gray-400">·</span>
                        <span class="text-gray-600">
                            Total: <span class="font-bold text-gray-900">
                                {{ number_format($this->receiptsForDate->getCollection()->sum(fn($o) => (float)$o->total_amount), 2) }} QAR
                            </span>
                            <span class="text-xs text-gray-500">(this page)</span>
                        </span>
                    </div>
                    <a href="{{ $this->getBulkPrintUrl() }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold text-sm px-5 py-2 rounded-xl transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        🖨️ Print All {{ $this->receiptsForDate->total() }} Receipts
                    </a>
                </div>

            @else
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-lg font-semibold text-gray-700">No orders found</p>
                    <p class="text-sm text-gray-500 mt-1">
                        There are no
                        @if($receiptFilter !== 'all') <span class="font-medium">{{ $receiptFilter }}</span> @endif
                        orders for <span class="font-medium">{{ \Carbon\Carbon::parse($receiptDate)->format('d M Y') }}</span>.
                    </p>
                    <p class="text-xs text-gray-400 mt-3">Try selecting a different date or switching the payment filter.</p>
                </div>
            @endif

        </div>
    </div>

</div>