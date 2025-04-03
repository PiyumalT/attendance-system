<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use Hasfactory;

    protected $fillable = [
        'user_id',
        'notes',
        'time_in',
        'time_out',
    ];
}
