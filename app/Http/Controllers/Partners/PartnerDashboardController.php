<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ClinicalAdmin;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PartnerDashboardController extends Controller
{
  public function index()
{
    $partner_id = auth()->user()->partner_id;

    $partner_clinic = ClinicalAdmin::with('user')
        ->where('partner_id', $partner_id)
        ->get();

    foreach ($partner_clinic as $clinic) {

        // Today's appointments
        $todayAppointments = Appointment::where(
            'clinical_admin_id',
            $clinic->id
        )
        ->whereDate('appointment_date', today())
        ->get();

        // Total today's appointments
        $clinic->today_appointments =
            $todayAppointments->count();

        // Today's completed appointments
        $clinic->completed_appointments =
            $todayAppointments
                ->where('status', 'completed')
                ->count();

        // Today's unique patients
        $clinic->today_patients =
            $todayAppointments
                ->pluck('patient_id')
                ->filter()
                ->unique()
                ->count();
        // Today's Revenue
        $clinic->today_revenue =
          $todayAppointments->sum('appointment_fee');


        // Partner Payment - 10%
        $clinic->partner_payment =
        $clinic->today_revenue * 0.10;
    }

    return view(
        'partners.partner_dashboard',
        compact('partner_clinic')
    );
}

  public function store_clinic(Request $request){
      // print_r(auth()->user()->toArray());
      // print_r($request->all());
      // die;
      $request->validate([
      'clinic_name' => 'required',
      'mobile_number'      => 'required | digits:10',
      'user_name' => 'required',
      'email'       => 'required|email|unique:users,email',
    ]);



      $clinicName = $request->clinic_name;
      $mobile = $request->mobile_number;
      // First 4 letters
      $firstFour = substr(preg_replace('/\s+/', '', $clinicName), 0, 4);
      // Last 4 digits of mobile
      $lastFour = substr($mobile, -4);
      // Generate password
      $password = ucfirst($firstFour) . '@' . $lastFour;
      $partner_id = auth()->user()->partner_id;
      DB::beginTransaction();
      try {
        // Create Clinic First
        $clinic = ClinicalAdmin::create([
          'clinic_name' => $request->clinic_name,
          'mobile_number'  => $request->mobile_number,
          'city'        => $request->city,
          'state'       => $request->state,
          'address'     => $request->address,
          'partner_id' =>  $partner_id
        ]);
        // dd($clinic->id);
        // Create User
        $user = User::create([
          'clinical_admin_id' => $clinic->id,
          'user_name'      => $request->user_name,
          'email'     => $request->email,
          'password'  => Hash::make($password),
          'status'    => $request->status ,
          'role'   => 'clinic_admin' 
        ]);

        DB::commit();

        return redirect()
          ->route('partners.partner_dashboard')
          ->with('success', true)
          ->with('username', $user->email)
          ->with('password', $password);

      } catch (\Exception $e) {

        DB::rollBack();

        // return back()->withErrors([
        //     'error' => $e->getMessage()
        // ]);
        dd($e->getMessage());
    }
  }

public function clinicPerformance(Request $request)
{
  // print_r($request->all());
  // die;
  // dd($request->all());
    $request->validate([
        'clinic_id' => 'required|integer',
        'from_date' => 'required|date',
        'to_date'   => 'required|date|after_or_equal:from_date',
    ]);

    $clinic = ClinicalAdmin::findOrFail($request->clinic_id);

    $appointments = Appointment::where(
        'clinical_admin_id',
        $clinic->id
    )
    ->whereBetween('appointment_date', [
        $request->from_date,
        $request->to_date
    ])
    ->get();

    // Total appointments
    $totalAppointments = $appointments->count();

    // Completed appointments
    $completedPatients = $appointments
        ->where('status', 'completed')
        ->count();

    // Unique patients
    $totalPatients = $appointments
        ->pluck('patient_id')
        ->filter()
        ->unique()
        ->count();
        // print_r($request->clinic_id);
        // print_r($totalPatients);
        // die;

    // Total revenue
    $totalRevenue = $appointments->sum('consultation_fee');

    // Partner gets 10%
    $partnerPayment = $totalRevenue * 0.10;

    return response()->json([
        'success' => true,

        'total_patients' => $totalPatients,

        'completed_patients' => $completedPatients,

        'total_appointments' => $totalAppointments,

        'total_revenue' => $totalRevenue,

        'partner_payment' => $partnerPayment,
    ]);
}
}
