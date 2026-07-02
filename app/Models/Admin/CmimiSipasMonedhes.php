<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CmimiSipasMonedhes extends Model
{
    //
    protected $table = 'adm_cmimi_sipas_monedhes';
    protected $guarded = [];
    public function intervali(): BelongsTo
    {
        return $this->belongsTo(OretCmimi::class, 'interval_id');
    }

    /**
     * Lidhja mbrapsht me Monedhën.
     */
    public function monedha(): BelongsTo
    {
        return $this->belongsTo(Monedhat::class, 'monedha_id');
    }
}
