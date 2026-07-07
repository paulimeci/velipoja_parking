<?php

namespace App\Services\Admin;

use App\Models\Admin\Operacionet;
use App\Models\Admin\TransaksioniOperacionit;
use App\Models\Admin\KategoriaPageses;
use Illuminate\Support\Facades\Log;

class KuponParkimiService
{
    protected string $printerIp;
    protected int $printerPort;
    protected int $timeout = 5;

    protected int $paperWidth = 31;

    public function __construct(string $printerIp = '10.10.12.15', int $printerPort = 9100, ?int $paperWidth = null)
    {
        $this->printerIp = $printerIp;
        $this->printerPort = $printerPort;

        if ($paperWidth !== null && $paperWidth > 0) {
            $this->paperWidth = $paperWidth;
        }
    }

    /**
     * =========================================================
     * PUBLIC API
     * =========================================================
     */

    public function printoHyrjen(Operacionet $operacioni): bool
    {
        try {
            $content = $this->buildHyrjaContent($operacioni);
            return $this->sendToPrinter($content);
        } catch (\Throwable $e) {
            Log::error('KuponParkimiService hyrja error', [
                'operacioni_id' => $operacioni->id,
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function printoParapagesen(Operacionet $operacioni, TransaksioniOperacionit $transaksioni, string $metodaPageses): bool
    {
        try {
            $content = $this->buildPagesaContent($operacioni, $transaksioni, $metodaPageses, false, false);
            return $this->sendToPrinter($content);
        } catch (\Throwable $e) {
            Log::error('KuponParkimiService parapagesa error', [
                'operacioni_id' => $operacioni->id,
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }

    // NEW: shtuam parametrin $ishteParaprakisht — nëse mbyllja bëhet mbi një transaksion
    // që ishte tashmë PARAPAGUAR (dhe s'ndryshoi vlera), kuponi i daljes e thekson këtë
    public function printoDaljen(
        Operacionet $operacioni,
        TransaksioniOperacionit $transaksioni,
        string $metodaPageses,
        bool $ishteParaprakisht = false
    ): bool {
        try {
            $content = $this->buildPagesaContent($operacioni, $transaksioni, $metodaPageses, true, $ishteParaprakisht);
            return $this->sendToPrinter($content);
        } catch (\Throwable $e) {
            Log::error('KuponParkimiService dalja error', [
                'operacioni_id' => $operacioni->id,
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }

    public function buildHyrjaRaw(Operacionet $operacioni): string
    {
        return $this->buildHyrjaContent($operacioni);
    }

    public function buildDaljaRaw(Operacionet $operacioni, TransaksioniOperacionit $transaksioni, string $metodaPageses, bool $ishteParaprakisht = false): string
    {
        return $this->buildPagesaContent($operacioni, $transaksioni, $metodaPageses, true, $ishteParaprakisht);
    }

    public function sendRaw(string $content): bool
    {
        return $this->sendToPrinter($content);
    }

    /**
     * =========================================================
     * KUPONI I HYRJES
     * =========================================================
     */
    protected function buildHyrjaContent(Operacionet $operacioni): string
    {
        $content = '';
        $content .= $this->initPrinter();
        $content .= $this->alignCenter();

        $content .= $this->textDoubleHeightOn();
        $content .= $this->centerLine('PARKINGU');
        $content .= $this->textDoubleHeightOff();
        $content .= $this->centerLine('Kuponi i Hyrjes');
        $content .= $this->separator('=');

        $content .= $this->textDoubleHeightOn();
        $content .= $this->centerLine($this->normalizeText($operacioni->targa));
        $content .= $this->textDoubleHeightOff();
        $content .= $this->separator('-');

        $content .= $this->alignLeft();
        $content .= $this->kvLine('Data', \Carbon\Carbon::parse($operacioni->nisja)->format('d/m/Y'));
        $content .= $this->kvLine('Ora Hyrjes', \Carbon\Carbon::parse($operacioni->nisja)->format('H:i'));
        $content .= $this->kvLine('Nr. Bilete', '#' . str_pad($operacioni->id, 6, '0', STR_PAD_LEFT));

        $content .= $this->separator('=');
        $content .= $this->alignCenter();
        $content .= $this->centerLine('Ju lutem ruajeni kete kupon');
        $content .= $this->centerLine('deri ne momentin e daljes');
        $content .= "\n\n";
        $content .= $this->cutPaper();

        return $content;
    }

    /**
     * =========================================================
     * KUPONI I PAGESËS (parapagesë ose mbyllje/dalje reale)
     * =========================================================
     */
    protected function buildPagesaContent(
        Operacionet $operacioni,
        TransaksioniOperacionit $transaksioni,
        string $metodaPageses,
        bool $eshteDalje,
        bool $ishteParaprakisht = false // NEW
    ): string {
        $kategoria = KategoriaPageses::find($transaksioni->id_prenotimit);

        // NEW: marrim emrin e plotë të monedhës (Lek/Euro/Dollar) në vend të kodit
        $emriMonedhes = $transaksioni->monedhaRelacioni->emri
            ?? $transaksioni->monedhaRelacioni->kodi
            ?? '';

        $content = '';
        $content .= $this->initPrinter();
        $content .= $this->alignCenter();

        $content .= $this->textDoubleHeightOn();
        $content .= $this->centerLine('PARKINGU');
        $content .= $this->textDoubleHeightOff();

        // NEW: titulli ndryshon nëse është dalje mbi një parapagesë ekzistuese
        if ($eshteDalje && $ishteParaprakisht) {
            $content .= $this->centerLine('Kuponi i Daljes (Parapaguar)');
        } elseif ($eshteDalje) {
            $content .= $this->centerLine('Kuponi i Daljes / Fature');
        } else {
            $content .= $this->centerLine('Kuponi i Pageses (Parapagese)');
        }

        $content .= $this->separator('=');

        $content .= $this->textDoubleHeightOn();
        $content .= $this->centerLine($this->normalizeText($operacioni->targa));
        $content .= $this->textDoubleHeightOff();
        $content .= $this->separator('-');

        $content .= $this->alignLeft();
        $content .= $this->kvLine('Hyrja', \Carbon\Carbon::parse($operacioni->nisja)->format('d/m/Y H:i'));

        if ($eshteDalje) {
            $content .= $this->kvLine('Dalja', \Carbon\Carbon::parse($operacioni->ikja)->format('d/m/Y H:i'));

            // NEW: nëse ishte parapaguar, e theksojmë qartë te statusi
            if ($ishteParaprakisht) {
                $content .= $this->kvLine('Statusi', 'PARAPAGUAR');
            }
        } else {
            $content .= $this->kvLine('Statusi', 'PREZENT (parapaguar)');
        }

        $content .= $this->separator('-');
        $content .= $this->kvLine('Sherbimi', $kategoria->kategoria ?? '-');

// NEW: njësoj si te buildHistorikuContent() — kontrollojmë njesia_matjes
// nëse është 'dite', shfaqim SASINË te rreshti "Fasha" (jo ndarë më vete)
        if ($kategoria && $kategoria->njesia_matjes === 'dite') {
            $content .= $this->kvLine('Fasha', $transaksioni->sasia . ' Dite');
        } elseif ($transaksioni->fashaOrare) {
            $content .= $this->kvLine('Fasha', $transaksioni->fashaOrare->nga . '-' . $transaksioni->fashaOrare->ne);
        }

        $content .= $this->kvLine('Metoda', $metodaPageses === 'kesh' ? 'Kesh' : 'Karte');

        $content .= $this->separator('-');

        $content .= $this->alignCenter();
        $content .= $this->textEmphasizedOn();
        $content .= $this->textDoubleHeightOn();
        // NEW: shtuam emrin e monedhës te totali
        $content .= $this->centerLine('TOTAL: ' . number_format($transaksioni->vlera, 2) . ' ' . $emriMonedhes);
        $content .= $this->textDoubleHeightOff();
        $content .= $this->textEmphasizedOff();

        $content .= $this->separator('=');
        $content .= $this->centerLine('Faleminderit!');
        $content .= "\n\n";
        $content .= $this->cutPaper();

        return $content;
    }

    /**
     * =========================================================
     * LOW LEVEL HELPERS
     * =========================================================
     */

    protected function kvLine(string $label, string $value): string
    {
        $label = $this->normalizeText($label);
        $value = $this->normalizeText($value);

        $labelWidth = 11;
        $valueWidth = $this->paperWidth - $labelWidth - 1;

        $label = $this->truncateText($label, $labelWidth);
        $value = $this->truncateText($value, $valueWidth);

        return sprintf("%-{$labelWidth}s %{$valueWidth}s\n", $label . ':', $value);
    }

    protected function leftRightLine(string $left, string $right): string
    {
        $left = $this->normalizeText(trim($left));
        $right = $this->normalizeText(trim($right));

        $space = $this->paperWidth - mb_strlen($left) - mb_strlen($right);
        if ($space < 1) {
            $space = 1;
        }

        return $left . str_repeat(' ', $space) . $right . "\n";
    }

    protected function separator(string $char = '-'): string
    {
        return str_repeat($char, $this->paperWidth) . "\n";
    }

    protected function initPrinter(): string
    {
        return "\x1B\x40";
    }

    protected function alignLeft(): string
    {
        return "\x1B\x61\x00";
    }

    protected function alignCenter(): string
    {
        return "\x1B\x61\x01";
    }

    protected function textEmphasizedOn(): string
    {
        return "\x1B\x45\x01";
    }

    protected function textEmphasizedOff(): string
    {
        return "\x1B\x45\x00";
    }

    protected function textDoubleHeightOn(): string
    {
        return "\x1D\x21\x01";
    }

    protected function textDoubleHeightOff(): string
    {
        return "\x1D\x21\x00";
    }

    protected function centerLine(string $text): string
    {
        return $this->normalizeText($text) . "\n";
    }

    protected function truncateText(string $text, int $max): string
    {
        $text = trim($text);

        return mb_strlen($text) > $max
            ? mb_substr($text, 0, $max - 1) . '…'
            : $text;
    }

    protected function normalizeText(string $text): string
    {
        $text = trim($text);

        $map = [
            'ë' => 'e', 'Ë' => 'E',
            'ç' => 'c', 'Ç' => 'C',
        ];

        $text = strtr($text, $map);
        $text = preg_replace('/[^\x20-\x7E]/u', '', $text) ?? '';

        return $text;
    }

    protected function cutPaper(): string
    {
        return "\x1D\x56\x00";
    }

    /**
     * =========================================================
     * SEND TO PRINTER
     * =========================================================
     */
    protected function sendToPrinter(string $content): bool
    {
        try {
            Log::info('KuponParkimiService sendToPrinter start', [
                'ip' => $this->printerIp,
                'port' => $this->printerPort,
                'paper_width_chars' => $this->paperWidth,
                'bytes' => strlen($content),
            ]);

            $socket = @fsockopen(
                $this->printerIp,
                $this->printerPort,
                $errno,
                $errstr,
                $this->timeout
            );

            if (!$socket) {
                throw new \Exception("Nuk lidhet me printerin: {$errstr} ({$errno})");
            }

            stream_set_timeout($socket, $this->timeout);

            $bytesWritten = fwrite($socket, $content);

            $meta = stream_get_meta_data($socket);
            fclose($socket);

            Log::info('KuponParkimiService sendToPrinter result', [
                'bytes_written' => $bytesWritten,
                'timed_out' => $meta['timed_out'] ?? false,
            ]);

            return $bytesWritten !== false && $bytesWritten > 0;
        } catch (\Throwable $e) {
            Log::error('KuponParkimiService printer connection error', [
                'ip' => $this->printerIp,
                'port' => $this->printerPort,
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function printoHistorikunMjetit(Operacionet $operacioni): bool
    {
        try {
            // Sigurohemi që relacionet janë të ngarkuara njësoj si te modali
            $operacioni->loadMissing([
                'operatori',
                'transaksioni.prenotimi',
                'transaksioni.fashaOrare',
                'transaksioni.monedha',
                'transaksioni.operatori'
            ]);

            $content = $this->buildHistorikuContent($operacioni);
            return $this->sendToPrinter($content);
        } catch (\Throwable $e) {
            Log::error('KuponParkimiService historiku error', [
                'operacioni_id' => $operacioni->id,
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }

    protected function buildHistorikuContent(Operacionet $operacioni): string
    {
        $transaksioni = $operacioni->transaksioni;

        $content = '';
        $content .= $this->initPrinter();
        $content .= $this->alignCenter();

        $content .= $this->textDoubleHeightOn();
        $content .= $this->centerLine('PARKINGU');
        $content .= $this->textDoubleHeightOff();
        $content .= $this->centerLine('Historiku i Operacionit');
        $content .= $this->separator('=');

        // Targa e mjetit e zmadhuar
        $content .= $this->textDoubleHeightOn();
        $content .= $this->centerLine($this->normalizeText($operacioni->targa));
        $content .= $this->textDoubleHeightOff();
        $content .= $this->separator('-');

        // Kohët e lëvizjes
        $content .= $this->alignLeft();
        $content .= $this->kvLine('Hyrja', \Carbon\Carbon::parse($operacioni->nisja)->format('d/m/Y H:i'));
        $content .= $this->kvLine('Dalja', $operacioni->ikja ? \Carbon\Carbon::parse($operacioni->ikja)->format('d/m/Y H:i') : '-');

        // Kalkulimi i kohës totale të qëndrimit
        $hyrja = \Carbon\Carbon::parse($operacioni->nisja);
        $ikja = \Carbon\Carbon::parse($operacioni->ikja);
        $kohezgjatja = $hyrja->diffForHumans($ikja, true);
        $content .= $this->kvLine('Qendrimi', $kohezgjatja);

        // Operatori që e ka mbyllur ose regjistruar
        $emriOperatorit = $transaksioni->operatori->name ?? $operacioni->operatori->name ?? 'I panjohur';
        $content .= $this->kvLine('Operatori', $emriOperatorit);

        $content .= $this->separator('-');

        // Detajet e faturimit nëse ka transaksion
        if ($transaksioni) {
            $kategoria = $transaksioni->prenotimi->kategoria ?? 'Standard';
            $content .= $this->kvLine('Sherbimi', $kategoria);

            // Kontrolli për Ditë ose Orë sipas njesia_matese
            if ($transaksioni->prenotimi && $transaksioni->prenotimi->njesia_matjes === 'dite') {
                $content .= $this->kvLine('Kohezgjatja', $transaksioni->sasia . ' Dite');
            } elseif ($transaksioni->fashaOrare) {
                $content .= $this->kvLine('Kohezgjatja', $transaksioni->fashaOrare->nga . '-' . $transaksioni->fashaOrare->ne . ' ore');
            }

            $content .= $this->kvLine('Pagesa', $transaksioni->metoda_pageses === 'karte' ? 'Karte' : 'Kesh');
            $content .= $this->separator('-');

            // Vlera e paguar e theksuar
            $emriMonedhes = $transaksioni->monedha->kodi ?? 'ALL';
            $content .= $this->alignCenter();
            $content .= $this->textEmphasizedOn();
            $content .= $this->textDoubleHeightOn();
            $content .= $this->centerLine('PAGUAR: ' . number_format($transaksioni->vlera, 2) . ' ' . $emriMonedhes);
            $content .= $this->textDoubleHeightOff();
            $content .= $this->textEmphasizedOff();
        } else {
            $content .= $this->alignCenter();
            $content .= $this->textEmphasizedOn();
            $content .= $this->centerLine('STATUSI: PA PAGUAR / SKA TRANSAKSION');
            $content .= $this->textEmphasizedOff();
        }

        $content .= $this->separator('=');
        $content .= $this->alignCenter();
        $content .= $this->centerLine('Kopje e Rishfaqur');
        $content .= $this->centerLine(\Carbon\Carbon::now()->format('d/m/Y H:i:s'));
        $content .= "\n\n";
        $content .= $this->cutPaper();

        return $content;
    }

    public function buildParapagesenRaw(Operacionet $operacioni, TransaksioniOperacionit $transaksioni, string $metodaPageses): string
    {
        return $this->buildPagesaContent($operacioni, $transaksioni, $metodaPageses, false, false);
    }

    public function buildHistorikuRaw(Operacionet $operacioni): string
    {
        $operacioni->loadMissing([
            'operatori',
            'transaksioni.prenotimi',
            'transaksioni.fashaOrare',
            'transaksioni.monedha',
            'transaksioni.operatori'
        ]);

        return $this->buildHistorikuContent($operacioni);
    }

}
