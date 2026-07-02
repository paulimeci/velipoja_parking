<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class LiveAdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.live-admin-dashboard')->layout('layouts.dashboard.app');
    }
}
