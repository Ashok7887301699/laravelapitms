<?php

namespace App\Feature\PickupRequestNote\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class fb_lr_state_log extends Model
{
    use HasFactory;

    protected $table = 'fb_lr_state_log';
    public $incrementing = false;

    protected $fillable = [
        'tenant_id',
        'lr_id',
        'status',
        'consignment_location_id',
        'total_num_of_pkgs',
        'num_of_pkgs',
        'remarks',
        'state_datetime',
        'state_change_by',
        // Add new columns here
    ];

    // Define the relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'state_change_by', 'id');
    }

    public function consignmentLocation(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'consignment_location_id', 'BranchCode');
    }

    public function lr(): BelongsTo
    {
        return $this->belongsTo(FbLr::class, 'lr_id', 'id');
    }
}