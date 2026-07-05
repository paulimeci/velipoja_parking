<?php

namespace App\Exports\Transaksionet;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class RaportiPergjithshemBilanci implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithTitle
{
    protected Collection $raportet;
    protected string $periudha;

    public function __construct(Collection $raportet, string $periudha)
    {
        $this->raportet = $raportet;
        $this->periudha = $periudha;
    }

    public function collection(): Collection
    {
        return $this->raportet;
    }

    public function headings(): array
    {
        return [
            'Data',
            'Nr. Mjeteve',
            'Pagesa (LEK)',
            'Monedha të Tjera',
        ];
    }

    // Formaton çdo rresht ($rreshti është array, siç vjen nga $raportetFormatizuar)
    public function map($rreshti): array
    {
        // Rreshtojmë "monedhat_e_tjera" si tekst të vetëm, p.sh. "50.00 EUR, 20.00 USD"
        $monedhatETjera = '-';
        if (!empty($rreshti['monedhat_e_tjera'])) {
            $pjeset = [];
            foreach ($rreshti['monedhat_e_tjera'] as $kodi => $vlera) {
                $pjeset[] = number_format($vlera, 2, '.', '') . ' ' . $kodi;
            }
            $monedhatETjera = implode(', ', $pjeset);
        }

        return [
            Carbon::parse($rreshti['data'])->format('d/m/Y'),
            $rreshti['nr_mjeteve'],
            number_format($rreshti['pagesa_lek'], 2, '.', ''),
            $monedhatETjera,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15, 'B' => 14, 'C' => 16, 'D' => 30,
        ];
    }

    public function title(): string
    {
        return 'Bilanci ' . $this->periudha;
    }
}
