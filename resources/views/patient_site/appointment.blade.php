@extends('layouts.clinic_website')
@section('clinic_website-container')

<!-- voice script end -->
<!-- Header -->
<header class="top-header">

    <div class="logo-area">
        <i class="fa-solid fa-stethoscope"></i>
        <span>Doctor Clinic</span>
    </div>

    <!-- Menu Button -->

    <button class="menu-btn" id="menuBtn">
        <i class="fa-solid fa-bars"></i>
    </button>

    <!-- Overlay -->

    <div class="overlay" id="overlay"></div>

    <!-- Side Menu -->

    <div class="side-menu" id="sideMenu">

        <div class="menu-header">
            <h4>Doctor Clinic</h4>
            <button id="closeMenu">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <ul>

            <li>
                <a href="index.html">
                    <i class="fa-solid fa-house"></i>
                    Home
                </a>
            </li>

            <li>
                <a href="Appointment.html">
                    <i class="fa-solid fa-calendar-check"></i>
                    Appointment
                </a>
            </li>

            <li>
                <a href="about.html">
                    <i class="fa-solid fa-circle-info"></i>
                    About
                </a>
            </li>

            <li>
                <a href="location.html">
                    <i class="fa-solid fa-location-dot"></i>
                    Location
                </a>
            </li>

            <li>
                <a href="game.html">
                    <i class="fa-solid fa-gamepad"></i>
                    Game
                </a>
            </li>

        </ul>

    </div>

</header>

<div class="appointment-form-card"> 
  <h2 class="appointment-form-title">
    Book Appointment
  </h2>

  <form action="{{ route('patient_site.appointment') }}" method="post">
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
  <!-- Patient Name -->
    <div class="appointment-form-group">
      <label>Patient Name <span class="text-danger">*</span></label>
        <div class="voice-input-wrapper">
          <input type="text" name="patient_name" class="appointment-form-control voice-input" placeholder="Enter Patient Name" required>
          <button type="button" class="voice-btn">
            <i class="fas fa-microphone"></i>
          </button>
        </div>
    </div>

    <!-- Contact No -->
    <div class="appointment-form-group">
        <label>Contact No. <span class="text-danger">*</span></label>
        <div class="voice-input-wrapper">
        <input type="tel" name="mobile_number" id="patientMobile" class="appointment-form-control voice-input" placeholder="Enter Contact Number" maxlength="10" inputmode="numeric" required>
      <button type="button" class="voice-btn">
                <i class="fas fa-microphone"></i>
            </button>
        </div>
    </div>

    <!-- Address -->
    <div class="appointment-form-group">
        <label>Address <span class="text-danger">*</span></label>
        <div class="voice-input-wrapper">
            <input type="text" class="appointment-form-control voice-input"
                      rows="3" name="address"
                      placeholder="Enter Address"
                      required>
            <button type="button" class="voice-btn">
                <i class="fas fa-microphone"></i>
          </button>
      </div>
    </div>

    <!-- Select Doctor -->
    <div class="appointment-form-group">
        <label>Select Doctor <span class="text-danger">*</span></label>
        <select class="form-select doctor_id"  name="doctor_id" id="doctor_id">
                  @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->doctor_name }}</option>
                  @endforeach
                </select>
    </div>

    <!-- Appointment Date -->
    <div class="appointment-form-group">
        <label>Appointment Date <span class="text-danger">*</span></label>
        <input type="date" name="appointment_date" 
              class="appointment-form-control " id="appointment_date"
              required>
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
    <!-- <div class="appointment-form-group">
        <label>Appointment Time <span class="text-danger">*</span></label>
        <input type="time" name="appointment_time"
              class="appointment-form-control"
              required>
    </div> -->

    <!-- Date of Birth -->
    <!-- <div class="appointment-form-group">
        <label>Date of Birth <span class="text-danger">*</span></label>
        <input type="date"
      id="patientDob"
      class="appointment-form-control"
      required>
    </div> -->

    <div class="appointment-form-group">
      <label>Date of Birth <span class="text-danger">*</span></label>

      <div class="d-flex gap-2">

          <!-- <input type="text"
                id="dobDay"
                class="appointment-form-control text-center"
                placeholder="DD"
                maxlength="2"
                required>

          <input type="text"
                id="dobMonth"
                class="appointment-form-control text-center"
                placeholder="MM"
                maxlength="2"
                required>

          <input type="text"
                id="dobYear"
                class="appointment-form-control text-center"
                placeholder="YYYY"
                maxlength="4"
                required> -->
          <input type="date" class="appointment-form-control dob" name="date_of_birth" >

      </div>
    </div>

    <div class="appointment-form-group">
    <label>Age <span class="text-danger">*</span></label>

    <input type="text"
          id="patientAge" name="age"
          class="appointment-form-control age"
          placeholder="Age"
          readonly>
  </div>

    <!-- Gender -->
    <div class="appointment-form-group">
        <label>Gender <span class="text-danger">*</span></label>
        <select class="appointment-form-control" required name="gender">
            <option value="">Select Gender</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
            <option value="O">Other</option>
            </select>
        </select>
    </div>
    <!-- Submit -->
    <button type="submit" class="appointment-submit-btn">
      Submit
    </button>
  </form>
</div>
@endsection


