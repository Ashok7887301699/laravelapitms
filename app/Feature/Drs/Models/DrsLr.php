<?php

namespace App\Feature\Drs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrsLr extends Model
{
    protected $table = 'fm_drs_lr';

    protected $fillable = [
        'id',
        'tenant_id',
        'drs_id',
        'lr_id',
        'seq_num',
    ];

    public $timestamps = false;

    public function drs(): BelongsTo
    {
        return $this->belongsTo(Drs::class, 'drs_id', 'id');
    }

    public function lr(): BelongsTo
    {
        return $this->belongsTo(Lr::class, 'lr_id', 'id');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }
}
