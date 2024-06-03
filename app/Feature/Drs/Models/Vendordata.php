<?php
namespace App\Feature\Drs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vendordata extends Model
{
    use HasFactory;

    protected $table = 'vendor';
    protected $primaryKey = 'id';
    protected $fillable = [
        'VendorCode',
        'VendorName',
        'Type',
    ];

    // Accessor to concatenate VendorCode and VendorName
    public function getConcatenatedAttribute()
    {
        return $this->VendorCode . '-' . $this->VendorName;
    }

    // Scope for filtering attached vendors
    public function scopeAttached($query)
    {
        return $query->where('Type', 'ATTACHED');
    }
}
