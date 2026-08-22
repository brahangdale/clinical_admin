<?php

namespace App\Http\Controllers\ClinicalAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClinicalDashboardController extends Controller
{
	public function index(){
		$clinicId = Auth::user()->clinical_admin_id;
    $currentTokens = Appointment::with(['patient', 'doctor'])
    ->where('clinical_admin_id', $clinicId)
    ->whereDate('appointment_date', today())
    ->where('status', 'in_consultation')
    ->orderBy('doctor_id')
    ->orderBy('id', 'asc')
    ->get()
    ->unique('doctor_id')
    ->values();
        // print_r($currentTokens->toArray());
        // die;
		// Today's Appointments
		$todayAppointments = Appointment::where('clinical_admin_id', $clinicId)
				->whereDate('appointment_date', today())->where('status', 'pending')
				->count();
		// Completed Today
		$completedToday = Appointment::where('clinical_admin_id', $clinicId)
				->whereDate('appointment_date', today())
				->where('status', 'completed')
				->count();
    // print_r($completedToday);
    // die;
		// Birthday Today
		$birthdayToday = Patient::where('clinical_admin_id', $clinicId)
				->whereMonth('date_of_birth', Carbon::today()->month)
				->whereDay('date_of_birth', Carbon::today()->day)
				->count();
		$futureAppointments = Appointment::where('clinical_admin_id', $clinicId)
    		->whereDate('appointment_date', '>', today())
    		->count();
    $follow_ups = Appointment::where('clinical_admin_id', $clinicId)
    		->whereDate('follow_up_date', '>', today())
    		->count();
		return view('clinical_admins.dashboard.clinic_dashboard', compact('todayAppointments', 'completedToday', 
		'birthdayToday', 'futureAppointments', 'currentTokens', 'follow_ups'));
	}

  public function today_appointments(){
    $clinicId = Auth::user()->clinical_admin_id;

    $todayQueue = Appointment::with('patient')
        ->where('clinical_admin_id', $clinicId)
        ->whereDate('appointment_date', today())->whereIn('status', ['pending', 'in_consultation'])
        ->orderBy('token_number')
        ->paginate(10);
    return view('clinical_admins.dashboard.today_appointments', compact('todayQueue'));
  }

  public function completed_today(){
    $clinicId = Auth::user()->clinical_admin_id;
    $completedToday = Appointment::where('clinical_admin_id', $clinicId)
				->whereDate('appointment_date', today())
				->where('status', 'completed')->paginate(10);
    return view('clinical_admins.dashboard.completed_today_appointments',compact('completedToday'));
  }
  public function todays_birthday(){
    $clinicId = Auth::user()->clinical_admin_id;
    $birthdayToday = Patient::where('clinical_admin_id', $clinicId)
				->whereMonth('date_of_birth', Carbon::today()->month)
				->whereDay('date_of_birth', Carbon::today()->day)->get();
    return view('clinical_admins.dashboard.todays_birthday', compact('birthdayToday'));
  }

  public function future_appointments( ){
    $clinicId = Auth::user()->clinical_admin_id;
    $futureAppointments = Appointment::where('clinical_admin_id', $clinicId)
    		->whereDate('appointment_date', '>', today())->paginate(10);
        
    return view('clinical_admins.dashboard.future_appointments', compact('futureAppointments'));
  }

  public function follow_up( ){
    $clinicId = Auth::user()->clinical_admin_id;
    $follow_up = Appointment::where('clinical_admin_id', $clinicId)
    		->whereDate('follow_up_date', '>', today())->paginate(10);
        
    return view('clinical_admins.dashboard.follow_up', compact('follow_up'));
  }

  public function skipToken(Appointment $appointment)
  {
    Log::info('SKIP TOKEN CALLED', [
        'appointment_id' => $appointment->id,
        'doctor_id' => $appointment->doctor_id,
        'clinical_admin_id' => $appointment->clinical_admin_id,
    ]);

    DB::beginTransaction();

    try {

        $doctorId = $appointment->doctor_id;
        $clinicId = $appointment->clinical_admin_id;

        // Current patient ko pending karo
        $appointment->update([
            'status' => 'pending',
        ]);

        // Same doctor ka next pending patient
        $nextAppointment = Appointment::with(['patient', 'doctor'])
        ->where('doctor_id', $doctorId)
        ->where('clinical_admin_id', $clinicId)
        ->whereDate('appointment_date', today())
        ->where('status', 'pending')
        ->where('id', '!=', $appointment->id)
        ->orderBy('id', 'asc')
        ->first();

        Log::info('NEXT APPOINTMENT', [
            'next_appointment' => $nextAppointment?->id,
            'doctor_id' => $doctorId,
            'clinic_id' => $clinicId,
        ]);

        // Next patient ko consultation me lao
        if ($nextAppointment) {
            $nextAppointment->update([
                'status' => 'in_consultation',
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,

            'doctor_id' => $doctorId,

            'doctor_name' => $appointment->doctor->doctor_name,

            'nextAppointment' => $nextAppointment ? [
                'id' => $nextAppointment->id,
                'token_number' => $nextAppointment->token_number,
                'patient_name' => $nextAppointment->patient->patient_name,
                'doctor_name' => $nextAppointment->doctor->doctor_name,

                'skip_url' => route(
                    'clinical_admins.appointment.skip',
                    $nextAppointment->id
                ),

                'complete_url' => route(
                    'clinical_admins.appointment.complete',
                    $nextAppointment->id
                ),
            ] : null,
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}


public function completeToken(Appointment $appointment)
{
    
    DB::beginTransaction();

    try {

        $doctorId = $appointment->doctor_id;
        $clinicId = $appointment->clinical_admin_id;

        // Current patient completed
        $appointment->update([
            'status' => 'completed',
        ]);
        
       $pendingAppointments = Appointment::where('doctor_id', $doctorId)
        ->where('clinical_admin_id', $clinicId)
        ->whereDate('appointment_date', today())
        ->where('status', 'pending')
        ->get();

       
        $nextAppointment = $pendingAppointments->first();

       
        if ($nextAppointment) {

            $nextAppointment->update([
                'status' => 'in_consultation',
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,

            'doctor_id' => $doctorId,

            'doctor_name' => $appointment->doctor->doctor_name,

            'nextAppointment' => $nextAppointment ? [
                'id' => $nextAppointment->id,
                'token_number' => $nextAppointment->token_number,
                'patient_name' => $nextAppointment->patient->patient_name,
                'doctor_name' => $nextAppointment->doctor->doctor_name,

                'skip_url' => route(
                    'clinical_admins.appointment.skip',
                    $nextAppointment->id
                ),

                'complete_url' => route(
                    'clinical_admins.appointment.complete',
                    $nextAppointment->id
                ),
            ] : null,
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

public function add_appointment(){
    $clinicId = auth()->user()->clinical_admin_id;
    $doctors = Doctor::where('clinical_admin_id', $clinicId)->get();
    return view('clinical_admins.dashboard.add_appointment', compact('doctors'));
  }



}
