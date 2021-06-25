<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportingtime extends Model
{

    use HasFactory;

    protected $fillable = [
        'time', 'state'
    ];


    protected $casts = [
        'state' => 'boolean',
    ];
}
