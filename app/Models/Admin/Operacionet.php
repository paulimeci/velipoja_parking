<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Operacionet extends Model
{
    //

    protected $table = 'adm_operacionet';
    protected $guarded = [];


    public function monedha(): BelongsTo
    {
        return $this->belongsTo(Monedhat::class, 'monedha_id');
    }

    public function kategoria (): BelongsTo {
        return $this->belongsTo(KategoriaPageses::class, 'kategoria_id');
    }
    public function transaksioni (): HasOne {
        return $this->hasOne(TransaksioniOperacionit::class, 'id_operacionit');
    }

    public function operatori (): BelongsTo {
        return $this->belongsTo(User::class, 'id_operatori');
    }
}
