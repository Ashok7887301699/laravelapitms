<?php

namespace App\Feature\Drs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hamalidata extends Model
{
    use HasFactory;

    protected $table = 'hamali';
    protected $primaryKey = 'id';

    protected $fillable = [
        'VendorCode',
        'Hvendor',
    ];

    public function getConcatenatedAttribute()
    {
        return $this->VendorCode . '-' . $this->Hvendor;
    }

    
}
