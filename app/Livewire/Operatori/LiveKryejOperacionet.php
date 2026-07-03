<?php

namespace App\Livewire\Operatori;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Admin\KategoriaPageses;
use App\Models\Admin\Monedhat;
use Livewire\Component;


class LiveKryejOperacionet extends Component
{
    use AuthorizesRequests;


    // Vetitë e formës
    public $targa;
    public $id_kategoria;
    public $id_monedha;

    public function mount()
    {
        // By default gjejmë monedhën me kodin ALL dhe e vendosim si të përzgjedhur
        $monedhaDefault = Monedhat::where('kodi', 'ALL')->first();
        if ($monedhaDefault) {
            $this->id_monedha = $monedhaDefault->id;
        }
    }

    public function ruajOperacionin()
    {
        $this->validate([
            'targa'        => 'required|string|max:20',
            'id_kategoria' => 'required|exists:kategoria_pageses,id', // Përshtate me emrin e saktë të tabelës sate
            'id_monedha'   => 'required|exists:monedhat,id',
        ], [
            'targa.required'        => 'Ju lutem vendosni targën e makinës.',
            'id_kategoria.required' => 'Ju lutem zgjidhni shërbimin.',
            'id_monedha.required'   => 'Ju lutem zgjidhni monedhën.',
        ]);

        // Këtu vendoset logjika jote për të ruajtur operacionin (p.sh. hyrjen e makinës)

        session()->flash('success', 'Operacioni u regjistrua me sukses!');

        // Resetojmë vetëm targën pas ruajtjes, kategorinë dhe monedhën i lëmë të zgjedhura
        $this->reset('targa');
    }

    public function render()
    {
        return view('livewire.operatori.live-kryej-operacionet', [
            'kategorite' => KategoriaPageses::all(),
            'monedhat'   => Monedhat::all(),
        ])->layout('layouts.dashboard.app');
    }
}
