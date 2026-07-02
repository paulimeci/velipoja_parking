<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Admin\OretCmimi;

class LiveAdminKonfiguroOret extends Component
{
    public $ora_fillestare;
    public $ora_limit;
    public $sasia_leke;

    public bool $showOretModal = false;
    public bool $isViewOnly = false; // Ruajnë gjendjen nëse vetëm po i shikojmë të dhënat
    public $editingId = null;       // Ruajnë ID-në e rekordit që po editojmë

    protected $rules = [
        'ora_fillestare' => 'required|numeric|min:0',
        'ora_limit' => 'required|numeric|gt:ora_fillestare',
        'sasia_leke' => 'required|numeric|min:0',
    ];

    public function hapModalin()
    {
        $this->reset(['ora_fillestare', 'ora_limit', 'sasia_leke', 'editingId', 'isViewOnly']);
        $this->showOretModal = true;
    }

    // 1. FUNKSIONI VIEW
    public function shikoOret($id)
    {
        $this->reset(['ora_fillestare', 'ora_limit', 'sasia_leke']);
        $konfig = OretCmimi::findOrFail($id);

        $this->ora_fillestare = $konfig->nga;
        $this->ora_limit = $konfig->ne;
        $this->sasia_leke = $konfig->shifra;

        $this->isViewOnly = true;
        $this->showOretModal = true;
    }

    // 2. FUNKSIONI EDIT (Hapja e modalit me të dhëna)
    public function editOret($id)
    {
        $this->reset(['ora_fillestare', 'ora_limit', 'sasia_leke', 'isViewOnly']);
        $konfig = OretCmimi::findOrFail($id);

        $this->editingId = $konfig->id;
        $this->ora_fillestare = $konfig->nga;
        $this->ora_limit = $konfig->ne;
        $this->sasia_leke = $konfig->shifra;

        $this->showOretModal = true;
    }

    // RUAJTJA DHE PËRDITËSIMI
    public function ruajOret()
    {
        // 1. Validimi standard i fushave (nëse janë plotësuar dhe janë numra)
        $this->validate();

        $nga_e_re = floatval($this->ora_fillestare);
        $ne_e_re = floatval($this->ora_limit);

        // 2. KONTROLLI I RI I MBIVENDEOSJES
        // Marrim të gjitha fashat nga DB, por PËRJASHTOJMË veten nëse po editojmë
        $fashatETjera = OretCmimi::query()
            ->when($this->editingId, function ($query) {
                return $query->where('id', '!=', $this->editingId);
            })
            ->get();

        // Kontrollojmë në memorie nëse fasha e re përplaset me ndonjë nga fashat e tjera
        $kaMbivendosje = false;
        foreach ($fashatETjera as $fasha) {
            // Logjika: Fillimi i ri < Fundi ekzistues DHE Fundi i ri > Fillimi ekzistues
            if ($nga_e_re < $fasha->ne && $ne_e_re > $fasha->nga) {
                $kaMbivendosje = true;
                break;
            }
        }

        // 3. Nëse ka përplasje me fashat e tjera, shfaqim gabimin
        if ($kaMbivendosje) {
            $this->addError('ora_fillestare', 'Ky interval kohor mbivendoset me një fashë ekzistuese çmimi!');
            return;
        }

        // 4. Ruajtja ose Përditësimi në DB
        if ($this->editingId) {
            $konfig = OretCmimi::findOrFail($this->editingId);
            $konfig->update([
                'nga'    => $nga_e_re,
                'ne'     => $ne_e_re,
                'shifra' => floatval($this->sasia_leke),
            ]);
        } else {
            OretCmimi::create([
                'nga'    => $nga_e_re,
                'ne'     => $ne_e_re,
                'shifra' => floatval($this->sasia_leke),
            ]);
        }

        // Mbyllim modalin dhe pastrojmë variablat
        $this->showOretModal = false;
        $this->reset(['ora_fillestare', 'ora_limit', 'sasia_leke', 'editingId', 'isViewOnly']);
    }

    // 3. FUNKSIONI DELETE
    public function fshiOret($id)
    {
        $konfig = OretCmimi::findOrFail($id);
        $konfig->delete();

        session()->flash('message', 'Intervali u fshi me sukses.');
    }

    public function render()
    {
        $konfigurimet = OretCmimi::orderBy('nga', 'asc')->get();

        return view('livewire.admin.live-admin-konfiguro-oret', [
            'konfigurimet' => $konfigurimet
        ])->layout('layouts.dashboard.app');
    }
}
