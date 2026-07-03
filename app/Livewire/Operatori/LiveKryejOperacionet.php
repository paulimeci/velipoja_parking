<?php

namespace App\Livewire\Operatori;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveKryejOperacionet extends Component
{
    use AuthorizesRequests;

    public function mount()
    {
        $this->authorize('operatori.kryej-operacionet');
    }

    public function render()
    {
        return view('livewire.operatori.live-kryej-operacionet');
    }
}
