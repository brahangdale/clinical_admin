<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $fillable = [
        'doctor_id',
        'day',
        'is_off',
        'morning_start',
        'morning_end',
        'evening_start',
        'evening_end',
        'general_start',
        'general_end'
    ];
    public function doctor()
        {
            return $this->belongsTo(Doctor::class);
        }
}
