<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;

class BusinessSettings extends Component
{
    use WithFileUploads;

    public string $business_name = '';
    public string $business_address = '';
    public string $business_phone = '';
    public string $business_email = '';
    public float $tax_rate = 0;
    public string $currency = 'QAR';
    public $logo;
    public string $current_logo = '';

    public function mount(): void
    {
        $this->loadSettings();
    }

    protected function loadSettings(): void
    {
        $this->business_name = Setting::get('business_name', 'Laundry POS');
        $this->business_address = Setting::get('business_address', '');
        $this->business_phone = Setting::get('business_phone', '');
        $this->business_email = Setting::get('business_email', '');
        $this->tax_rate = (float) Setting::get('tax_rate', 0);
        $this->currency = Setting::get('currency', 'QAR');
        $this->current_logo = Setting::get('logo_path', '');
    }

    protected function rules(): array
    {
        return [
            'business_name' => 'required|string|max:255',
            'business_address' => 'nullable|string',
            'business_phone' => 'nullable|string|max:20',
            'business_email' => 'nullable|email|max:255',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'currency' => 'required|string|max:10',
            'logo' => 'nullable|image|max:2048',
        ];
    }

    public function save(): void
    {
        $this->validate();

        // Handle logo upload
        if ($this->logo) {
            $logoPath = $this->logo->store('logos', 'public');
            Setting::set('logo_path', $logoPath, 'string', 'business');
        }

        Setting::set('business_name', $this->business_name, 'string', 'business');
        Setting::set('business_address', $this->business_address, 'string', 'business');
        Setting::set('business_phone', $this->business_phone, 'string', 'business');
        Setting::set('business_email', $this->business_email, 'string', 'business');
        Setting::set('tax_rate', (string) $this->tax_rate, 'float', 'business');
        Setting::set('currency', $this->currency, 'string', 'business');

        session()->flash('success', 'Business settings updated successfully!');
        $this->loadSettings();
        $this->logo = null;
    }

    public function removeLogo(): void
    {
        if ($this->current_logo) {
            Setting::set('logo_path', '', 'string', 'business');
            $this->current_logo = '';
            session()->flash('success', 'Logo removed successfully!');
        }
    }

    public function render()
    {
        return view('livewire.settings.business-settings');
    }
}
