<?php

namespace App\Livewire\Operatori;

use App\Models\Admin\TransaksioniOperacionit;
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
        // Hiqim ->with(['kategoria','monedha']) — Operacionet s'ka këto relacione
        $this->mjetiZgjedhur = Operacionet::find($id);

        if ($this->mjetiZgjedhur) {
            $sherbimiDefault = KategoriaPageses::where('is_default', 1)->first();
            $this->modal_id_kategoria = $sherbimiDefault ? $sherbimiDefault->id : null;

            $monedhaDefault = Monedhat::where('kodi', 'ALL')->first();
            $this->modal_id_monedha = $monedhaDefault ? $monedhaDefault->id : null;

            $hyrja = Carbon::parse($this->mjetiZgjedhur->nisja);
            $tani  = Carbon::now();

            $diferencaDite   = (int) $hyrja->diffInDays($tani);
            $diferencaOre    = (int) ($hyrja->diffInHours($tani) % 24);
            $diferencaMinuta = (int) ($hyrja->diffInMinutes($tani) % 60);

            $pjeset = [];
            if ($diferencaDite >= 1) { $pjeset[] = $diferencaDite . ' ditë'; }
            if ($diferencaOre > 0) { $pjeset[] = $diferencaOre . ' orë'; }
            if ($diferencaMinuta > 0 || empty($pjeset)) { $pjeset[] = $diferencaMinuta . ' min'; }

            if (count($pjeset) > 1) {
                $fundi = array_pop($pjeset);
                $this->koha_qendrimit = implode(', ', $pjeset) . ' e ' . $fundi;
            } else {
                $this->koha_qendrimit = $pjeset[0];
            }

            $this->llogaritCmiminAutomatik();
        }

        $this->klickedTarga = true;
    }

    public function llogaritCmiminAutomatik()
    {
        if (!$this->mjetiZgjedhur) {
            return;
        }

        $hyrja = Carbon::parse($this->mjetiZgjedhur->nisja);
        $tani  = Carbon::now();

        $totaliMinutaveReal = $hyrja->diffInMinutes($tani);
        $oreTeqendrimit = max($totaliMinutaveReal / 60, 0.01);

        $fashaOrare = \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->modal_id_kategoria)
            ->whereRaw('? BETWEEN `nga` AND `ne`', [$oreTeqendrimit])
            ->first();

        if (!$fashaOrare) {
            $fashaOrare = \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->modal_id_kategoria)
                ->orderBy('ne', 'desc')
                ->first();
        }

        $cmimiMonedhes = $fashaOrare
            ? $fashaOrare->cmimet()->where('monedha_id', $this->modal_id_monedha)->first()
            : null;

        $this->modal_vlera = $cmimiMonedhes ? $cmimiMonedhes->vlera : '';
    }

    public function updatedModalIdMonedha()
    {
        $this->llogaritCmiminAutomatik();
    }

// Ri-llogarit çmimin nëse përdoruesi ndryshon Shërbimin nga dropdown-i
    public function updatedModalIdKategoria()
    {
        $this->llogaritCmiminAutomatik();
    }

    public function ruajTransaksionin()
    {
        $this->validate([
            'modal_id_kategoria' => 'required',
            'modal_id_monedha'   => 'required',
            'modal_vlera'        => 'required|numeric|min:0',
        ], [
            'modal_vlera.required' => 'Ju lutem vendosni vlerën e pagesës.',
        ]);

        if (!$this->mjetiZgjedhur) {
            return;
        }

        // ════════════════════════════════════════════════
        // 1) RUAJTJA E TRANSAKSIONIT (adm_transaksioni_operacionit)
        // ════════════════════════════════════════════════
        TransaksioniOperacionit::create([
            'id_operacionit' => $this->mjetiZgjedhur->id,   // lidhja me mjetin/operacionin
            'id_prenotimit'  => $this->modal_id_kategoria,  // shërbimi/kategoria e zgjedhur në modal
            'status_pagesa'  => 'paguar',                   // mbyllja e operacionit nënkupton pagesë
            'monedha'        => $this->modal_id_monedha,
            'vlera'          => $this->modal_vlera,
        ]);

        // ════════════════════════════════════════════════
        // 2) MBYLLJA E OPERACIONIT (adm_operacionet)
        // ════════════════════════════════════════════════
        $this->mjetiZgjedhur->update([
            'ikja'   => now(),
            'status' => 'larguar',
        ]);

        // Mbyllim modalin dhe pastrojmë state-in
        $this->klickedTarga = false;
        $this->mjetiZgjedhur = null;
        $this->koha_qendrimit = '';
        $this->modal_vlera = '';

        session()->flash('success', 'Operacioni u mbyll me sukses!');
    }

    public function ruajOperacionin()
    {
        // Pastrojmë targën: heqim hapësirat dhe e kthejmë me shkronja të mëdha
        $targaPastruar = strtoupper(str_replace(' ', '', $this->targa));

        // Validimi i fushave
        $rules = [
            'targa' => 'required|string|max:20',
            /* 'id_kategoria' => 'required',
            'id_monedha'   => 'required', */
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
        // KONTROLLI: A ËSHTË MJETI TASHMË "PREZENT" NË PARKING?
        // ════════════════════════════════════════════════
        $ekziston = Operacionet::where('status', 'prezent')
            ->whereRaw("REPLACE(UPPER(targa), ' ', '') = ?", [$targaPastruar])
            ->exists();

        if ($ekziston) {
            $this->addError('targa', 'Kjo targë është tashmë e regjistruar si "Prezent" në parking.');
            return;
        }

        // ════════════════════════════════════════════════
        // RUAJTJA NË DATABAZË (Tabela: adm_operacionet)
        // ════════════════════════════════════════════════
        Operacionet::create([
            'targa'  => $targaPastruar, // E ruajmë të pastruar (pa hapësira, me shkronja të mëdha)
            'nisja'  => now(),
            'ikja'   => null,
            'status' => 'prezent',
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
