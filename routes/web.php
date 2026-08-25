<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicalAdmin\ClinicalDashboardController;
use App\Http\Controllers\ClinicSettingController;
use App\Http\Controllers\ClinicWebsiteController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ClinicalAdminController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\Partners\PartnerDashboardController;
use App\Http\Controllers\SuperAdmin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\AuthController;


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('superadmin')->middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('superadmin.dashboard');

});
Route::prefix('partner')->middleware(['auth', 'role:sub_admin'])->group(function () {
  Route::get('/partner_dashboard', [PartnerDashboardController::class, 'index'])
      ->name('partners.partner_dashboard');
  Route::post('/store_clinic', [PartnerDashboardController::class, 'store_clinic'])->name('partners.store_clinic');
  Route::post('/partner/clinic-performance',[PartnerDashboardController::class, 'clinicPerformance'])->name('partner.clinic.performance');
});
Route::prefix('clinical_admins')->middleware(['auth', 'role:clinic_admin'])->group(function () {        
    Route::get('/clinic_dashboard', [ClinicalDashboardController::class, 'index'])
      ->name('clinical_admins.dashboard.clinic_dashboard');
    Route::get('/today_appointments', [ClinicalDashboardController::class, 'today_appointments' ])->name('clinical_admins.dashboard.today_appointments');
    Route::get('/completed_today', [ClinicalDashboardController::class, 'completed_today' ])->name('clinical_admins.dashboard.completed_today_appointments');
    Route::get('/todays_birthday', [ClinicalDashboardController::class, 'todays_birthday' ])->name('clinical_admins.dashboard.todays_birthday');
    Route::get('/future_appointments', [ClinicalDashboardController::class, 'future_appointments' ])->name('clinical_admins.dashboard.future_appointments');
    Route::get('/follow_up', [ClinicalDashboardController::class, 'follow_up' ])->name('clinical_admins.dashboard.follow_up');
    Route::get('/add_appointment', [ClinicalDashboardController::class, 'add_appointment'])->name('clinical_admins.dashboard.add_appointment');
    Route::post('/appointment/{appointment}/skip', [ClinicalDashboardController::class, 'skipToken'])->name('clinical_admins.appointment.skip');
    Route::post('/appointment/{appointment}/complete',[ClinicalDashboardController::class, 'completeToken'])->name('clinical_admins.appointment.complete');
    
    Route::get('/notifications', [ClinicalDashboardController::class, 'notifications' ])->name('clinical_admins.dashboard.notifications');

    Route::get('/clinic_setting', [ClinicSettingController::class, 'clinic_setting'])
      ->name('clinical_admins.setting');
    Route::post('/create_setting', [ClinicSettingController::class, 'create_setting'])
      ->name('clinical_admins.create_setting');
    Route::post('/create_clinic_time', [ClinicSettingController::class, 'create_clinic_time'])
      ->name('clinical_admins.clinic_timing');
    Route::post('/clinic_about', [ClinicSettingController::class, 'clinic_about'])
    ->name('clinical_admins.about_clinic');
    Route::post('/clinic_contact', [ClinicSettingController::class, 'clinic_contact'])
    ->name('clinical_admins.clinic_contact');
    Route::delete('/clinical-admin/gallery/{gallery}',[ClinicSettingController::class, 'deleteGallery']
    )->name('clinical_admins.delete_gallery');
  });
Route::middleware(['auth'])->group(function () {
  Route::get('/reports', [DashboardController::class, 'reports'])
        ->name('reports');

  Route::resource('partners', PartnerController::class);
  Route::post('/partner/toggle-status/{id}',[PartnerController::class, 'toggleStatus'])->name('partner.toggle.status');
  
  Route::resource('clinical_admins', ClinicalAdminController::class);
  Route::post('/clinic/toggle-status/{id}',
    [ClinicalAdminController::class, 'toggleStatus']
  )->name('clinic.toggle.status');

  Route::resource('doctors', DoctorController::class);
  Route::post('/doctor/toggle-status/{id}',[DoctorController::class, 'toggleStatus'])->name('doctor.toggle.status');
  Route::resource('appointments', AppointmentController::class);
  Route::get('/get-doctors/{clinic}', [AppointmentController::class, 'getDoctors']);
  Route::post('/update-status/{appointment}',[AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
  Route::post('/appointments/{appointment}/fee', 
    [AppointmentController::class, 'updateFees'])->name('appointments.update-fees');
});
Route::get('/doctors/{doctor}/schedule', [DoctorController::class, 'schedule'])->name('doctors.schedule');

Route::middleware('identify.clinic')->group(function () {

    // Route::get('/', function () {

    //     $clinic = app('currentClinic');

    //     return view('ptient_site.home', compact('clinic'));

    // })->name('ptient_site.home');
  Route::get('/', [ClinicWebsiteController::class, 'home'])->name('patient_site.home');
  Route::get('/about', [ClinicWebsiteController::class, 'about'])->name('patient_site.about');
  Route::get('/location', [ClinicWebsiteController::class, 'location'])->name('patient_site.location');
  Route::get('/games', [ClinicWebsiteController::class, 'games'])->name('patient_site.games');
  Route::get('/memory_game', [ClinicWebsiteController::class, 'memory_game'])->name('patient_site.memory_game');
  Route::get('/number_game', [ClinicWebsiteController::class, 'number_game'])->name('patient_site.number_game');
  Route::get('/math_plane_game', [ClinicWebsiteController::class, 'math_plane_game'])->name('patient_site.math_plane_game');
  Route::get('/appointment', [ClinicWebsiteController::class, 'appointment'])->name('patient_site.appointment');
  Route::post('/appointment', [ClinicWebsiteController::class, 'create_appointment'])->name('patient_site.appointment');
  Route::get('/token_page', [ClinicWebsiteController::class, 'token_page'])->name('patient_site.token_page');
  Route::get('/check_token/{doctor}', [ClinicWebsiteController::class, 'check_token'])->name('patient_site.check_token');

});
