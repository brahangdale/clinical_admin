<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      $partners = Partner::with('user')
      ->when($request->search, function ($query) use ($request) {
          $query->where(
              'clinic_name',
              'like',
              '%' . $request->search . '%'
          );
      })->latest()
      ->paginate(5)->withQueryString();

      $total_partners = Partner::count();
      $inactive_partners = User::where('role', 'sub_admin')
                      ->where('status', 0)
                      ->count();

      $active_partners = User::where('role', 'sub_admin')
                        ->where('status', 1)
                        ->count();

      // if(auth()->user()->role == 'clinic_admin'){
      //   $clinicId = auth()->user()->clinical_admin_id;
      //   $current_clinic = ClinicalAdmin::find($clinicId);
      // }
      // else{
      //   $current_clinic = null ;
      // }      

      return view('partners.index', compact('partners', 'active_partners', 'inactive_partners','total_partners'));
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
        'partner_name' => 'required',
        'mobile_number'      => 'required | digits:10',
        'user_name' => 'required',
        'email'       => 'required|email|unique:users,email',
      ]);

        $partnerName = $request->partner_name;
        $mobile = $request->mobile_number;
        // First 4 letters
        $firstFour = substr(preg_replace('/\s+/', '', $partnerName), 0, 4);
        // Last 4 digits of mobile
        $lastFour = substr($mobile, -4);
        // Generate password
        $password = ucfirst($firstFour) . '@' . $lastFour;
        DB::beginTransaction();
        try {
          // Create Clinic First
          $partner = Partner::create([
            'partner_name' => $request->partner_name,
            'mobile_number'  => $request->mobile_number,
            'city'        => $request->city,
            'state'       => $request->state,
            'address'     => $request->address,
          ]);
          // dd($clinic->id);
          // Create User
          $user = User::create([
            'partner_id' => $partner->id,
            'user_name'      => $request->user_name,
            'email'     => $request->email,
            'password'  => Hash::make($password),
            'status'    => $request->status ,
            'role'   => 'sub_admin' 
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
      $partner = Partner::findOrFail($id);
      $user = $partner->user();
      // print_r($clinic->user);
      $partner->user->status = $partner->user?->status == 0 ? 1 : 0;
      $partner->user->save();
      
      return response()->json([
        'status' => $partner->user->status
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
    // public function update(Request $request, string $id)
    // {
    //     //
    // }
    public function update(Request $request, string $id)
    {
      $partner = Partner::findOrFail($id);
        $request->validate([
        'partner_name'   => 'required|string|max:255',
        'user_name'     => 'required|string|max:255',
        'mobile_number' => 'required|digits:10',
        'city'          => 'required|string|max:100',
        'state'         => 'required|string|max:100',
        'address'       => 'required|string|max:500',

        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($partner->user->id),
        ],

        'status' => 'required|in:0,1',
      ]);
      $partner->update([
          'partner_name'   => $request->partner_name,
          'mobile_number' => $request->mobile_number,
          'city'          => $request->city,
          'state'         => $request->state,
          'address'       => $request->address,
      ]);

      if ($partner->user) {

          $partner->user->update([
              'user_name' => $request->user_name,
              'email'     => $request->email,
              'status'    => $request->status,
          ]);
      }

      return redirect()
          ->route('partners.index')
          ->with('Partner updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
