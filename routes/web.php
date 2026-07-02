<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

     Route::get('/admin/dashboard', \App\Livewire\Admin\LiveAdminDashboard::class)
        /*->middleware('role:admin')
        ->name('admin.dashboard')*/;
        Route::get('admin/konfiguo/oret',\App\Livewire\Admin\LiveAdminKonfiguroOret::class)->name('admin.manage.oret');


});

require __DIR__.'/settings.php';
