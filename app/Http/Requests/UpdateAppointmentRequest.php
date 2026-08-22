<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
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
      'patient_name'      => 'required|string|max:255',
      'mobile_number'     => 'required|digits:10',
      'gender'            => 'required|in:M,F,O',
      'age'               => 'nullable|integer|min:0|max:120',
      'date_of_birth'     => 'nullable|date|before_or_equal:today',

      'appointment_date'  => 'required|date',
    //   'appointment_time'  => 'required',
      'clinical_admin_id' => 'required|exists:clinical_admins,id',
      'doctor_id'         => 'required|exists:doctors,id',

      'status'            => 'required|in:pending,in_consultation,completed,cancelled',
      'visit_type'        => 'required|in:New Patient,Follow-up',

      'weight'            => 'nullable|numeric|min:1|max:500',
      'height'            => 'nullable|numeric|min:20|max:300',
      'bmi'               => 'nullable|numeric|min:1|max:100',

      'bp'                => ['nullable','regex:/^\d{2,3}\/\d{2,3}$/'],
      'pulse'             => 'nullable|integer|min:30|max:250',
      'temperature'       => 'nullable|numeric|min:90|max:110',
      'spo2'              => 'nullable|integer|min:50|max:100',
      'blood_suger'       => 'nullable|numeric|min:20|max:600',

      'follow_up_date'    => 'nullable|date|after_or_equal:appointment_date',
      ];
    }
}
