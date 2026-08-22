<?php

namespace App\Http\Controllers;

use App\Models\AboutClinic;
use App\Models\Appointment;
use App\Models\ClinicalAdmin;
use App\Models\ClinicContact;
use App\Models\ClinicGallary;
use App\Models\ClinicTiming;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\PatientVital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicWebsiteController extends Controller
{
  public function home(){
    $clinic = app('currentClinic');
    // print_r($clinic->toArray());
    // die;
    $clinic_setting = app('currentClinicSetting');
    $clinic_gallary = ClinicGallary::where('clinical_admin_id', $clinic->id)->get();
    $clinic_timings = ClinicTiming::where('clinical_admin_id', $clinic->id)->get();
    return view('patient_site.home', compact('clinic', 'clinic_setting', 'clinic_gallary', 'clinic_timings'));
  }

  public function about(){
    $clinic = app('currentClinic');
    $clinic_about = AboutClinic::where('clinical_admin_id', $clinic->id)->first();
    return view('patient_site.about', compact('clinic_about') );
  }
  public function location(){
    $clinic = app('currentClinic');
    $location = ClinicContact::where('clinical_admin_id', $clinic->id)->first();
    return view('patient_site.location', compact('location'));
    
  }
  public function games(){
    return view('patient_site.games');
  }
  public function memory_game(){
     return view('patient_site.memory_game');
  }
  public function number_game(){
     return view('patient_site.number_game');
  }
  public function math_plane_game(){
     return view('patient_site.math_plane_game');
  }

  public function token_page(){
    $clinic = app('currentClinic');
    $doctors = Doctor::where('clinical_admin_id', $clinic->id)->get();
    return view('patient_site.token_page', compact('doctors'));
  }
  public function check_token($doctor){
    // print_r($doctor);
    // die;
    $clinic = app('currentClinic');
    $current_doctor = Doctor::findOrFail($doctor);
    $currentToken = Appointment::with(['patient', 'doctor'])
        ->where('clinical_admin_id', $clinic->id)
        ->where('doctor_id', $doctor)
        ->whereDate('appointment_date', today())
        ->where('status', 'in_consultation')
        ->orderBy('id', 'asc')
        ->first();
  // print_r($currentToken);
  // die;
    return view('patient_site.check_token', compact('currentToken', 'current_doctor'));
  }

  public function appointment(Request $request){
    $clinic = app('currentClinic');
    $doctors = Doctor::where('clinical_admin_id', $clinic->id)->get();
    return view('patient_site.appointment', compact('doctors', 'clinic'));
  }

  public function create_appointment(Request $request)
  {
    $clinic = app('currentClinic');
    $lastToken = Appointment::where('doctor_id', $request->doctor_id)
    ->whereDate('appointment_date', $request->appointment_date)
    ->selectRaw("MAX(CAST(REPLACE(token_number, 'TK-', '') AS UNSIGNED)) as max_token")
    ->value('max_token');

    if ($lastToken) {
      $nextNumber = $lastToken + 1;
    } else {
      $nextNumber = 1;
    }
    $tokenNumber = 'TK-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    $request->validate([
      // patient validation
      'patient_name' => 'required',
      'mobile_number'=> 'required',
      // 'clinical_admin_id'=> 'required',
      'doctor_id'=> 'required',
      'appointment_date'=>'required',
      // 'appointment_time'=>'required'
    ]);
    DB::beginTransaction();
    try {

      $patient = Patient::where('clinical_admin_id', $clinic->id)
      ->where('mobile_number', $request->mobile_number)
      ->where('patient_name', $request->patient_name)
      ->first();
      if(!$patient){
        $patient = Patient::create([
          'patient_id'        => $this->generatePatientId($clinic->id),
          'clinical_admin_id' => $clinic->id,
          'doctor_id' => $request->doctor_id,
          'patient_name'      => $request->patient_name,
          'mobile_number'     => $request->mobile_number,
          'age'               => $request->age,
          'date_of_birth'     => $request->date_of_birth,
          'gender'            => $request->gender,
          // 'height'            => $request->height,
          'address'           => $request->address,
        ]);
      }
      // Create Appointment
      $appointment = Appointment::create([
          'patient_id'        => $patient->id,
          'clinical_admin_id' => $clinic->id,
          'doctor_id'         => $request->doctor_id,
          'appointment_date'  => $request->appointment_date,
          'shift_name'  => $request->shift_name,
          'shift_time'  => $request->shift_time,
          'appointment_time'  => $request->appointment_time,
          // 'status'            => 'scheduled',
          'token_number' => $tokenNumber
      ]);
      PatientVital::create([
        'patient_id'     => $patient->id,
        'appointment_id' => $appointment->id,
      ]);
      DB::commit();
      return redirect('/')->with('success', 'Appointment booked successfully.');

    } catch (\Exception $e) {
    DB::rollBack();
      dd($e->getMessage());
    return redirect()
        ->back()
        ->with('error', $e->getMessage());
    } 
  }
  private function generatePatientId($clinicalAdminId)
  {
    $clinic = ClinicalAdmin::findOrFail($clinicalAdminId);

    // Clinic name ke first 3 letters
    $prefix = strtoupper(substr($clinic->clinic_name, 0, 3));

    // Is clinic ka last patient
    $lastPatient = Patient::where('clinical_admin_id', $clinicalAdminId)
        ->orderByDesc('id')
        ->first();

    if ($lastPatient) {
        $lastNumber = (int) substr($lastPatient->patient_id, 3);
        $number = $lastNumber + 1;
    } else {
        $number = 1;
    }

    return $prefix . str_pad($number, 2, '0', STR_PAD_LEFT);
  }
}
