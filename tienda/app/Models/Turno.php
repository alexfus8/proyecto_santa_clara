<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $table= 'turno';
    protected $primarykey='id';

       protected $fillable = [
        'turno',
    ];
}
