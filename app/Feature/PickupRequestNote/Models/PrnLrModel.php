<?php

namespace App\Feature\PickupRequestNote\Models;

use App\Feature\User\Models\User; // Assuming User model resides here
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrnLrModel extends Model
{
    protected $table = 'fm_prn_lr';

    protected $fillable = [
        'id',
        'tenant_id',
        'prn_id',
        'lr_id',
        'seq_num',
    ];

    public function fmPrn(): BelongsTo // Potential typo corrected
    {
        return $this->belongsTo(PickupRequestNote::class, 'prn_id', 'id');
    }

    public function lr(): BelongsTo
    {
        return $this->belongsTo(Lrdata::class, 'lr_id', 'id'); // Assuming Lrdata model name
    }

    public function tenant(): BelongsTo // Potential typo corrected (lowercase t)
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }
}