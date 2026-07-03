<?php

namespace App\Livewire\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class LiveAdminDashboard extends Component
{
    use AuthorizesRequests;

    public function mount()
    {
        $this->authorize('admin.dashboard');
    }

    public function render()
    {
        return view('livewire.admin.live-admin-dashboard')->layout('layouts.dashboard.app');
    }
}
