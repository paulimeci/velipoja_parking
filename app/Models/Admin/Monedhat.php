<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Monedhat extends Model
{
    //

    protected $table = 'adm_monedhat';
    protected $guarded = [];

    public function cmimet(): HasMany
    {
        return $this->hasMany(CmimiSipasMonedhes::class, 'monedha_id');
    }

    /**
     * Marrëdhënia: Një monedhë mund të jetë përdorur në shumë operacione (pagesa).
     */
    public function operacionet(): HasMany
    {
        return $this->hasMany(Operacionet::class, 'monedha_id');
    }
}
