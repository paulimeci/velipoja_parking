<?php

use App\Livewire\Admin\ChangePassword;
use App\Livewire\Admin\LanguageManager;
use App\Livewire\Admin\LiveAdminDashboard;
use App\Livewire\Admin\LiveAdminKonfiguroOret;
use App\Livewire\Admin\LiveBilanciTransaksioneve;
use App\Livewire\Admin\ManageRoles;
use App\Livewire\Admin\ManageUsers;
use App\Http\Controllers\PrintController;
use App\Livewire\Operatori\LiveKryejOperacionet;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Ndrysho rrugën kryesore '/'
Route::get('/', function () {
    if (Auth::check()) {
        // Nëse është i loguar, e çojmë te dashboard që bën ndarjen e roleve automatikisht
        return redirect()->route('dashboard');
    }

    // Nëse NUK është i loguar, e çojmë te faqja e login-it
    return redirect()->route('login');
})->name('home');
Route::middleware(['auth', 'verified'])->group(function () {

    // KETU BEHET REDIRECT DINAMIK BAZUAR NE PERMISSIONS/ROLET E SPATIE
    Route::get('dashboard', function () {
        $user = Auth::user();

        if ($user->can('admin.dashboard') || $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->can('operatori.kryej-operacionet') || $user->hasRole('user')) {
            return redirect()->route('operatori.operacionet');
        }

        // Default nëse nuk ka asnjë nga këto (opsionale)
        return redirect()->route('admin.change-password');
    })->name('dashboard');

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

    Route::middleware(['can:admin.manage-raportet'])->group(function () {
        // Kjo është tabela e bilancit që bëmë bashkë me eksportin Excel
        Route::get('admin/transaksionet', LiveBilanciTransaksioneve::class)->name('admin.bilanci.transaksioneve');
    });

    Route::middleware(['can:manage all'])->group(function () {
        Route::get('admin/gjuhët', LanguageManager::class)->name('admin.languages');
    });

    Route::get('admin/ndrysho-fjalëkalimin', ChangePassword::class)->name('admin.change-password');

    // Operatori Routes
    Route::middleware(['can:operatori.kryej-operacionet'])->group(function () {
        Route::get('operatori/operacionet', LiveKryejOperacionet::class)->name('operatori.operacionet');
    });

    Route::get('/print/hyrje/{operacioni}', [PrintController::class, 'kuponiHyrjes'])
        ->name('print.hyrje')
        ->middleware('auth');

    Route::get('/print/dalje/{operacioni}', [PrintController::class, 'kuponiDaljes'])
        ->name('print.dalje')
        ->middleware('auth');

});

require __DIR__.'/settings.php';
