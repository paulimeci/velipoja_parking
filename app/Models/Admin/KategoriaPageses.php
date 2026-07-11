<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class KategoriaPageses extends Model
{
    protected $guarded = [];
    protected $table = 'adm_kategoria_pageses';

    public function eshteNjesiaDite(): bool
    {
        return $this->njesia_matjes === 'dite';
    }

    public function oreNjesiReale(): int
    {
        return $this->ore_per_njesi ?: 24;
    }


    public function gjysmaDite()
    {
        return $this->belongsTo(KategoriaPageses::class, 'id_kategoria_gjysme_dite');
    }

    public function gjysmaNate()
    {
        return $this->belongsTo(KategoriaPageses::class, 'id_kategoria_gjysme_nate');
    }


}
