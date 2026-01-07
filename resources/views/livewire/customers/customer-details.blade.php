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
                            <button wire:click="closeModal"
                                class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="p-6">
                        
                        {{-- Flash Messages --}}
                        @if(session()->has('message'))
                            <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                                <p class="text-green-800 font-medium">{{ session('message') }}</p>
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                                <p class="text-red-800 font-medium">Please fix the errors below</p>
                            </div>
                        @endif

                        {{-- Edit Mode Banner --}}
                        @if($editMode)
                            <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span class="font-semibold text-yellow-800">Edit Mode Active - Make changes and click Save</span>
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="button" wire:click="saveCustomer"
                                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold shadow-lg">
                                            💾 Save Changes
                                        </button>
                                        <button type="button" wire:click="cancelEdit"
                                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors font-semibold">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Customer Information Card --}}
                        <div class="bg-gradient-to-br from-gray-50 to-white rounded-xl p-8 mb-6 border-2 border-gray-200 shadow-sm">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-2xl font-bold text-gray-800">👤 Customer Information</h3>
                                @if(!$editMode)
                                    <button type="button" wire:click="enableEdit"
                                        class="px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors font-semibold flex items-center gap-2 shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit Details
                                    </button>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Customer Name --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                                        Customer Name *
                                    </label>
                                    @if($editMode)
                                        <input type="text" wire:model="editName"
                                            class="w-full text-lg px-4 py-3 border-2 {{ $errors->has('editName') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                            placeholder="Enter customer name" />
                                        @error('editName')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    @else
                                        <div class="text-lg font-semibold text-gray-900 px-4 py-3 bg-gray-100 rounded-lg">
                                            {{ $this->customer->name }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Phone --}}
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                                        Phone Number *
                                    </label>
                                    @if($editMode)
                                        <input type="text" wire:model="editPhone"
                                            class="w-full text-lg px-4 py-3 border-2 {{ $errors->has('editPhone') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                            placeholder="Enter phone number" />
                                        @error('editPhone')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    @else
                                        <div class="text-lg font-semibold text-gray-900 px-4 py-3 bg-gray-100 rounded-lg">
                                            {{ $this->customer->phone }}
                                        </div>
                                    @endif
                                </div>

                                {{-- Address --}}
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                                        Address (Optional)
                                    </label>
                                    @if($editMode)
                                        <textarea wire:model="editAddress" rows="2"
                                            class="w-full text-lg px-4 py-3 border-2 {{ $errors->has('editAddress') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200" 
                                            placeholder="Enter customer address"></textarea>
                                        @error('editAddress')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    @else
                                        <div class="text-lg text-gray-900 px-4 py-3 bg-gray-100 rounded-lg">
                                            {{ $this->customer->address ?? 'No address provided' }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Statistics Cards --}}
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                            {{-- Total Orders --}}
                            <div class="bg-white rounded-xl p-5 border-l-4 border-purple-500 shadow-sm">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Total Orders</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $this->statistics['total_orders'] }}</p>
                            </div>

                            {{-- Total Spent --}}
                            <div class="bg-white rounded-xl p-5 border-l-4 border-green-500 shadow-sm">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Total Spent</p>
                                <p class="text-3xl font-bold text-green-600">{{ number_format($this->statistics['total_spent'], 2) }}</p>
                                <p class="text-xs text-gray-600">QAR</p>
                            </div>

                            {{-- Total Pending --}}
                            <div class="bg-white rounded-xl p-5 border-l-4 border-red-500 shadow-sm">
                                <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Total Due</p>
                                <p class="text-3xl font-bold text-red-600">{{ number_format($this->statistics['total_pending'], 2) }}</p>
                                <p class="text-xs text-gray-600">QAR</p>
                            </div>
                        </div>

                        {{-- Order History --}}
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">📋 Order History</h3>

                            @if($this->customer->orders->count() > 0)
                                <div class="space-y-3">
                                    @foreach($this->customer->orders->sortByDesc('created_at')->take(10) as $order)
                                        <div
                                            class="bg-white rounded-lg p-4 border border-gray-200 hover:border-purple-300 transition-all">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1">
                                                    <div class="flex items-center space-x-3 mb-2">
                                                        <span
                                                            class="text-base font-bold text-purple-600">#{{ $order->order_number }}</span>
                                                        <span
                                                            class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                                                    </div>
                                                    <div class="flex items-center space-x-4 text-sm">
                                                        <span class="text-gray-700">
                                                            <strong>{{ $order->orderItems->count() }}</strong> items
                                                        </span>
                                                        <span
                                                            class="inline-flex rounded-full px-3 py-1 text-xs font-bold
                                                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-800' : '' }}
                                                                    {{ $order->status === 'ready' ? 'bg-purple-100 text-purple-800' : '' }}
                                                                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                        <span
                                                            class="inline-flex rounded-full px-3 py-1 text-xs font-bold
                                                                    {{ $order->payment_status === 'pending' ? 'bg-red-100 text-red-800' : '' }}
                                                                    {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : '' }}">
                                                            {{ ucfirst($order->payment_status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-xl font-bold text-gray-900">
                                                        {{ number_format($order->total_amount, 2) }}</p>
                                                    <p class="text-xs text-gray-500">AED</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div
                                        class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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
                        <button wire:click="closeModal"
                            class="rounded-xl bg-gray-600 px-8 py-3 text-base font-bold text-white hover:bg-gray-700">
                            ✕ Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>