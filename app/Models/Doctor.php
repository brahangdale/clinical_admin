<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'clinical_admin_id',
        'doctor_name',
        'mobile_number',
        'email',
        'gender',
        'dob',
        'specialization',
        'qualification',
        'experience',
        'consultation_fee',
        'profile_photo',
        'status',
        'address'
    ];

    public function clinic()
        {
            return $this->belongsTo(
            ClinicalAdmin::class,
            'clinical_admin_id'
            );
        }

    public function schedules()
        {
            return $this->hasMany(DoctorSchedule::class);
        }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'doctor_id');
    }

      public function appointments()
{
    return $this->hasMany(Appointment::class, 'doctor_id');
}

public function clinical_admin()
{
    return $this->belongsTo(ClinicalAdmin::class, 'clinical_admin_id');
}
}
