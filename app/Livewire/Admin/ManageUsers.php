<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class ManageUsers extends Component
{
    use AuthorizesRequests, WithPagination;

    public $search = '';

    public $userId;

    public $name;

    public $email;

    public $selectedRoles = [];

    public $showUserModal = false;

    protected $updatesQueryString = ['search'];

    public function mount()
    {
        $this->authorize('admin.manage-users');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
        $this->showUserModal = true;
    }

    public function saveUser()
    {
        $this->authorize('admin.manage-users');

        $user = User::findOrFail($this->userId);
        $user->syncRoles($this->selectedRoles);

        $this->showUserModal = false;
        session()->flash('message', 'Roli i përdoruesit u përditësua me sukses.');
    }

    public function deleteUser($id)
    {
        $this->authorize('admin.delete-users');

        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            session()->flash('error', 'Nuk mund të fshini veten tuaj.');

            return;
        }

        // Optional: protect specific admin email
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
