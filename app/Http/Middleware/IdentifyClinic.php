<?php

namespace App\Http\Middleware;

use App\Models\ClinicalAdmin;
use App\Models\ClinicSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyClinic
{
  public function handle(Request $request, Closure $next): Response
  {
      $host = $request->getHost();

      $baseDomain = config('app.clinic_domain');

      /*
      |--------------------------------------------------------------------------
      | Main Domain
      |--------------------------------------------------------------------------
      */

      if (
          $host === $baseDomain ||
          $host === 'www.' . $baseDomain
      ) {
          return $next($request);
      }

      /*
      |--------------------------------------------------------------------------
      | Get Subdomain
      |--------------------------------------------------------------------------
      |
      | matoshree.myclinx.test
      |         ↓
      |      matoshree
      |
      */

      $subdomain = str_replace(
          '.' . $baseDomain,
          '',
          $host
      );

      /*
      |--------------------------------------------------------------------------
      | Find Clinic Setting
      |--------------------------------------------------------------------------
      */

      $clinicSetting = ClinicSetting::where(
          'logo_name',
          $subdomain
      )->first();

      /*
      |--------------------------------------------------------------------------
      | Clinic Setting Not Found
      |--------------------------------------------------------------------------
      */

      if (!$clinicSetting) {
          abort(404, 'Clinic not found.');
      }

      /*
      |--------------------------------------------------------------------------
      | Find Clinical Admin
      |--------------------------------------------------------------------------
      */

      $clinic = ClinicalAdmin::find(
          $clinicSetting->clinical_admin_id
      );

      if (!$clinic) {
          abort(404, 'Clinic admin not found.');
      }

      /*
      |--------------------------------------------------------------------------
      | Store Current Clinic
      |--------------------------------------------------------------------------
      */

      app()->instance(
          'currentClinic',
          $clinic
      );

      app()->instance(
          'currentClinicSetting',
          $clinicSetting
      );

      return $next($request);
  }
}