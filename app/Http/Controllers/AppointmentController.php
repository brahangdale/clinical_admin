<?php

namespace App\Http\Controllers;

use App\Models\PatientVital;
use Illuminate\Http\Request;
use App\Models\ClinicalAdmin;
use App\Models\Doctor;
use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateAppointmentRequest;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
      // dd(auth()->user()->role );
      if(auth()->user()->role == 'clinic_admin') {
         $clinicId = auth()->user()->clinical_admin_id;
        $todayAppointments = Appointment::where('clinical_admin_id', $clinicId)->whereDate('appointment_date', Carbon::today())->count();
        $pendingAppointments = Appointment::where('clinical_admin_id', $clinicId)->where('status', 'Pending')->count();
        $completedAppointments = Appointment::where('clinical_admin_id', $clinicId)->where('status', 'Completed')->count();
        $cancelledAppointments = Appointment::where('clinical_admin_id', $clinicId)->where('status', 'Cancelled')->count(); 
        $appointments = Appointment::where('clinical_admin_id', $clinicId)->with(['patient', 'doctor'])->orderBy('appointment_date')
          ->orderBy('id', 'asc'); //->latest()->get();
        $doctors = Doctor::where('clinical_admin_id', $clinicId)->get();
        }
      else{
        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $pendingAppointments = Appointment::where('status', 'Pending')->count();
        $completedAppointments = Appointment::where('status', 'Completed')->count();
        $cancelledAppointments = Appointment::where('status', 'Cancelled')->count(); 
        $appointments = Appointment::with(['patient', 'doctor'])->orderBy('appointment_date')
          ->orderBy('appointment_time'); //->latest()->get();
        $doctors = Doctor::all();
      }
      if (
        $request->filled('patient_name') ||
        $request->filled('doctor_id') ||
        $request->filled('appointment_date')
      ) 
      {

        $appointments->where(function ($query) use ($request) {

          // Patient Name
          if ($request->filled('patient_name')) {
              $query->orWhereHas('patient', function ($q) use ($request) {
                  $q->where('patient_name', 'like', '%' . $request->patient_name . '%');
              });
          }

          // Doctor
          if ($request->filled('doctor_id')) {
              $query->orWhere('doctor_id', $request->doctor_id);
          }

          // Appointment Date
          if ($request->filled('appointment_date')) {
              $query->orWhereDate('appointment_date', $request->appointment_date);
          }

        });
      }

    $appointments =  $appointments->paginate(10)->withQueryString();
      
    $clinics = ClinicalAdmin::all();
  
    return view('appointments.index', compact('appointments','clinics', 'doctors',
      'todayAppointments',
      'pendingAppointments',
      'completedAppointments',
      'cancelledAppointments'));
    }

    public function getDoctors($clinicId){
      $clinicId = $clinicId ? $clinicId : auth()->user()->clinical_admin_id;
      $doctors = Doctor::where('clinical_admin_id', $clinicId)
                    // ->where('status', 'active')
                    ->select('id', 'doctor_name')
                    ->get();

    return response()->json($doctors);
    }

    public function updateStatus(Request $request, Appointment $appointment)
      {
        // print_r($request->all());
        // die;
          // $request->validate([
          //     'id' => 'required|exists:appointments,id',
          //     'status' => 'required|in:Pending,Confirmed,Completed,Cancelled',
          // ]);

          // $appointment = Appointment::findOrFail($request->id);

          // $appointment->status = $request->status;
          // $appointment->save();
          $appointment->status = $request->status;
          $appointment->save();

          return response()->json([
              'success' => true,
              'message' => 'Status Updated Successfully'
          ]);
      }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
          'clinical_admin_id'=> 'required',
          'doctor_id'=> 'required',
          'appointment_date'=>'required',
          // 'appointment_time'=>'required'
        ]);
        DB::beginTransaction();
        try {

          $patient = Patient::where('clinical_admin_id', $request->clinical_admin_id)
          ->where('mobile_number', $request->mobile_number)
          ->where('patient_name', $request->patient_name)
          ->first();
          if(!$patient){
            $patient = Patient::create([
              'patient_id'        => $this->generatePatientId($request->clinical_admin_id),
              'clinical_admin_id' => $request->clinical_admin_id,
              'doctor_id' => $request->doctor_id,
              'patient_name'      => $request->patient_name,
              'mobile_number'     => $request->mobile_number,
              'age'               => $request->age,
              'date_of_birth'     => $request->date_of_birth,
              'gender'            => $request->gender,
              'height'            => $request->height,
              'address'           => $request->address,
            ]);
          }
          $doctor = Doctor::findOrFail($request->doctor_id);
          // Create Appointment
          $appointment = Appointment::create([
              'patient_id'        => $patient->id,
              'clinical_admin_id' => $request->clinical_admin_id,
              'doctor_id'         => $request->doctor_id,
              'appointment_date'  => $request->appointment_date,
              'shift_name'  => $request->shift_name,
              'shift_time'  => $request->shift_time,
              'appointment_time'  => $request->appointment_time,
              'token_number' => $tokenNumber,
              'consultation_fee' => $doctor->consultation_fee
          ]);
          PatientVital::create([
            'patient_id'     => $patient->id,
            'appointment_id' => $appointment->id,
          ]);
          DB::commit();
          // if ($request->redirect_to === 'appointment') {
          if ($request->redirect_to === 'appointment') {
            return redirect()->back()->with('success', 'Appointment booked successfully.');
          }

          if ($request->redirect_to === 'clinic_dashboard') {
              return redirect()
              ->route('clinical_admins.dashboard.clinic_dashboard')
              ->with('success', 'Patient created successfully.');
          }
          // return redirect()->back()->with('success', 'Appointment booked successfully.');

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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, string $id)
    {
      // print_r($request->all());
      // die;
      DB::beginTransaction();

      try {
        $appointment = Appointment::findOrFail($id);  
        $appointment->update([
          'appointment_date'=> $request->appointment_date,
          'appointment_time'=>  $request->appointment_time,
          'doctor_id'=> $appointment->doctor_id,
          'patient_id' => $appointment->patient_id,
          'shift_name' => $appointment->shift_name,
          'shift_time' => $appointment->shift_time,
          'date_of_birth' => $appointment->date_of_birth,
          'occupation' => $appointment->occupation,
          'clinical_admin_id'=> $request->clinical_admin_id,
          'status' => $request->status,
          'visit_type' =>$request->visit_type,
          'reffered_by'=> $request->reffered_by,
          'department'=> $request->department,
          'chief_complaint'=> $request->chief_complaint,
          'diagnosis'=> $request->diagnosis,
          'prescription'=> $request->prescription,
          'test_recommended'=> $request->test_recommended,
          'follow_up_date'=> $request->follow_up_date,
          'notes'=> $request->notes
        ]);

        $appointment->patient->update([
          'patient_name'=>$request->patient_name,
          'mobile_number'=> $request->mobile_number,
          'clinical_admin_id' => $request->clinical_admin_id,
          'doctor_id' => $request->doctor_id,
          'gender'=> $request->gender,
          'age'=> $request->age,
          'date_of_birth'=> $request->date_of_birth,
          'city'=> $request->city,
          'email'=> $request->email,
          'emergency_number'=> $request->emergency_number,
          'address'=> $request->address,
          // 'blood_group'=> $request->blood_group,
          // 'marital_status'=> $request->marital_status,
          'occupation'=> $request->occupation,
          // 'height'=>$request->height
        ]);

        $appointment->patientVital()->update([
          'height'      => $request->height,
          'weight'      => $request->weight,
          'bmi'         => $request->bmi,
          'bp'          => $request->bp,
          'pulse'       => $request->pulse,
          'temperature' => $request->temperature,
          'spo2'        => $request->spo2,
          'blood_sugar' => $request->blood_suger,
          'blood_group' => $request->blood_group,
          'allergies' => $request->allergies
        ]);

        DB::commit();
       

        return redirect()->back()
            ->with('success', 'Appointment updated successfully.');

      } catch (\Exception $e) {

        DB::rollBack();
        dd($e->getMessage());
        return redirect()->back()
            ->with('error', $e->getMessage());
      }
    }


    public function updateFees(Request $request, Appointment $appointment)
    {
      $request->validate([
          'consultation_fee' => 'required|numeric|min:0',
      ]);

      $appointment->update([
          'consultation_fee' => $request->consultation_fee,
      ]);

      return response()->json([
          'success' => true,
          'message' => 'Consultation fee updated successfully.',
      ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
