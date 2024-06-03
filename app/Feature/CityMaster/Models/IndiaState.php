<?php

// app/Feature/CityMaster/Models/IndiaState.php

namespace App\Feature\CityMaster\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndiaState extends Model
{
    protected $table = 'india';
    protected $fillable = [
        'State',
        'District', // Add the district column here
    ];
}
