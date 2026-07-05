<?php

namespace App\Livewire\Operatori;

use App\Models\Admin\TransaksioniOperacionit;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Admin\KategoriaPageses;
use App\Models\Admin\Monedhat;
use App\Models\Admin\Operacionet;
use Illuminate\Support\Facades\Auth;
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
    // Shtoje te vetitë e klasës
    public $transaksioniIRuajtur = null;

    // NEW: dallon nëse modali u hap për "pagesë paraprake" (mjeti mbetet prezent)
    // apo për mbylljen reale të operacionit (mjeti largohet)
    public $eshteRegjistrimParaprak = false;
    public $modal_sasia = 1;


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
            'id_operatori'  => Auth::user()->id,
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

        // Ngarkojmë me relacionin fashaOrare që ta kemi gati për shfaqje
        $transaksioniEkzistues = TransaksioniOperacionit::with('fashaOrare')
            ->where('id_operacionit', $operacioni->id)
            ->first();

        $this->transaksioniIRuajtur = $transaksioniEkzistues;

        // 1. LLOGARITJA E KOHËS REALE (Në orë me presje, p.sh. 5 orë e 3 min = 5.05)
        $hyrja = Carbon::parse($operacioni->nisja);
        $tani  = Carbon::now();
        $oreTeQendrimitReal = max($hyrja->diffInMinutes($tani) / 60, 0.01);

        if ($this->eshteRegjistrimParaprak) {
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
            $this->modal_id_kategoria = $transaksioniEkzistues->id_prenotimit;
            $this->modal_id_monedha   = $transaksioniEkzistues->monedha;
            $this->modal_id_fasha     = $transaksioniEkzistues->id_fashes_orare;
            $this->modal_sasia        = $transaksioniEkzistues->sasia ?? 1;
            $this->modal_vlera        = $transaksioniEkzistues->vlera;
        } else {
            $sherbimiDefault = KategoriaPageses::where('is_default', 1)->first();
            $this->modal_id_kategoria = $sherbimiDefault ? $sherbimiDefault->id : null;

            $monedhaDefault = Monedhat::where('kodi', 'ALL')->first();
            $this->modal_id_monedha = $monedhaDefault ? $monedhaDefault->id : null;

            // FIX: përdorim metodën e përbashkët në vend të logjikës së dyfishtë
            if ($this->modal_id_kategoria) {
                $fashaEPershtatshme = $this->gjejFashenPerKohenReale($this->modal_id_kategoria);
                $this->modal_id_fasha = $fashaEPershtatshme ? $fashaEPershtatshme->id : null;
            } else {
                $this->modal_id_fasha = null;
            }

            $this->llogaritCmiminAutomatik();
        }

        // 3. SHFAQJA E TEKSTIT TË KOHËS SË QËNDRIMIT
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
    // NEW: Metodë e përbashkët — gjen fashën orare që përputhet me kohën reale të qëndrimit
    private function gjejFashenPerKohenReale(int $idKategoria): ?\App\Models\Admin\OretCmimi
    {
        if (!$this->mjetiZgjedhur) {
            return null;
        }

        $hyrja = Carbon::parse($this->mjetiZgjedhur->nisja);
        $tani  = Carbon::now();
        $oreTeQendrimitReal = max($hyrja->diffInMinutes($tani) / 60, 0.01);

        $fashatEKategorise = \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $idKategoria)
            ->orderBy('nga')
            ->get();

        $fashaAutodetektuar = $fashatEKategorise->first(function ($fasha) use ($oreTeQendrimitReal) {
            return $oreTeQendrimitReal >= $fasha->nga && $oreTeQendrimitReal <= $fasha->ne;
        });

        // Nëse ka kaluar limitin e fundit, merr fashën maksimale
        return $fashaAutodetektuar ?: $fashatEKategorise->last();
    }

    public function llogaritCmiminAutomatik()
    {
        if (!$this->mjetiZgjedhur) {
            return;
        }

        $kategoria = KategoriaPageses::find($this->modal_id_kategoria);
        $eshteNjesiaDite = $kategoria && $kategoria->eshteNjesiaDite();

        if ($eshteNjesiaDite) {
            // NEW: llogaritje me SASI — çmimi_njësi × sasia, pa bracket fare
            $njesiaCmimi = $this->modal_id_fasha
                ? \App\Models\Admin\OretCmimi::find($this->modal_id_fasha)
                : \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->modal_id_kategoria)->first();

            $cmimiMonedhes = $njesiaCmimi
                ? $njesiaCmimi->cmimet()->where('monedha_id', $this->modal_id_monedha)->first()
                : null;

            $cmimiNjesi = $cmimiMonedhes ? $cmimiMonedhes->vlera : 0;
            $this->modal_vlera = round($cmimiNjesi * max($this->modal_sasia, 0), 2);
            return;
        }

        // Orë — sillet EKZAKTËSISHT si më parë, pa asnjë ndryshim
        if ($this->modal_id_fasha) {
            $fashaOrare = \App\Models\Admin\OretCmimi::find($this->modal_id_fasha);
        } elseif (!$this->eshteRegjistrimParaprak) {
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

// NEW: rillogarit sa herë ndryshon sasia
    public function updatedModalSasia()
    {
        $this->llogaritCmiminAutomatik();
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
        $kategoria = KategoriaPageses::find($this->modal_id_kategoria);

        if ($kategoria && $kategoria->eshteNjesiaDite()) {
            $njesiaCmimi = \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->modal_id_kategoria)
                ->first();
            $this->modal_id_fasha = $njesiaCmimi ? $njesiaCmimi->id : null;
            $this->modal_sasia = 1;
        } elseif ($this->eshteRegjistrimParaprak) {
            // Parapagesë — s'ka kohë reale kuptimplote ende, marrim fashën e parë si default
            $fashaEPare = \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->modal_id_kategoria)
                ->orderBy('nga')
                ->first();
            $this->modal_id_fasha = $fashaEPare ? $fashaEPare->id : null;
        } else {
            // FIX: Mbyllje reale — gjejmë fashën që PËRPUTHET me kohën reale të qëndrimit
            $fashaEPershtatshme = $this->gjejFashenPerKohenReale($this->modal_id_kategoria);
            $this->modal_id_fasha = $fashaEPershtatshme ? $fashaEPershtatshme->id : null;
        }

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
            'id_fashes_orare' => $this->modal_id_fasha,
            'sasia'           => $this->modal_sasia, // NEW
            'status_pagesa'   => 'paguar',
            'monedha'         => $this->modal_id_monedha,
            'vlera'           => $this->modal_vlera,
        ];
        // FIX: Fshijmë ÇDO transaksion ekzistues për këtë operacion (edhe nëse ka dublikatë
        // aksidentale) përpara se të krijojmë të riun, kështu garantojmë vetëm 1 rekord aktiv
        TransaksioniOperacionit::where('id_operacionit', $this->mjetiZgjedhur->id)->delete();

        TransaksioniOperacionit::create($tedhenatTransaksionit);

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
        $this->transaksioniIRuajtur = null;
        $this->eshteRegjistrimParaprak = false;
        $this->modal_sasia = 1; // NEW

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
            'id_operatori'  => Auth::user()->id,
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

        $fashatOrare = $this->modal_id_kategoria
            ? \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->modal_id_kategoria)
                ->orderBy('nga')
                ->get()
            : collect();

        // NEW: përcaktojmë njësinë e matjes për kategorinë aktuale, për ta shfaqur në select
        $kategoriaAktuale = $this->modal_id_kategoria ? KategoriaPageses::find($this->modal_id_kategoria) : null;
        $njesiaFashave = ($kategoriaAktuale && $kategoriaAktuale->eshteNjesiaDite()) ? __('ditë') : __('orë');

        return view('livewire.operatori.live-kryej-operacionet', [
            'kategorite'    => KategoriaPageses::all(),
            'monedhat'      => Monedhat::all(),
            'mjetePrezent'  => $mjetePrezent,
            'fashatOrare'   => $fashatOrare,
            'njesiaFashave' => $njesiaFashave, // NEW
            'kategoriaAktuale' => $kategoriaAktuale, // NEW
        ])->layout('layouts.dashboard.app');
    }
}
