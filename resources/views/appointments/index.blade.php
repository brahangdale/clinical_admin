@extends('layouts.main')
@section('main-container')

  <div class="sam-appointment-header">
    <div>
        <h3 class="sam-appointment-title">
          Appointments Management
        </h3>
        <p class="text-muted mb-0">
          Manage all appointments across clinics
        </p>
    </div>
    <button
        class="btn sam-appointment-add-btn"
        data-bs-toggle="modal"
        data-bs-target="#samAddPatientModal">
        <i class="fa-solid fa-plus"></i>
        New Appointment
    </button>
  </div>
  <!-- Stats -->
  <div class="row g-4 mb-4">
    <div class="col-6 col-lg-3">
        <div class="sam-appointment-stats-card">
          <h6>Today's Appointments</h6>
          <h2>{{ $todayAppointments }}</h2>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="sam-appointment-stats-card">
          <h6>Pending Appointments</h6>
          <h2>{{ $pendingAppointments }}</h2>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="sam-appointment-stats-card">
          <h6>Appointments Completed</h6>
          <h2>{{ $completedAppointments }}</h2>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="sam-appointment-stats-card">
          <h6>Appointments Cancelled</h6>
          <h2>{{ $cancelledAppointments }}</h2>
        </div>
    </div>
  </div>
  <!-- Search -->
  <div class="sam-appointment-card mb-4">
    <form action="{{ route('appointments.index') }}" method="GET">
    <div class="row g-3">
      <div class="col-lg-3">
        <input
            type="text"
            class="form-control"
            placeholder="Search Patient" name="patient_name">
      </div>
      <div class="col-lg-2">

        <select class="form-select " required name="doctor_id">
          <option >Select Doctor</option>
          @foreach($doctors as $doctor)
            <option value="{{ $doctor->id }}" >
              {{ $doctor->doctor_name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-lg-3">
        <input
            type="date"
            class="form-control" name="appointment_date">
      </div>

      <div class="col-lg-6">
        <div class="d-flex gap-2 sam-filter-btns">
          <button class="btn btn-primary flex-fill">
              Search
          </button>
          <button class="btn btn-outline-secondary flex-fill">
                Reset
          </button>
        </div>
      </div>
    </div>
    </form>
  </div>
  <!-- Table -->
  <div class="sam-appointment-card">
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
              <tr>
                <th>TK No</th>
                <th>Patient</th>
                <th>Doctor</th>
                <!-- <th>Clinic</th> -->
                <th>{{ auth()->user()->role == 'super_admin' ? 'Clinic' : '' }}</th>
                <th>Date</th>
                <th>Shift & Time</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
        </thead>
        <tbody>
          
          @forelse($appointments as $appointment)
          
          <tr>
            <td>{{ $appointment->token_number}}</td>
            <td>{{ $appointment->patient->patient_name }}</td>
            <td>{{ $appointment->doctor->doctor_name }}</td>
            <td>{{ auth()->user()->role == 'super_admin' ? $appointment->clinic->clinic_name : '' }}</td>
            <td>{{ $appointment->appointment_date }}</td>
            <!-- <td>{{ $appointment->appointment_time }}</td> -->
            <td> <span><b>{{ $appointment->shift_name }}</b></span><br>
              <small>{{ $appointment->shift_time }}</small>
            </td>
            <!-- <td class="availablee-status">{{ $appointment->status }}</td> -->
            <td class="">{{ $appointment->status }}</td>
            <!-- <td>
              <select class="form-select form-select-sm appointment-status
                @if($appointment->status == 'pending') status-pending
                @elseif($appointment->status == 'in_consultation') status-confirmed
                @elseif($appointment->status == 'completed') status-completed
                @elseif($appointment->status == 'cancelled') status-cancelled
                @endif
              "data-id="{{ $appointment->id }}">
                <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>
                  Pending
                </option>

                <option value="in_consultation"
                    {{ $appointment->status == 'in_consultation' ? 'selected' : '' }}>
                    In Consultation
                </option>

                <option value="completed"
                    {{ $appointment->status == 'completed' ? 'selected' : '' }}>
                    Completed
                </option>

                <option value="cancelled"
                    {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>
                    Cancelled
                </option>
              </select>
            </td> -->
            <td>
              <button
                class="btn btn-sm btn-primary"
                data-bs-toggle="offcanvas"
                data-bs-target="#samAppointmentViewOffcanvas{{ $appointment->id }}">
              View
              </button>
            </td>
            <td>
              <button
                class="btn btn-sm btn-warning"
                data-bs-toggle="modal"
                data-bs-target="#sameditAppointmentModal{{ $appointment->id }}">
                Edit
              </button>
            </td>
          </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center">
                No Appointments Found
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
  <div class="d-flex justify-content-end mt-3">
    {{ $appointments->links() }}
  </div>
  <!-- Edit appointment model start -->
  @foreach ($appointments as $appointment )
    <div class="modal fade" id="sameditAppointmentModal{{ $appointment->id }}" tabindex="-1">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">
              Update Appointment
            </h5>
            <button
              class="btn-close"
              data-bs-dismiss="modal">
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <form id="appointmentForm" action="{{ route('appointments.update', $appointment->id) }}" method="post" novalidate>
                @csrf
                @method('PUT')  
                <!-- @if($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                @endif -->
                <input type="hidden" name="modal_id" value="sameditAppointmentModal{{ $appointment->id }}"> 
                <div class="stepper-wrapper">
                <div class="step-item active">
                  <div class="step-circle">1</div>
                  <div class="step-title">Patient</div>
                </div>
                <div class="step-item">
                  <div class="step-circle">2</div>
                  <div class="step-title">Appointment</div>
                </div>
                <div class="step-item">
                  <div class="step-circle">3</div>
                  <div class="step-title">Registration</div>
                </div>
                <div class="step-item">
                  <div class="step-circle">4</div>
                  <div class="step-title">Consultation</div>
                </div>
                </div>
                <!-- STEP 1 -->
                <div class="step-content active">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="required">Patient Name</label>
                    <input type="text" class="form-control required-field" name="patient_name" value="{{ old('patient_name',$appointment->patient->patient_name )}}">
                    @error('patient_name')
                      <span class="text-danger">
                        {{ $message }}
                      </span>
                    @enderror 
                  </div>

                  <div class="col-md-6">
                    <label class="required">Mobile Number</label>
                    <input type="tel" class="form-control required-field" name="mobile_number" value="{{ old('mobile_number',$appointment->patient->mobile_number) }}">
                    @error('mobile_number')
                      <span class="text-danger">
                        {{ $message }}
                      </span>
                    @enderror
                  </div>

                  <div class="col-md-4">
                    <label>Gender</label>
                    <select class="form-select required" name="gender">
                      <option value="">Select</option>
                      <option value="M" {{ $appointment->patient->gender == 'M' ? 'selected' : '' }}>Male</option>
                      <option value="F" {{ $appointment->patient->gender == 'F' ? 'selected' : '' }}>Female</option>
                      <option value="O" {{ $appointment->patient->gender == 'O' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                      <span class="text-danger">
                        {{ $message }}
                      </span>
                    @enderror 
                  </div>

                  <div class="col-md-4">
                    <label>DOB</label>
                    <input type="date" class="form-control dob"  name="date_of_birth" value="{{ old('date_of_birth',$appointment->patient->date_of_birth) }}" max="{{ date('Y-m-d') }}">
                    @error('date_of_birth')
                      <span class="text-danger">
                        {{ $message }}
                      </span>
                    @enderror
                  </div>

                  <div class="col-md-4">
                    <label>Age</label>
                    <input type="number" class="form-control age" name="age" 
                    value="{{ old('age',$appointment->patient->age) }}" readonly>
                    @error('age')
                      <span class="text-danger">
                        {{ $message }}
                      </span>
                    @enderror
                  </div>

                  <div class="col-md-6">
                    <label>City</label>
                    <input type="text" class="form-control" name="city"  value="{{ old('city',$appointment->patient->city) }}">
                  </div>

                  <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email"  value="{{ old('email',$appointment->patient->email) }}">
                  </div>

                  <div class="col-md-6">
                    <label>Emergency Contact</label>
                    <input type="tel" class="form-control" name="emergency_number"  value="{{ old('emergency_number',$appointment->patient->emergency_number) }}">
                  </div>

                  <div class="col-md-12">
                  <label>Address</label>
                  <textarea class="form-control" name="address">{{ old('address',$appointment->patient->address) }}</textarea>
                  </div>
                </div>
                </div>

                <!-- STEP 2 -->
                <div class="step-content">
                  <div class="row g-3">
                    @if(auth()->user()->role == 'super_admin')
                      <!-- clinic -->
                      <div class="col-md-6">
                        <label class="form-label fw-semibold">
                          Clinic Name <span class="text-danger">*</span>
                        </label>
                        <select class="form-select clinic_id" required name="clinical_admin_id">
                          @foreach($clinics as $clinic)
                            <option value="{{ $clinic->id }}" {{ $appointment->clinical_admin_id == $clinic->id ? 'selected' : '' }}>
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
                        <select class="form-select doctor_id" required name="doctor_id">
                            <option value="{{ $appointment->doctor->id  }}">{{ $appointment->doctor->doctor_name }}</option>
                        </select>
                      </div>
                    @else
                    <input type="hidden" name="clinical_admin_id" value="{{ auth()->user()->clinical_admin_id }}">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                          Doctor Name <span class="text-danger">*</span>
                        </label>
                        <select class="form-select edit_doctor_id" required name="doctor_id">
                          @foreach($doctors as $doctor)
                          <!-- @dump( $appointment) -->
                            <option value="{{ $doctor->id }}" {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                              {{ $doctor->doctor_name }}
                            </option>
                          @endforeach
                        </select>
                        @error('doctor_id')
                          <span class="text-danger">
                            {{ $message }}
                          </span>
                        @enderror
                      </div>
                    @endif
                    <div class="col-md-6">
                      <label class="required">Appointment Date</label>
                      <input type="date" class="form-control required-field edit_appointment_date"  name="appointment_date" value="{{ old('appointment_date',$appointment->appointment_date) }}" min="{{ date('Y-m-d') }}">
                      @error('appointment_date')
                      <span class="text-danger">
                        {{ $message }}
                      </span>
                    @enderror
                    </div>
                    <!-- ------------------------- -->
                    <div class="col-md-12">
                      <label class="form-label fw-semibold">
                        Shift <span class="text-danger">*</span>
                      </label>

                      <div class="doctor-shifts flex-wrap gap-3">

                        <p class="text-muted mb-0">
                            Select doctor and appointment date.
                        </p>
                      </div>

                  </div>


                  

                  <input type="hidden"
                        class="saved_shift_name" name="shift_name"
                        value="{{ old('shift_name', $appointment->shift_name) }}">

                  <input type="hidden"
                        class="saved_shift_time" name="shift_time"
                        value="{{ old('shift_time', $appointment->shift_time) }}">
                    <!-- ------------------------- -->

                    <div class="col-md-6">
                      <label class="required">Appointment Time</label>
                      <input type="time" class="form-control required-field" name="appointment_time" value="{{ old('appointment_time',$appointment->appointment_time) }}">
                      @error('appointment_time')
                      <span class="text-danger">
                        {{ $message }}
                      </span>
                      @enderror
                    </div>
                    

                    <!-- clinic -->
                      

                    <div class="col-md-6">
                      <label>Department</label>
                      <input type="text" class="form-control" name="department" value="{{ $appointment->department }}">
                    </div>

                    <div class="col-md-6">
                      <label>Status</label>
                      <select class="form-select" name="status">
                        @foreach(['pending','in_consultation','completed','cancelled'] as $status)
                          <option value="{{ old('status',$status) }}"
                            {{ $appointment->status == $status ? 'selected' : '' }}>
                            {{ $status }}
                          </option>
                        @endforeach
                      </select>
                      @error('status')
                          <span class="text-danger">
                            {{ $message }}
                          </span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                      <label>Visit Type</label>
                      <select class="form-select" name="visit_type">
                        @foreach(['New Patient','Follow-up'] as $visit)
                            <option value="{{ $visit }}"
                              {{ $appointment->visit_type == $visit ? 'selected' : '' }}>
                              {{ $visit }}
                            </option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label>Referred By</label>
                      <input type="text" class="form-control" name="reffered_by" value="{{ old('reffered_by',$appointment->reffered_by) }}">
                    </div>

                    <div class="col-md-12">
                      <label>Reason / Symptoms</label>
                      <textarea class="form-control" name="symptoms">{{ old('symptoms',$appointment->symptoms) }}</textarea>
                    </div>
                  </div>
                </div>

                <!-- STEP 3 -->

                <div class="step-content">

                  <div class="row g-3">

                    <div class="col-md-6">
                      <label>Patient ID</label>
                      <input type="text" class="form-control" value="{{ $appointment->patient->patient_id  }}" readonly>
                    </div>
                  
                    <div class="col-md-6">
                      @php
                        $groups=['A+','A-','B+','B-','AB+','AB-','O+','O-'];
                      @endphp
                      <label>Blood Group</label>
                      <select class="form-select" name="blood_group">
                        @foreach($groups as $group)
                          <option value="{{ $group }}"
                            {{ $appointment->patient->blood_group == $group ? 'selected' : '' }}>
                            {{ $group }}
                          </option>
                        @endforeach
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label>Marital Status</label>
                      <select class="form-select" name="marital_status">
                        <option value="Singal">Single</option>
                        <option value="Married">Married</option>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label>Occupation</label>
                      <input type="text" class="form-control" name="occupation" value="{{ old('occupation',$appointment->patient->occupation) }}">
                    </div>

                  </div>
                </div>

                <!-- STEP 4 -->

                <div class="step-content">
                  <div class="row g-3">

                    <div class="col-md-4">
                      <label>Height (cm)</label>
                      <input type="number" id="height" class="form-control" name="height" value="{{ old('height',$appointment->patient->height) }}">
                      <small class="field-hint">
                        ex: 150–200 cm
                      </small>
                      @error('height')
                          <span class="text-danger">
                            {{ $message }}
                          </span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                      <label>Weight (kg)</label>
                      <input type="number" id="weight" class="form-control" name="weight" value="{{ old('weight',$appointment->weight) }}">
                      <small class="field-hint">
                        ex: 40–150 kg
                      </small>
                      @error('weight')
                          <span class="text-danger">
                            {{ $message }}
                          </span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                      <label>BMI</label>
                      <input type="text" id="bmi" class="form-control" readonly name="bmi" value="{{ old('bmi',$appointment->bmi) }}">
                      @error('bmi')
                          <span class="text-danger">
                            {{ $message }}
                          </span>
                        @enderror
                    </div>

                    <div class="col-md-4">
                      <label>BP (mmHg)</label>
                      <input type="text" class="form-control" name="bp" value="{{ old('bp',$appointment->bp) }}">
                      <small class="field-hint">
                        ex: 120/80 mmHg
                      </small>
                      @error('bp')
                        <span class="text-danger">
                          {{ $message }}
                        </span>
                      @enderror  
                    </div>

                    <div class="col-md-4">
                      <label>Pulse (bpm)</label>
                      <input type="number" class="form-control" name="pulse" value="{{ old('pulse',$appointment->pulse) }}">
                      <small class="field-hint">
                          Normal resting pulse: 60–100 bpm
                      </small>
                      @error('pulse')
                        <span class="text-danger">
                          {{ $message }}
                        </span>
                      @enderror
                    </div>

                    <div class="col-md-4">
                      <label>Temperature (°F)</label>
                      <input type="number" class="form-control" name="temperature" value="{{ old('tempreature',$appointment->tempreature) }}">
                      <small class="field-hint">
                        Normal: 97–99 °F
                      </small>
                      @error('temperature')
                        <span class="text-danger">
                          {{ $message }}
                        </span>
                      @enderror
                    </div>

                    <div class="col-md-4">
                      <label>SpO2</label>
                      <input type="number" class="form-control" name="spo2" value="{{ old('spo2',$appointment->spo2) }}">
                      <small class="field-hint">
                          Normal: 95–100%
                      </small>
                      @error('spo2')
                        <span class="text-danger">
                          {{ $message }}
                        </span>
                      @enderror
                    </div>

                    <div class="col-md-4">
                      <label>Blood Sugar</label>
                      <input type="number" class="form-control" name="blood_suger" value="{{ old('blood_suger',$appointment->blood_suger) }}">
                      <small class="field-hint">
                          Fasting normal: 70–99 mg/dL
                      </small>
                      @error('blood_suger')
                        <span class="text-danger">
                          {{ $message }}
                        </span>
                      @enderror
                    </div>

                    <div class="col-md-4">
                      <label>Allergies</label>
                      <input type="text" class="form-control" name="allergies" value="{{ old('allergies',$appointment->allergies) }}">
                    </div>

                    <div class="col-md-12">
                      <label>Chief Complaint</label>
                      <textarea class="form-control" name="chief_complaint">{{ old('chief_complaint',$appointment->chief_complaint) }}</textarea>
                    </div>

                    <div class="col-md-12">
                      <label>Diagnosis</label>
                      <textarea class="form-control" name="diagnosis">{{ old('diagnosis',$appointment->diagnosis) }}</textarea>
                    </div>

                    <div class="col-md-12">
                      <label>Prescription</label>
                      <textarea class="form-control" name="prescription">{{ old('prescription',$appointment->prescription) }}</textarea>
                    </div>

                    <div class="col-md-12">
                      <label>Tests Recommended</label>
                      <textarea class="form-control" name="test_recommended">{{ old('test_recommended',$appointment->test_recommended) }}</textarea>
                    </div>

                    <div class="col-md-6">
                      <label>Follow-up Date</label>
                      <input type="date" class="form-control" name="follow_up_date" value="{{ old('follow_up_date',$appointment->follow_up_date) }}">
                      @error('follow_up_date')
                        <span class="text-danger">
                          {{ $message }}
                        </span>
                      @enderror
                    </div>

                    <div class="col-md-6">
                      <label>Notes</label>
                      <input type="text" class="form-control" name="notes" value="{{ old('notes',$appointment->notes) }}">
                    </div>
                  </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                  <button type="button" class="btn btn-secondary prevBtn" id="prevBtn">Previous</button>
                  <button type="button" class="btn btn-primary nextBtn" id="nextBtn">Next</button>
                  <button type="submit" class="btn btn-success d-none submitBtn" id="submitBtn">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
      document.querySelectorAll('.modal').forEach(function(modal){

      let currentStep = 0;

      const steps = modal.querySelectorAll('.step-content');
      const indicators = modal.querySelectorAll('.step-item');

      const nextBtn = modal.querySelector('.nextBtn');
      const prevBtn = modal.querySelector('.prevBtn');
      const submitBtn = modal.querySelector('.submitBtn');

    // Next Previous Logic

      function showStep(step){

      steps.forEach((s,index)=>{
      s.classList.toggle('active',index===step);
      });

      indicators.forEach((item,index)=>{

      item.classList.remove('active','completed');

      if(index<step){
      item.classList.add('completed');
      }
      else if(index===step){
      item.classList.add('active');
      }

      });

      prevBtn.style.display = step===0 ? 'none' : 'inline-block';

      if(step===steps.length-1){
      nextBtn.classList.add('d-none');
      submitBtn.classList.remove('d-none');
      }else{
      nextBtn.classList.remove('d-none');
      submitBtn.classList.add('d-none');
      }

      }

      nextBtn.addEventListener('click',()=>{

      currentStep++;

      if(currentStep>=steps.length){
      currentStep=steps.length-1;
      }

      showStep(currentStep);

      });

      prevBtn.addEventListener('click',()=>{

      currentStep--;

      if(currentStep<0){
      currentStep=0;
      }

      showStep(currentStep);

      });

      showStep(currentStep);

      document.getElementById('height').addEventListener('input',calculateBMI);
      document.getElementById('weight').addEventListener('input',calculateBMI);

      function calculateBMI(){

      let h=document.getElementById('height').value/100;
      let w=document.getElementById('weight').value;

      if(h>0 && w>0){
      document.getElementById('bmi').value=(w/(h*h)).toFixed(2);
      }

      }
    });
    </script> 
    <!-- Doctor Details Start -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="samAppointmentViewOffcanvas{{ $appointment->id }}">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title">
          Appointment Details
        </h5>
        <button
          class="btn-close"
          data-bs-dismiss="offcanvas">
        </button>
      </div>
      <div class="offcanvas-body">
        <table class="table">
          <tr>
            <th>Appointment ID</th>
            <td>{{ $appointment->patient->patient_id}}</td>
          </tr>
          <tr>
            <th>Patient</th>
            <td>{{ $appointment->patient->patient_name }}</td>
          </tr>
          <tr>
            <th>Doctor</th>
            <td>{{ $appointment->doctor->doctor_name }}</td>
          </tr>
          <tr>
            <th>Clinic</th>
            <td>{{$appointment->clinic->clinic_name}}</td>
          </tr>
          <tr>
            <th>Date</th>
            <td>{{$appointment->appointment_date}}</td>
          </tr>
          <tr>
            <th>Time</th>
            <td>{{$appointment->appointment_time}}</td>
          </tr>
          <tr>
            <th>Status</th>
            <td>
              <span class="badge bg-warning">
              {{ $appointment->status }}
              </span>
            </td>
          </tr>
          
        </table>
      </div>
    </div>
  @endforeach
    <!-- Edit paisint Module Starts -->
    <!--  -->
  <div class="modal fade" id="samAddPatientModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Add Patient Appointment
          </h5>
          <button
            class="btn-close"
            data-bs-dismiss="modal">
          </button>
        </div>
        <div class="modal-body sam-appointment-body">
          <form id="quickAppointmentForm" action="{{ route('appointments.store') }}" method="post">
            @csrf 
            <input type="hidden" name="modal_id" value="samAddPatientModal"> 
            <input type="hidden" name="redirect_to" value="appointment">
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
      </div>
    </div>
  </div>
  <div  id="page-data"
      data-errors="{{ $errors->any() ? '1' : '0' }}"
      data-success="{{ session('success') ? '1' : '0' }}"
      data-modal-id="{{ old('modal_id') }}"></div>
@endsection