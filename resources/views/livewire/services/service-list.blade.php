<div class="p-6">
    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="mb-4 rounded-lg bg-green-50 p-4 text-green-800 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-800 border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Services Management</h1>
            <p class="mt-1 text-sm text-gray-600">Manage laundry services and pricing</p>
        </div>
        <button wire:click="openCreateModal"
            class="rounded-lg bg-purple-600 px-4 py-2 text-white hover:bg-purple-700 transition-colors flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New Service
        </button>
    </div>

    {{-- Filters --}}
    <div class="mb-6 rounded-lg bg-white p-4 shadow">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
            <div class="md:col-span-2">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search services..."
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500" />
            </div>
            <div>
                <select wire:model.live="categoryFilter"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    <option value="all">All Categories</option>
                    @foreach($this->categories as $category)
                        <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="statusFilter"
                    class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        @if($search || $categoryFilter !== 'all' || $statusFilter !== 'all')
            <button wire:click="clearFilters" class="mt-3 text-sm text-purple-600 hover:text-purple-700">
                Clear Filters
            </button>
        @endif
    </div>

    {{-- Services Grid --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($this->services->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-6">
                @foreach($this->services as $service)
                    <div wire:key="service-{{ $service->id }}"
                        class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                        {{-- Service Image --}}
                        <div class="relative h-48 bg-gradient-to-br from-purple-100 to-indigo-100">
                            @if($service->image_path)
                                <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-20 h-20 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                            @endif

                            {{-- Status Badge --}}
                            <div class="absolute top-2 right-2">
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>

                        {{-- Service Info --}}
                        <div class="p-4">
                            <div class="mb-3">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $service->name }}</h3>
                                @if($service->category)
                                    <p class="text-xs text-gray-500 mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded bg-purple-100 text-purple-800">
                                            {{ ucfirst($service->category) }}
                                        </span>
                                    </p>
                                @endif
                            </div>

                            {{-- Pricing --}}
                            <div class="mb-4 space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600">Wash & Iron:</span>
                                    <span class="text-base font-semibold text-purple-900">AED
                                        {{ number_format($service->price_wash_iron, 2) }}</span>
                                </div>
                                @if($service->price_iron_only)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Iron Only:</span>
                                        <span class="text-base font-semibold text-green-600">AED
                                            {{ number_format($service->price_iron_only, 2) }}</span>
                                    </div>
                                @endif
                                @if($service->size_variant)
                                    <div class="mt-1">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-800">
                                            {{ $service->size_variant }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Description --}}
                            @if($service->description)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $service->description }}</p>
                            @endif

                            {{-- Action Buttons --}}
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <button wire:click="toggleStatus({{ $service->id }})"
                                    class="text-sm {{ $service->is_active ? 'text-orange-600 hover:text-orange-700' : 'text-green-600 hover:text-green-700' }} font-medium">
                                    {{ $service->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                                <div class="flex items-center space-x-2">
                                    <button wire:click="editService({{ $service->id }})"
                                        class="text-purple-600 hover:text-purple-900" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button wire:click="deleteService({{ $service->id }})"
                                        wire:confirm="Are you sure you want to delete this service?"
                                        class="text-red-600 hover:text-red-900" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="border-t border-gray-200 px-6 py-4">
                {{ $this->services->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <p class="mt-4 text-lg font-semibold text-gray-900">No services found</p>
                <p class="mt-1 text-sm text-gray-500">
                    @if($search || $categoryFilter !== 'all' || $statusFilter !== 'all')
                        Try adjusting your filters
                    @else
                        Get started by creating your first service
                    @endif
                </p>
                @if(!$search && $categoryFilter === 'all' && $statusFilter === 'all')
                    <button wire:click="openCreateModal"
                        class="mt-4 rounded-lg bg-purple-600 px-4 py-2 text-white hover:bg-purple-700">
                        Add New Service
                    </button>
                @endif
            </div>
        @endif
    </div>

    {{-- Create Service Modal --}}
    @if($showCreateModal)
        @livewire('services.create-service')
    @endif

    {{-- Edit Service Modal --}}
    @if($showEditModal && $editingServiceId)
        @livewire('services.edit-service', ['serviceId' => $editingServiceId])
    @endif
</div>