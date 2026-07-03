<?php

namespace App\Livewire\Operatori;

use Carbon\Carbon;
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
    public $klickedTarga = false;
    public $mjetiZgjedhur = null;
    public $koha_qendrimit = '';
    public $metoda_pageses = 'kesh';
    public $modal_id_kategoria;
    public $modal_id_monedha;
    public $modal_vlera = '';
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


    public function shfaqModalPagesen($id)
    {
        $this->mjetiZgjedhur = Operacionet::with(['kategoria', 'monedha'])->find($id);

        if ($this->mjetiZgjedhur) {
            // 1. Gjejmë shërbimin default nga lista e kategorive
            // Supozojmë se kolona në tabelë quhet 'is_default' (ndryshoje nëse e ke ndryshe, p.sh. 'default')
            $sherbimiDefault = KategoriaPageses::where('is_default', 1)->first();

            // 2. E vendosim shërbimin default në dropdown. Nëse nuk ekziston, përdorim atë të mjetit.
            $this->modal_id_kategoria = $sherbimiDefault ? $sherbimiDefault->id : $this->mjetiZgjedhur->id_kategoria;

            // Monedha qëndron ajo që ka mjeti (ose siç dëshiron ta lësh)
            $this->modal_id_monedha = $this->mjetiZgjedhur->id_monedha;
            $this->modal_vlera = ''; // Lihet bosh fillimisht

            // Llogaritja e saktë e kohës
            $hyrja = Carbon::parse($this->mjetiZgjedhur->nisja);
            $tani = Carbon::now();

            $diferencaDite = (int) $hyrja->diffInDays($tani);
            $diferencaOre = (int) ($hyrja->diffInHours($tani) % 24);
            $diferencaMinuta = (int) ($hyrja->diffInMinutes($tani) % 60);

            $pjeset = [];
            if ($diferencaDite >= 1) {
                $pjeset[] = $diferencaDite . ' ditë';
            }
            if ($diferencaOre > 0) {
                $pjeset[] = $diferencaOre . ' orë';
            }
            if ($diferencaMinuta > 0 || empty($pjeset)) {
                $pjeset[] = $diferencaMinuta . ' min';
            }

            if (count($pjeset) > 1) {
                $fundi = array_pop($pjeset);
                $this->koha_qendrimit = implode(', ', $pjeset) . ' e ' . $fundi;
            } else {
                $this->koha_qendrimit = $pjeset[0];
            }
        }

        $this->klickedTarga = true;
    }

    public function ruajTransaksionin()
    {
        // logjika e ruajtjes

        // shembull:
        // Transaksioni::create([...]);

        dd("ok");
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
