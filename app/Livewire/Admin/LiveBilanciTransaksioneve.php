<?php

namespace App\Livewire\Admin;

use App\Models\Admin\Monedhat;
use App\Models\Admin\TransaksioniOperacionit;
use Carbon\Carbon;
use Livewire\Component;

use App\Exports\Transaksionet\BilanciDitesExport;
use App\Exports\Transaksionet\RaportiPergjithshemBilanci;


use Maatwebsite\Excel\Facades\Excel;


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
    public $operatoriZgjedhur = ''; // '' = të gjithë operatorët

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
            // 1. Lidhja me operacionet kryesore
            ->join('adm_operacionet', 'adm_transaksioni_operacionit.id_operacionit', '=', 'adm_operacionet.id')

            // 2. Lidhja me tabelën e monedhave
            ->join('adm_monedhat', 'adm_transaksioni_operacionit.monedha', '=', 'adm_monedhat.id')

            // 3. Lidhja me kategorinë e pagesës
            ->join('adm_kategoria_pageses', 'adm_transaksioni_operacionit.id_prenotimit', '=', 'adm_kategoria_pageses.id')

            // 4. Lidhja me tabelën users për emrin e operatorit
            ->join('users', 'adm_operacionet.id_operatori', '=', 'users.id')

            // 5. RREGULLIMI: Lidhja e saktë me tabelën adm_oret_cmimi
            ->leftJoin('adm_oret_cmimi', 'adm_transaksioni_operacionit.id_fashes_orare', '=', 'adm_oret_cmimi.id')

            // Filtri për datën e ikjes
            ->whereRaw('DATE(adm_operacionet.ikja) = ?', [$data])

            ->select([
                'adm_operacionet.targa',
                'adm_operacionet.nisja as koha_hyrjes',
                'adm_operacionet.ikja as koha_ikjes',
                'adm_transaksioni_operacionit.vlera as shuma',
                'adm_transaksioni_operacionit.sasia',
                'adm_monedhat.kodi as monedha_kodi',
                'adm_kategoria_pageses.kategoria as lloji_qendrimit',
                'adm_kategoria_pageses.njesia_matjes',
                'users.name as emri_operatorit',

                // Marrim vlerat 'nga' dhe 'ne' nga tabela e saktë adm_oret_cmimi
                'adm_oret_cmimi.nga as fasha_nga',
                'adm_oret_cmimi.ne as fasha_ne'
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

    public function eksportoDetajetNeExcel()
    {
        if (empty($this->detajetMjeteve)) {
            return;
        }

        $emriSkedarit = 'detajet_' . str_replace('/', '-', $this->dataEPerzgjedhur) . '.xlsx';

        return Excel::download(
            new BilanciDitesExport($this->detajetMjeteve, $this->dataEPerzgjedhur),
            $emriSkedarit
        );
    }


// NEW: nxjerrim llogaritjen e raportit në një metodë të veçantë
    private function ndertoRaportinFormatizuar($fillimi, $fundi)
    {
        $idMonedhaLek = Monedhat::where('kodi', 'ALL')->value('id');

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
            // NEW: filtrim sipas operatorit, vetëm nëse është zgjedhur ndonjë
            ->when($this->operatoriZgjedhur, function ($query) {
                $query->where('adm_operacionet.id_operatori', $this->operatoriZgjedhur);
            })
            ->groupBy('data_ikjes', 'monedha_id', 'monedha_kodi')
            ->orderByDesc('data_ikjes')
            ->get();

        $raportetFormatizuar = [];
        foreach ($transaksionet as $t) {
            $data = $t->data_ikjes;

            if (!isset($raportetFormatizuar[$data])) {
                $raportetFormatizuar[$data] = [
                    'data'             => $data,
                    'nr_mjeteve'       => 0,
                    'pagesa_lek'       => 0,
                    'monedhat_e_tjera' => []
                ];
            }

            if ($t->monedha_id == $idMonedhaLek) {
                $raportetFormatizuar[$data]['pagesa_lek'] += $t->totali_vlera;
            } else {
                if (!isset($raportetFormatizuar[$data]['monedhat_e_tjera'][$t->monedha_kodi])) {
                    $raportetFormatizuar[$data]['monedhat_e_tjera'][$t->monedha_kodi] = 0;
                }
                $raportetFormatizuar[$data]['monedhat_e_tjera'][$t->monedha_kodi] += $t->totali_vlera;
            }
        }

        $mjeteDitore = TransaksioniOperacionit::query()
            ->join('adm_operacionet', 'adm_transaksioni_operacionit.id_operacionit', '=', 'adm_operacionet.id')
            ->selectRaw('DATE(adm_operacionet.ikja) as data_ikjes, COUNT(DISTINCT adm_transaksioni_operacionit.id_operacionit) as total_mjete')
            ->whereBetween('adm_operacionet.ikja', [$fillimi, $fundi])
            // NEW: i njëjti filtër, që numri i mjeteve të mos dalë i çekuilibruar me shumat
            ->when($this->operatoriZgjedhur, function ($query) {
                $query->where('adm_operacionet.id_operatori', $this->operatoriZgjedhur);
            })
            ->groupBy('data_ikjes')
            ->pluck('total_mjete', 'data_ikjes');

        foreach ($raportetFormatizuar as $data => $vlerat) {
            $raportetFormatizuar[$data]['nr_mjeteve'] = $mjeteDitore[$data] ?? 0;
        }

        return collect($raportetFormatizuar)->values();
    }
    public function zgjidhOperatorin($id)
    {
        $this->operatoriZgjedhur = $id;
    }

    public function eksportoRaportinNeExcel()
    {
        [$fillimi, $fundi] = $this->resolveDateRange();

        $raportet = $this->ndertoRaportinFormatizuar($fillimi, $fundi);

        $etiketaPeriudhes = $fillimi->format('d-m-Y') . '_deri_' . $fundi->format('d-m-Y');

        // NEW: nëse është zgjedhur operator, e shtojmë emrin te skedari
        if ($this->operatoriZgjedhur) {
            $emriOperatorit = \App\Models\User::find($this->operatoriZgjedhur)?->name;
            $etiketaPeriudhes .= $emriOperatorit ? '_' . str_replace(' ', '-', $emriOperatorit) : '';
        }

        $emriSkedarit = 'bilanci_' . $etiketaPeriudhes . '.xlsx';

        return Excel::download(
            new RaportiPergjithshemBilanci($raportet, $etiketaPeriudhes),
            $emriSkedarit
        );
    }


    public function render()
    {
        [$fillimi, $fundi] = $this->resolveDateRange();

        $raportetFormatizuar = $this->ndertoRaportinFormatizuar($fillimi, $fundi);

        // NEW: lista e operatorëve që kanë të paktën 1 operacion, për dropdown-in e filtrit
        $operatoret = \App\Models\User::query()
            ->whereHas('operacionet') // supozon relacion 'operacionet' te modeli User, shiko shënimin poshtë
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('livewire.admin.live-bilanci-transaksioneve', [
            'raportet'   => $raportetFormatizuar,
            'fillimi'    => $fillimi,
            'fundi'      => $fundi,
            'operatoret' => $operatoret, // NEW
        ])->layout('layouts.dashboard.app');
    }
}
