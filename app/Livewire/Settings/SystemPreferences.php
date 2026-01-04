<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class SystemPreferences extends Component
{
    public string $timezone = 'Asia/Qatar';
    public string $date_format = 'Y-m-d';
    public string $time_format = 'H:i:s';
    public int $items_per_page = 10;
    public bool $enable_notifications = true;
    public int $low_stock_threshold = 10;

    public function mount(): void
    {
        $this->loadSettings();
    }

    protected function loadSettings(): void
    {
        $this->timezone = Setting::get('timezone', 'Asia/Qatar');
        $this->date_format = Setting::get('date_format', 'Y-m-d');
        $this->time_format = Setting::get('time_format', 'H:i:s');
        $this->items_per_page = (int) Setting::get('items_per_page', 10);
        $this->enable_notifications = (bool) Setting::get('enable_notifications', true);
        $this->low_stock_threshold = (int) Setting::get('low_stock_threshold', 10);
    }

    protected function rules(): array
    {
        return [
            'timezone' => 'required|string',
            'date_format' => 'required|string',
            'time_format' => 'required|string',
            'items_per_page' => 'required|integer|min:5|max:100',
            'enable_notifications' => 'boolean',
            'low_stock_threshold' => 'required|integer|min:0|max:1000',
        ];
    }

    public function save(): void
    {
        $this->validate();

        Setting::set('timezone', $this->timezone, 'string', 'system');
        Setting::set('date_format', $this->date_format, 'string', 'system');
        Setting::set('time_format', $this->time_format, 'string', 'system');
        Setting::set('items_per_page', (string) $this->items_per_page, 'integer', 'system');
        Setting::set('enable_notifications', $this->enable_notifications ? 'true' : 'false', 'boolean', 'system');
        Setting::set('low_stock_threshold', (string) $this->low_stock_threshold, 'integer', 'system');

        session()->flash('success', 'System preferences updated successfully!');
    }

    public function render()
    {
        return view('livewire.settings.system-preferences');
    }
}
