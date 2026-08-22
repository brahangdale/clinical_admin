<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicTiming extends Model
{
    protected $fillable = [
        'clinical_admin_id',
        'day',
        'morning_time',
        'evening_time',
    ];
}
