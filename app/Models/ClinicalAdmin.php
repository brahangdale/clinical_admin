<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalAdmin extends Model
{
    protected $fillable = [
        'clinic_name',
        'mobile_number',
        'city',
        'state',
        'address',
        'partner_id'
        
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'clinical_admin_id');
    }
    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'clinical_admin_id');
    }
    public function patients()
    {
        return $this->hasMany(Patient::class, 'clinical_admin_id');
    }
    public function appointments()
        {
            return $this->hasMany(Appointment::class, 'clinical_admin_id');
        }
        public function partner()
{
    return $this->belongsTo(Partner::class, 'partner_id');
}
}
