<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\ClinicalAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\DoctorSchedule;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreDoctorRequest;
use  App\Http\Requests\UpdateDoctorRequest;
use Carbon\Carbon;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
      $clinics = ClinicalAdmin::all();
      $query = Doctor::with(['clinic', 'schedules']);
      // Clinical Admin ko sirf apne clinic ke doctors dikhaye
      if (auth()->user()->role == 'clinic_admin') {
        $query->where('clinical_admin_id', auth()->user()->clinical_admin_id);
      }
      $query->where(function ($q) use ($request) {

        if ($request->filled('doctor_name')) 
        { 
          $q->orWhere('doctor_name', 'like', '%' . trim($request->doctor_name) . '%');
        }
        // Super Admin hi clinic wise search karega
        if (auth()->user()->role == 'super_admin' && $request->filled('clinical_admin_id')) {
            $q->where('clinical_admin_id', $request->clinical_admin_id);
        }
        if ($request->filled('specialization')) {
            $q->orWhere('specialization',
                $request->specialization);
        }
      });
      $doctors = Doctor::with('clinic')
        ->withCount([
            'appointments as total_patients_checked' => function ($query) {
                $query->where('status', 'completed');
            },

            'appointments as today_patients_checked' => function ($query) {
                $query->where('status', 'completed')
                    ->whereDate('appointment_date', today());
            },
        ])
        ->get();

      $doctors = $query->latest()->paginate(5)->withQueryString();

      


      foreach ($doctors as $doctor) {
        $doctor->scheduleMap = $doctor->schedules->keyBy('day');
      }
      // Dropdown ke liye specialization list
      $specializations = Doctor::distinct()->pluck('specialization');
      if (auth()->user()->role == 'clinic_admin') {
        $clinicalAdminId = auth()->user()->clinical_admin_id;
        $totalDoctors = Doctor::where('clinical_admin_id', $clinicalAdminId)->count();
        $availableDoctors = Doctor::where('clinical_admin_id', $clinicalAdminId)
            ->where('status', 1)
            ->count();
        $unavailableDoctors = Doctor::where('clinical_admin_id', $clinicalAdminId)
            ->where('status', 0)
            ->count();
      }
      else{
        $totalDoctors = Doctor::count();
        $availableDoctors = Doctor::where('status', 1)->count();
        $unavailableDoctors = Doctor::where('status', 0)->count();
      }

      
      return view(
          'doctors.index',
          compact(
              'clinics',
              'doctors',
              'specializations',
              'totalDoctors',
              'availableDoctors',
              'unavailableDoctors',
              
          )
      );
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
     * StoreDoctorRequest  isase validations a rhe hai
     */
    public function store(StoreDoctorRequest $request)
    {

      $photo = null;
      if ($request->hasFile('profile_photo')) {
        $photo = $request->file('profile_photo')
                            ->store('doctor_profiles', 'public');
      }

      DB::beginTransaction();
         
      try {
        $doctor = Doctor::create([
            'clinical_admin_id' => $request->clinical_admin_id,
            'doctor_name' => $request->doctor_name,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'specialization' => $request->specialization,
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'consultation_fee' => $request->consultation_fee,
            'status' => $request->status,
            'address' => $request->address,
            'profile_photo' => $photo
        ]);
        foreach ($request->schedules as $schedule) {

            $doctor->schedules()->create([
                'day' => $schedule['day'],
                'is_off' => $schedule['is_off'] ?? 0,
                'morning_start' => $schedule['morning_start'] ?? null,
                'morning_end' => $schedule['morning_end'] ?? null,
                'evening_start' => $schedule['evening_start'] ?? null,
                'evening_end' => $schedule['evening_end'] ?? null,
                'general_start' => $schedule['general_start'] ?? null,
                'general_end' => $schedule['general_end'] ?? null
            ]);
        }
        DB::commit();
        return redirect()->back()
            ->with('success', 'Doctor added successfully.');
        } catch (\Exception $e) {

        DB::rollBack();
           dd($e->getMessage());
        return redirect()->back()
            ->withInput()
            ->with('error', $e->getMessage());
      }
    }

    public function  toggleStatus($id)
    {
      // print_r($id);
      // die;
      $doctor = Doctor::findOrFail($id);

      $doctor->status = $doctor->status == 0 ? 1 : 0;
      $doctor->save();

      // return response()->json([
      //     'success' => true,
      //     'status'  => $clinic->status
      // ]);
      return response()->json([
        'status' => $doctor->status
    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $doctor = Doctor::with('schedules')->findOrFail($id);

        $clinics = ClinicalAdmin::all();

        $schedules = $doctor->schedules->keyBy('day');

        return view(
            'doctors.edit',
            compact('doctor', 'clinics', 'schedules')
        );
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateDoctorRequest $request, $id)
    {
      $doctor = Doctor::findOrFail($id);
      
      DB::beginTransaction();

      try {
        $doctor = Doctor::findOrFail($id);
        if ($request->hasFile('profile_photo')) {
          if ($doctor->profile_photo) {
            Storage::disk('public')->delete($doctor->profile_photo);
          }
          $photo = $request->file('profile_photo')->store('doctor_profiles', 'public');
          } else
          {
            $photo = $doctor->profile_photo;
          }
        
        $doctor->update([
            'doctor_name'      => $request->doctor_name,
            'mobile_number'    => $request->mobile_number,
            'email'            => $request->email,
            'gender'           => $request->gender,
            'dob'    => $request->dob,
            'specialization'   => $request->specialization,
            'qualification'    => $request->qualification,
            'experience'       => $request->experience,
            'consultation_fee' => $request->consultation_fee,
            'status'           => $request->status,
            'address'          => $request->address,
            'profile_photo'    => $photo,
        ]);

        foreach ($request->schedules as $schedule) {

          DoctorSchedule::updateOrCreate(
              [
                  'doctor_id' => $doctor->id,
                  'day' => $schedule['day'],
              ],
              [
                  'morning_start' => $schedule['morning_start'] ?? null,
                  'morning_end'   => $schedule['morning_end'] ?? null,
                  'evening_start' => $schedule['evening_start'] ?? null,
                  'evening_end'   => $schedule['evening_end'] ?? null,
                  'is_off'        => $schedule['is_off'] ?? 0,
              ]
          );
        }

        DB::commit();

        return redirect()->back()
            ->with('success', 'Doctor updated successfully.');

      } catch (\Exception $e) {

          DB::rollBack();
          dd($e->getMessage());
          return redirect()->back()
              ->with('error', $e->getMessage());
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        //
    }

public function schedule(Request $request, Doctor $doctor)
{
    try {

        $date = $request->date;

        $day = Carbon::parse($date)->format('l');

        $schedule = $doctor->schedules()
            ->where('day', $day)
            ->first();

        if (!$schedule || $schedule->is_off) {

            return response()->json([
                'success' => true,
                'shifts' => []
            ]);
        }

        $shifts = [];


        // Morning
        if ($schedule->morning_start && $schedule->morning_end) {

            $shifts[] = [
                'name' => 'Morning',
                'start' => date(
                    'h:i A',
                    strtotime($schedule->morning_start)
                ),
                'end' => date(
                    'h:i A',
                    strtotime($schedule->morning_end)
                ),
            ];
        }


        // Evening
        if ($schedule->evening_start && $schedule->evening_end) {

            $shifts[] = [
                'name' => 'Evening',
                'start' => date(
                    'h:i A',
                    strtotime($schedule->evening_start)
                ),
                'end' => date(
                    'h:i A',
                    strtotime($schedule->evening_end)
                ),
            ];
        }


        // General
        if ($schedule->general_start && $schedule->general_end) {

            $shifts[] = [
                'name' => 'General',
                'start' => date(
                    'h:i A',
                    strtotime($schedule->general_start)
                ),
                'end' => date(
                    'h:i A',
                    strtotime($schedule->general_end)
                ),
            ];
        }


        return response()->json([
            'success' => true,
            'shifts' => $shifts
        ]);


    } catch (\Exception $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ], 500);
    }
}
}
