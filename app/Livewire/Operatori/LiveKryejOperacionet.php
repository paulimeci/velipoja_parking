<?php

namespace App\Livewire\Operatori;

use App\Models\Admin\TransaksioniOperacionit;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Admin\KategoriaPageses;
use App\Models\Admin\Monedhat;
use App\Models\Admin\Operacionet;
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
    public $kerkoTarge = '';
    public $klickedTarga = false;
    public $mjetiZgjedhur = null;
    public $koha_qendrimit = '';
    public $metoda_pageses = 'kesh';
    public $modal_id_kategoria;
    public $modal_id_monedha;
    public $modal_vlera = '';
    public $modal_id_fasha;

    // NEW: dallon nëse modali u hap për "pagesë paraprake" (mjeti mbetet prezent)
    // apo për mbylljen reale të operacionit (mjeti largohet)
    public $eshteRegjistrimParaprak = false;

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

    // ════════════════════════════════════════════════
    // NEW: Trigger-i kryesor — thirret automatikisht kur ndryshon $eshte_paguar
    // (falë wire:model.live="eshte_paguar" në blade)
    // ════════════════════════════════════════════════
    public function updatedEshtePaguar($value)
    {
        if (!$value) {
            return; // nëse e çekon, nuk bëjmë asgjë
        }

        // Duhet targa e plotësuar përpara se të vazhdojmë
        $this->validate([
            'targa' => 'required|string|max:20',
        ], [
            'targa.required' => 'Ju lutem vendosni targën e makinës para se ta shënoni si të paguar.',
        ]);

        $targaPastruar = strtoupper(str_replace(' ', '', $this->targa));

        $ekziston = Operacionet::where('status', 'prezent')
            ->whereRaw("REPLACE(UPPER(targa), ' ', '') = ?", [$targaPastruar])
            ->exists();

        if ($ekziston) {
            $this->addError('targa', 'Kjo targë është tashmë e regjistruar si "Prezent" në parking.');
            $this->eshte_paguar = false;
            return;
        }

        // Regjistrojmë menjëherë mjetin si "prezent"
        $operacioni = Operacionet::create([
            'targa'  => $targaPastruar,
            'nisja'  => now(),
            'ikja'   => null,
            'status' => 'prezent',
        ]);

        // Pastrojmë formën e regjistrimit për mjetin tjetër
        $this->reset('targa', 'eshte_paguar', 'shuma_paguar');

        // Hapim modalin e pagesës në "modë paraprak" (pa e mbyllur operacionin)
        $this->eshteRegjistrimParaprak = true;
        $this->inicializoModalinPerOperacionin($operacioni);

        session()->flash('success', 'Mjeti u regjistrua si Prezent. Vazhdo me pagesën paraprake më poshtë.');
    }

    // ════════════════════════════════════════════════
    // Hapja e modalit nga lista e "Mjeteve Prezent" (mbyllje reale)
    // ════════════════════════════════════════════════
    public function shfaqModalPagesen($id)
    {
        $operacioni = Operacionet::find($id);

        if ($operacioni) {
            $this->eshteRegjistrimParaprak = false; // kjo është mbyllja reale
            $this->inicializoModalinPerOperacionin($operacioni);
        }
    }

    // ════════════════════════════════════════════════
    // NEW: Logjika e përbashkët për të inicializuar modalin
    // (përdoret dhe nga pagesa paraprake dhe nga mbyllja reale)
    // ════════════════════════════════════════════════
    private function inicializoModalinPerOperacionin(Operacionet $operacioni)
    {
        $this->mjetiZgjedhur = $operacioni;

        // NEW: kontrollojmë nëse ekziston tashmë një transaksion (nga parapagesa)
        $transaksioniEkzistues = TransaksioniOperacionit::where('id_operacionit', $operacioni->id)->first();

        if ($this->eshteRegjistrimParaprak) {
            // Modë parapagese: vendosim default-et normale
            $sherbimiDefault = KategoriaPageses::where('is_default', 1)->first();
            $this->modal_id_kategoria = $sherbimiDefault ? $sherbimiDefault->id : null;

            $monedhaDefault = Monedhat::where('kodi', 'ALL')->first();
            $this->modal_id_monedha = $monedhaDefault ? $monedhaDefault->id : null;

            $fashaEPare = \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->modal_id_kategoria)
                ->orderBy('nga')
                ->first();
            $this->modal_id_fasha = $fashaEPare ? $fashaEPare->id : null;

            $this->llogaritCmiminAutomatik();
        } elseif ($transaksioniEkzistues) {
            // NEW: Mbyllje reale ME parapagesë ekzistuese — mbushim modalin me të dhënat e ruajtura
            $this->modal_id_kategoria = $transaksioniEkzistues->id_prenotimit;
            $this->modal_id_monedha   = $transaksioniEkzistues->monedha;
            $this->modal_id_fasha     = $transaksioniEkzistues->id_fashes_orare;
            $this->modal_vlera        = $transaksioniEkzistues->vlera;
        } else {
            // Mbyllje reale PA parapagesë (rast direkt) — sillet si më parë, auto-llogaritje nga koha
            $sherbimiDefault = KategoriaPageses::where('is_default', 1)->first();
            $this->modal_id_kategoria = $sherbimiDefault ? $sherbimiDefault->id : null;

            $monedhaDefault = Monedhat::where('kodi', 'ALL')->first();
            $this->modal_id_monedha = $monedhaDefault ? $monedhaDefault->id : null;

            $this->modal_id_fasha = null;

            $this->llogaritCmiminAutomatik();
        }

        // Llogaritja e kohës së qëndrimit (gjithmonë, për shfaqje informative)
        $hyrja = Carbon::parse($operacioni->nisja);
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

        $this->klickedTarga = true;
    }

    public function llogaritCmiminAutomatik()
    {
        if (!$this->mjetiZgjedhur) {
            return;
        }

        if ($this->modal_id_fasha) {
            // Fasha është zgjedhur (manualisht ose e ruajtur) — çmimi vjen prej saj
            $fashaOrare = \App\Models\Admin\OretCmimi::find($this->modal_id_fasha);
        } elseif (!$this->eshteRegjistrimParaprak) {
            // Mbyllje direkte pa fashë të zgjedhur — auto nga koha reale
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

            $this->modal_id_fasha = $fashaOrare?->id;
        } else {
            $this->modal_vlera = '';
            return;
        }

        $cmimiMonedhes = $fashaOrare
            ? $fashaOrare->cmimet()->where('monedha_id', $this->modal_id_monedha)->first()
            : null;

        $this->modal_vlera = $cmimiMonedhes ? $cmimiMonedhes->vlera : '';
    }

    public function updatedModalIdFasha()
    {
        $this->llogaritCmiminAutomatik();
    }

// NEW


    public function updatedModalIdMonedha()
    {
        $this->llogaritCmiminAutomatik();
    }

    public function updatedModalIdKategoria()
    {
        $fashaEPare = \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->modal_id_kategoria)
            ->orderBy('nga')
            ->first();
        $this->modal_id_fasha = $fashaEPare ? $fashaEPare->id : null;

        $this->llogaritCmiminAutomatik();
    }
    // ════════════════════════════════════════════════
    // Ruajtja e transaksionit — tani vepron ndryshe në bazë të flag-ut
    // ════════════════════════════════════════════════
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

        $tedhenatTransaksionit = [
            'id_operacionit'  => $this->mjetiZgjedhur->id,
            'id_prenotimit'   => $this->modal_id_kategoria,
            'id_fashes_orare' => $this->modal_id_fasha, // NEW
            'status_pagesa'   => 'paguar',
            'monedha'         => $this->modal_id_monedha,
            'vlera'           => $this->modal_vlera,
        ];

        // NEW: nëse ekziston tashmë një transaksion për këtë operacion (nga parapagesa), e përditësojmë
        $transaksioniEkzistues = TransaksioniOperacionit::where('id_operacionit', $this->mjetiZgjedhur->id)->first();

        if ($transaksioniEkzistues) {
            $transaksioniEkzistues->update($tedhenatTransaksionit);
        } else {
            TransaksioniOperacionit::create($tedhenatTransaksionit);
        }

        if ($this->eshteRegjistrimParaprak) {
            session()->flash('success', 'Pagesa u regjistrua paraprakisht. Mjeti mbetet Prezent në parking.');
        } else {
            $this->mjetiZgjedhur->update([
                'ikja'   => now(),
                'status' => 'larguar',
            ]);
            session()->flash('success', 'Operacioni u mbyll me sukses!');
        }

        $this->klickedTarga = false;
        $this->mjetiZgjedhur = null;
        $this->koha_qendrimit = '';
        $this->modal_vlera = '';
        $this->modal_id_fasha = null;
        $this->eshteRegjistrimParaprak = false;
    }

    // Regjistrimi normal (pa pagesë) mbetet i njëjtë
    public function ruajOperacionin()
    {
        $targaPastruar = strtoupper(str_replace(' ', '', $this->targa));

        $rules = [
            'targa' => 'required|string|max:20',
        ];

        $this->validate($rules, [
            'targa.required' => 'Ju lutem vendosni targën e makinës.',
        ]);

        $ekziston = Operacionet::where('status', 'prezent')
            ->whereRaw("REPLACE(UPPER(targa), ' ', '') = ?", [$targaPastruar])
            ->exists();

        if ($ekziston) {
            $this->addError('targa', 'Kjo targë është tashmë e regjistruar si "Prezent" në parking.');
            return;
        }

        Operacionet::create([
            'targa'  => $targaPastruar,
            'nisja'  => now(),
            'ikja'   => null,
            'status' => 'prezent',
        ]);

        session()->flash('success', 'Mjeti u regjistrua me sukses si Prezent!');

        $this->reset('targa', 'shuma_paguar', 'eshte_paguar');

        $kategoriaDefault = KategoriaPageses::where('is_default', 1)->first();
        if ($kategoriaDefault) {
            $this->id_kategoria = $kategoriaDefault->id;
        }
    }

    public function render()
    {
        $mjetePrezent = Operacionet::where('status', 'prezent')
            ->when($this->kerkoTarge, function($query) {
                $query->where('targa', 'like', '%' . strtoupper($this->kerkoTarge) . '%');
            })
            ->get();

        // NEW: fashat orare gjithmonë sipas kategorisë së zgjedhur në modal
        $fashatOrare = $this->modal_id_kategoria
            ? \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->modal_id_kategoria)
                ->orderBy('nga')
                ->get()
            : collect();

        return view('livewire.operatori.live-kryej-operacionet', [
            'kategorite'   => KategoriaPageses::all(),
            'monedhat'     => Monedhat::all(),
            'mjetePrezent' => $mjetePrezent,
            'fashatOrare'  => $fashatOrare,
        ])->layout('layouts.dashboard.app');
    }
}
