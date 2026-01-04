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
                <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl transform transition-all"
                    @click.away="$wire.closeModal()">

                    <form wire:submit="record">
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Record Payment</h3>
                                <p class="text-sm text-gray-600 mt-1">Order #{{ $order->order_number }}</p>
                            </div>
                            <button type="button" wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- Modal Body -->
                        <div class="px-6 py-6 space-y-5">
                            <!-- Balance Summary -->
                            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-200 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Total Amount</span>
                                    <span class="text-base font-semibold text-gray-900">QAR {{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm text-gray-600">Already Paid</span>
                                    <span class="text-base font-semibold text-green-600">QAR {{ number_format($order->total_paid, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t border-purple-200">
                                    <span class="text-base font-semibold text-gray-900">Remaining Balance</span>
                                    <span class="text-lg font-bold text-red-600">QAR {{ number_format($remainingBalance, 2) }}</span>
                                </div>
                            </div>

                            <!-- Payment Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                    Payment Amount (QAR) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" id="amount" wire:model="amount" step="0.01" min="0.01" 
                                        max="{{ $remainingBalance }}"
                                        class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 @error('amount') border-red-500 @enderror pr-20"
                                        placeholder="0.00">
                                    <button type="button" wire:click="payFull" 
                                        class="absolute right-2 top-1/2 -translate-y-1/2 text-xs bg-purple-100 text-purple-700 px-3 py-1 rounded hover:bg-purple-200 transition-colors">
                                        Pay Full
                                    </button>
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-2">
                                    Payment Method <span class="text-red-500">*</span>
                                </label>
                                <select id="payment_method" wire:model="payment_method"
                                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 @error('payment_method') border-red-500 @enderror">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                </select>
                                @error('payment_method')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Date -->
                            <div>
                                <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Payment Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="payment_date" wire:model="payment_date"
                                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 @error('payment_date') border-red-500 @enderror">
                                @error('payment_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Notes (Optional)
                                </label>
                                <textarea id="notes" wire:model="notes" rows="3"
                                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 @error('notes') border-red-500 @enderror"
                                    placeholder="Add any additional notes about this payment"></textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Payment Summary Preview -->
                            @if($amount)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-green-900 mb-2">Payment Summary</p>
                                    <div class="space-y-1 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-green-700">Payment Amount:</span>
                                            <span class="font-semibold text-green-900">QAR {{ number_format((float)$amount, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-green-700">Remaining After Payment:</span>
                                            <span class="font-semibold text-green-900">
                                                QAR {{ number_format($remainingBalance - (float)$amount, 2) }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between pt-2 border-t border-green-200">
                                            <span class="text-green-700">New Status:</span>
                                            <span class="font-semibold">
                                                @if($remainingBalance - (float)$amount <= 0)
                                                    <span class="inline-flex px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs">
                                                        Paid
                                                    </span>
                                                @else
                                                    <span class="inline-flex px-2 py-1 rounded-full bg-orange-100 text-orange-800 text-xs">
                                                        Partial
                                                    </span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end px-6 py-4 border-t border-gray-200 bg-gray-50 space-x-3">
                            <button type="button" wire:click="closeModal" 
                                class="px-5 py-2 bg-white hover:bg-gray-50 text-gray-700 font-medium rounded-lg border border-gray-300 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                class="px-5 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-lg transition-all shadow-md hover:shadow-lg"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="record">Record Payment</span>
                                <span wire:loading wire:target="record">Recording...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
