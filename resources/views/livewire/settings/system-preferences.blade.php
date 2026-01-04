<div class="bg-white rounded-lg shadow-sm p-6">
    @if (session()->has('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        {{-- Localization --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Localization</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Timezone *</label>
                    <select wire:model="timezone"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                        <option value="Asia/Qatar">Asia/Qatar (GMT+3)</option>
                        <option value="Asia/Dubai">Asia/Dubai (GMT+4)</option>
                        <option value="Asia/Riyadh">Asia/Riyadh (GMT+3)</option>
                        <option value="Europe/London">Europe/London (GMT+0)</option>
                        <option value="America/New_York">America/New York (GMT-5)</option>
                        <option value="Asia/Kolkata">Asia/Kolkata (GMT+5:30)</option>
                    </select>
                    @error('timezone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date Format *</label>
                    <select wire:model="date_format"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                        <option value="Y-m-d">YYYY-MM-DD (2026-01-04)</option>
                        <option value="d/m/Y">DD/MM/YYYY (04/01/2026)</option>
                        <option value="m/d/Y">MM/DD/YYYY (01/04/2026)</option>
                        <option value="d-M-Y">DD-MMM-YYYY (04-Jan-2026)</option>
                    </select>
                    @error('date_format')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Time Format *</label>
                    <select wire:model="time_format"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                        <option value="H:i:s">24-hour (14:30:00)</option>
                        <option value="h:i A">12-hour (02:30 PM)</option>
                    </select>
                    @error('time_format')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Display Settings --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Display Settings</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Items Per Page *</label>
                    <input type="number" wire:model="items_per_page" min="5" max="100"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    @error('items_per_page')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Number of items to display in tables and lists</p>
                </div>
            </div>
        </div>

        {{-- Inventory Settings --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Inventory Settings</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Low Stock Threshold *</label>
                    <input type="number" wire:model="low_stock_threshold" min="0" max="1000"
                        class="w-full rounded-lg border-gray-300 focus:border-purple-500 focus:ring-purple-500">
                    @error('low_stock_threshold')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Alert when stock falls below this number</p>
                </div>
            </div>
        </div>

        {{-- Notification Settings --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Notification Settings</h3>
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" wire:model="enable_notifications" id="enable_notifications"
                        class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <label for="enable_notifications" class="ml-2 block text-sm text-gray-700">
                        Enable system notifications
                    </label>
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-end">
            <button type="submit"
                class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                Save System Preferences
            </button>
        </div>
    </form>
</div>