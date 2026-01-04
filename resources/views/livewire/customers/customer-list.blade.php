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
            <h1 class="text-2xl font-bold text-gray-900">Customers</h1>
            <p class="mt-1 text-sm text-gray-600">Manage your customer database</p>
        </div>
        <button wire:click="openCreateModal" class="rounded-lg bg-purple-600 px-4 py-2 text-white hover:bg-purple-700">
            + Add Customer
        </button>
    </div>

    {{-- Filters --}}
    <div class="mb-6 rounded-lg bg-white p-4 shadow">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class="md:col-span-2">
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Search by name, phone, or address..."
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500" />
            </div>
            <div>
                <select wire:model.live="statusFilter"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    <option value="all">All Customers</option>
                    <option value="active">Active Only</option>
                    <option value="inactive">Inactive Only</option>
                    <option value="regular">Regular Customers</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Customers Table --}}
    <div class="overflow-hidden rounded-lg bg-white shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Customer
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Orders
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($this->customers as $customer)
                        <tr class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-purple-100 text-purple-600">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-semibold text-gray-900">{{ $customer->name }}</div>
                                        @if ($customer->isRegular)
                                            <span
                                                class="inline-flex items-center rounded-full bg-yellow-100 px-2 py-0.5 text-xs font-medium text-yellow-800">
                                                Regular Customer
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm text-gray-900">{{ $customer->phone }}</div>
                                <div class="text-sm text-gray-500">{{ Str::limit($customer->address ?? 'N/A', 30) }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $customer->total_orders }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($customer->is_active)
                                    <span
                                        class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex rounded-full bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="viewCustomer({{ $customer->id }})"
                                        class="text-purple-600 hover:text-purple-900" title="View Details">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                    <button wire:click="toggleStatus({{ $customer->id }})"
                                        class="text-yellow-600 hover:text-yellow-900" title="Toggle Status">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </button>
                                    <button wire:click="deleteCustomer({{ $customer->id }})"
                                        wire:confirm="Are you sure you want to delete this customer?"
                                        class="text-red-600 hover:text-red-900" title="Delete">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="mb-4 h-16 w-16 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="text-lg font-semibold text-gray-900">No customers found</p>
                                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first customer
                                    </p>
                                    <button wire:click="openCreateModal"
                                        class="mt-4 rounded-lg bg-purple-600 px-4 py-2 text-white hover:bg-purple-700">
                                        + Add Customer
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="border-t border-gray-200 px-6 py-4">
            {{ $this->customers->links() }}
        </div>
    </div>

    {{-- Create Customer Modal --}}
    @if ($showCreateModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-gray-900 bg-opacity-50 p-4">
            <div class="w-full max-w-lg">
                <livewire:customers.create-customer />
            </div>
        </div>
    @endif

    {{-- Customer Details Modal --}}
    @if($showDetailsModal && $selectedCustomerId)
        @livewire('customers.customer-details', ['customerId' => $selectedCustomerId], key('customer-details-' . $selectedCustomerId))
    @endif

    {{-- Edit Customer Modal --}}
    @livewire('customers.edit-customer')
</div>