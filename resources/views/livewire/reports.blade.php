<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-6">
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
                        {{ number_format($this->salesData['total_revenue'], 2) }} <span
                            class="text-lg text-gray-600">AED</span></p>
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
                            class="text-3xl font-bold text-emerald-600">{{ number_format($this->paymentMethodData['cash_amount'], 2) }}
                            <span class="text-sm text-gray-600">AED</span></span>
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
                                class="text-lg font-semibold text-emerald-600">{{ number_format($this->paymentMethodData['cash_amount'] / $this->paymentMethodData['cash_count'], 2) }}
                                AED</span>
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
                            class="text-3xl font-bold text-indigo-600">{{ number_format($this->paymentMethodData['card_amount'], 2) }}
                            <span class="text-sm text-gray-600">AED</span></span>
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
                                class="text-lg font-semibold text-indigo-600">{{ number_format($this->paymentMethodData['card_amount'] / $this->paymentMethodData['card_count'], 2) }}
                                AED</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Top Services & Recent Orders --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Top Services --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                <h3 class="font-bold text-gray-900">Top Services</h3>
            </div>
            <div class="space-y-3">
                @forelse($this->topServices as $service)
                    <div
                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900 text-sm">{{ $service->name }}</p>
                            <p class="text-xs text-gray-600">{{ $service->total_quantity }} items</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-purple-600">{{ number_format($service->total_revenue, 2) }} AED</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <p class="text-sm">No services data</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="font-bold text-gray-900">Recent Orders</h3>
            </div>
            <div class="space-y-3">
                @forelse($this->recentOrders as $order)
                    <div
                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <div class="flex-1">
                            <p class="font-semibold text-purple-600 text-sm">{{ $order->order_number }}</p>
                            <p class="text-xs text-gray-600">{{ $order->customer->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900 text-sm">{{ number_format($order->total_amount, 2) }} AED</p>
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
        </div>
    </div>
</div>