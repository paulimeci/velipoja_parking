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
use App\Services\Admin\KuponParkimiService;

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

    public $tabiAktiv = 'sot'; // Vlera default: sot, dje, cakto_daten
    public $dataSpecifike;     // Do të lidhet me input-in e datës

    public $mjetiLarguarZgjedhur = null;
    public $shfaqModalDetajet = false;
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
        $this->dispatch('printo-kupon', url: route('print.hyrje', $operacioni->id));
        session()->flash('success', 'Mjeti u regjistrua si Prezent. Vazhdo me pagesën paraprake më poshtë.');
    }

    public function shfaqModalPagesen($id)
    {
        $operacioni = Operacionet::find($id);

        if ($operacioni) {
            $this->eshteRegjistrimParaprak = false; // kjo është mbyllja reale
            $this->inicializoModalinPerOperacionin($operacioni);
        }
    }

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

            if ($this->modal_id_kategoria) {
                $kategoriaZgjedhur = KategoriaPageses::find($this->modal_id_kategoria);

                if ($kategoriaZgjedhur && $kategoriaZgjedhur->eshteNjesiaDite()) {
                    // NEW: kategori ditë — llogarisim sasinë automatike (ceil)
                    $njesiaCmimi = \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->modal_id_kategoria)->first();
                    $this->modal_id_fasha = $njesiaCmimi ? $njesiaCmimi->id : null;
                    $this->modal_sasia = $this->llogaritSasineAutomatike($this->modal_id_kategoria);
                } else {
                    // Orë — sillet si më parë
                    $fashaEPershtatshme = $this->gjejFashenPerKohenReale($this->modal_id_kategoria);
                    $this->modal_id_fasha = $fashaEPershtatshme ? $fashaEPershtatshme->id : null;
                }
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

            // FIX: nëse është mbyllje reale, llogarit automatikisht (ceil); parapagesë mbetet 1
            $this->modal_sasia = $this->eshteRegjistrimParaprak
                ? 1
                : $this->llogaritSasineAutomatike($this->modal_id_kategoria);
        } elseif ($this->eshteRegjistrimParaprak) {
            $fashaEPare = \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->modal_id_kategoria)
                ->orderBy('nga')
                ->first();
            $this->modal_id_fasha = $fashaEPare ? $fashaEPare->id : null;
        } else {
            $fashaEPershtatshme = $this->gjejFashenPerKohenReale($this->modal_id_kategoria);
            $this->modal_id_fasha = $fashaEPershtatshme ? $fashaEPershtatshme->id : null;
        }

        $this->llogaritCmiminAutomatik();
    }

    // NEW: llogarit sa "njësi" (ditë/net) janë kaluar realisht, duke rrumbullakosur NGA LART
// p.sh. 4 ditë e 3 orë (me njësi 24-orëshe) → 5
    private function llogaritSasineAutomatike(int $idKategoria): int
    {
        if (!$this->mjetiZgjedhur) {
            return 1;
        }

        $kategoria = KategoriaPageses::find($idKategoria);
        $oreNjesie = $kategoria ? $kategoria->oreNjesiReale() : 24;

        $hyrja = Carbon::parse($this->mjetiZgjedhur->nisja);
        $tani  = Carbon::now();
        $oreReale = max($hyrja->diffInMinutes($tani) / 60, 0.01);

        return (int) ceil($oreReale / $oreNjesie);
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
            'sasia'           => $this->modal_sasia,
            'status_pagesa'   => 'paguar',
            'monedha'         => $this->modal_id_monedha,
            'vlera'           => $this->modal_vlera,
        ];

        $vleraEVjeter = $this->transaksioniIRuajtur->vlera ?? null;

        TransaksioniOperacionit::where('id_operacionit', $this->mjetiZgjedhur->id)->delete();

        $transaksioniIRi = TransaksioniOperacionit::create($tedhenatTransaksionit);

        if ($this->eshteRegjistrimParaprak) {
            // Printimi i kuponit të parapagesës — LAN, me fallback Bluetooth
            $rezultatiPrintimit = app(KuponParkimiService::class)->printoParapagesen(
                $this->mjetiZgjedhur, $transaksioniIRi, $this->metoda_pageses
            );

            if (!$rezultatiPrintimit) {
                $rawContent = app(KuponParkimiService::class)->buildParapagesenRaw(
                    $this->mjetiZgjedhur, $transaksioniIRi, $this->metoda_pageses
                );
                $this->dispatch('printo-bluetooth-fallback', rawContent: $rawContent);
            }

            session()->flash(
                $rezultatiPrintimit ? 'success' : 'error',
                $rezultatiPrintimit
                    ? 'Pagesa u regjistrua paraprakisht. Mjeti mbetet Prezent në parking.'
                    : 'Printeri LAN nuk u përgjigj — po provohet printimi Bluetooth...'
            );
        } else {
            $operatoriOrigjinal = $this->mjetiZgjedhur->id_operatori;
            $operatoriAktual    = Auth::id();

            if ($operatoriOrigjinal && $operatoriOrigjinal != $operatoriAktual) {
                $pagesaERe = ($vleraEVjeter !== null && $this->modal_vlera > $vleraEVjeter)
                    ? $this->modal_vlera
                    : null;

                \App\Models\Admin\NdryshimiOperatorit::create([
                    'id_transaksionit' => $transaksioniIRi->id,
                    'operatori_pare'   => $operatoriOrigjinal,
                    'operatori_dyte'   => $operatoriAktual,
                    'pagesa_e_re'      => $pagesaERe,
                ]);

                $this->mjetiZgjedhur->id_operatori = $operatoriAktual;
            }

            $this->mjetiZgjedhur->ikja = now();
            $this->mjetiZgjedhur->status = 'larguar';
            $this->mjetiZgjedhur->save();

            // Printimi i kuponit të daljes — LAN, me fallback Bluetooth
            $rezultatiPrintimit = app(KuponParkimiService::class)->printoDaljen(
                $this->mjetiZgjedhur, $transaksioniIRi, $this->metoda_pageses
            );

            if (!$rezultatiPrintimit) {
                $rawContent = app(KuponParkimiService::class)->buildDaljaRaw(
                    $this->mjetiZgjedhur, $transaksioniIRi, $this->metoda_pageses
                );
                $this->dispatch('printo-bluetooth-fallback', rawContent: $rawContent);
            }

            session()->flash(
                $rezultatiPrintimit ? 'success' : 'error',
                $rezultatiPrintimit
                    ? 'Operacioni u mbyll me sukses!'
                    : 'Printeri LAN nuk u përgjigj — po provohet printimi Bluetooth...'
            );
        }

        $this->klickedTarga = false;
        $this->mjetiZgjedhur = null;
        $this->koha_qendrimit = '';
        $this->modal_vlera = '';
        $this->modal_id_fasha = null;
        $this->transaksioniIRuajtur = null;
        $this->eshteRegjistrimParaprak = false;
        $this->modal_sasia = 1;
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

        $operacioni = Operacionet::create([
            'targa'        => $targaPastruar,
            'id_operatori' => Auth::user()->id,
            'nisja'        => now(),
            'ikja'         => null,
            'status'       => 'prezent',
        ]);


        // NEW: thirrja e Service-it për printimin e kuponit të Hyrjes
        $rezultatiPrintimit = app(KuponParkimiService::class)->printoHyrjen($operacioni);

        if (!$rezultatiPrintimit) {
            $rawContent = app(KuponParkimiService::class)->buildHyrjaRaw($operacioni);
            $this->dispatch('printo-bluetooth-fallback', rawContent: $rawContent);
        }

        session()->flash(
            $rezultatiPrintimit ? 'success' : 'error',
            $rezultatiPrintimit
                ? 'Mjeti u regjistrua me sukses si Prezent!'
                : 'Printeri LAN nuk u përgjigj — po provohet printimi Bluetooth...'
        );


        $this->reset('targa', 'shuma_paguar', 'eshte_paguar');

        $kategoriaDefault = KategoriaPageses::where('is_default', 1)->first();
        if ($kategoriaDefault) {
            $this->id_kategoria = $kategoriaDefault->id;
        }
    }//////////

    public function shfaqDetajetMjetitLarguar($id)
    {
        // Ngarkojmë operacionin dhe përdorim emërtimet e sakta të modelit tënd brenda transaksionit
        $this->mjetiLarguarZgjedhur = Operacionet::with([
            'operatori', // Operatori në nivel operacioni (nëse e ke te modeli Operacionet)
            'transaksioni.prenotimi', // Kategoria (id_prenotimit)
            'transaksioni.fashaOrare', // Fasha orare (id_fashes_orare)
            'transaksioni.monedha', // Monedha (monedha)
            'transaksioni.operatori' // Operatori i transaksionit (id_operatori)
        ])->find($id);

        if ($this->mjetiLarguarZgjedhur) {
            $this->shfaqModalDetajet = true;
        }
    }

    public function printoHistorikunMjetitLarguar()
    {
        if (!$this->mjetiLarguarZgjedhur) {
            return;
        }

        $rezultati = app(KuponParkimiService::class)->printoHistorikunMjetit($this->mjetiLarguarZgjedhur);

        if ($rezultati) {
            session()->flash('success_modal', 'Kuponi i historikut u dërgua në printer!');
        } else {
            $rawContent = app(KuponParkimiService::class)->buildHistorikuRaw($this->mjetiLarguarZgjedhur);
            $this->dispatch('printo-bluetooth-fallback', rawContent: $rawContent);
            session()->flash('success_modal', 'Printeri LAN nuk u përgjigj — po provohet printimi Bluetooth...');
        }
    }

    // Në Livewire Component


    public function render()
    {
        // 1. Mjetet që janë aktualisht në parking (Kodi ekzistues)
        $mjetePrezent = Operacionet::where('status', 'prezent')
            ->when($this->kerkoTarge, function($query) {
                $query->where('targa', 'like', '%' . strtoupper($this->kerkoTarge) . '%');
            })
            ->get();

        // 2. NEW: Logjika e filtrimit për mjetet e larguara (të shërbyera)
        $queryLarguar = Operacionet::where('status', 'larguar')
            ->with('transaksioni.fashaOrare') // E ngarkojmë për të parë vlerat/pagesat nëse duhen
            ->when($this->kerkoTarge, function($query) {
                $query->where('targa', 'like', '%' . strtoupper($this->kerkoTarge) . '%');
            });

        if ($this->tabiAktiv === 'sot') {
            $queryLarguar->whereDate('ikja', Carbon::today());
        } elseif ($this->tabiAktiv === 'dje') {
            $queryLarguar->whereDate('ikja', Carbon::yesterday());
        } elseif ($this->tabiAktiv === 'cakto_daten' && $this->dataSpecifike) {
            $queryLarguar->whereDate('ikja', $this->dataSpecifike);
        } else {
            // Nëse zgjidhet cakto_daten por s'ka datë akoma, mos kthe asgjë ose kthe të sotmet
            $queryLarguar->whereDate('ikja', Carbon::today());
        }

        $mjeteLarguar = $queryLarguar->orderBy('ikja', 'desc')->get();

        // 3. Fashat orare (Kodi ekzistues)
        $fashatOrare = $this->modal_id_kategoria
            ? \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->modal_id_kategoria)
                ->orderBy('nga')
                ->get()
            : collect();

        $kategoriaAktuale = $this->modal_id_kategoria ? KategoriaPageses::find($this->modal_id_kategoria) : null;
        $njesiaFashave = ($kategoriaAktuale && $kategoriaAktuale->eshteNjesiaDite()) ? __('ditë') : __('orë');

        return view('livewire.operatori.live-kryej-operacionet', [
            'kategorite'       => KategoriaPageses::all(),
            'monedhat'         => Monedhat::all(),
            'mjetePrezent'     => $mjetePrezent,
            'mjeteLarguar'     => $mjeteLarguar, // PASSED TO VIEW
            'fashatOrare'      => $fashatOrare,
            'njesiaFashave'    => $njesiaFashave,
            'kategoriaAktuale' => $kategoriaAktuale,
        ])->layout('layouts.dashboard.app');
    }
}
