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

    public $shfaqModalEdit = false;
    public $transaksioniId;
    public $editTarga;
    public $editVlera;
    public $editSasia;
    public $editMonedha;
    public $editKategoria;
    public $editIdFasha;
    public $editFashatOrare = [];

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
            ->join('adm_operacionet', 'adm_transaksioni_operacionit.id_operacionit', '=', 'adm_operacionet.id')
            ->join('adm_monedhat', 'adm_transaksioni_operacionit.monedha', '=', 'adm_monedhat.id')
            ->join('adm_kategoria_pageses', 'adm_transaksioni_operacionit.id_prenotimit', '=', 'adm_kategoria_pageses.id')
            ->leftJoin('users', 'adm_operacionet.id_operatori', '=', 'users.id')
            ->leftJoin('adm_oret_cmimi', 'adm_transaksioni_operacionit.id_fashes_orare', '=', 'adm_oret_cmimi.id')
            ->whereRaw('DATE(adm_operacionet.ikja) = ?', [$data])
            ->when($this->operatoriZgjedhur, function ($query) {
                $query->where('adm_operacionet.id_operatori', $this->operatoriZgjedhur);
            })
            ->select([
                'adm_transaksioni_operacionit.id as transaksioni_id', // E RËNDËSISHME: Na duhet për editim/fshirje
                'adm_operacionet.targa',
                'adm_operacionet.nisja as koha_hyrjes',
                'adm_operacionet.ikja as koha_ikjes',
                'adm_transaksioni_operacionit.vlera as shuma',
                'adm_transaksioni_operacionit.sasia',
                'adm_monedhat.kodi as monedha_kodi',
                'adm_transaksioni_operacionit.monedha as monedha_id',
                'adm_kategoria_pageses.kategoria as lloji_qendrimit',
                'adm_kategoria_pageses.id as kategoria_id',
                'adm_kategoria_pageses.njesia_matjes',
                'users.name as emri_operatorit',
            ])
            ->get()
            ->toArray();

        $this->shfaqModalDetaje = true;
    }
    public function editoTransaksionin($id)
    {
        $transaksioni = \App\Models\Admin\TransaksioniOperacionit::with('operacioni')->find($id);

        if ($transaksioni) {
            $this->transaksioniId = $transaksioni->id;
            $this->editTarga      = $transaksioni->operacioni->targa ?? '';
            $this->editVlera      = $transaksioni->vlera;
            $this->editSasia      = $transaksioni->sasia ?? 1;
            $this->editMonedha    = $transaksioni->monedha;
            $this->editKategoria  = $transaksioni->id_prenotimit;
            $this->editIdFasha    = $transaksioni->id_fashes_orare; // Ruajmë fashën aktuale

            // Ngarkojmë fashat orare për këtë kategori specifike
            $this->editFashatOrare = \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->editKategoria)
                ->orderBy('nga')
                ->get();

            $this->shfaqModalEdit = true;
        }
    }
    public function ruajNdryshimet()
    {
        $transaksioni = \App\Models\Admin\TransaksioniOperacionit::find($this->transaksioniId);
        if ($transaksioni) {
            $transaksioni->update([
                'vlera' => $this->editVlera,
                'sasia' => $this->editSasia,
                'monedha' => $this->editMonedha,
                'id_prenotimit' => $this->editKategoria,
                'id_fashes_orare' => $this->editIdFasha // E RËNDËSISHME: ruajmë fashën e re
            ]);

            if ($transaksioni->id_operacionit) {
                \DB::table('adm_operacionet')
                    ->where('id', $transaksioni->id_operacionit)
                    ->update(['targa' => strtoupper($this->editTarga)]);
            }

            $this->shfaqModalEdit = false;
            $dataFormatValue = Carbon::parse(str_replace('/', '-', $this->dataEPerzgjedhur))->format('Y-m-d');
            $this->shfaqDetajetEDates($dataFormatValue);
        }
    }
    public function fshiTransaksionin()
    {
        $transaksioni = \App\Models\Admin\TransaksioniOperacionit::find($this->transaksioniId);
        if ($transaksioni) {
            $transaksioni->delete(); // Ose fshirje fizike ose SoftDelete nqs e ke aktivizuar te ky model

            $this->shfaqModalEdit = false;

            // Ringarkojmë detajet
            $dataFormatValue = Carbon::parse(str_replace('/', '-', $this->dataEPerzgjedhur))->format('Y-m-d');
            $this->shfaqDetajetEDates($dataFormatValue);
        }
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
// Kjo metodë ekzekutohet automatikisht nga Livewire kur ndryshon Kategoria ose Sasia
    public function updatedEditKategoria($value)
    {
        $this->editFashatOrare = \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $value)
            ->orderBy('nga')
            ->get();

        // Caktojmë fashën e parë automatikisht si default nëse ka fasha
        $this->editIdFasha = $this->editFashatOrare->first()?->id ?? null;

        $this->riperllogaritVleren();
    }

    public function updatedEditSasia()
    {
        $this->riperllogaritVleren();
    }

// Kjo metodë ekzekutohet automatikisht kur ndryshon monedha
    public function updatedEditMonedha()
    {
        $this->riperllogaritVleren();
    }

    /**
     * Logjika e ripërllogaritjes dinamike bazuar në grafikën tuaj të çmimeve
     */
    private function riperllogaritVleren()
    {
        $kategoria = \App\Models\Admin\KategoriaPageses::find($this->editKategoria);
        if (!$kategoria) return;

        $eshteNjesiaDite = ($kategoria->njesia_matjes === 'dite');

        // Nëse është orë, marrim fashën e zgjedhur nga dropdown-i, përndryshe fashën e parë të ditës
        if (!$eshteNjesiaDite && $this->editIdFasha) {
            $fashaOrare = \App\Models\Admin\OretCmimi::find($this->editIdFasha);
        } else {
            $fashaOrare = \App\Models\Admin\OretCmimi::where('id_kategoria_rezervimit', $this->editKategoria)->first();
        }

        if (!$fashaOrare) {
            $this->editVlera = 0;
            return;
        }

        // Gjejmë çmimin për atë monedhë
        $cmimiMonedhes = $fashaOrare->cmimet()->where('monedha_id', $this->editMonedha)->first();
        $cmimiNjesi = $cmimiMonedhes ? $cmimiMonedhes->vlera : 0;
        $sasia = is_numeric($this->editSasia) ? $this->editSasia : 1;

        if ($eshteNjesiaDite) {
            $this->editVlera = round($cmimiNjesi * max($sasia, 0), 2);
        } else {
            // Për fashat me orë, çmimi vjen fiks i fashës ose x sasi (varet nga struktura juaj)
            $this->editVlera = $cmimiNjesi;
        }
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
