<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'doctor_id',
        'clinical_admin_id',
        'patient_id',
        'appointment_date',
        'shift_name',
        'shift_time',
        'appointment_time',
        'referred_by',
        'department',
        'token_number',
        'status',
        'reffered_by',
        'visit_type',
        'follow_up_date',
        'reason',
        'chief_complaint',
        'diagnosis',
        'prescription',
        'test_recommended',
        'notes',
        'appointment_fee'
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function clinic()
        {
            return $this->belongsTo(
            ClinicalAdmin::class,
            'clinical_admin_id'
            );
        }
    public function patientVital()
{
    return $this->hasOne(PatientVital::class);
}
    
}
