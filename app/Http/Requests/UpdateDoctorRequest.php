<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
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

        'email' => [
            'nullable',
            'email',
            Rule::unique('doctors', 'email')
                ->ignore($this->route('doctor')),
        ],
        'schedules.*.morning_start' => [ 'nullable','date_format:H:i',],
        'schedules.*.morning_end' => [ 'nullable','date_format:H:i',],
        'schedules.*.evening_start' => ['nullable','date_format:H:i',],
        'schedules.*.evening_end' => ['nullable', 'date_format:H:i',],
        'schedules.*.general_start' => ['nullable','date_format:H:i',],
        'schedules.*.general_end' => ['nullable','date_format:H:i',],
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
    public function withValidator($validator)
    {
      $validator->after(function ($validator) {

          foreach ($this->input('schedules', []) as $day => $schedule) {

              $morningStart = $schedule['morning_start'] ?? null;
              $morningEnd   = $schedule['morning_end'] ?? null;

              $eveningStart = $schedule['evening_start'] ?? null;
              $eveningEnd   = $schedule['evening_end'] ?? null;

              /*
              |--------------------------------------------------------------------------
              | Morning must be AM
              |--------------------------------------------------------------------------
              */

            //   if ($morningStart && strtoupper(date('A', strtotime($morningStart))) !== 'AM') {

            //       $validator->errors()->add(
            //           "schedules.$day.morning_start",
            //           "Morning Start Time must be AM."
            //       );
            //   }

            //   if ($morningEnd && strtoupper(date('A', strtotime($morningEnd))) !== 'AM') {

            //       $validator->errors()->add(
            //           "schedules.$day.morning_end",
            //           "Morning Close Time must be AM."
            //       );
            //   }


              /*
              |--------------------------------------------------------------------------
              | Evening must be PM
              |--------------------------------------------------------------------------
              */

            //   if ($eveningStart && strtoupper(date('A', strtotime($eveningStart))) !== 'PM') {

            //       $validator->errors()->add(
            //           "schedules.$day.evening_start",
            //           "Evening Start Time must be PM."
            //       );
            //   }

            //   if ($eveningEnd && strtoupper(date('A', strtotime($eveningEnd))) !== 'PM') {

            //       $validator->errors()->add(
            //           "schedules.$day.evening_end",
            //           "Evening Close Time must be PM."
            //       );
            //   }


              /*
              |--------------------------------------------------------------------------
              | Morning/Evening + General is not allowed
              |--------------------------------------------------------------------------
              */

              $morningFilled =
                  !empty($morningStart) ||
                  !empty($morningEnd);

              $eveningFilled =
                  !empty($eveningStart) ||
                  !empty($eveningEnd);

              $generalFilled =
                  !empty($schedule['general_start']) ||
                  !empty($schedule['general_end']);


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
