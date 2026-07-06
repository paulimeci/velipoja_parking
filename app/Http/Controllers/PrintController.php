<?php

namespace App\Http\Controllers;

use App\Models\Admin\Operacionet;
use App\Models\Admin\TransaksioniOperacionit;
use Illuminate\Support\Facades\Log;

class PrintController extends Controller
{
    // NEW: konfigurimi i printerit termik — mund ta zhvendosësh te .env nëse do fleksibilitet
    protected string $printerIp = '10.10.12.15';
    protected int $printerPort = 9100;

    // ════════════════════════════════════════════════
    // KUPONI I HYRJES
    // ════════════════════════════════════════════════
    public function kuponiHyrjes($operacioni)
    {
        $operacioni = Operacionet::findOrFail($operacioni);

        $komandat = $this->gjeneroKuponinHyrjes($operacioni);

        return $this->dergoTePrinteri($komandat);
    }

    // ════════════════════════════════════════════════
    // KUPONI I DALJES
    // ════════════════════════════════════════════════
    public function kuponiDaljes($operacioni)
    {
        $operacioni = Operacionet::findOrFail($operacioni);

        $transaksioni = TransaksioniOperacionit::with(['prenotimi', 'fashaOrare', 'monedhaRelacioni'])
            ->where('id_operacionit', $operacioni->id)
            ->latest()
            ->first();

        $komandat = $this->gjeneroKuponinDaljes($operacioni, $transaksioni);

        return $this->dergoTePrinteri($komandat);
    }

    // ════════════════════════════════════════════════
    // DËRGIMI DIREKT TE PRINTERI (socket, njësoj si localRelayPrint)
    // ════════════════════════════════════════════════
    private function dergoTePrinteri(string $komandat)
    {
        $fp = @fsockopen($this->printerIp, $this->printerPort, $errno, $errstr, 3);

        if (!$fp) {
            Log::error('Printer Error: ' . $errstr . ' (errno: ' . $errno . ')');
            return response()->json([
                'success' => false,
                'error'   => 'S\'u lidh dot me printerin: ' . $errstr,
            ]);
        }

        fwrite($fp, $komandat);
        fclose($fp);

        return response()->json(['success' => true]);
    }

    // ════════════════════════════════════════════════
    // GJENERIMI I KOMANDAVE ESC/POS — KUPONI I HYRJES
    // ════════════════════════════════════════════════
    private function gjeneroKuponinHyrjes(Operacionet $operacioni): string
    {
        $esc = fn($cmd) => chr(27) . $cmd;
        $gs  = fn($cmd) => chr(29) . $cmd;

        $out = "";
        $out .= $esc("@"); // Init

        // Header
        $out .= $esc("a") . chr(1); // Center
        $out .= $esc("E") . chr(1); // Bold ON
        $out .= "PARKINGU\n";
        $out .= $esc("E") . chr(0); // Bold OFF
        $out .= "Kuponi i Hyrjes\n";
        $out .= str_repeat("-", 32) . "\n";

        // Targa (mesatare/e madhe)
        $out .= $gs("!") . chr(0x11); // Double height + width
        $out .= $this->pastroTekstin($operacioni->targa) . "\n";
        $out .= $gs("!") . chr(0x00); // Reset madhësia

        $out .= str_repeat("-", 32) . "\n";

        // Info (majtas)
        $out .= $esc("a") . chr(0);
        $out .= "Data:       " . \Carbon\Carbon::parse($operacioni->nisja)->format('d/m/Y') . "\n";
        $out .= "Ora Hyrjes: " . \Carbon\Carbon::parse($operacioni->nisja)->format('H:i') . "\n";
        $out .= "Nr. Bilete: #" . str_pad($operacioni->id, 6, '0', STR_PAD_LEFT) . "\n";

        $out .= str_repeat("-", 32) . "\n";
        $out .= $esc("a") . chr(1); // Center
        $out .= "Ju lutem ruajeni kete kupon\n";
        $out .= "deri ne momentin e daljes\n";

        $out .= "\n\n\n\n";
        $out .= $gs("V") . chr(65); // Cut

        return $out;
    }

    // ════════════════════════════════════════════════
    // GJENERIMI I KOMANDAVE ESC/POS — KUPONI I DALJES
    // ════════════════════════════════════════════════
    private function gjeneroKuponinDaljes(Operacionet $operacioni, $transaksioni): string
    {
        $esc = fn($cmd) => chr(27) . $cmd;
        $gs  = fn($cmd) => chr(29) . $cmd;

        $out = "";
        $out .= $esc("@"); // Init

        $out .= $esc("a") . chr(1); // Center
        $out .= $esc("E") . chr(1);
        $out .= "PARKINGU\n";
        $out .= $esc("E") . chr(0);
        $out .= "Kuponi i Daljes / Fature\n";
        $out .= str_repeat("-", 32) . "\n";

        $out .= $gs("!") . chr(0x11);
        $out .= $this->pastroTekstin($operacioni->targa) . "\n";
        $out .= $gs("!") . chr(0x00);

        $out .= str_repeat("-", 32) . "\n";

        $out .= $esc("a") . chr(0); // Majtas
        $out .= "Hyrja: " . \Carbon\Carbon::parse($operacioni->nisja)->format('d/m/Y H:i') . "\n";
        $out .= "Ikja:  " . \Carbon\Carbon::parse($operacioni->ikja)->format('d/m/Y H:i') . "\n";

        $out .= str_repeat("-", 32) . "\n";

        if ($transaksioni) {
            $out .= "Sherbimi: " . $this->pastroTekstin($transaksioni->prenotimi->kategoria ?? '-') . "\n";

            if ($transaksioni->sasia && $transaksioni->sasia > 1) {
                $out .= "Sasia:    x" . $transaksioni->sasia . "\n";
            }

            if ($transaksioni->fashaOrare) {
                $out .= "Fasha:    " . $transaksioni->fashaOrare->nga . "-" . $transaksioni->fashaOrare->ne . "\n";
            }

            $out .= str_repeat("-", 32) . "\n";

            // Totali (bold, i madh)
            $out .= $esc("a") . chr(1); // Center
            $out .= $esc("E") . chr(1); // Bold
            $out .= $gs("!") . chr(0x01); // Double width
            $out .= "TOTAL: " . number_format($transaksioni->vlera, 2) . " " . ($transaksioni->monedhaRelacioni->kodi ?? '') . "\n";
            $out .= $gs("!") . chr(0x00);
            $out .= $esc("E") . chr(0);
        } else {
            $out .= $esc("a") . chr(1);
            $out .= "Pa transaksion te regjistruar.\n";
        }

        $out .= str_repeat("-", 32) . "\n";
        $out .= $esc("a") . chr(1);
        $out .= "Faleminderit!\n";

        $out .= "\n\n\n\n";
        $out .= $gs("V") . chr(65); // Cut

        return $out;
    }

    private function pastroTekstin($text)
    {
        $map = ['ë' => 'e', 'Ë' => 'E', 'ç' => 'c', 'Ç' => 'C'];
        $text = strtr($text, $map);
        return preg_replace('/[^\x20-\x7E\n]/', '', $text);
    }
}
