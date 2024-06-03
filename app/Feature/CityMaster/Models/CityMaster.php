<?php

namespace App\Feature\CityMaster\Models;

use App\Feature\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CityMaster extends Model
{
    protected $table = 'citymaster';
    protected $fillable = [
        'CityNameEng',        
        'Taluka',
        'District',
        'DistrictMar',       
        'Pincode',
        'Country',
        'State',
        'CityNameMar',
        'CityNameGmap',
        'Latitude',
        'Longitude',
        'Zone',
        'RouteNo', 
        'RouteSequens',
        'DelDepot',
        'Tat',
        'ODA',        
        'NearStateHighway',
        'NearestNationalHighway',      
        'status',
        'AddUser',
    ];

     public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}