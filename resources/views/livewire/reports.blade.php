<div class="p-6">
    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Reports & Analytics</h1>
        <p class="mt-1 text-sm text-gray-600">Comprehensive business insights and performance metrics</p>
    </div>

    {{-- Filters --}}
    <div class="mb-6 bg-white rounded-lg shadow-sm p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
                <select wire:model.live="dateRange"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    <option value="today">Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="this_week">This Week</option>
                    <option value="last_week">Last Week</option>
                    <option value="this_month">This Month</option>
                    <option value="last_month">Last Month</option>
                    <option value="this_year">This Year</option>
                </select>
            </div>
            <div class="md:col-span-2 flex items-end justify-between">
                <div class="text-sm text-gray-600">
                    <span class="font-medium">Showing data from:</span>
                    <span class="text-purple-600">{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}</span>
                    <span class="text-gray-400">to</span>
                    <span class="text-purple-600">{{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</span>
                </div>
                <button wire:click="exportPDF"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export PDF
                </button>
            </div>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="mb-6 bg-white rounded-lg shadow-sm">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px overflow-x-auto" aria-label="Tabs">
                <button wire:click="switchTab('sales')"
                    class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors whitespace-nowrap {{ $activeTab === 'sales' ? 'border-purple-600 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    Sales Report
                </button>
                <button wire:click="switchTab('payments')"
                    class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors whitespace-nowrap {{ $activeTab === 'payments' ? 'border-purple-600 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Payments
                </button>
                <button wire:click="switchTab('services')"
                    class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors whitespace-nowrap {{ $activeTab === 'services' ? 'border-purple-600 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Services
                </button>
                <button wire:click="switchTab('customers')"
                    class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors whitespace-nowrap {{ $activeTab === 'customers' ? 'border-purple-600 text-purple-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Customers
                </button>
            </nav>
        </div>
    </div>

    {{-- Sales Report Tab --}}
    @if($activeTab === 'sales')
        <div>
            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-sm p-6 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Total Orders</p>
                            <p class="text-3xl font-bold text-blue-900 mt-2">{{ $this->salesStats['total_orders'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-blue-600 mt-2">
                        {{ $this->salesStats['completed_orders'] }} completed
                    </p>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-sm p-6 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">Total Revenue</p>
                            <p class="text-3xl font-bold text-green-900 mt-2">
                                {{ number_format($this->salesStats['total_revenue'], 2) }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-green-600 mt-2">QAR</p>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-sm p-6 border border-purple-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600">Paid Amount</p>
                            <p class="text-3xl font-bold text-purple-900 mt-2">
                                {{ number_format($this->salesStats['paid_amount'], 2) }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-purple-600 mt-2">QAR</p>
                </div>

                <div
                    class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-lg shadow-sm p-6 border border-teal-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-teal-600">Total Services</p>
                            <p class="text-3xl font-bold text-teal-900 mt-2">
                                {{ number_format($this->salesStats['total_items'], 0) }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-teal-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-teal-600 mt-2">Items processed</p>
                </div>
            </div>

            {{-- Daily Sales Chart --}}
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Daily Sales Trend</h3>
                <canvas id="dailySalesChart" height="80"></canvas>
            </div>

            {{-- Order Status and Payment Method Breakdown --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Status Distribution</h3>
                    <canvas id="orderStatusChart"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Methods</h3>
                    <div class="space-y-3 mt-4">
                        @foreach($this->paymentMethods as $method)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $method->payment_method === 'cash' ? 'bg-emerald-100' : 'bg-indigo-100' }}">
                                        <svg class="w-5 h-5 {{ $method->payment_method === 'cash' ? 'text-emerald-600' : 'text-indigo-600' }}"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            @if($method->payment_method === 'cash')
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            @endif
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <div class="font-semibold text-gray-900">{{ strtoupper($method->payment_method) }}</div>
                                        <div class="text-xs text-gray-500">{{ $method->count }} orders</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-gray-900">{{ number_format($method->total, 2) }} AED</div>
                                    <div class="text-xs text-gray-500">
                                        {{ round(($method->total / $this->paymentMethods->sum('total')) * 100, 1) }}%
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Average Order Value --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Average Order Value</h3>
                <div class="text-center py-8">
                    <div class="text-5xl font-bold text-purple-600">
                        {{ number_format($this->salesStats['average_order_value'], 2) }}
                    </div>
                    <div class="text-gray-500 mt-2">AED per order</div>
                    <div class="mt-6 grid grid-cols-3 gap-4">
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-yellow-600">{{ $this->salesStats['pending_orders'] }}
                            </div>
                            <div class="text-xs text-yellow-600 mt-1">Pending</div>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-blue-600">{{ $this->salesStats['processing_orders'] }}
                            </div>
                            <div class="text-xs text-blue-600 mt-1">Processing</div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <div class="text-2xl font-bold text-green-600">{{ $this->salesStats['completed_orders'] }}
                            </div>
                            <div class="text-xs text-green-600 mt-1">Completed</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Payment Methods Tab --}}
    @if($activeTab === 'payments')
        {{-- Payment Counts Summary --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            @php
                $cashPayments = $this->paymentMethods->firstWhere('payment_method', 'cash');
                $cardPayments = $this->paymentMethods->firstWhere('payment_method', 'card');
            @endphp
            
            {{-- Cash Payments Card --}}
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium mb-1">Cash Payments</p>
                        <h3 class="text-3xl font-bold">{{ $cashPayments ? $cashPayments->count : 0 }}</h3>
                        <p class="text-emerald-100 text-sm mt-2">
                            {{ $cashPayments ? number_format($cashPayments->total, 2) : '0.00' }} AED
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Card Payments Card --}}
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-100 text-sm font-medium mb-1">Card Payments</p>
                        <h3 class="text-3xl font-bold">{{ $cardPayments ? $cardPayments->count : 0 }}</h3>
                        <p class="text-indigo-100 text-sm mt-2">
                            {{ $cardPayments ? number_format($cardPayments->total, 2) : '0.00' }} AED
                        </p>
                    </div>
                    <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payment Method Details --}}
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Method Details</h3>
            <div class="space-y-4">
                @foreach($this->paymentMethods as $method)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 rounded-full flex items-center justify-center {{ $method->payment_method === 'cash' ? 'bg-green-100' : ($method->payment_method === 'card' ? 'bg-blue-100' : 'bg-purple-100') }}">
                                <svg class="w-5 h-5 {{ $method->payment_method === 'cash' ? 'text-green-600' : ($method->payment_method === 'card' ? 'text-blue-600' : 'text-purple-600') }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($method->payment_method === 'cash')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    @endif
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">{{ ucfirst($method->payment_method) }}</div>
                                <div class="text-sm text-gray-500">{{ $method->count }} transactions</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-gray-900">{{ number_format($method->total, 2) }} AED</div>
                            <div class="text-sm text-gray-500">
                                {{ round(($method->total / $this->paymentMethods->sum('total')) * 100, 1) }}%
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Service Performance Tab --}}
    @if($activeTab === 'services')
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Service Performance Rankings</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rank
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Service Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Orders
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity Sold
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Revenue
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($this->servicePerformance as $index => $service)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($index < 3)
                                            <span
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : ($index === 1 ? 'bg-gray-200 text-gray-700' : 'bg-orange-100 text-orange-700') }} font-bold text-sm">
                                                {{ $index + 1 }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 font-medium">{{ $index + 1 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ $service->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $service->order_count }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $service->total_quantity }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-green-600">
                                        {{ number_format($service->total_revenue, 2) }} QAR
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Customer Analytics Tab --}}
    @if($activeTab === 'customers')
        <div>
            {{-- Customer Statistics --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div
                    class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg shadow-sm p-6 border border-indigo-200">
                    <div class="text-sm font-medium text-indigo-600">New Customers</div>
                    <div class="text-3xl font-bold text-indigo-900 mt-2">{{ $this->customerStats['new_customers'] }}
                    </div>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-sm p-6 border border-blue-200">
                    <div class="text-sm font-medium text-blue-600">Total Customers</div>
                    <div class="text-3xl font-bold text-blue-900 mt-2">{{ $this->customerStats['total_customers'] }}
                    </div>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-sm p-6 border border-green-200">
                    <div class="text-sm font-medium text-green-600">Active Customers</div>
                    <div class="text-3xl font-bold text-green-900 mt-2">{{ $this->customerStats['active_customers'] }}
                    </div>
                </div>
                <div
                    class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-sm p-6 border border-purple-200">
                    <div class="text-sm font-medium text-purple-600">Retention Rate</div>
                    <div class="text-3xl font-bold text-purple-900 mt-2">
                        {{ $this->customerStats['retention_rate'] }}%
                    </div>
                </div>
            </div>

            {{-- Top Customers --}}
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Top 10 Customers by Revenue</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rank
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Customer
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Orders
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total Spent
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($this->topCustomers as $index => $customer)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($index < 3)
                                            <span
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $index === 0 ? 'bg-yellow-100 text-yellow-800' : ($index === 1 ? 'bg-gray-200 text-gray-700' : 'bg-orange-100 text-orange-700') }} font-bold text-sm">
                                                {{ $index + 1 }}
                                            </span>
                                        @else
                                            <span class="text-gray-500 font-medium">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-semibold">
                                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">{{ $customer->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $customer->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $customer->orders_count }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-green-600">
                                            {{ number_format($customer->orders_sum_total_amount ?? 0, 2) }} QAR
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- Expense Analytics Tab --}}
    @if($activeTab === 'expenses')
        <div>
            {{-- Export Button --}}
            <div class="mb-4 flex justify-end">
                <button wire:click="exportExpensePDF"
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Expense Report
                </button>
            </div>

            {{-- Expense Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg shadow-sm p-6 border border-red-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-600">Total Expenses</p>
                            <p class="text-3xl font-bold text-red-900 mt-2">
                                {{ number_format($this->expenseStats['total_expenses'], 2) }}</p>
                            <p class="text-xs text-red-600 mt-1">QAR</p>
                        </div>
                        <div class="w-12 h-12 bg-red-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg shadow-sm p-6 border border-orange-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-orange-600">Transactions</p>
                            <p class="text-3xl font-bold text-orange-900 mt-2">
                                {{ $this->expenseStats['expense_count'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-sm p-6 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Average Expense</p>
                            <p class="text-3xl font-bold text-blue-900 mt-2">
                                {{ number_format($this->expenseStats['average_expense'], 2) }}</p>
                            <p class="text-xs text-blue-600 mt-1">QAR</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-sm p-6 border border-purple-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600">Largest Expense</p>
                            <p class="text-3xl font-bold text-purple-900 mt-2">
                                {{ number_format($this->expenseStats['largest_expense'], 2) }}</p>
                            <p class="text-xs text-purple-600 mt-1">QAR</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Expense Trends</h3>
                    <canvas id="expenseTrendsChart" height="250"></canvas>
                </div>

                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Expense by Category</h3>
                    <canvas id="expenseCategoryChart" height="250"></canvas>
                </div>
            </div>

            {{-- Category Breakdown Table --}}
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Category Breakdown</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Transactions</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total
                                    Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">% of Total
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($this->expenseByCategory as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $category->category === 'rent' ? 'bg-red-100 text-red-800' : ($category->category === 'utilities' ? 'bg-blue-100 text-blue-800' : ($category->category === 'salaries' ? 'bg-purple-100 text-purple-800' : ($category->category === 'supplies' ? 'bg-green-100 text-green-800' : ($category->category === 'maintenance' ? 'bg-orange-100 text-orange-800' : ($category->category === 'marketing' ? 'bg-pink-100 text-pink-800' : ($category->category === 'transportation' ? 'bg-cyan-100 text-cyan-800' : 'bg-gray-100 text-gray-800')))))) }}">
                                            {{ ucfirst($category->category) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $category->count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        {{ number_format($category->total, 2) }} QAR</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $this->expenseStats['total_expenses'] > 0 ? number_format(($category->total / $this->expenseStats['total_expenses']) * 100, 1) : 0 }}%
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Top Expenses Table --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Top 10 Expenses</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($this->topExpenses as $expense)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($expense->expense_date)->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $expense->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ ucfirst($expense->category) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-right">
                                        {{ number_format($expense->amount, 2) }} QAR</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- Profit & Loss Tab --}}
    @if($activeTab === 'profitloss')
        <div>
            {{-- Export Button --}}
            <div class="mb-4 flex justify-end">
                <button wire:click="exportProfitLossPDF"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export P&L Report
                </button>
            </div>

            {{-- Profit & Loss Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div
                    class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-sm p-6 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">Total Revenue</p>
                            <p class="text-3xl font-bold text-green-900 mt-2">
                                {{ number_format($this->profitLossAnalysis['total_revenue'], 2) }}</p>
                            <p class="text-xs text-green-600 mt-1">QAR</p>
                        </div>
                        <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg shadow-sm p-6 border border-red-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-600">Total Expenses</p>
                            <p class="text-3xl font-bold text-red-900 mt-2">
                                {{ number_format($this->profitLossAnalysis['total_expenses'], 2) }}</p>
                            <p class="text-xs text-red-600 mt-1">QAR</p>
                        </div>
                        <div class="w-12 h-12 bg-red-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-sm p-6 border border-purple-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600">Gross Profit</p>
                            <p
                                class="text-3xl font-bold {{ $this->profitLossAnalysis['gross_profit'] >= 0 ? 'text-purple-900' : 'text-red-600' }} mt-2">
                                {{ number_format($this->profitLossAnalysis['gross_profit'], 2) }}</p>
                            <p class="text-xs text-purple-600 mt-1">QAR</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-sm p-6 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Profit Margin</p>
                            <p
                                class="text-3xl font-bold {{ $this->profitLossAnalysis['profit_margin'] >= 0 ? 'text-blue-900' : 'text-red-600' }} mt-2">
                                {{ $this->profitLossAnalysis['profit_margin'] }}%</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Month-over-Month Comparison --}}
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Month-over-Month Comparison</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <div class="text-sm text-gray-600 mb-2">Revenue</div>
                        <div class="flex items-baseline justify-between">
                            <span class="text-2xl font-bold text-gray-900">
                                {{ number_format($this->monthlyComparison['current_revenue'], 2) }}
                            </span>
                            <span
                                class="text-sm font-medium {{ $this->monthlyComparison['revenue_change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $this->monthlyComparison['revenue_change'] >= 0 ? '+' : '' }}{{ $this->monthlyComparison['revenue_change'] }}%
                            </span>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">vs
                            {{ number_format($this->monthlyComparison['previous_revenue'], 2) }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600 mb-2">Expenses</div>
                        <div class="flex items-baseline justify-between">
                            <span class="text-2xl font-bold text-gray-900">
                                {{ number_format($this->monthlyComparison['current_expenses'], 2) }}
                            </span>
                            <span
                                class="text-sm font-medium {{ $this->monthlyComparison['expense_change'] <= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $this->monthlyComparison['expense_change'] >= 0 ? '+' : '' }}{{ $this->monthlyComparison['expense_change'] }}%
                            </span>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">vs
                            {{ number_format($this->monthlyComparison['previous_expenses'], 2) }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-600 mb-2">Profit</div>
                        <div class="flex items-baseline justify-between">
                            <span
                                class="text-2xl font-bold {{ $this->monthlyComparison['current_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($this->monthlyComparison['current_profit'], 2) }}
                            </span>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">vs
                            {{ number_format($this->monthlyComparison['previous_profit'], 2) }}</div>
                    </div>
                </div>
            </div>

            {{-- Expense Breakdown by Category --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Expense Breakdown by Category</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">% of
                                    Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($this->expenseByCategory as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ ucfirst($category->category) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-right">
                                        {{ number_format($category->total, 2) }} QAR</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-right">
                                        {{ $this->profitLossAnalysis['total_revenue'] > 0 ? number_format(($category->total / $this->profitLossAnalysis['total_revenue']) * 100, 1) : 0 }}%
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-50 font-bold">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">TOTAL EXPENSES</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                    {{ number_format($this->profitLossAnalysis['total_expenses'], 2) }} QAR</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                    {{ $this->profitLossAnalysis['expense_ratio'] }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    {{-- Inventory Tab --}}
    @if($activeTab === 'inventory')
        <div>
            {{-- Inventory Statistics Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-sm p-6 border border-purple-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-purple-600">Total Items</p>
                            <p class="text-3xl font-bold text-purple-900 mt-2">{{ $this->inventoryStats['total_items'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-sm p-6 border border-green-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-green-600">Active Items</p>
                            <p class="text-3xl font-bold text-green-900 mt-2">{{ $this->inventoryStats['active_items'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg shadow-sm p-6 border border-red-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-red-600">Low Stock</p>
                            <p class="text-3xl font-bold text-red-900 mt-2">{{ $this->inventoryStats['low_stock_items'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg shadow-sm p-6 border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Inactive Items</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $this->inventoryStats['inactive_items'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-sm p-6 border border-blue-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-blue-600">Total Value</p>
                            <p class="text-3xl font-bold text-blue-900 mt-2">{{ number_format($this->inventoryStats['total_value'], 2) }}</p>
                            <p class="text-xs text-blue-600 mt-1">QAR</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Inventory by Category --}}
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Inventory by Category</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Items</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Stock</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Value (QAR)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($this->inventoryByCategory as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                            {{ $category->category }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $category->item_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($category->total_stock, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-right">{{ number_format($category->category_value, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Low Stock Alerts --}}
            @if($this->lowStockItems->count() > 0)
                <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                    <div class="flex items-center mb-4">
                        <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-red-900">Low Stock Alerts ({{ $this->lowStockItems->count() }} items)</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-red-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-red-900 uppercase">Item</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-red-900 uppercase">Current Stock</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-red-900 uppercase">Min Stock</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-red-900 uppercase">Unit Cost</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-red-200">
                                @foreach($this->lowStockItems as $item)
                                    <tr class="hover:bg-red-100">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                            <div class="text-xs text-gray-600">{{ $item->category }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-900 text-right">
                                            {{ $item->current_stock }} {{ $item->unit }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 text-right">
                                            {{ $item->min_stock }} {{ $item->unit }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                            {{ number_format($item->unit_cost, 2) }} QAR
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Recent Transactions --}}
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Inventory Transactions</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($this->recentTransactions as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $transaction->inventoryItem->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $transaction->type === 'in' ? 'bg-green-100 text-green-800' : ($transaction->type === 'out' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $transaction->reason }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                        {{ $transaction->type === 'out' ? '-' : '+' }}{{ $transaction->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $transaction->user->name ?? 'Unknown' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        No transactions found for the selected period
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('livewire:navigated', function () {
            initCharts();
        });

        function initCharts() {
            // Daily Sales Chart
            @if($activeTab === 'sales')
                const dailySalesCtx = document.getElementById('dailySalesChart');
                if (dailySalesCtx) {
                    const dailySalesData = @json($this->dailySales);
                    new Chart(dailySalesCtx, {
                        type: 'line',
                        data: {
                            labels: dailySalesData.map(d => new Date(d.date).toLocaleDateString('en-US', {
                                month: 'short',
                                day: 'numeric'
                            })),
                            datasets: [{
                                label: 'Revenue (QAR)',
                                data: dailySalesData.map(d => d.revenue),
                                borderColor: 'rgb(147, 51, 234)',
                                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }

                // Order Status Chart
                const orderStatusCtx = document.getElementById('orderStatusChart');
                if (orderStatusCtx) {
                    const orderStatusData = @json($this->orderStatusBreakdown);
                    new Chart(orderStatusCtx, {
                        type: 'doughnut',
                        data: {
                            labels: orderStatusData.map(d => d.status.charAt(0).toUpperCase() + d.status
                                .slice(1)),
                            datasets: [{
                                data: orderStatusData.map(d => d.count),
                                backgroundColor: [
                                    'rgb(250, 204, 21)', // pending - yellow
                                    'rgb(59, 130, 246)', // processing - blue
                                    'rgb(6, 182, 212)', // ready - cyan
                                    'rgb(34, 197, 94)', // delivered - green
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                }
            @endif

                // Payment Method Chart
                @if($activeTab === 'payments')
                    const paymentMethodCtx = document.getElementById('paymentMethodChart');
                    if (paymentMethodCtx) {
                        const paymentMethodData = @json($this->paymentMethods);
                        new Chart(paymentMethodCtx, {
                            type: 'pie',
                            data: {
                                labels: paymentMethodData.map(d => d.payment_method.charAt(0).toUpperCase() + d
                                    .payment_method.slice(1)),
                                datasets: [{
                                    data: paymentMethodData.map(d => d.total),
                                    backgroundColor: [
                                        'rgb(34, 197, 94)', // cash - green
                                        'rgb(59, 130, 246)', // card - blue
                                    ]
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }
                        });
                    }
                @endif

            // Expense Trends Chart
            @if($activeTab === 'expenses')
                const expenseTrendsCtx = document.getElementById('expenseTrendsChart');
                if (expenseTrendsCtx) {
                    const dailyExpensesData = @json($this->dailyExpenses);
                    new Chart(expenseTrendsCtx, {
                        type: 'line',
                        data: {
                            labels: dailyExpensesData.map(d => new Date(d.date).toLocaleDateString('en-US', {
                                month: 'short',
                                day: 'numeric'
                            })),
                            datasets: [{
                                label: 'Expenses (QAR)',
                                data: dailyExpensesData.map(d => d.total),
                                borderColor: 'rgb(239, 68, 68)',
                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }

                // Expense Category Chart
                const expenseCategoryCtx = document.getElementById('expenseCategoryChart');
                if (expenseCategoryCtx) {
                    const expenseCategoryData = @json($this->expenseByCategory);
                    new Chart(expenseCategoryCtx, {
                        type: 'doughnut',
                        data: {
                            labels: expenseCategoryData.map(d => d.category.charAt(0).toUpperCase() + d.category.slice(1)),
                            datasets: [{
                                data: expenseCategoryData.map(d => d.total),
                                backgroundColor: [
                                    'rgb(239, 68, 68)', // rent - red
                                    'rgb(59, 130, 246)', // utilities - blue
                                    'rgb(147, 51, 234)', // salaries - purple
                                    'rgb(34, 197, 94)', // supplies - green
                                    'rgb(249, 115, 22)', // maintenance - orange
                                    'rgb(236, 72, 153)', // marketing - pink
                                    'rgb(6, 182, 212)', // transportation - cyan
                                    'rgb(107, 114, 128)', // other - gray
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                }
            @endif
            }

        // Initialize charts on page load
        initCharts();

        // Reinitialize charts when tab changes
        Livewire.on('tab-switched', () => {
            setTimeout(initCharts, 100);
        });
    </script>
@endpush