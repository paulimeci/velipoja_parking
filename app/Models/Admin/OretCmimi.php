<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OretCmimi extends Model
{
    //
    protected $table = 'adm_oret_cmimi';
    protected $guarded = [];
    public function cmimet(): HasMany
    {
        return $this->hasMany(CmimiSipasMonedhes::class, 'interval_id');
    }
}
