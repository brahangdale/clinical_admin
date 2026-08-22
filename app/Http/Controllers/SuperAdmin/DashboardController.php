<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ClinicalAdmin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
  public function index(){
      if (auth()->check()) {
        $clinics = ClinicalAdmin::with('user')->latest()->take(5)->get();
          $total_clinics = ClinicalAdmin::count();
          $active_clinics = User::where('role', 'clinic_admin')->where('status', 1)->count();
          $total_patients = Patient::count();
          $total_appointments = Appointment::count();
          return view('superadmin.dashboard', compact('clinics','total_clinics','active_clinics','total_patients','total_appointments'));
      }
      return view('auth.login');
  }

  // public function reports(){
  //   // top clinc
  //   $topClinics = ClinicalAdmin::withCount([
  //       'doctors',
  //       'patients',
  //       'appointments',
  //       'appointments as completed_appointments_count' => function ($query) {
  //           $query->where('status', 'Completed');
  //       }
  //   ])
  //   ->orderByDesc('appointments_count') // Sabse jyada appointments wala clinic upar
  //   ->take(5)
  //   ->get();

  //   // Top doctors
  //   $topDoctors = Doctor::with('clinic')
  //   ->withCount([
  //       'patients',
  //       'appointments'
  //   ])
  //   ->orderByDesc('appointments_count')
  //   ->take(5)
  //   ->get();
    
  //   // total counts
  //   $totalAppointments = Appointment::count();
  //   $totalPatients = Patient::count();
  //   $totalDoctors = Doctor::count();
  //   $totalCancelled = Appointment::where('status', 'Cancelled')->count();
    
  //   // monthly chart
  //   $appointments = Appointment::select(
  //     DB::raw('MONTH(appointment_date) as month'),
  //     DB::raw('COUNT(*) as total')
  //   )
  //     ->whereYear('appointment_date', date('Y')) // Current year
  //     ->groupBy(DB::raw('MONTH(appointment_date)'))
  //     ->orderBy(DB::raw('MONTH(appointment_date)'))
  //     ->get();

  //   $months = [];
  //   $counts = [];

  //   for ($i = 1; $i <= 12; $i++) {
  //     $months[] = date('M', mktime(0, 0, 0, $i, 1));
  //     $record = $appointments->firstWhere('month', $i);
  //     $counts[] = $record ? $record->total : 0;
  //   }
  //   // Status Chart
  //   $completed = Appointment::where('status', 'Completed')->count();
  //   $pending = Appointment::where('status', 'Pending')->count();
  //   $cancelled = Appointment::where('status', 'Cancelled')->count();

  //   return view('superadmin.report', compact(
  //       'months',
  //       'counts',
  //       'completed',
  //       'pending',
  //       'cancelled',
  //       'totalAppointments',
  //       'totalPatients',
  //       'totalDoctors',
  //       'totalCancelled',
  //       'topClinics',
  //       'topDoctors'
  //   ));

  //   // return view('superadmin.report', compact('months', 'counts'));
  // }
  public function reports()
  {
    if (auth()->user()->role == 'super_admin') {
      // Super Admin - All Data

      $topClinics = ClinicalAdmin::withCount([
          'doctors',
          'patients',
          'appointments',
          'appointments as completed_appointments_count' => function ($q) {
              $q->where('status', 'Completed');
          }
      ])
      ->orderByDesc('appointments_count')
      ->take(5)
      ->get();

      $topDoctors = Doctor::with('clinic')
        ->withCount(['patients', 'appointments'])
        ->orderByDesc('appointments_count')
        ->take(5)
        ->get();

      $totalAppointments = Appointment::count();
      $totalPatients = Patient::count();
      $totalDoctors = Doctor::count();
      $totalCancelled = Appointment::where('status', 'Cancelled')->count();

      $appointments = Appointment::select(
          DB::raw('MONTH(appointment_date) as month'),
          DB::raw('COUNT(*) as total')
      )
      ->whereYear('appointment_date', date('Y'))
      ->groupBy(DB::raw('MONTH(appointment_date)'))
      ->get();

      $completed = Appointment::where('status', 'Completed')->count();
      $pending = Appointment::where('status', 'Pending')->count();
      $cancelled = Appointment::where('status', 'Cancelled')->count();

    } else {

        // Clinical Admin - Own Clinic Data

      $clinicId = auth()->user()->clinical_admin_id;

      $topClinics = ClinicalAdmin::where('id', $clinicId)
          ->withCount([
              'doctors',
              'patients',
              'appointments',
              'appointments as completed_appointments_count' => function ($q) {
                  $q->where('status', 'Completed');
              }
          ])
          ->get();

      $topDoctors = Doctor::where('clinical_admin_id', $clinicId)
          ->withCount(['patients', 'appointments'])
          ->orderByDesc('appointments_count')
          ->take(5)
          ->get();

      $totalAppointments = Appointment::where('clinical_admin_id', $clinicId)->count();

      $totalPatients = Patient::where('clinical_admin_id', $clinicId)->count();

      $totalDoctors = Doctor::where('clinical_admin_id', $clinicId)->count();

      $totalCancelled = Appointment::where('clinical_admin_id', $clinicId)
          ->where('status', 'Cancelled')
          ->count();

      $appointments = Appointment::select(
          DB::raw('MONTH(appointment_date) as month'),
          DB::raw('COUNT(*) as total')
      )
      ->where('clinical_admin_id', $clinicId)
      ->whereYear('appointment_date', date('Y'))
      ->groupBy(DB::raw('MONTH(appointment_date)'))
      ->get();

      $completed = Appointment::where('clinical_admin_id', $clinicId)
          ->where('status', 'Completed')
          ->count();

      $pending = Appointment::where('clinical_admin_id', $clinicId)
          ->where('status', 'Pending')
          ->count();

      $cancelled = Appointment::where('clinical_admin_id', $clinicId)
          ->where('status', 'Cancelled')
          ->count();
    }

    $months = [];
    $counts = [];

    for ($i = 1; $i <= 12; $i++) {
        $months[] = date('M', mktime(0, 0, 0, $i, 1));
        $record = $appointments->firstWhere('month', $i);
        $counts[] = $record ? $record->total : 0;
    }

    return view('superadmin.report', compact(
      'months',
      'counts',
      'completed',
      'pending',
      'cancelled',
      'totalAppointments',
      'totalPatients',
      'totalDoctors',
      'totalCancelled',
      'topClinics',
      'topDoctors'
    ));
  }

  
}
