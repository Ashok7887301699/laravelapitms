<?php
namespace App\Feature\Customer\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndType extends Model{
    use HasFactory;
    protected $table = 'industry_types';

    protected $fillable = [
        'name',
        'description',
    ];
}
