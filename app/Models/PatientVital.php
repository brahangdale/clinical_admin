<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientVital extends Model
{
    protected $fillable = [
        'patient_id',
        'appointment_id',
        'height',
        'weight',
        'bmi',
        'bp',
        'pulse',
        'temperature',
        'spo2',
        'blood_sugar',
    ];

     public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
