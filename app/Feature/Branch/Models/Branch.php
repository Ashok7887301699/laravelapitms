<?php

namespace App\Feature\Branch\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Feature\User\Models\User;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'Branch';

    protected $primaryKey = 'BranchCode';
    public $incrementing = false;

    protected $fillable = [
        // 'SrNo',
        'BranchCode',
        'BranchName',
        'GSTStateCode',
        'BranchType',
        'Latitude',
        'Longitude',
        'Country',
        'State',
        'District',
        'Taluka',
        'City',
        'Status',
        'CreatedBy',
        // 'PinCodes',
        'UploadBranch',
        'UploadShopAct',
        // 'AssetDeployedList',
        'RegionalBranchName',
    ];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'userbranch', 'branch_code', 'user_id');
    }
}
