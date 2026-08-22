<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
      'patient_name',
      'mobile_number',
      'patient_id',
      'clinical_admin_id',
      'doctor_id',
      'email',
      'age',
      'gender',
      
      'date_of_birth',
     
      'marital_status',
      'city',
      'address',
      'occupation',
      'emergency_number'
    ];

    public function vitals()
    {
      return $this->hasMany(PatientVital::class);
    }
}
