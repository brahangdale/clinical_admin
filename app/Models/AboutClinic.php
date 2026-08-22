<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutClinic extends Model
{
     protected $fillable = [
        'clinical_admin_id',
        'logo',
        'name',
        'tagline',
        'about_clinic',
        'experience'

     ];
}
