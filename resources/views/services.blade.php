<x-layouts.app title="Services">
    <div class="min-h-screen bg-gray-50 p-4">
        {{-- Simple Header --}}
        <div class="mb-6 text-center">
            <h1 class="text-4xl font-bold text-purple-600">🧺 Services</h1>
            <p class="mt-2 text-lg text-gray-600">Manage your laundry services & pricing</p>
        </div>

        {{-- Add Service Button --}}
        <div class="max-w-7xl mx-auto mb-6">
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">All Services</h2>
                        <p class="text-sm text-gray-600 mt-1">
                            @php
                                $services = \App\Models\Service::latest()->get();
                            @endphp
                            <strong>{{ $services->count() }}</strong> service(s) available
                        </p>
                    </div>
                    <livewire:create-service />
                </div>
            </div>
        </div>

        {{-- Services List Layout --}}
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                @forelse($services as $service)
                    <div class="border-b border-gray-200 hover:bg-purple-50 transition-colors duration-150">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                {{-- Left: Image + Info --}}
                                <div class="flex items-center space-x-6 flex-1">
                                    {{-- Service Image --}}
                                    <div class="relative flex-shrink-0">
                                        @if($service->image_url)
                                            <img src="{{ $service->image_url }}" alt="{{ $service->name }}"
                                                class="w-20 h-20 rounded-xl object-cover shadow-lg border-2 border-purple-200">
                                        @else
                                            <div class="w-20 h-20 rounded-xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center shadow-lg">
                                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Service Details --}}
                                    <div class="flex-1 min-w-0">
                                        {{-- Name & Status --}}
                                        <div class="flex items-center space-x-3 mb-2">
                                            <h3 class="text-xl font-bold text-gray-900">{{ $service->name }}</h3>
                                            @if($service->is_active)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-300">
                                                    ✓ Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800 border border-gray-300">
                                                    ✗ Inactive
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Category --}}
                                        @if($service->category)
                                            <div class="mb-3">
                                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-purple-100 text-purple-700">
                                                    📁 {{ $service->category }}
                                                </span>
                                            </div>
                                        @endif

                                        {{-- Pricing Grid --}}
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            {{-- Wash & Iron Price --}}
                                            <div class="flex items-center space-x-3 bg-blue-50 rounded-lg p-3">
                                                <div class="w-10 h-10 bg-blue-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-xs text-blue-600 font-medium">Wash & Iron</p>
                                                    <p class="text-lg font-bold text-blue-900">{{ number_format((float) $service->price_wash_iron, 2) }} QAR</p>
                                                </div>
                                            </div>

                                            {{-- Iron Only Price --}}
                                            <div class="flex items-center space-x-3 bg-green-50 rounded-lg p-3">
                                                <div class="w-10 h-10 bg-green-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-5 h-5 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-xs text-green-600 font-medium">Iron Only</p>
                                                    <p class="text-lg font-bold text-green-900">{{ number_format((float) $service->price_iron_only, 2) }} QAR</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Right: Quick Stats --}}
                                <div class="ml-6 text-right flex-shrink-0">
                                    <div class="bg-purple-100 rounded-xl p-4 border-2 border-purple-200">
                                        <p class="text-xs text-purple-600 font-medium mb-1">Total Orders</p>
                                        <p class="text-3xl font-bold text-purple-700">{{ $service->orderItems()->count() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="p-12 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-24 h-24 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-12 h-12 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Services Found</h3>
                            <p class="text-gray-600 mb-6">Get started by adding your first laundry service</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>