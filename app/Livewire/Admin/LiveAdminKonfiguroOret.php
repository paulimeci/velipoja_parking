<?php

namespace App\Livewire\Admin;

use App\Models\Admin\Monedhat;
use App\Models\Admin\OretCmimi;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class LiveAdminKonfiguroOret extends Component
{
    public $ora_fillestare;
    public $ora_limit;

    // Array dinamik për të mbajtur çmimet sipas monedhave: [monedha_id => vlera]
    public array $cmimet_monedhave = [];

    public bool $showOretModal = false;
    public bool $isViewOnly = false;
    public $editingId = null;

    // Rregullat e validimit të përshtatshme për array-n e monedhave
    protected function rules()
    {
        return [
            'ora_fillestare' => 'required|numeric|min:0',
            'ora_limit' => 'required|numeric|gt:ora_fillestare',
            'cmimet_monedhave.*' => 'required|numeric|min:0',
        ];
    }

    protected $messages = [
        'ora_fillestare.required' => 'Fillimi i intervalit është i detyrueshëm.',
        'ora_limit.required' => 'Fundi i intervalit është i detyrueshëm.',
        'ora_limit.gt' => 'Fundi duhet të jetë më i madh se fillimi.',
        'cmimet_monedhave.*.required' => 'Ky çmim është i detyrueshëm.',
        'cmimet_monedhave.*.numeric' => 'Duhet të jetë numër valid.',
        'cmimet_monedhave.*.min' => 'Çmimi nuk mund të jetë më i vogël se 0.',
    ];

    public function hapModalin()
    {
        $this->reset(['ora_fillestare', 'ora_limit', 'cmimet_monedhave', 'editingId', 'isViewOnly']);
        $this->showOretModal = true;
    }

    // 1. FUNKSIONI VIEW
    public function shikoOret($id)
    {
        $this->reset(['ora_fillestare', 'ora_limit', 'cmimet_monedhave']);

        $fasha = DB::table('adm_oret_cmimi')->where('id', $id)->first();
        if (!$fasha) return;

        $this->ora_fillestare = $fasha->nga;
        $this->ora_limit = $fasha->ne;

        // Marrim çmimet e lidhura me këtë fashë
        $cmimet = DB::table('adm_cmimi_sipas_monedhes')->where('interval_id', $id)->get();
        foreach ($cmimet as $cmimi) {
            $this->cmimet_monedhave[$cmimi->monedha_id] = $cmimi->vlera;
        }

        $this->isViewOnly = true;
        $this->showOretModal = true;
    }

    // 2. FUNKSIONI EDIT
    public function editOret($id)
    {
        $this->reset(['ora_fillestare', 'ora_limit', 'cmimet_monedhave', 'isViewOnly']);
        $this->editingId = $id;

        $fasha = DB::table('adm_oret_cmimi')->where('id', $id)->first();
        if (!$fasha) return;

        $this->ora_fillestare = $fasha->nga;
        $this->ora_limit = $fasha->ne;

        // Mbushim array-n me çmimet ekzistuese në DB
        $cmimet = DB::table('adm_cmimi_sipas_monedhes')->where('interval_id', $id)->get();
        foreach ($cmimet as $cmimi) {
            $this->cmimet_monedhave[$cmimi->monedha_id] = $cmimi->vlera;
        }

        $this->showOretModal = true;
    }

    // RUAJTJA DHE PËRDITËSIMI
    public function ruajOret()
    {
        $this->validate();

        $nga_e_re = floatval($this->ora_fillestare);
        $ne_e_re = floatval($this->ora_limit);

        // Kontrolli i mbivendosjes në memorie (PHP) duke përjashtuar veten nëse editojmë
        $fashatETjera = DB::table('adm_oret_cmimi')
            ->when($this->editingId, function ($query) {
                return $query->where('id', '!=', $this->editingId);
            })
            ->get();

        $kaMbivendosje = false;
        foreach ($fashatETjera as $fasha) {
            if ($nga_e_re < $fasha->ne && $ne_e_re > $fasha->nga) {
                $kaMbivendosje = true;
                break;
            }
        }

        if ($kaMbivendosje) {
            $this->addError('ora_fillestare', 'Ky interval kohor mbivendoset me një fashë ekzistuese çmimi!');
            return;
        }

        // Përdorim Transaction për të garantuar që çdo gjë ruhet saktë në të dyja tabelat
        DB::transaction(function () use ($nga_e_re, $ne_e_re) {

            if ($this->editingId) {
                // Përditësojmë fashën e kohës
                DB::table('adm_oret_cmimi')->where('id', $this->editingId)->update([
                    'nga' => $nga_e_re,
                    'ne'  => $ne_e_re,
                    'updated_at' => now(),
                ]);
                $intervalId = $this->editingId;

                // Fshijmë çmimet e vjetra në mënyrë që t'i rishkruajmë pastër pa mbetur mbetje
                DB::table('adm_cmimi_sipas_monedhes')->where('interval_id', $intervalId)->delete();
            } else {
                // Krijojmë fashën e re dhe marrim ID-në e saj
                $intervalId = DB::table('adm_oret_cmimi')->insertGetId([
                    'nga' => $nga_e_re,
                    'ne'  => $ne_e_re,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Ruajmë vlerat për secilën monedhë në tabelën pivot
            foreach ($this->cmimet_monedhave as $monedhaId => $vlera) {
                DB::table('adm_cmimi_sipas_monedhes')->insert([
                    'interval_id' => $intervalId,
                    'monedha_id'  => $monedhaId,
                    'vlera'       => floatval($vlera),
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        });

        $this->showOretModal = false;
        $this->reset(['ora_fillestare', 'ora_limit', 'cmimet_monedhave', 'editingId', 'isViewOnly']);
        session()->flash('message', 'Konfigurimi i fashave dhe çmimeve u ruajt me sukses.');
    }

    // 3. FUNKSIONI DELETE
    public function fshiOret($id)
    {
        // Falë ->onDelete('cascade') në migrim, fshirja këtu do të fshijë automatikisht edhe çmimet përkatëse
        DB::table('adm_oret_cmimi')->where('id', $id)->delete();

        session()->flash('message', 'Intervali u fshi me sukses.');
    }

    public function render()
    {
        // Marrim monedhat duke përdorur Modelin
        $monedhat = Monedhat::all();

        // Marrim fashat bashkë me çmimet dhe monedhat e tyre në një query të vetëm elegant
        $fashat = OretCmimi::with('cmimet.monedha')->orderBy('nga', 'asc')->get();

        // E përshtasim që Blade ta lexojë njëlloj si më parë
        $konfigurimet = $fashat->map(function ($fasha) {
            $fasha->cmimet = $fasha->cmimet->pluck('vlera', 'monedha.kodi');
            return $fasha;
        });

        return view('livewire.admin.live-admin-konfiguro-oret', [
            'monedhat' => $monedhat,
            'konfigurimet' => $konfigurimet
        ])->layout('layouts.dashboard.app');
    }
}
