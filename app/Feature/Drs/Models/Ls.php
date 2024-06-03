<?php

namespace App\Feature\Drs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Feature\Tenant\Models\Tenant;
use App\Feature\User\Models\User;
use App\Feature\Branch\Models\Branch;
class Ls extends Model
{
    use HasFactory;

    protected $table = 'fm_ls';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'tenant_id',
        'dated',
        'del_depot',
        'from_depot',
        'to_depot',
        'freight_charges',
        'created_by',
        'cancel_by',
        'cancellation_reason',
        'status'
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }


    public function del_depot()
    {
        return $this->belongsTo(Branch::class, 'del_depot', 'BranchCode');
    }

    public function to_depot()
    {
        return $this->belongsTo(Branch::class, 'to_depot', 'BranchCode');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cancelBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancel_by');
    }

}
