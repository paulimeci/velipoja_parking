<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Operacionet extends Model
{
    //

    protected $table = 'adm_operacionet';
    protected $guarded = [];


    public function monedha(): BelongsTo
    {
        return $this->belongsTo(Monedhat::class, 'monedha_id');
    }
}
