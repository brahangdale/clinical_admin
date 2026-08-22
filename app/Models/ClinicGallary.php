<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicGallary extends Model
{
    protected $fillable = [
        'clinical_admin_id',
        'image'
    ];
}
