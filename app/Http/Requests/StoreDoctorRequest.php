<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
      return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'clinical_admin_id' => 'required|exists:clinical_admins,id',
      'doctor_name' => 'required|string|max:255',
      'mobile_number' => 'required|digits:10',
      'email' => 'nullable|email|unique:doctors,email',
      'gender' => 'nullable',
      'dob' => 'nullable|date',
      'specialization' => 'required|string|max:255',
      'qualification' => 'required|string|max:255',
      'experience' => 'nullable|integer|min:0',
      'consultation_fee' => 'nullable|numeric|min:0',
      'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
      'status' => 'required|boolean',
      'address' => 'nullable|string',

      // Schedule Validation
      'schedules.*.day' => 'required',
      'schedules.*.morning_start' => 'nullable|date_format:H:i',
      'schedules.*.morning_end' => 'nullable|date_format:H:i',
      'schedules.*.evening_start' => 'nullable|date_format:H:i',
      'schedules.*.evening_end' => 'nullable|date_format:H:i',
      'schedules.*.general_start' => 'nullable|date_format:H:i',
      'schedules.*.general_end' => 'nullable|date_format:H:i',
    ];
  }
  public function messages(): array
  {
    return [
      'schedules.*.morning_start.date_format' =>
          'Please enter Morning Start Time in HH:MM format, e.g. 10:00.',

      'schedules.*.morning_end.date_format' =>
          'Please enter Morning Close Time in HH:MM format, e.g. 11:00.',

      'schedules.*.evening_start.date_format' =>
          'Please enter Evening Start Time in HH:MM format, e.g. 05:00.',

      'schedules.*.evening_end.date_format' =>
          'Please enter Evening Close Time in HH:MM format, e.g. 09:00.',

      'schedules.*.general_start.date_format' =>
          'Please enter General Start Time in HH:MM format, e.g. 09:00.',

      'schedules.*.general_end.date_format' =>
          'Please enter General Close Time in HH:MM format, e.g. 06:00.',
    ];
  }
  // Custom Schedule Validation
  // =========================

  public function withValidator($validator)
  {
    $validator->after(function ($validator) {

        foreach ($this->input('schedules', []) as $day => $schedule) {

            $morningStart = $schedule['morning_start'] ?? null;
            $morningEnd   = $schedule['morning_end'] ?? null;

            $eveningStart = $schedule['evening_start'] ?? null;
            $eveningEnd   = $schedule['evening_end'] ?? null;

            $generalStart = $schedule['general_start'] ?? null;
            $generalEnd   = $schedule['general_end'] ?? null;


            /*
            |--------------------------------------------------------------------------
            | Morning + Evening + General validation
            |--------------------------------------------------------------------------
            */

            $morningFilled =
                !empty($morningStart) ||
                !empty($morningEnd);

            $eveningFilled =
                !empty($eveningStart) ||
                !empty($eveningEnd);

            $generalFilled =
                !empty($generalStart) ||
                !empty($generalEnd);


            /*
            |--------------------------------------------------------------------------
            | General Shift cannot be combined with Morning/Evening
            |--------------------------------------------------------------------------
            */

            if (($morningFilled || $eveningFilled) && $generalFilled) {

                $validator->errors()->add(
                    "schedules.$day.general_start",
                    "General Shift cannot be used with Morning or Evening Shift."
                );
            }
        }
    });
  }
}
