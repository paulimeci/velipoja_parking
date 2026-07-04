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
            // 1. Lidhja me operacionet (Lidh id_operacionit me id)
            ->join('adm_operacionet', 'adm_transaksioni_operacionit.id_operacionit', '=', 'adm_operacionet.id')

            // 2. Lidhja me monedhat (Lidh kolonën monedha me id e tabelës adm_monedhat)
            ->join('adm_monedhat', 'adm_transaksioni_operacionit.monedha', '=', 'adm_monedhat.id')

            // Filtrojmë për datën e klikuar të ikjes
            ->whereRaw('DATE(adm_operacionet.ikja) = ?', [$data])

            ->select([
                'adm_operacionet.targa',
                'adm_operacionet.nisja as koha_hyrjes',
                'adm_operacionet.ikja as koha_ikjes',
                'adm_transaksioni_operacionit.vlera as shuma',
                'adm_monedhat.kodi as monedha_kodi',
                // Pasi nuk kemi kolonë kategoria në asnjë nga këto dy tabela,
                // po e lëmë statike ose mund ta heqësh fare nga tabela në HTML
                \DB::raw("'Pagesë Mjeti' as lloji_qendrimit")
            ])
            ->get()
            ->toArray();

        $this->dispatch('hap-modal-detaje');
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

        $raportet = TransaksioniOperacionit::query()
            // Bëjmë join me tabelën e operacioneve (supozojmë se quhet 'adm_operacionet')
            // Lidhja bëhet nëpërmjet id_operacionit dhe id-së së mjetit
            ->join('adm_operacionet', 'adm_transaksioni_operacionit.id_operacionit', '=', 'adm_operacionet.id')

            // Grupojmë dhe selektojmë sipas kolonës 'ikja' të tabelës së operacioneve
            ->selectRaw('DATE(adm_operacionet.ikja) as data')
            ->selectRaw('COUNT(DISTINCT adm_transaksioni_operacionit.id_operacionit) as nr_mjeteve')
            ->selectRaw('SUM(CASE WHEN adm_transaksioni_operacionit.monedha = ? THEN adm_transaksioni_operacionit.vlera ELSE 0 END) as pagesa_lek', [$idMonedhaLek])
            ->selectRaw('SUM(CASE WHEN adm_transaksioni_operacionit.monedha != ? THEN adm_transaksioni_operacionit.vlera ELSE 0 END) as monedha_te_tjera', [$idMonedhaLek])

            // Filtrojmë transaksionet që kanë një datë ikjeje brenda periudhës së zgjedhur
            ->whereBetween('adm_operacionet.ikja', [$fillimi, $fundi])

            // Sigurohemi që nuk po llogarisim mjete që janë ende brenda ('prezent' / null)
            ->whereNotNull('adm_operacionet.ikja')

            ->groupBy('data')
            ->orderByDesc('data')
            ->get();

        return view('livewire.admin.live-bilanci-transaksioneve', [
            'raportet' => $raportet,
            'fillimi'  => $fillimi,
            'fundi'    => $fundi,
        ])->layout('layouts.dashboard.app');
    }
}
