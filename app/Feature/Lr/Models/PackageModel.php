<?php

namespace App\Feature\Lr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageModel extends Model
{
    use HasFactory;

    protected $table = 'package_types';

    protected $fillable = [
        'package_type',
    ];
}