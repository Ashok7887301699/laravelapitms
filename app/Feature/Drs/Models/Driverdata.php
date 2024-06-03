<?php

namespace App\Feature\Drs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driverdata extends Model
{
    use HasFactory;

    protected $table = 'drivers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'DriverName',
        'FirstName',
        'MiddleName',
        'LastName',
    ];

    public function getFullNameAttribute()
    {
        return $this->FirstName . ' ' . $this->MiddleName . ' ' . $this->LastName;
    }
}
