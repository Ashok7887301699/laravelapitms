<?php

namespace App\Feature\Ls\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Feature\Tenant\Models\Tenant;
use App\Feature\User\Models\User;
use App\Feature\Branch\Models\Branch;
use App\Feature\Drs\Models\Drs;
use App\Feature\Lr\Models\lrdata;
use App\Feature\Thc\Models\Thc;
class LsLr extends Model
{
    use HasFactory;

    protected $table = 'fm_ls_lr';

    protected $fillable = [
        'tenant_id',
        'drs_id',
        'thc_id',
        'ls_id',
        'lr_id',
        'seq_num'
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function drs(): BelongsTo
    {
        return $this->belongsTo(Drs::class, 'drs_id');
    }

    public function thc(): BelongsTo
    {
        return $this->belongsTo(Thc::class, 'thc_id');
    }

    public function ls(): BelongsTo
    {
        return $this->belongsTo(Ls::class, 'ls_id');
    }

    public function lr(): BelongsTo
    {
        return $this->belongsTo(lrdata::class, 'lr_id');
    }
}
