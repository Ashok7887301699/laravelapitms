<?php

namespace App\Feature\Drs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GetLsdata extends Model
{
    use HasFactory;

    protected $table = 'fm_ls';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
    ];

}
