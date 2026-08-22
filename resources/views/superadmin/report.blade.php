@extends('layouts.main')
@section('main-container')
<!-- =======================================================
REPORTS & ANALYTICS PAGE
======================================================= -->

<div class="sam-report-header">

    <div>

        <h3 class="sam-report-title">
            Reports & Analytics
        </h3>

        <p class="text-muted mb-0">
            Monitor clinics, doctors, patients and appointments
        </p>

    </div>

    <div>

        <button class="btn btn-success">
            <i class="fa-solid fa-file-excel"></i>
            Export Excel
        </button>

        <button class="btn btn-danger">
            <i class="fa-solid fa-file-pdf"></i>
            Export PDF
        </button>

    </div>

</div>

<!-- =======================================================
FILTERS
======================================================= -->

<!-- <div class="sam-report-card mb-4">

    <div class="row g-3">

        <div class="col-lg-3">

            <label class="form-label">
                From Date
            </label>

            <input
            type="date"
            class="form-control">

        </div>

        <div class="col-lg-3">

            <label class="form-label">
                To Date
            </label>

            <input
            type="date"
            class="form-control">

        </div>

        <div class="col-lg-3">

            <label class="form-label">
                Clinic
            </label>

            <select class="form-select">

                <option>
                    All Clinics
                </option>

            </select>

        </div>

        <div class="col-lg-3">

            <label class="form-label">
                Doctor
            </label>

            <select class="form-select">

                <option>
                    All Doctors
                </option>

            </select>

        </div>

    </div>

</div> -->

<!-- =======================================================
SUMMARY CARDS
======================================================= -->

<div class="row g-4 mb-4">

    <div class="col-lg-3">

        <div class="sam-report-stats-card">

            <h6>Total Appointments</h6>

            <h2>{{ $totalAppointments }}</h2>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="sam-report-stats-card">

            <h6>Total Patients</h6>

            <h2>{{$totalPatients}}</h2>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="sam-report-stats-card">

            <h6>Total Doctors</h6>

            <h2>{{ $totalDoctors }}</h2>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="sam-report-stats-card">

            <h6>Cancelled</h6>

            <h2>{{ $totalCancelled }}</h2>

        </div>

    </div>

</div>

<!-- =======================================================
CHART SECTION
======================================================= -->

<div class="row g-4 mb-4">

    <div class="col-lg-8">

        <div class="sam-report-card">

            <h5 class="mb-3">
                Monthly Appointments
            </h5>

            <canvas id="appointmentChart"
						data-months='@json($months)'
    				data-counts='@json($counts)'></canvas>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="sam-report-card">

            <h5 class="mb-3">
                Appointment Status
            </h5>

            <canvas id="statusChart" data-status='@json([$completed, $pending, $cancelled])'></canvas>

        </div>

    </div>

</div>

<!-- =======================================================
TOP CLINICS
======================================================= -->
@if(auth()->user()->role == 'super_admin')
  <div class="sam-report-card mb-4">

    <h5 class="mb-3">
        Top Clinics
    </h5>

    <div class="table-responsive">

        <table class="table">

            <thead>

                <tr>

                    <th>Clinic</th>
                    <th>Doctors</th>
                    <th>Patients</th>
                    <th>Appointments</th>
                    <th>Completed</th>

                </tr>

            </thead>

            <tbody>
							@forelse($topClinics as $clinic)
                <tr>

                    <td>{{ $clinic->clinic_name }}</td>
                    <td>{{$clinic->doctors_count}}</td>
                    <td>{{ $clinic->patients_count }}</td>
                    <td>{{ $clinic->appointments_count }}</td>
                    <td>{{ $clinic->completed_appointments_count }}</td>

                </tr>
							@empty
                <tr>
                    <td colspan="5" class="text-center">No clinics found.</td>
                </tr>
            @endforelse
            </tbody>

        </table>

    </div>

  </div>
@endif

<!-- =======================================================
TOP DOCTORS
======================================================= -->

<div class="sam-report-card">

	<h5 class="mb-3">
			Top Doctors
	</h5>

	<div class="table-responsive">
		<table class="table">
			<thead>

					<tr>

							<th>Doctor</th>
							<th>Clinic</th>
							<th>Patients</th>
							<th>Appointments</th>

					</tr>

			</thead>

			<tbody>
				@forelse($topDoctors as $doctor)
                <tr>
                    <td>{{ $doctor->doctor_name }}</td>
                    <td>{{ $doctor->clinic->clinic_name ?? '-' }}</td>
                    <td>{{ $doctor->patients_count }}</td>
                    <td>{{ $doctor->appointments_count }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No doctors found.</td>
                </tr>
            @endforelse

			</tbody>
		</table>
	</div>
@endsection