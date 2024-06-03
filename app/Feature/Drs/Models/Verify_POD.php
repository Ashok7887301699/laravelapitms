<?php

namespace App\Feature\Drs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Verify_POD extends Model
{
    use HasFactory;

    protected $table = 'fm_drs';
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
    ];

    
}
