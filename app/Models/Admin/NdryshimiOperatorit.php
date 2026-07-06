<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class NdryshimiOperatorit extends Model
{
    protected $table = 'adm_ndryshimi_operatorit';
    protected $guarded = [];

    public function transaksioni(): BelongsTo
    {
        return $this->belongsTo(TransaksioniOperacionit::class, 'id_transaksionit');
    }

    public function operatoriPare(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operatori_pare');
    }

    public function operatoriDyte(): BelongsTo
    {
        return $this->belongsTo(User::class, 'operatori_dyte');
    }

}
