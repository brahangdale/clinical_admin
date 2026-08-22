<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicSetting extends Model
{
    protected $fillable = [
        'clinical_admin_id',
        'logo_name',
        'banner_title',
        'banner_description',
        'facebook_link',
        'instagram_link',
        'youtube_link',
        'gallary'
    ];
}
