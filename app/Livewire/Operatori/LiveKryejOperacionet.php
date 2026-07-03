<?php

namespace App\Livewire\Operatori;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Admin\KategoriaPageses;
use App\Models\Admin\Monedhat;
use App\Models\Admin\Operacionet; // <-- Importojmë Modelin e ri këtu
use Livewire\Component;

class LiveKryejOperacionet extends Component
{
    use AuthorizesRequests;

    // Vetitë e formës
    public $targa;
    public $id_kategoria;
    public $id_monedha;
    public $eshte_paguar = false;
    public $shuma_paguar;
    public $kerkoTarge = ''; // Ruante tekstin e kërkimit
    public function mount()
    {
        $kategoriaDefault = KategoriaPageses::where('is_default', 1)->first();
        if ($kategoriaDefault) {
            $this->id_kategoria = $kategoriaDefault->id;
        }

        $monedhaDefault = Monedhat::where('kodi', 'ALL')->first();
        if ($monedhaDefault) {
            $this->id_monedha = $monedhaDefault->id;
        }
    }

    public function ruajOperacionin()
    {
        // Validimi i fushave
        $rules = [
            'targa'        => 'required|string|max:20',
            'id_kategoria' => 'required',
            'id_monedha'   => 'required',
        ];

        if ($this->eshte_paguar) {
            $rules['shuma_paguar'] = 'required|numeric|min:0';
        }

        $this->validate($rules, [
            'targa.required'        => 'Ju lutem vendosni targën e makinës.',
            'id_kategoria.required' => 'Ju lutem zgjidhni shërbimin.',
            'id_monedha.required'   => 'Ju lutem zgjidhni monedhën.',
            'shuma_paguar.required' => 'Ju lutem vendosni shifrën e paguar.',
        ]);

        // ════════════════════════════════════════════════
        // RUAJTJA NË DATABAZË (Tabela: adm_operacionet)
        // ════════════════════════════════════════════════
        Operacionet::create([
            'targa'  => strtoupper($this->targa), // E kthejmë targën me shkronja të mëdha automatikisht
            'nisja'  => now(),                    // Vendos datën dhe orën aktuale
            'ikja'   => null,                     // E lëmë null siç kërkove
            'status' => 'prezent',                // Vlera nga enumi
        ]);

        // TODO: Këtu më vonë do shtohet logjika e dytë për ruajtjen te tabela e pagesave
        // nëse $this->eshte_paguar është true.

        session()->flash('success', 'Mjeti u regjistrua me sukses si Prezent!');

        // Resetojmë fushat për operacionin e radhës
        $this->reset('targa', 'shuma_paguar', 'eshte_paguar');

        // Rikthejmë kategorinë default
        $kategoriaDefault = KategoriaPageses::where('is_default', 1)->first();
        if ($kategoriaDefault) {
            $this->id_kategoria = $kategoriaDefault->id;
        }
    }



    public function render()
    {
        // Filtrojmë mjetet prezent në bazë të asaj që shkruhet te searchbox
        $mjetePrezent = Operacionet::where('status', 'prezent')
            ->when($this->kerkoTarge, function($query) {
                $query->where('targa', 'like', '%' . strtoupper($this->kerkoTarge) . '%');
            })
            ->get();

        return view('livewire.operatori.live-kryej-operacionet', [
            'kategorite'   => KategoriaPageses::all(),
            'monedhat'     => Monedhat::all(),
            'mjetePrezent' => $mjetePrezent, // ia kalojmë listën e filtruar frontend-it
        ])->layout('layouts.dashboard.app');
    }
}
