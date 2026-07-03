<?php

namespace App\Livewire\Admin;

use App\Models\Admin\KategoriaPageses;
use App\Models\Admin\Monedhat;
use App\Models\Admin\OretCmimi;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LiveAdminKonfiguroOret extends Component
{
    use AuthorizesRequests;

    public $ora_fillestare;

    public $ora_limit;

    public $id_kategoria_rezervimit;

    // Array dinamik për të mbajtur çmimet sipas monedhave: [monedha_id => vlera]
    public array $cmimet_monedhave = [];

    public bool $showOretModal = false;

    public function mount()
    {
        $this->authorize('admin.konfiguro-oret');
    }

    public bool $isViewOnly = false;

    public $editingId = null;

    public ?int $filterKatId = null;

    public string $search = '';

    // Rregullat e validimit të përshtatshme për array-n e monedhave
    protected function rules()
    {
        return [
            'id_kategoria_rezervimit' => 'required|exists:adm_kategoria_pageses,id',
            'ora_fillestare' => 'required|numeric|min:0',
            'ora_limit' => 'required|numeric|gt:ora_fillestare',
            'cmimet_monedhave.*' => 'required|numeric|min:0',
        ];
    }

    protected $messages = [
        'id_kategoria_rezervimit.required' => 'Duhet të zgjidhni kategorinë e rezervimit.',
        'id_kategoria_rezervimit.exists' => 'Kategoria e zgjedhur nuk është valide.',
        'ora_fillestare.required' => 'Fillimi i intervalit është i detyrueshëm.',
        'ora_limit.required' => 'Fundi i intervalit është i detyrueshëm.',
        'ora_limit.gt' => 'Fundi duhet të jetë më i madh se fillimi.',
        'cmimet_monedhave.*.required' => 'Ky çmim është i detyrueshëm.',
        'cmimet_monedhave.*.numeric' => 'Duhet të jetë numër valid.',
        'cmimet_monedhave.*.min' => 'Çmimi nuk mund të jetë më i vogël se 0.',
    ];

    public function filtroKat($id = null)
    {
        $this->filterKatId = $id;
    }

    public function updatingSearch()
    {
        // e ruajme thjeshte per konsistence, live.debounce e rifreskon vetë render()
    }

    public function hapModalin()
    {
        $this->reset(['ora_fillestare', 'ora_limit', 'cmimet_monedhave', 'editingId', 'isViewOnly', 'id_kategoria_rezervimit']);
        $this->resetErrorBag();

        // Nëse ka filtër aktiv kategorie, e parazgjedhim direkt në modal
        if ($this->filterKatId) {
            $this->id_kategoria_rezervimit = $this->filterKatId;
        }

        $this->showOretModal = true;
    }

    // 1. FUNKSIONI VIEW
    public function shikoOret($id)
    {
        $this->reset(['ora_fillestare', 'ora_limit', 'cmimet_monedhave', 'id_kategoria_rezervimit']);

        $fasha = DB::table('adm_oret_cmimi')->where('id', $id)->first();
        if (! $fasha) {
            return;
        }

        $this->ora_fillestare = $fasha->nga;
        $this->ora_limit = $fasha->ne;
        $this->id_kategoria_rezervimit = $fasha->id_kategoria_rezervimit;

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
        $this->reset(['ora_fillestare', 'ora_limit', 'cmimet_monedhave', 'isViewOnly', 'id_kategoria_rezervimit']);
        $this->editingId = $id;

        $fasha = DB::table('adm_oret_cmimi')->where('id', $id)->first();
        if (! $fasha) {
            return;
        }

        $this->ora_fillestare = $fasha->nga;
        $this->ora_limit = $fasha->ne;
        $this->id_kategoria_rezervimit = $fasha->id_kategoria_rezervimit;

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
        $katId = $this->id_kategoria_rezervimit;

        // Kontrolli i mbivendosjes VETËM brenda së njëjtës kategori rezervimi,
        // duke përjashtuar veten nëse editojmë
        $fashatETjera = DB::table('adm_oret_cmimi')
            ->where('id_kategoria_rezervimit', $katId)
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
            $this->addError('ora_fillestare', 'Ky interval kohor mbivendoset me një fashë ekzistuese për këtë kategori!');

            return;
        }

        // Përdorim Transaction për të garantuar që çdo gjë ruhet saktë në të dyja tabelat
        DB::transaction(function () use ($nga_e_re, $ne_e_re, $katId) {

            if ($this->editingId) {
                // Përditësojmë fashën e kohës
                DB::table('adm_oret_cmimi')->where('id', $this->editingId)->update([
                    'id_kategoria_rezervimit' => $katId,
                    'nga' => $nga_e_re,
                    'ne' => $ne_e_re,
                    'updated_at' => now(),
                ]);
                $intervalId = $this->editingId;

                // Fshijmë çmimet e vjetra në mënyrë që t'i rishkruajmë pastër pa mbetur mbetje
                DB::table('adm_cmimi_sipas_monedhes')->where('interval_id', $intervalId)->delete();
            } else {
                // Krijojmë fashën e re dhe marrim ID-në e saj
                $intervalId = DB::table('adm_oret_cmimi')->insertGetId([
                    'id_kategoria_rezervimit' => $katId,
                    'nga' => $nga_e_re,
                    'ne' => $ne_e_re,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Ruajmë vlerat për secilën monedhë në tabelën pivot
            foreach ($this->cmimet_monedhave as $monedhaId => $vlera) {
                DB::table('adm_cmimi_sipas_monedhes')->insert([
                    'interval_id' => $intervalId,
                    'monedha_id' => $monedhaId,
                    'vlera' => floatval($vlera),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        $this->showOretModal = false;
        $this->reset(['ora_fillestare', 'ora_limit', 'cmimet_monedhave', 'editingId', 'isViewOnly', 'id_kategoria_rezervimit']);
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

        // Marrim fashat bashkë me çmimet, monedhat dhe kategorinë e tyre
        $fashat = OretCmimi::with(['cmimet.monedha', 'kategoria'])
            ->when($this->filterKatId, function ($query) {
                $query->where('id_kategoria_rezervimit', $this->filterKatId);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nga', 'like', '%'.$this->search.'%')
                        ->orWhere('ne', 'like', '%'.$this->search.'%')
                        ->orWhereHas('kategoria', function ($qk) {
                            $qk->where('kategoria', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->orderBy('nga', 'asc')
            ->get();

        // E përshtasim duke përdorur një emër tjetër që mos të prishim relacionin `kategoria`
        $konfigurimet = $fashat->map(function ($fasha) {
            // Krijojmë një atribute të ri "cmimet_mapped" që mos të prekim relacionin origjinal
            $fasha->cmimet_mapped = $fasha->cmimet->pluck('vlera', 'monedha.kodi')->toArray();

            return $fasha;
        });

        return view('livewire.admin.live-admin-konfiguro-oret', [
            'monedhat' => $monedhat,
            'konfigurimet' => $konfigurimet,
            'kategorite' => KategoriaPageses::get(),
        ])->layout('layouts.dashboard.app');
    }
}
