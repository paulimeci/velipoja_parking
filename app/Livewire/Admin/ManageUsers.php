<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class ManageUsers extends Component
{
    use AuthorizesRequests, WithPagination;

    public $search = '';

    public $userId = null; // null do të thotë që po krijojmë user të ri

    public $name;

    public $email;

    public $password; // Fusha e re për krijim

    public $selectedRoles = [];

    public $showUserModal = false;

    protected $updatesQueryString = ['search'];

    public function mount()
    {
        $this->authorize('admin.manage-users');
    }

    // Hap modalin bosh për krijim të ri
    public function createUser()
    {
        $this->resetValidation();
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->selectedRoles = [];
        $this->showUserModal = true;
    }

    // Hap modalin me të dhënat ekzistuese për editim
    public function editUser($id)
    {
        $this->resetValidation();
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = ''; // Lilet bosh gjatë editimit
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
        $this->showUserModal = true;
    }

    public function saveUser()
    {
        $this->authorize('admin.manage-users');

        // Rregullat e validimit dinamik
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->userId,
            'password' => $this->userId ? 'nullable|min:6' : 'required|min:6',
            'selectedRoles' => 'required|array|min:1',
        ];

        $this->validate($rules);

        if ($this->userId) {
            // Editim Përdoruesi
            $user = User::findOrFail($this->userId);
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            if (!empty($this->password)) {
                $user->update(['password' => Hash::make($this->password)]);
            }

            session()->flash('message', 'Përdoruesi u përditësua me sukses.');
        } else {
            // Krijim Përdoruesi i Ri
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            session()->flash('message', 'Përdoruesi i ri u krijua me sukses.');
        }

        // Sinkronizo rolet e përzgjedhura (Admin, Manager, Agent, etj.)
        $user->syncRoles($this->selectedRoles);

        $this->showUserModal = false;
    }

    public function deleteUser($id)
    {
        $this->authorize('admin.delete-users');

        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            session()->flash('error', 'Nuk mund të fshini veten tuaj.');
            return;
        }

        if ($user->email === 'paulin.meci@gmail.com') {
            session()->flash('error', 'Ky përdorues admin nuk mund të fshihet.');
            return;
        }

        $user->delete();
        session()->flash('message', __('Përdoruesi u fshi me sukses.'));
    }

    public function render()
    {
        $users = User::with('roles')
            ->where(function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->paginate(10);

        return view('livewire.admin.manage-users', [
            'users' => $users,
            'roles' => Role::all(),
        ])->layout('layouts.dashboard.app');
    }
}
