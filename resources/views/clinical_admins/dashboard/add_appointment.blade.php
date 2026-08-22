@extends('layouts.main')
@section('main-container')
 <div class="sam-appointment-card mt-3">
    <form id="quickAppointmentForm" action="{{ route('appointments.store') }}" method="post">
      @csrf 
      <input type="hidden" name="modal_id" value="samAddPatientModal"> 
      <input type="hidden" name="redirect_to" value="clinic_dashboard">
      <div class="row g-3">

      <!-- Patient Name -->
      <div class="col-md-6">
        <label class="form-label fw-semibold">
            Patient Name <span class="text-danger">*</span>
        </label>
        <input type="text" name="patient_name" class="form-control" placeholder="Enter patient name"  value="{{ old('patient_name') }}">
        @error('patient_name')
          <span class="text-danger">
              {{ $message }}
          </span>
        @enderror   
      </div>

      <!-- Mobile -->
      <div class="col-md-6">
        <label class="form-label fw-semibold">
            Mobile Number <span class="text-danger">*</span>
        </label>
        <input type="tel" name="mobile_number" class="form-control" placeholder="Enter mobile number" value="{{ old('mobile_number') }}">
        @error('mobile_number')
          <span class="text-danger">
              {{ $message }}
          </span>
        @enderror 
      </div>
      <!-- clinic -->
      @if(auth()->user()->role == 'super_admin')
        <div class="col-md-6">
          <label class="form-label fw-semibold">
              Clinic Name <span class="text-danger">*</span>
          </label>
          <select class="form-select clinic_id"  name="clinical_admin_id" id="clinic_id">
            <option value="">Select Clinic</option> 
            @foreach($clinics as $clinic)
              <option value="{{ $clinic->id }}">
                {{ $clinic->clinic_name }}
              </option>
            @endforeach
          </select>
          @error('clinical_admin_id')
            <span class="text-danger">
                {{ $message }}
            </span>
          @enderror 
        </div>

        <!-- Doctor -->
        <div class="col-md-6">
          <label class="form-label fw-semibold">
              Doctor <span class="text-danger">*</span>
          </label>
          <select class="form-select doctor_id"  name="doctor_id" id="doctor_id">
              <!-- <option value="">Select Doctor</option> -->
          </select>
          @error('doctor_id')
            <span class="text-danger">
                {{ $message }}
            </span>
          @enderror 
        </div>
      @else
        <input type="hidden" name="clinical_admin_id" value="{{ auth()->user()->clinical_admin_id }}">
        <div class="col-md-6">
          <label class="form-label fw-semibold">
              Doctor <span class="text-danger">*</span>
          </label>
          <select class="form-select doctor_id"  name="doctor_id" id="doctor_id">
            @foreach($doctors as $doctor)
              <option value="{{ $doctor->id }}">{{ $doctor->doctor_name }}</option>
            @endforeach
          </select>
          @error('doctor_id')
            <span class="text-danger">
                {{ $message }}
            </span>
          @enderror 
        </div>
      @endif
      <!-- Appointment Date -->
      <div class="col-md-6">
          <label class="form-label fw-semibold">
              Appointment Date <span class="text-danger">*</span>
          </label>
          <input type="date" class="form-control"  name="appointment_date" id="appointment_date" value="{{ old('appointment_date') }}" min="{{ date('Y-m-d') }}">
          @error('appointment_date')
            <span class="text-danger">
                {{ $message }}
            </span>
          @enderror 
        </div>

        <div class="mt-3">

          <label class="form-label">
              Available Shifts
          </label>

          <div id="doctor-shifts">
              <p class="text-muted">
                  Select doctor and appointment date.
              </p>
          </div>
          <input type="hidden" name="shift_name" id="shift_name">
          <input type="hidden" name="shift_time" id="shift_time">

        </div>

      <!-- Appointment Time -->
      <div class="col-md-6">
          <label class="form-label fw-semibold">
            Appointment Time <span class="text-danger">*</span>
          </label>
          <input type="time" class="form-control"  name="appointment_time" value="{{ old('appointment_time') }}">
          <!-- <div class="input-group" id="appointmentTimePicker">
            <input
                type="text"
                class="form-control"
                id="appointment_time"
                name="appointment_time"
                value="{{ old('appointment_time') }}"
                placeholder="Select Time">

            <span class="input-group-text">
                <i class="fa fa-clock"></i>
            </span>
          </div> -->
          @error('appointment_time')
            <span class="text-danger">
                {{ $message }}
            </span>
          @enderror 
        </div>
      <!-- date of birth -->
        <div class="row">
        <div class="col-md-4">
          <label>DOB</label>
          <input type="date" class="form-control dob" name="date_of_birth" value="{{ old('date_of_birth') }}" max="{{ date('Y-m-d') }}">
        </div>

        <!-- Age -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">Age</label>
            <input type="number" class="form-control age" placeholder="Age" name="age" value="{{ old('age') }}">
        </div>

        <!-- Gender -->
        <div class="col-md-4">
            <label class="form-label fw-semibold">Gender</label>
            <select class="form-select" name="gender">
                <option value="">Select</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
                <option value="O">Other</option>
            </select>
        </div>
      </div>
      <!-- Address -->
      <div class="col-md-12">
          <label class="form-label fw-semibold">Address</label>
          <textarea class="form-control" rows="3" placeholder="Enter address" name="address"></textarea>
      </div>
      </div>

      <div class="mt-4 text-end">
          <button type="submit" class="btn btn-primary px-4">
              <i class="fas fa-calendar-check me-1"></i>
              Book Appointment
          </button>
      </div>
    </form>
  </div>
@endsection