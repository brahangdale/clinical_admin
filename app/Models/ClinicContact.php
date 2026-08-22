<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicContact extends Model
{
    protected $fillable = [
        'clinical_admin_id',
        'address',
        'google_map_link',
        'phone',
        'emergency_contact',
    ];
}
