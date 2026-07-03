<?php

namespace App\Livewire\Settings;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Appearance settings')]
class Appearance extends Component
{
    use AuthorizesRequests;

    public function mount()
    {
        $this->authorize('settings.appearance');
    }
}
