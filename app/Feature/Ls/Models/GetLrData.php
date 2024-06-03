<?php

namespace App\Feature\Ls\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GetLrData extends Model
{
    use HasFactory;

    protected $table = 'fb_lr';
    public $incrementing = false;
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
    ];

}
