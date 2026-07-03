<?php

use App\Livewire\Admin\LiveAdminDashboard;
use App\Livewire\Admin\LiveAdminKonfiguroOret;
use App\Livewire\Admin\ManageRoles;
use App\Livewire\Admin\ManageUsers;
use App\Livewire\Operatori\LiveKryejOperacionet;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // Admin Routes
    Route::middleware(['can:admin.dashboard'])->group(function () {
        Route::get('/admin/dashboard', LiveAdminDashboard::class)->name('admin.dashboard');
    });

    Route::middleware(['can:admin.konfiguro-oret'])->group(function () {
        Route::get('admin/konfiguo/oret', LiveAdminKonfiguroOret::class)->name('admin.manage.oret');
    });

    Route::middleware(['can:admin.manage-users'])->group(function () {
        Route::get('admin/përdoruesit', ManageUsers::class)->name('admin.users');
    });

    Route::middleware(['can:admin.manage-roles'])->group(function () {
        Route::get('admin/rolet', ManageRoles::class)->name('admin.roles');
    });

    // Operatori Routes
    Route::middleware(['can:operatori.kryej-operacionet'])->group(function () {
        Route::get('operatori/operacionet', LiveKryejOperacionet::class)->name('operatori.operacionet');
    });
});

require __DIR__.'/settings.php';
