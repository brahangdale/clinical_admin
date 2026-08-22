<?php

namespace App\Http\Controllers;

use App\Models\AboutClinic;
use App\Models\ClinicalAdmin;
use App\Models\ClinicContact;
use App\Models\ClinicGallary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ClinicSetting;
use App\Models\ClinicTiming;


class ClinicSettingController extends Controller
{
  public function clinic_setting(){
    $clinicId = auth()->user()->clinical_admin_id;
    $clinicSettings = ClinicSetting::where('clinical_admin_id', $clinicId)->first();
    $aboutClinic = AboutClinic::where('clinical_admin_id', $clinicId)->first();
    $clinicContact = ClinicContact::where('clinical_admin_id', $clinicId)->first();
    $clinicTimings = ClinicTiming::where(
        'clinical_admin_id',
        $clinicId
    )->get();
    $galleryImages = ClinicGallary::where(
        'clinical_admin_id',
        $clinicId
    )->get();


    $clinic = ClinicalAdmin::findOrFail($clinicId);
    return view('clinical_admins.setting',compact(
        'clinic', 'clinicSettings', 'aboutClinic' ,'clinicContact', 
        'galleryImages','clinicTimings'
    ));
  }

  // public function  create_setting(Request $request){
  //   $clinicId = auth()->user()->clinical_admin_id;
  //   $request->validate([
  //       'logo_name'       => 'required|string|max:255',
  //       'banner_title'    => 'nullable|string|max:255',
  //       'description'     => 'nullable|string|max:70',
  //       'facebook_link'   => 'nullable|url',
  //       'instagram_link'  => 'nullable|url',
  //       'youtube_link'    => 'nullable|url',
  //       // 'gallary.*'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
  //   ]);

  //   $data = [
  //       'clinical_admin_id' => $clinicId ,
  //       'logo_name'         => $request->logo_name,
  //       'banner_title'      => $request->banner_title,
  //       'description'       => $request->description,
  //       'facebook_link'     => $request->facebook_link,
  //       'instagram_link'    => $request->instagram_link,
  //       'youtube_link'      => $request->youtube_link,
  //   ];
  //   // Home Setting Create / Update
  //   ClinicSetting::updateOrCreate(
  //       [
  //           'clinical_admin_id' => $clinicId
  //       ],
  //       $data
  //   );

  //   // Existing setting
  //   // $setting = ClinicSetting::where('clinical_admin_id',$clinicId)->first();

  //   // Gallery Upload
  //   if ($request->hasFile('gallary')) {

  //       foreach ($request->file('gallary') as $image) {

  //           $path = $image->store(
  //               'clinic_gallery',
  //               'public'
  //           );

  //           ClinicGallary::create([
  //               'clinical_admin_id' => $clinicId,
  //               'image' => $path,
  //           ]);
  //       }
  //   }

  //   return back()->with(
  //       'success',
  //       'Clinic setting saved successfully.'
  //   );

  // }

  public function create_setting(Request $request)
  {
    $clinicId = auth()->user()->clinical_admin_id;

    // Existing gallery images
    $existingGalleryCount = ClinicGallary::where(
        'clinical_admin_id',
        $clinicId
    )->count();

    // New uploaded images
    $newGalleryCount = count(
        $request->file('gallary', [])
    );

    // Existing + New
    $totalGalleryCount = $existingGalleryCount + $newGalleryCount;

    // Maximum 5 images allowed
    if ($totalGalleryCount > 5) {
        return back()
      ->withErrors([
          'gallary' =>
              "Maximum 5 gallery images are allowed. " .
              "You already have {$existingGalleryCount} image(s), " .
              "and you are trying to upload {$newGalleryCount} more."
      ])
      ->withInput();
    }

    $request->validate([
      'logo_name'       => 'required|string|max:255',
      'banner_title'    => 'required|string|max:255',
      'description'     => 'required|string|max:100',
      'facebook_link'   => 'required|url',
      'instagram_link'  => 'required|url',
      'youtube_link'    => 'required|url',

      // Gallery validation
      'gallary' => 'nullable|array',
      'gallary.*' => 'image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $data = [
      'clinical_admin_id' => $clinicId,
      'logo_name'         => $request->logo_name,
      'banner_title'      => $request->banner_title,
      'banner_description'       => $request->description,
      'facebook_link'     => $request->facebook_link,
      'instagram_link'    => $request->instagram_link,
      'youtube_link'      => $request->youtube_link,
    ];
  // print_r($data);
  // die;
    // Home Setting Create / Update
    ClinicSetting::updateOrCreate(
      [
        'clinical_admin_id' => $clinicId
      ],
      $data
    );

    // Gallery Upload
    if ($request->hasFile('gallary')) {

      foreach ($request->file('gallary') as $image) {

        $path = $image->store(
            'clinic_gallery',
            'public'
        );

        ClinicGallary::create([
            'clinical_admin_id' => $clinicId,
            'image' => $path,
        ]);
      }
    }

    return back()->with(
      'success',
      'Clinic setting saved successfully.'
    );
}

  public function create_clinic_time(Request $request){
    // $request->validate([
    //     'timings' => 'required|array',

    //     'timings.*.morning_time' => 'required|date_format:H:i',
    //     'timings.*.evening_time' => 'required|date_format:H:i',
    // ]);
    $clinicId = auth()->user()->clinical_admin_id;
    foreach ($request->timings as $day => $timing) {
      ClinicTiming::updateOrCreate(
        [
          'clinical_admin_id' => $clinicId,
          'day' => $day,
        ],
        [
          'morning_time' => $timing['morning_time'] ?? null,
          'evening_time' => $timing['evening_time'] ?? null,
        ]
      );
    }

    return back()->with('success', 'Clinic timing saved successfully.');
  }

  public function clinic_about(Request $request){
    $clinicId = auth()->user()->clinical_admin_id;
    $request->validate([
      'name' => 'required|string|max:255',
      'tagline' => 'required|string|max:255',
      'about_clinic' => 'required|string',
      'experience' => 'required|string',
      'logo' => 'nullable|image|max:2048',
    ]);

    $data = [
      'name' => $request->name,
      'tagline' => $request->tagline,
      'about_clinic' => $request->about_clinic,
      'experience' => $request->experience,
    ];

    if ($request->hasFile('logo')) {
      $data['logo'] = $request->file('logo')->store('clinic_logos', 'public');
    }

    AboutClinic::updateOrCreate(
      [
          'clinical_admin_id' =>  $clinicId
      ],
      $data
    );
    return back()->with('success', 'Clinic information saved successfully.');
  }

  public function clinic_contact(Request $request){

    $clinicId = auth()->user()->clinical_admin_id;
    $request->validate([
        'address' => 'required|string',
        'google_map_link' => 'required|url',
        'phone' => 'required|string|max:20',
        'emergency_contact' => 'required|string|max:20',
    ]);

    ClinicContact::updateOrCreate(
      [
        'clinical_admin_id' => $clinicId,
      ],
      [
        'address' => $request->address,
        'google_map_link' => $request->google_map_link,
        'phone' => $request->phone,
        'emergency_contact' => $request->emergency_contact,
      ]
    );
    return back()->with('success', 'Clinic contact details saved successfully.');
  }
  public function deleteGallery($id)
  {
    $clinicId = auth()->user()->clinical_admin_id;

    $gallery = ClinicGallary::where('id', $id)
        ->where('clinical_admin_id', $clinicId)
        ->firstOrFail();

    // Storage se image delete
    if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
        Storage::disk('public')->delete($gallery->image);
    }

    // Database se delete
    $gallery->delete();

    return response()->json([
        'success' => true,
        'message' => 'Gallery image deleted successfully.'
    ]);
  }
}
