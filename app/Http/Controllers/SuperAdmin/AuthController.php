<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
  public function login(){
    if (Auth::check()) {
      return redirect('/superadmin/dashboard');
    }
    return view('auth.login');
  }

  public function authenticate(Request $request){
    $request->validate([
      'user_name' => 'required',
      'password' => 'required'
    ]);

    $user = $request->only('user_name', 'password');
    // print_r($user);
    if(Auth::attempt($user)){
      // dd(auth()->user()->role);
      $request->session()->regenerate();
      if(Auth::check()){
        $userDetails = Auth::user();
        // print_r($userDetails);
        Session::put('name', $userDetails->user_name);
        Session::put('userId', $userDetails->id);
       
        if (auth()->user()->role == 'super_admin') {
          return redirect('/superadmin/dashboard');
        }
        if (auth()->user()->role == 'clinic_admin') {
          return redirect('/clinical_admins/clinic_dashboard');
        }
        if (auth()->user()->role == 'sub_admin') {
          return redirect('/partner/partner_dashboard');
        }
      }
    }
    else{
      return redirect()->back()->withErrors([
      'user_name' => 'Invalid username',
      'password' => 'Invalid password'
      ])->withInput();
    }
  }

  public function logout(Request $request){
    // print_r($request->all());
    // die;
    Auth::logout();
    Session::flush();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
  }
}
