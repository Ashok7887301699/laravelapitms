<?php
namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conpartymodel extends Model{
    use HasFactory;
    protected $table = 'customers';

    protected $fillable = [
        'customers',
    ];
}
