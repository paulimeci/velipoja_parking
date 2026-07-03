<?php

namespace App\Livewire\Admin;

use App\Concerns\PasswordValidationRules;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    use AuthorizesRequests, PasswordValidationRules;

    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function mount()
    {
        // No specific permission required other than being logged in,
        // but we can add one if needed.
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => $this->passwordRules(),
        ], [
            'current_password.current_password' => __('Fjalëkalimi aktual nuk është i saktë.'),
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['current_password', 'password', 'password_confirmation']);

        session()->flash('message', __('Fjalëkalimi u ndryshua me sukses.'));
    }

    public function render()
    {
        return view('livewire.admin.change-password')->layout('layouts.dashboard.app');
    }
}
