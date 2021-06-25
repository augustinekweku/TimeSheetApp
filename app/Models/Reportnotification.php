<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reportnotification extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'staff_id', 'reportingtime', 'timereported', 'timediff', 'status'
    ];
}
