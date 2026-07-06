<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksioniOperacionit extends Model
{
    //
    protected $table = 'adm_transaksioni_operacionit';
    protected $guarded = [];

    public function prenotimi() :BelongsTo {
        return $this->belongsTo(KategoriaPageses::class, 'id_prenotimit');
    }


    public function fashaOrare () :BelongsTo {
        return $this->belongsTo(OretCmimi::class, 'id_fashes_orare');
    }

    public function operatori () :BelongsTo {
        return $this->belongsTo(User::class, 'id_operatori');
    }
    public function monedha(): BelongsTo
    {
        return $this->belongsTo(Monedhat::class, 'monedha');
    }
    // Shto te App\Models\Admin\TransaksioniOperacionit
    public function monedhaRelacioni(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Admin\Monedhat::class, 'monedha');
    }
}
