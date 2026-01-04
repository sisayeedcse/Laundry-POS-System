<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;

class OrderSettings extends Component
{
    public string $order_prefix = '';
    public string $default_order_status = 'pending';
    public bool $auto_print_receipt = false;
    public bool $require_customer = true;
    public bool $enable_express_service = true;
    public int $default_delivery_days = 3;

    public function mount(): void
    {
        $this->loadSettings();
    }

    protected function loadSettings(): void
    {
        $this->order_prefix = Setting::get('order_prefix', 'ORD');
        $this->default_order_status = Setting::get('default_order_status', 'pending');
        $this->auto_print_receipt = (bool) Setting::get('auto_print_receipt', false);
        $this->require_customer = (bool) Setting::get('require_customer', true);
        $this->enable_express_service = (bool) Setting::get('enable_express_service', true);
        $this->default_delivery_days = (int) Setting::get('default_delivery_days', 3);
    }

    protected function rules(): array
    {
        return [
            'order_prefix' => 'required|string|max:10',
            'default_order_status' => 'required|in:pending,processing,ready,delivered',
            'auto_print_receipt' => 'boolean',
            'require_customer' => 'boolean',
            'enable_express_service' => 'boolean',
            'default_delivery_days' => 'required|integer|min:1|max:30',
        ];
    }

    public function save(): void
    {
        $this->validate();

        Setting::set('order_prefix', $this->order_prefix, 'string', 'order');
        Setting::set('default_order_status', $this->default_order_status, 'string', 'order');
        Setting::set('auto_print_receipt', $this->auto_print_receipt ? 'true' : 'false', 'boolean', 'order');
        Setting::set('require_customer', $this->require_customer ? 'true' : 'false', 'boolean', 'order');
        Setting::set('enable_express_service', $this->enable_express_service ? 'true' : 'false', 'boolean', 'order');
        Setting::set('default_delivery_days', (string) $this->default_delivery_days, 'integer', 'order');

        session()->flash('success', 'Order settings updated successfully!');
    }

    public function render()
    {
        return view('livewire.settings.order-settings');
    }
}
