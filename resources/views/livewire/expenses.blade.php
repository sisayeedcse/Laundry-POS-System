<div class="p-6">
    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-green-800 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Expenses Management</h1>
            <p class="mt-1 text-sm text-gray-600">Track and manage business expenses</p>
        </div>
        <button wire:click="openCreateModal"
            class="inline-flex items-center rounded-lg bg-purple-600 px-4 py-2 text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Expense
        </button>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg shadow-sm p-6 border border-red-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-red-600">Total Expenses</p>
                    <p class="text-3xl font-bold text-red-900 mt-2">
                        {{ number_format($this->summary['total_expenses'], 2) }}</p>
                    <p class="text-xs text-red-600 mt-1">QAR</p>
                </div>
                <div class="w-12 h-12 bg-red-200 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-sm p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600">Total Transactions</p>
                    <p class="text-3xl font-bold text-blue-900 mt-2">{{ $this->summary['count'] }}</p>
                    <p class="text-xs text-blue-600 mt-1">Expenses recorded</p>
                </div>
                <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-sm p-6 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-600">Average Expense</p>
                    <p class="text-3xl font-bold text-purple-900 mt-2">{{ number_format($this->summary['average'], 2) }}
                    </p>
                    <p class="text-xs text-purple-600 mt-1">QAR per transaction</p>
                </div>
                <div class="w-12 h-12 bg-purple-200 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="mb-6 rounded-lg bg-white p-4 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search expenses..."
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select wire:model.live="categoryFilter"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    <option value="all">All Categories</option>
                    <option value="rent">Rent</option>
                    <option value="utilities">Utilities</option>
                    <option value="salaries">Salaries</option>
                    <option value="supplies">Supplies</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="marketing">Marketing</option>
                    <option value="transportation">Transportation</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
                <select wire:model.live="dateRange"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    <option value="today">Today</option>
                    <option value="this_week">This Week</option>
                    <option value="this_month">This Month</option>
                    <option value="last_month">Last Month</option>
                    <option value="this_year">This Year</option>
                </select>
            </div>
            <div class="flex items-end">
                <button wire:click="clearFilters"
                    class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Clear Filters
                </button>
            </div>
        </div>
    </div>

    {{-- Expenses Table --}}
    <div class="overflow-hidden rounded-lg bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Category
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Amount
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Receipt
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($this->expenses as $expense)
                        <tr class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $expense->expense_date->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $expense->expense_date->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $expense->title }}</div>
                                @if($expense->description)
                                    <div class="text-xs text-gray-500">{{ Str::limit($expense->description, 50) }}</div>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span
                                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $expense->category_color }}">
                                    {{ $expense->category_label }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm font-bold text-red-600">{{ number_format($expense->amount, 2) }} QAR
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if($expense->receipt_image)
                                    <a href="{{ $expense->receipt_image_url }}" target="_blank"
                                        class="text-purple-600 hover:text-purple-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">No receipt</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button wire:click="editExpense({{ $expense->id }})"
                                        class="text-blue-600 hover:text-blue-900" title="Edit">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button wire:click="deleteExpense({{ $expense->id }})"
                                        wire:confirm="Are you sure you want to delete this expense?"
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
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-lg font-semibold text-gray-900">No expenses found</p>
                                    <p class="mt-1 text-sm text-gray-500">Get started by adding your first expense</p>
                                    <button wire:click="openCreateModal"
                                        class="mt-4 rounded-lg bg-purple-600 px-4 py-2 text-white hover:bg-purple-700">
                                        + Add Expense
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($this->expenses->hasPages())
            <div class="border-t border-gray-200 px-6 py-4">
                {{ $this->expenses->links() }}
            </div>
        @endif
    </div>

    {{-- Create Expense Modal --}}
    @if ($showCreateModal)
        @livewire('expenses.create-expense')
    @endif

    {{-- Edit Expense Modal --}}
    @livewire('expenses.edit-expense')
</div>