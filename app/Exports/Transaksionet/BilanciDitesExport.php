<?php

namespace App\Exports\Transaksionet;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class BilanciDitesExport implements FromArray, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    protected array $tedhenat;
    protected string $data;

    public function __construct(array $tedhenat, string $data)
    {
        $this->tedhenat = $tedhenat;
        $this->data = $data;
    }

    public function array(): array
    {
        $rreshtatFinale = $this->tedhenat;

        // Llogarisim totalet sipas monedhave dinamikisht
        $totaleMonedhash = [];
        foreach ($this->tedhenat as $mjeti) {
            $monedha = $mjeti['monedha_kodi'];
            $shuma = (float) $mjeti['shuma'];

            if (!isset($totaleMonedhash[$monedha])) {
                $totaleMonedhash[$monedha] = 0;
            }
            $totaleMonedhash[$monedha] += $shuma;
        }

        // Shto një rresht bosh si ndarës përpara totaleve
        $rreshtatFinale[] = ['is_total' => true, 'tipi' => 'bosh'];

        // Shto rreshtat e totaleve për çdo monedhë të gjetur
        foreach ($totaleMonedhash as $monedha => $total) {
            $rreshtatFinale[] = [
                'is_total' => true,
                'tipi'     => 'te_dhena',
                'monedha'  => $monedha,
                'vlera'    => $total
            ];
        }

        return $rreshtatFinale;
    }

    public function headings(): array
    {
        return [
            'Targa',
            'Koha e Hyrjes',
            'Koha e Ikjes',
            'Lloji i Qëndrimit',
            'Sasia / Fasha',
            'Kohëzgjatja Reale', // Kolona e re për diferencën
            'Operatori',
            'Shuma',
            'Monedha',
        ];
    }

    // Formaton çdo rresht (përfshin kolonën e re të kohëzgjatjes)
    public function map($mjeti): array
    {
        // Kontrollojmë nëse ky rresht është një nga rreshtat e totaleve
        if (isset($mjeti['is_total'])) {
            if ($mjeti['tipi'] === 'bosh') {
                return ['', '', '', '', '', '', '', '', ''];
            }

            return [
                'TOTALI ' . $mjeti['monedha'], // Kolona Targa
                '',
                '',
                '',
                '',
                '',
                '', // Hapësirë për Operatorin
                number_format($mjeti['vlera'], 2, '.', ''), // Kolona Shuma
                $mjeti['monedha'], // Kolona Monedha
            ];
        }

        // 1. Logjika dinamike për kolonën Sasia / Fasha
        $sasiaDinamike = '-';
        if ($mjeti['njesia_matjes'] === 'dite' && !empty($mjeti['sasia'])) {
            $sasiaDinamike = $mjeti['sasia'] . ' Ditë';
        } elseif ($mjeti['njesia_matjes'] === 'ore') {
            // Nëse i ke të dhënat e fashës nga join-i në backend (p.sh. fasha_nga dhe fasha_ne)
            $nga = $mjeti['fasha_nga'] ?? 0;
            $ne = $mjeti['fasha_ne'] ?? 0;
            $sasiaDinamike = $nga . '-' . $ne . ' orë';
        }

        // 2. Llogaritja e Diferencës Reale (Kohëzgjatja mes Hyrjes dhe Ikjes)
        $hyrja = Carbon::parse($mjeti['koha_hyrjes']);
        $ikja = Carbon::parse($mjeti['koha_ikjes']);

        $diferencaNeMinuta = $hyrja->diffInMinutes($ikja);
        $oret = floor($diferencaNeMinuta / 60);
        $minutat = $diferencaNeMinuta % 60;

        $kohezgjatjaReale = "{$oret}f {$minutat}m"; // Formati p.sh. 2f 15m (orë/minuta)

        return [
            $mjeti['targa'],
            Carbon::parse($mjeti['koha_hyrjes'])->format('d/m/Y H:i'),
            Carbon::parse($mjeti['koha_ikjes'])->format('d/m/Y H:i'),
            $mjeti['lloji_qendrimit'],
            $sasiaDinamike,      // Ditë ose Fashë Orare
            $kohezgjatjaReale,  // Diferenca në kohë
            $mjeti['emri_operatorit'] ?? 'Pa emër',
            number_format($mjeti['shuma'], 2, '.', ''),
            $mjeti['monedha_kodi'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $styles = [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];

        // Gjejmë rreshtat ku fillojnë totalet për t'i bërë BOLD
        $totalRowsStart = count($this->tedhenat) + 3;
        $totalRowsEnd = $totalRowsStart + count($sheet->toArray()) - $totalRowsStart;

        for ($i = $totalRowsStart; $i <= $totalRowsEnd; $i++) {
            $styles[$i] = [
                'font' => ['bold' => true, 'color' => ['rgb' => '155724']],
            ];
        }

        return $styles;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18, 'B' => 20, 'C' => 20, 'D' => 22,
            'E' => 15, 'F' => 18, 'G' => 20, 'H' => 14, 'I' => 10
        ];
    }

    public function title(): string
    {
        return 'Detajet ' . $this->data;
    }
}
