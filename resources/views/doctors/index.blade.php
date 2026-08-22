@extends('layouts.main')
@section('main-container')
<!-- Main -->
<!-- <div class="sam-dashboard-main"> -->
  <!-- Header -->
  <div class="sam-doctor-header">
    <div>
      <h3 class="sam-doctor-title">
        Doctors Management
      </h3>
      <p class="text-muted mb-0">
        Manage all clinic doctors
      </p>
    </div>
    <button
      class="btn sam-doctor-add-btn"
      data-bs-toggle="modal"
      data-bs-target="#samAddDoctorModal">
    <i class="fa-solid fa-plus"></i>
    Add Doctor
    </button>
  </div>
  <!-- Stats -->
  <div class="row g-2 mb-4">
    <div class="col-4 col-lg-4">
      <div class="sam-doctor-stats-card">
        <h6>Total Doctors</h6>
        <h2>{{$totalDoctors}}</h2>
      </div>
    </div>
    <div class="col-4 col-lg-4">
      <div class="sam-doctor-stats-card">
        <h6>Available Doctors</h6>
        <h2>{{$availableDoctors}}</h2>
      </div>
    </div>
    <div class="col-4 col-lg-4">
      <div class="sam-doctor-stats-card">
        <h6>Unavailable Doctors</h6>
        <h2>{{ $unavailableDoctors }}</h2>
      </div>
    </div>
  </div>
  <!-- Search -->
  <div class="sam-doctor-card mb-4">
    <form action="{{ route('doctors.index')  }}" method="get">
      <div class="row g-3 align-items-end">
        <div class="col-lg-4 col-md-6">
          <label class="form-label">Search Doctor</label>
          <input type="text" name="doctor_name"
            class="form-control sam-doctor-search"
            placeholder="Search Doctor Name" value="{{ request('doctor_name') }}">
        </div>
        @if(auth()->user()->role == 'super_admin')
          <div class="col-lg-3 col-md-6">
            <label class="form-label">Clinic</label>
            <select class="form-select" name="clinical_admin_id">
              @foreach($clinics as $clinic)
                <option value="{{ $clinic->id }}"
                  {{ request('clinical_admin_id') == $clinic->id ? 'selected' : '' }}>
                  {{ $clinic->clinic_name }}
                </option>
              @endforeach
            </select>
          </div>
        @endif
        <div class="col-lg-3 col-md-6">
          <label class="form-label">Specialization</label>
          <!-- <select class="form-select">
            <option>All Specialization</option>
          </select> -->
          <!--  -->
          <select name="specialization" class="form-select">
            <option value="">All Specialization</option>
            @foreach($specializations as $specialization)
              <option value="{{ $specialization }}"
                {{ request('specialization') == $specialization ? 'selected' : '' }}>
                {{ $specialization }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-lg-2 col-md-6">
          <div class="d-flex gap-2 sam-filter-btns">
            <button class="btn btn-primary flex-fill">
            Search
            </button>
            <!-- <button class="btn btn-outline-secondary flex-fill">
            Reset
            </button> -->
              <a href="{{ route('doctors.index') }}"
                  class="btn btn-outline-secondary ">
                  Reset
              </a>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- Table -->
  <div class="sam-doctor-card">
    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Photo</th>
            <th>Name</th>
            <!-- <th>Clinic</th> -->
            <th>Specialization</th>
            <th>Mobile</th>
            <th>Experience</th>
            <th>Fee</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($doctors as $doctor)
          <tr id="row-{{ $doctor->id }}">
            <td>
              @if($doctor->profile_photo)
                <img src="{{ asset('storage/' . $doctor->profile_photo) }}"
                alt="Doctor Photo" width="50" height="50" class="rounded-circle">
              @else
              <img src="{{ url('assets/static_images/profile_photo.jpeg') }}"
                alt="Doctor Photo" width="50" height="50" class="rounded-circle">
              @endif
            </td>
            <td>
              <strong>{{ $doctor->doctor_name }}</strong>
              <br>
              <small class="text-muted">
                {{ $doctor->qualification }}
              </small>
            </td>
            <!-- <td>{{ $doctor->clinic->clinic_name }}</td> -->
            <td>{{ $doctor->specialization }}</td>
            <td>{{ $doctor->mobile_number }}</td>
            <td>{{ $doctor->experience }}</td>
            <td>{{ $doctor->consultation_fee}}</td>
            <td class="status-text">
              @if($doctor->status == 0)
                <span class="badge bg-success">Active</span>
              @else
                <span class="badge bg-danger">Inactive</span>
              @endif
            </td>
            <td style="display:flex">
              <button
                class="btn btn-sm btn-primary"
                data-bs-toggle="offcanvas"
                data-bs-target="#samDoctorViewOffcanvas{{ $doctor->id }}">
              View
              </button>

              <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#samEditDoctorModal{{ $doctor->id }}">
                Edit
              </button>
              
              </button>
              @if($doctor->status == 0)
                <button class="btn btn-sm btn-danger toggle-status" data-id="{{ $doctor->id }}">
                  Disable
                </button>
              @else
                <button class="btn btn-sm btn-success toggle-status" data-id="{{ $doctor->id }}">
                  Enable
                </button>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="d-flex justify-content-end mt-3">
    {{ $doctors->links() }}
  </div>
  <!-- Add New Doctor model start -->

  <div class="modal fade"
    id="samAddDoctorModal"
    tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content sam-doctor-modal">
        <div class="modal-header">
          <h5 class="modal-title">
            Add New Doctor
          </h5>
          <button
            class="btn-close"
            data-bs-dismiss="modal">
          </button>
        </div>
        <form action="{{ route('doctors.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
          <input type="hidden" name="modal_id" value="samAddDoctorModal">
          <div class="modal-body">
            <div class="row">
              @if(auth()->user()->role == 'super_admin')
                <div class="col-md-6 mb-3">
                  <label class="form-label">
                  Clinic *
                  </label>
                  <select name="clinical_admin_id" class="form-select sam-doctor-input">
                    @foreach($clinics as $clinic)
                        <option value="{{ $clinic->id }}"
                            {{ old('clinical_admin_id') == $clinic->id ? 'selected' : '' }}>
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
              @else
              <input type="hidden" name="clinical_admin_id" value="{{ auth()->user()->clinical_admin_id}}">
              @endif
              <div class="col-md-6 mb-3">
                <label class="form-label">
                Doctor Name *
                </label>
                <input type="text" name="doctor_name" class="form-control sam-doctor-input" value="{{ old('doctor_name') }}">
                @error('doctor_name')
                  <span class="text-danger">
                      {{ $message }}
                  </span>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">
                Mobile *
                </label>
                <input type="text" name="mobile_number" class="form-control sam-doctor-input" value="{{ old('mobile_number') }}">
                @error('mobile_number')
                  <span class="text-danger">
                      {{ $message }}
                  </span>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">
                Email
                </label>
                <input type="email" name="email" class="form-control sam-doctor-input" value="{{ old('email') }}">
                @error('email')
                  <span class="text-danger">
                      {{ $message }}
                  </span>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">
                Gender
                </label>
                <select name="gender" class="form-select sam-doctor-input">
                  <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }} >Male</option>
                  <option value="F" {{ old('gender') == 'M' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender')
                  <span class="text-danger">
                      {{ $message }}
                  </span>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">
                Date of Birth
                </label>
                <input type="date" name="dob" id="" class="form-control dob sam-doctor-input" value="{{ old('dob') }}" max="{{ date('Y-m-d') }}">
                @error('dob')
                  <span class="text-danger">
                      {{ $message }}
                  </span>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">
                Specialization *
                </label>
                <input type="text" name="specialization" class="form-control sam-doctor-input" value="{{ old('specialization') }}">
                @error('specialization')
                <span class="text-danger">
                    {{ $message }}
                </span>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">
                Qualification *
                </label>
                <input type="text" name="qualification" class="form-control sam-doctor-input" value="{{ old('qualification') }}">
                @error('qualification')
                <span class="text-danger">
                    {{ $message }}
                </span>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">
                Experience *
                </label>
                <input
                  type="text" name="experience"
                  class="form-control sam-doctor-input" value="{{ old('experience') }}">
                  @error('experience')
                  <span class="text-danger">
                      {{ $message }}
                  </span>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">
                Consultation Fee *
                </label>
                <input
                  type="number" name="consultation_fee"
                  class="form-control sam-doctor-input" value="{{ old('consultation_fee') }}">
                  @error('consultation_fee')
                  <span class="text-danger">
                      {{ $message }}
                  </span>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">
                Profile Photo
                </label>
                <input type="file" name="profile_photo" class="form-control">
                    @error('profile_photo')
                  <span class="text-danger">
                      {{ $message }}
                  </span>
                @enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">
                Status
                </label>
                <select class="form-select sam-doctor-input" name="status">
                  <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Active</option>
                  <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                  <span class="text-danger">
                      {{ $message }}
                  </span>
                @enderror
              </div>
              <div class="col-12">
                <label class="form-label">
                Address
                </label>
                <textarea
                  rows="3"
                  class="form-control"></textarea>
              </div>

              <!-- Doctor Weekly Schedule -->
              <div class="col-md-12 mb-3 mt-4">
                <div class="card shadow-sm">
                  <div class="card-header">
                  <h5 class="mb-0">Doctor Weekly Schedule</h5>
                  </div>

                  <div class="card-body">
                    @php
                      $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                    @endphp
                  <!-- Monday -->
                    @foreach($days as $day)
                      <div class="">
                        <div class="justify-content-between align-items-center">
                        <input type="hidden" name="schedules[{{ $day }}][day]" value="{{ $day }}">
                        <h6 class="mb-0">{{$day}}</h6>

                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox"  name="is_off" />
                          <label class="form-check-label">Off Day</label>
                        </div>

                        <div class="row inputday">
                          <div class="col-md-4">
                          <div class="p-3 border rounded">
                            <h6>Morning</h6>
                            <div class="col-md-12">
                              <label class="form-label"> Start Time </label>
                              <input type="text" placeholder="07:00 am" class="form-control sam-doctor-input" name="schedules[{{ $day }}][morning_start]"  value="{{ old('schedules.'.$day.'.morning_start') }}" />
                              @error('schedules.'.$day.'.morning_start')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                              @enderror
                            </div>

                            <div class="col-md-12">
                              <label class="form-label"> Close Time </label>
                              <input type="text" placeholder="12:00 am" class="form-control sam-doctor-input" name="schedules[{{ $day }}][morning_end]" value="{{ old('schedules.'.$day.'.morning_end') }}" />
                              @error('schedules.'.$day.'.morning_end')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                              @enderror
                            </div>
                          </div>
                          </div>
                          <div class="col-md-4">
                          <div class="p-3 border rounded">
                            <h6>Evening</h6>
                            <div class="col-md-12">
                            <label class="form-label"> Start Time </label>
                            <input type="text" placeholder="05:00 pm" class="form-control sam-doctor-input" name="schedules[{{ $day }}][evening_start]" value="{{ old('schedules.'.$day.'.evening_start') }}" />
                            @error('schedules.'.$day.'.evening_start')
                              <div class="text-danger mt-1">
                                  {{ $message }}
                              </div>
                            @enderror  
                          </div>

                            <div class="col-md-12">
                            <label class="form-label"> Close Time </label>
                            <input type="text" placeholder="09:00 pm" class="form-control sam-doctor-input" name="schedules[{{ $day }}][evening_end]" value="{{ old('schedules.'.$day.'.evening_end') }}"/>
                            @error('schedules.'.$day.'.evening_end')
                              <div class="text-danger mt-1">
                                  {{ $message }}
                              </div>
                          @enderror  
                          </div>
                          </div>
                          </div>

                          <div class="col-md-4">
                            <div class="p-3 border rounded">
                              <h6>General Shift</h6>
                              <div class="col-md-12">
                              <label class="form-label"> Start Time </label>
                              <input type="text" placeholder="07:00 am" class="form-control sam-doctor-input" name="schedules[{{ $day }}][general_start]" value="{{ old('schedules.'.$day.'.general_start') }}" />
                              @error('schedules.'.$day.'.general_start')
                                  <div class="text-danger mt-1">
                                      {{ $message }}
                                  </div>
                              @enderror
                            </div>

                            <div class="col-md-12">
                              <label class="form-label"> Close Time </label>
                              <input type="text" placeholder="07:00 pm" class="form-control sam-doctor-input" name="schedules[{{ $day }}][general_end]" value="{{ old('schedules.'.$day.'.general_end') }}"/>
                              @error('schedules.'.$day.'.general_end')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                              @enderror
                            </div>
                          </div>
                          </div>
                        </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
              
            </div>
          </div>
          <div class="modal-footer">
            <button
              class="btn btn-light"
              data-bs-dismiss="modal">
            Cancel
            </button>
            <button
              class="btn btn-primary">
            Save Doctor
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Doctor Details Start -->
  @foreach ($doctors as $doctor )
    <div class="offcanvas offcanvas-end" tabindex="-1" id="samDoctorViewOffcanvas{{ $doctor->id }}">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title">
          Doctor Details
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="offcanvas">
        </button>
      </div>
      <div class="offcanvas-body">
        <div class="text-center mb-4">
          <!-- <img
            src="https://ui-avatars.com/api/?name=Dr+Amit"
            class="rounded-circle"
            width="100"> -->
          @if($doctor->profile_photo)
            <img src="{{ asset('storage/' . $doctor->profile_photo) }}"
              alt="Doctor Photo" width="100"  class="rounded-circle">
          @else
            <img src="{{ url('assets/static_images/profile_photo.jpeg') }}"
              alt="Doctor Photo" width="100"  class="rounded-circle">
          @endif
          <h4 class="mt-3">
            {{$doctor->doctor_name}}
          </h4>
          <!-- <span class="badge bg-success">
          Active
          </span> -->
          @if($doctor->status == 0)
            <span class="badge bg-success">Active</span>
          @else
            <span class="badge bg-danger">Inactive</span>
          @endif
        </div>
        <table class="table">
          <tr>
            <th>Clinic</th>
            <td>{{$doctor->clinic->clinic_name}}</td>
          </tr>
          <tr>
            <th>Specialization</th>
            <td>{{$doctor->specialization}}</td>
          </tr>
          <tr>
            <th>Qualification</th>
            <td>{{ $doctor->qualification }}</td>
          </tr>
          <tr>
            <th>Experience</th>
            <td>{{ $doctor->experience }}</td>
          </tr>
          <tr>
            <th>Fee</th>
            <td>{{ $doctor->consultation_fee }}</td>
          </tr>
          <tr>
            <th>Mobile</th>
            <td>{{$doctor->mobile_number}}</td>
          </tr>
          <tr>
            <th>Email</th>
            <td>{{ $doctor->Email }}</td>
          </tr>
          <tr>
            <th>Available</th>
            <td>Mon-Fri</td>
          </tr>
          <tr>
            <th>Timing</th>
            <td>10 AM - 6 PM</td>
          </tr>
        </table>
        <hr>
        <div class="row g-3">
          <div class="col-6">
            <div class="sam-doctor-mini-card">
              <h6>Total Patients Checked</h6>
              <h3>{{ $doctor->total_patients_checked }}</h3>
            </div>
          </div>
          <div class="col-6">
            <div class="sam-doctor-mini-card">
              <h6>Today Patients Checked</h6>
              <h3>{{ $doctor->today_patients_checked }}</h3>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Edit Doctor Module Starts -->
    <!--  -->
    <div class="modal fade" id="samEditDoctorModal{{ $doctor->id }}" tabindex="-1">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content sam-doctor-modal">
          <div class="modal-header">
              <h5 class="modal-title">
                Edit Doctor
              </h5>
              <button
                class="btn-close"
                data-bs-dismiss="modal">
              </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('doctors.update', $doctor->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              @method('PUT')  
              @if($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                @endif
              <input type="hidden" name="modal_id" value="samEditDoctorModal{{ $doctor->id }}">
              <div class="row">
                @if(auth()->user()->role == 'super_admin')
                  <div class="col-md-6 mb-3">
                    <label class="form-label">
                    Clinic *
                    </label>
                    <select class="form-select sam-doctor-input" name="clinical_admin_id">
                      @foreach($clinics as $clinic)  
                        <option value="{{ $clinic->id }}">
                          {{ $clinic->clinic_name }}
                        </option>
                      @endforeach
                    </select>
                  </div>
                @else
                  <input type="hidden" name="clinical_admin_id" value="{{ auth()->user()->clinical_admin_id }}">
                @endif
                <div class="col-md-6 mb-3">
                  <label class="form-label">
                  Doctor Name *
                  </label>
                  <input type="text" name="doctor_name"
                      class="form-control sam-doctor-input"  value="{{ old('doctor_name',$doctor->doctor_name) }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Mobile *</label>
                  <input type="text" name="mobile_number"
                      class="form-control sam-doctor-input" value="{{ old('mobile_number',$doctor->mobile_number) }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">
                  Email
                  </label>
                  <input type="email" name="email" class="form-control sam-doctor-input" value="{{ old('email',$doctor->email) }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">
                  Gender
                  </label>
                  <select class="form-select sam-doctor-input">
                    <option value="M" {{ $doctor->gender == 'M' ? 'selected' : '' }}>Male</option>
                    <option value="F" {{ $doctor->gender == 'F' ? 'selected' : '' }}>Female</option>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">
                  Date of Birth
                  </label>
                  <input
                      type="date" name="dob"
                      class="form-control sam-doctor-input" value="{{ old('dob',$doctor->dob) }}" max="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">
                  Specialization *
                  </label>
                  <input
                      type="text" name="specialization"
                      class="form-control sam-doctor-input" value="{{ old('specialization',$doctor->specialization) }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">
                  Qualification *
                  </label>
                  <input
                      type="text" name="qualification"
                      class="form-control sam-doctor-input" value="{{ old('qualification',$doctor->qualification) }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">
                  Experience *
                  </label>
                  <input
                      type="text" name="experience"
                      class="form-control sam-doctor-input" value="{{ old('experience',$doctor->experience) }}">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">
                  Consultation Fee *
                  </label>
                  <input
                      type="number" name="consultation_fee"
                      class="form-control sam-doctor-input" value="{{ old('consultation_fee',$doctor->consultation_fee) }}" >
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">
                  Profile Photo
                  </label>
                  <input type="file" class="form-control" name="profile_photo">
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">
                  Status
                  </label>
                  <select class="form-select sam-doctor-input" name="status">
                      <option value="0" {{ $doctor->status == 0 ? 'selected' : '' }}>Active</option>
                      <option value="1" {{ $doctor->status == 1 ? 'selected' : '' }}>Inactive</option>
                  </select>
                </div>
                <div class="col-12  mb-3">
                  <label class="form-label">
                  Address
                  </label>
                  <textarea rows="3"
                      class="form-control" name="address"></textarea>
                </div>
                
                <div class="col-md-12 mb-3 mt-4">
                <div class="card shadow-sm">
                  <div class="card-header">
                  <h5 class="mb-0">Doctor Weekly Schedule</h5>
                  </div>

                  <div class="card-body">
                    @php
                      $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                    @endphp
                  <!-- Monday -->
                    @foreach($days as $day)
                      @php
                        $schedule = $doctor->schedules
                            ->where('day', $day)
                            ->first();
                      @endphp
                      <div class="">
                        <div class="justify-content-between align-items-center">
                        <input type="hidden" name="schedules[{{ $day }}][day]" value="{{ $day }}">
                        <h6 class="mb-0">{{$day}}</h6>

                        <div class="form-check form-switch">
                          <!-- <input class="form-check-input" type="checkbox"  name="is_off" /> -->
                          <input type="hidden" name="schedules[{{ $day }}][is_off]" value="0">
                          <input class="form-check-input" type="checkbox" name="schedules[{{ $day }}][is_off]" value="1" @checked($schedule && $schedule->is_off == 1)>
                          <label class="form-check-label">Off Day</label>
                        </div>

                        <div class="row inputday">
                          <div class="col-md-4">
                          <div class="p-3 border rounded">
                            <h6>Morning</h6>
                            <div class="col-md-12">
                            <label class="form-label"> Start Time </label>
                            <input type="text" placeholder="07:00 am" class="form-control sam-doctor-input" name="schedules[{{ $day }}][morning_start]"  
                              value="{{ old('schedules.'.$day.'.morning_start', $schedule?->morning_start) }}" />
                              @error('schedules.'.$day.'.morning_start')
                                <span class="text-danger">
                                  {{ $message }}
                                </span>
                              @enderror
                            </div>

                            <div class="col-md-12">
                            <label class="form-label"> Close Time </label>
                            <input type="text" placeholder="12:00 am" class="form-control sam-doctor-input" name="schedules[{{ $day }}][morning_end]" 
                              value="{{ old('schedules.'.$day.'.morning_end', $schedule?->morning_end) }}" />
                              @error('schedules.'.$day.'.morning_end')
                                <span class="text-danger">
                                  {{ $message }}
                                </span>
                              @enderror
                            </div>
                          </div>
                          </div>
                          <div class="col-md-4">
                          <div class="p-3 border rounded">
                            <h6>Evening</h6>
                            <div class="col-md-12">
                            <label class="form-label"> Start Time </label>
                            <input type="text" placeholder="05:00 pm" class="form-control sam-doctor-input" name="schedules[{{ $day }}][evening_start]" 
                              value="{{ old('schedules.'.$day.'.evening_start', $schedule?->evening_start) }}" />
                              @error('schedules.'.$day.'.evening_start')
                                <span class="text-danger">
                                  {{ $message }}
                                </span>
                              @enderror
                            </div>

                            <div class="col-md-12">
                            <label class="form-label"> Close Time </label>
                            <input type="text" placeholder="09:00 pm" class="form-control sam-doctor-input" name="schedules[{{ $day }}][evening_end]" 
                              value="{{ old('schedules.'.$day.'.evening_end', $schedule?->evening_end) }}"/>
                              @error('schedules.'.$day.'.evening_end')
                                <span class="text-danger">
                                  {{ $message }}
                                </span>
                              @enderror
                            </div>
                          </div>
                          </div>

                          <div class="col-md-4">
                          <div class="p-3 border rounded">
                            <h6>General Shift</h6>
                            <div class="col-md-12">
                            <label class="form-label"> Start Time </label>
                            <input type="text" placeholder="07:00 am" class="form-control sam-doctor-input" name="schedules[{{ $day }}][general_start]" 
                              value="{{ old('schedules.'.$day.'.general_start', $schedule?->general_start) }}" />
                              @error('schedules.'.$day.'.general_start')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                              @enderror
                            </div>

                            <div class="col-md-12">
                            <label class="form-label"> Close Time </label>
                            <input type="text" placeholder="07:00 pm" class="form-control sam-doctor-input" name="schedules[{{ $day }}][general_end]" 
                              value="{{ old('schedules.'.$day.'.general_end', $schedule?->general_end) }}"/>
                              @error('schedules.'.$day.'.general_end')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                              @enderror
                            </div>
                          </div>
                          </div>
                        </div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>
                
              </div>
              <div class="modal-footer">
                <button
                    class="btn btn-light"
                    data-bs-dismiss="modal">
                Cancel
                </button>
                <button
                    class="btn btn-primary">
                Save Doctor
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!--  -->
    <!-- edit doctor module end -->
  @endforeach
  <div id="page-data" data-errors="{{ $errors->any() ? '1' : '0' }}" data-success="{{ session('success') ? '1' : '0' }}"  data-modal-id="{{ old('modal_id') }}">
  </div>
@endsection