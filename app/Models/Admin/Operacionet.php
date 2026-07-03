<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
