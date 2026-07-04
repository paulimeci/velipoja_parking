<?php

namespace App\Livewire\Admin;

use App\Models\Admin\Monedhat;
use App\Models\Admin\TransaksioniOperacionit;
use Carbon\Carbon;
use Livewire\Component;

class LiveBilanciTransaksioneve extends Component
{
    // Lloji i periudhës: 'java' | 'muaji' | 'percaktuar'
    public $tipiPeriudhes = 'java';

    // Kur zgjidhet "Java"
    public $javaZgjedhur = 'aktuale'; // aktuale | e_shkuar | 2javet | 3javet | 4javet

    // Kur zgjidhet "Muaji"
    public $muajiZgjedhur;
    public $vitiZgjedhur;

    // Kur zgjidhet "Përcakto"
    public $data_nga;
    public $data_deri;
    public $detajetMjeteve = [];
    public $dataEPerzgjedhur = '';
    public $shfaqModalDetaje = false;

    public function mount()
    {
        $this->muajiZgjedhur = now()->month;
        $this->vitiZgjedhur  = now()->year;
        $this->data_nga  = now()->startOfMonth()->format('Y-m-d');
        $this->data_deri = now()->format('Y-m-d');
    }


    public function shfaqDetajetEDates($data)
    {
        $this->dataEPerzgjedhur = \Carbon\Carbon::parse($data)->format('d/m/Y');

        $this->detajetMjeteve = \App\Models\Admin\TransaksioniOperacionit::query()
            // 1. Lidhja me tabelën e operacioneve për të marrë targën dhe kohët
            ->join('adm_operacionet', 'adm_transaksioni_operacionit.id_operacionit', '=', 'adm_operacionet.id')

            // 2. Lidhja me tabelën e monedhave
            ->join('adm_monedhat', 'adm_transaksioni_operacionit.monedha', '=', 'adm_monedhat.id')

            // 3. Lidhja e saktë me kategorinë duke përdorur kolonën 'id_prenotimit'
            ->join('adm_kategoria_pageses', 'adm_transaksioni_operacionit.id_prenotimit', '=', 'adm_kategoria_pageses.id')

            // Filtrojmë për datën e klikuar të ikjes
            ->whereRaw('DATE(adm_operacionet.ikja) = ?', [$data])

            ->select([
                'adm_operacionet.targa',
                'adm_operacionet.nisja as koha_hyrjes',
                'adm_operacionet.ikja as koha_ikjes',
                'adm_transaksioni_operacionit.vlera as shuma',
                'adm_monedhat.kodi as monedha_kodi',
                // Marrim kolonën 'kategoria' dhe e emërtojmë si 'lloji_qendrimit' për Blade
                'adm_kategoria_pageses.kategoria as lloji_qendrimit'
            ])
            ->get()
            ->toArray();
        $this->shfaqModalDetaje = true;


    }
    public function mbyllModalin()
    {
        $this->shfaqModalDetaje = false;
        $this->detajetMjeteve = []; // pastrojmë të dhënat
    }
    public function zgjidhTipin($tip)
    {
        $this->tipiPeriudhes = $tip;
    }

    /**
     * Qendra e vetme që përcakton fillimin/fundin e periudhës,
     * sipas $tipiPeriudhes së zgjedhur.
     */
    private function resolveDateRange(): array
    {
        $sot = Carbon::now();

        switch ($this->tipiPeriudhes) {

            case 'muaji':
                $fillimi = Carbon::createFromDate($this->vitiZgjedhur, $this->muajiZgjedhur, 1)->startOfMonth();
                $fundi   = $fillimi->copy()->endOfMonth();
                break;

            case 'percaktuar':
                $fillimi = $this->data_nga
                    ? Carbon::parse($this->data_nga)->startOfDay()
                    : $sot->copy()->startOfMonth();
                $fundi = $this->data_deri
                    ? Carbon::parse($this->data_deri)->endOfDay()
                    : $sot->copy()->endOfDay();
                break;

            case 'java':
            default:
                [$fillimi, $fundi] = match ($this->javaZgjedhur) {
                    'e_shkuar' => [$sot->copy()->subWeek()->startOfWeek(), $sot->copy()->subWeek()->endOfWeek()],
                    '2javet'   => [$sot->copy()->subWeeks(2)->startOfWeek(), $sot->copy()->endOfWeek()],
                    '3javet'   => [$sot->copy()->subWeeks(3)->startOfWeek(), $sot->copy()->endOfWeek()],
                    '4javet'   => [$sot->copy()->subWeeks(4)->startOfWeek(), $sot->copy()->endOfWeek()],
                    default    => [$sot->copy()->startOfWeek(), $sot->copy()->endOfWeek()], // 'aktuale'
                };
                break;
        }

        return [$fillimi, $fundi];
    }

    public function render()
    {
        [$fillimi, $fundi] = $this->resolveDateRange();

        $idMonedhaLek = Monedhat::where('kodi', 'ALL')->value('id');

        // 1. Marrim të gjitha transaksionet e grupuara sipas Datës dhe Monedhës
        $transaksionet = TransaksioniOperacionit::query()
            ->join('adm_operacionet', 'adm_transaksioni_operacionit.id_operacionit', '=', 'adm_operacionet.id')
            ->join('adm_monedhat', 'adm_transaksioni_operacionit.monedha', '=', 'adm_monedhat.id')
            ->selectRaw('DATE(adm_operacionet.ikja) as data_ikjes')
            ->selectRaw('adm_transaksioni_operacionit.monedha as monedha_id')
            ->selectRaw('adm_monedhat.kodi as monedha_kodi')
            ->selectRaw('COUNT(DISTINCT adm_transaksioni_operacionit.id_operacionit) as nr_mjeteve')
            ->selectRaw('SUM(adm_transaksioni_operacionit.vlera) as totali_vlera')
            ->whereBetween('adm_operacionet.ikja', [$fillimi, $fundi])
            ->whereNotNull('adm_operacionet.ikja')
            ->groupBy('data_ikjes', 'monedha_id', 'monedha_kodi')
            ->orderByDesc('data_ikjes')
            ->get();

        // 2. I strukturojmë të dhënat në PHP sipas datës, që tabela në Blade të ketë vetëm 1 rresht për çdo datë
        $raportetFormatizuar = [];
    foreach ($transaksionet as $t) {
        $data = $t->data_ikjes;

        if (!isset($raportetFormatizuar[$data])) {
            $raportetFormatizuar[$data] = [
                'data'             => $data,
                'nr_mjeteve'       => 0, // do ta llogarisim me poshte si total unik per ate dite
                'pagesa_lek'       => 0,
                'monedhat_e_tjera' => [] // Këtu do të ruhen p.sh. ['EUR' => 50, 'USD' => 20]
            ];
        }

        // Ndajmë pagesat në Lek dhe Monedhat e Huaja
        if ($t->monedha_id == $idMonedhaLek) {
            $raportetFormatizuar[$data]['pagesa_lek'] += $t->totali_vlera;
        } else {
            if (!isset($raportetFormatizuar[$data]['monedhat_e_tjera'][$t->monedha_kodi])) {
                $raportetFormatizuar[$data]['monedhat_e_tjera'][$t->monedha_kodi] = 0;
            }
            $raportetFormatizuar[$data]['monedhat_e_tjera'][$t->monedha_kodi] += $t->totali_vlera;
        }
    }

    // Llogaritja e saktë e numrit të mjeteve unike për çdo ditë
    $mjeteDitore = TransaksioniOperacionit::query()
        ->join('adm_operacionet', 'adm_transaksioni_operacionit.id_operacionit', '=', 'adm_operacionet.id')
        ->selectRaw('DATE(adm_operacionet.ikja) as data_ikjes, COUNT(DISTINCT adm_transaksioni_operacionit.id_operacionit) as total_mjete')
        ->whereBetween('adm_operacionet.ikja', [$fillimi, $fundi])
        ->groupBy('data_ikjes')
        ->pluck('total_mjete', 'data_ikjes');

    foreach ($raportetFormatizuar as $data => $vlerat) {
        $raportetFormatizuar[$data]['nr_mjeteve'] = $mjeteDitore[$data] ?? 0;
    }

        return view('livewire.admin.live-bilanci-transaksioneve', [
            // Shtojmë ->values() këtu ⬇️
            'raportet' => collect($raportetFormatizuar)->values(),
            'fillimi'  => $fillimi,
            'fundi'    => $fundi,
        ])->layout('layouts.dashboard.app');
}
}
