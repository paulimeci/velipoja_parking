<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    public function transaksionet()
    {
        return $this->hasMany(TransaksioniOperacionit::class, 'id_operacionit');
    }

// "transaksioni" duhet t'i referohet GJITHMONË pagesës më të fundit
// (origjinale ose shtesë), jo çdo rreshti rastësisht
    public function transaksioni()
    {
        return $this->hasOne(TransaksioniOperacionit::class, 'id_operacionit')->latestOfMany();
    }

    public function getVleraTotalePaguarAttribute()
    {
        return $this->transaksionet()
            ->whereIn('status_pagesa', ['paguar', 'pagese_shtese'])
            ->sum('vlera');
    }

    public function operatori (): BelongsTo {
        return $this->belongsTo(User::class, 'id_operatori');
    }

    public function transaksioniOriginal()
    {
        return $this->hasOne(TransaksioniOperacionit::class, 'id_operacionit')
            ->where('status_pagesa', 'paguar')
            ->oldestOfMany();
    }

    public function transaksionetShtese()
    {
        return $this->hasMany(TransaksioniOperacionit::class, 'id_operacionit')
            ->where('status_pagesa', 'pagese_shtese');
    }

    public function getVleraShteseTotaleAttribute()
    {
        return $this->transaksionetShtese->sum('vlera');
    }
}
