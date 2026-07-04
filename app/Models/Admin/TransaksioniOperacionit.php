<?php

namespace App\Models\Admin;

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
}
