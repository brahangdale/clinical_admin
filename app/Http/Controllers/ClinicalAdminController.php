<?php

// namespace App\Http\Controllers\SuperAdmin;
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\ClinicalAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class ClinicalAdminController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    // $clinical_admins =  ClinicalAdmin::with('user')->get();
    $clinical_admins = ClinicalAdmin::with('user')
    ->withCount(['doctors','appointments',])
    ->when($request->search, function ($query) use ($request) {
      $query->where('clinic_name','like','%' . $request->search . '%');
    })->latest()->paginate(5)->withQueryString();
    // Unique Patients count clinic-wise
    foreach ($clinical_admins as $clinic) {

      $clinic->patients_count = Appointment::where(
          'clinical_admin_id',
          $clinic->id
      )
      ->whereNotNull('patient_id')
      ->distinct('patient_id')
      ->count('patient_id');
    }
    $total_clinics = ClinicalAdmin::count();
    $inactive_clinics = User::where('role', 'clinic_admin')
                    ->where('status', 0)
                    ->count();

    $active_clinics = User::where('role', 'clinic_admin')
                      ->where('status', 1)
                      ->count();

    if(auth()->user()->role == 'clinic_admin'){
      $clinicId = auth()->user()->clinical_admin_id;
      $current_clinic = ClinicalAdmin::find($clinicId);
    }
    else{
      $current_clinic = null ;
    }                
    $clinics = compact('clinical_admins','total_clinics','active_clinics', 'inactive_clinics', 'current_clinic');
    return view('clinical_admins.index')->with($clinics);
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
    // print_r($request->all());
    // die;
    $request->validate([
      'clinic_name' => 'required',
      'mobile_number'      => 'required | digits:10',
      'user_name' => 'required|string|min:6|max:20',
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
      DB::beginTransaction();
      try {
        // Create Clinic First
        $clinic = ClinicalAdmin::create([
          'clinic_name' => $request->clinic_name,
          'mobile_number'  => $request->mobile_number,
          'city'        => $request->city,
          'state'       => $request->state,
          'address'     => $request->address,
        ]);
        // Create User
        $user = User::create([
          'clinical_admin_id' => $clinic->id,
          'user_name'      => $request->user_name,
          'email'     => $request->email,
          'password'  => Hash::make($password),
          // Super Admin ke liye encrypted copy
          'visible_password' => Crypt::encryptString($password),
          'status'    => $request->status ,
          'role'   => 'clinic_admin' 
        ]);

        DB::commit();

        return redirect()
          ->route('clinical_admins.index')
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


  public function  toggleStatus($id)
  {
    // print_r($id);
    // die;
    $clinic = ClinicalAdmin::findOrFail($id);
    $user = $clinic->user();
    // print_r($clinic->user);
    $clinic->user->status = $clinic->user?->status == 0 ? 1 : 0;
    $clinic->user->save();
    
    return response()->json([
      'status' => $clinic->user->status
    ]);
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
  public function update(Request $request, string $id)
  {
    $clinic = ClinicalAdmin::findOrFail($id);
      $request->validate([
      'clinic_name'   => 'required|string|max:255',
      'user_name'     => 'required|string|min:6|max:20',
      'mobile_number' => 'required|digits:10',
      'city'          => 'required|string|max:100',
      'state'         => 'required|string|max:100',
      'address'       => 'required|string|max:500',

      'email' => [
          'required',
          'email',
          Rule::unique('users', 'email')->ignore($clinic->user->id),
      ],

      'status' => 'required|in:0,1',
    ]);
    $clinic->update([
        'clinic_name'   => $request->clinic_name,
        'mobile_number' => $request->mobile_number,
        'city'          => $request->city,
        'state'         => $request->state,
        'address'       => $request->address,
    ]);

    if ($clinic->user) {

        $clinic->user->update([
            'user_name' => $request->user_name,
            'email'     => $request->email,
            'status'    => $request->status,
        ]);
    }

    return redirect()
        ->route('clinical_admins.index')
        ->with('Clinic updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
      //
  }
}
