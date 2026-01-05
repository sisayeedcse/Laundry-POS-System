<div>
    {{-- Simple Modal Without Alpine.js --}}
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-75" wire:click="closeModal">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div wire:click.stop class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl max-h-[90vh] overflow-y-auto">
                
                {{-- Header --}}
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-6 sticky top-0 z-10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="h-16 w-16 rounded-full bg-white flex items-center justify-center shadow-lg">
                                <span class="text-2xl font-bold text-purple-600">
                                    {{ strtoupper(substr($this->customer->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-white">{{ $this->customer->name }}</h2>
                                <p class="text-purple-100">Customer Details</p>
                            </div>
                        </div>
                        <button wire:click="closeModal" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Body --}}
                <div class="p-6">
                    
                    {{-- Customer Info Cards --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        {{-- Phone --}}
                        <div class="bg-blue-50 rounded-xl p-6 border-2 border-blue-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-blue-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-blue-600 font-medium">Phone</p>
                                    <p class="text-lg font-bold text-blue-900">{{ $this->customer->phone }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Address --}}
                        <div class="bg-green-50 rounded-xl p-6 border-2 border-green-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-green-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs text-green-600 font-medium">Address</p>
                                    <p class="text-sm font-bold text-green-900">{{ $this->customer->address ?? 'No address' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Total Orders --}}
                        <div class="bg-purple-50 rounded-xl p-6 border-2 border-purple-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-purple-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs text-purple-600 font-medium">Total Orders</p>
                                    <p class="text-2xl font-bold text-purple-900">{{ $this->statistics['total_orders'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order History --}}
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">📋 Order History</h3>
                        
                        @if($this->customer->orders->count() > 0)
                            <div class="space-y-3">
                                @foreach($this->customer->orders->sortByDesc('created_at')->take(10) as $order)
                                    <div class="bg-white rounded-lg p-4 border border-gray-200 hover:border-purple-300 transition-all">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-3 mb-2">
                                                    <span class="text-base font-bold text-purple-600">#{{ $order->order_number }}</span>
                                                    <span class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                                                </div>
                                                <div class="flex items-center space-x-4 text-sm">
                                                    <span class="text-gray-700">
                                                        <strong>{{ $order->orderItems->count() }}</strong> items
                                                    </span>
                                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold
                                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                        {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                        {{ $order->status === 'ready' ? 'bg-purple-100 text-purple-800' : '' }}
                                                        {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold
                                                        {{ $order->payment_status === 'pending' ? 'bg-red-100 text-red-800' : '' }}
                                                        {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : '' }}">
                                                        {{ ucfirst($order->payment_status) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xl font-bold text-gray-900">{{ number_format($order->total_amount, 2) }}</p>
                                                <p class="text-xs text-gray-500">AED</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-lg font-semibold text-gray-600">No Orders Yet</p>
                                <p class="text-sm text-gray-400 mt-1">This customer hasn't placed any orders</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Footer --}}
                <div class="bg-gray-100 p-4 flex justify-end border-t">
                    <button wire:click="closeModal" class="rounded-xl bg-gray-600 px-8 py-3 text-base font-bold text-white hover:bg-gray-700">
                        ✕ Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
</div>