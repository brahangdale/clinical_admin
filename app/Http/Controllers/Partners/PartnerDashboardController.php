<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Models\ClinicalAdmin;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PartnerDashboardController extends Controller
{
    public function index(){
        $partner_id = auth()->user()->partner_id;
        $partners =ClinicalAdmin::with('user')
        ->where('partner_id', $partner_id)
        ->get();
        // print_r($partners);
        // die;
        return view('partners.partner_dashboard', compact('partners'));
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
}
