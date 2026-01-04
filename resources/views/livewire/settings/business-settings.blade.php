<div class="bg-white rounded-lg shadow-sm p-6">
    @if (session()->has('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        {{-- Business Information --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Business Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Business Name *</label>
                    <input type="text" wire:model="business_name"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    @error('business_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Business Phone</label>
                    <input type="text" wire:model="business_phone"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    @error('business_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Business Email</label>
                    <input type="email" wire:model="business_email"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    @error('business_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
                    <select wire:model="currency"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                        <option value="QAR">QAR - Qatari Riyal</option>
                        <option value="USD">USD - US Dollar</option>
                        <option value="EUR">EUR - Euro</option>
                        <option value="GBP">GBP - British Pound</option>
                        <option value="SAR">SAR - Saudi Riyal</option>
                        <option value="AED">AED - UAE Dirham</option>
                    </select>
                    @error('currency')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Business Address</label>
                    <textarea wire:model="business_address" rows="3"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500"></textarea>
                    @error('business_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Tax Settings --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tax Settings</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tax Rate (%) *</label>
                    <input type="number" step="0.01" wire:model="tax_rate"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    @error('tax_rate')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Logo Upload --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Business Logo</h3>

            @if($current_logo)
                <div class="mb-4 flex items-center space-x-4">
                    <img src="{{ asset('storage/' . $current_logo) }}" alt="Current Logo"
                        class="h-20 w-20 object-contain border rounded">
                    <button type="button" wire:click="removeLogo"
                        class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200">
                        Remove Logo
                    </button>
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Logo</label>
                <input type="file" wire:model="logo" accept="image/*"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                @error('logo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @if($logo)
                    <p class="mt-2 text-sm text-gray-500">Preview:</p>
                    <img src="{{ $logo->temporaryUrl() }}" class="mt-2 h-20 w-20 object-contain border rounded">
                @endif
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                Save Business Settings
            </button>
        </div>
    </form>
</div>