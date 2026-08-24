<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
      'partner_name',
      'mobile_number',
      'city',
      'state',
      'address',
        
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'partner_id');
    }
    public function clinicalAdmins()
    {
        return $this->hasMany(ClinicalAdmin::class, 'partner_id');
    }

}
