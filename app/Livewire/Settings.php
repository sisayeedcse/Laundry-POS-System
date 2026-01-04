<?php

declare(strict_types=1);

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Settings extends Component
{
    public string $activeTab = 'business';

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    #[Layout('components.layouts.app', ['title' => 'Settings'])]
    public function render()
    {
        return view('livewire.settings');
    }
}
