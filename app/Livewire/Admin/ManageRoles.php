<?php

namespace App\Livewire\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageRoles extends Component
{
    use AuthorizesRequests;

    public $roleId;

    public $roleName;

    public $newRoleName;

    public $selectedPermissions = [];

    public $showRoleModal = false;

    public $showCreateModal = false;

    public function mount()
    {
        $this->authorize('admin.manage-roles');
    }

    public function createRole()
    {
        $this->validate([
            'newRoleName' => 'required|unique:roles,name',
        ], [
            'newRoleName.required' => 'Emri i rolit është i detyrueshëm.',
            'newRoleName.unique' => 'Ky rol ekziston aktualisht.',
        ]);

        Role::create(['name' => strtolower($this->newRoleName)]);

        $this->newRoleName = '';
        $this->showCreateModal = false;
        session()->flash('message', 'Roli i ri u krijua me sukses.');
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'admin') {
            session()->flash('error', 'Roli admin nuk mund të fshihet.');

            return;
        }

        $role->delete();
        session()->flash('message', 'Roli u fshi me sukses.');
    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);
        $this->roleId = $role->id;
        $this->roleName = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->showRoleModal = true;
    }

    public function saveRolePermissions()
    {
        $this->authorize('admin.manage-roles');

        $role = Role::findOrFail($this->roleId);
        $role->syncPermissions($this->selectedPermissions);

        $this->showRoleModal = false;
        session()->flash('message', 'Permissionet e rolit u përditësuan me sukses.');
    }

    public function render()
    {
        $roles = Role::with('permissions')->get();
        $permissionsByModule = Permission::all()->groupBy('module');

        return view('livewire.admin.manage-roles', [
            'roles' => $roles,
            'permissionsByModule' => $permissionsByModule,
        ])->layout('layouts.dashboard.app');
    }
}
