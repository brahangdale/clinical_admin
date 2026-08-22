@extends('layouts.main')
@section('main-container')
  <div class="mt-4"></div>
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
              <th>Time</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
      </thead>
      <tbody>
        
        @forelse($completedToday as $appointment)
        
        <tr>
          <td>{{ $appointment->token_number}}</td>
          <td>{{ $appointment->patient->patient_name }}</td>
          <td>{{ $appointment->doctor->doctor_name }}</td>
          <td>{{ auth()->user()->role == 'super_admin' ? $appointment->clinic->clinic_name : '' }}</td>
          <td>{{ $appointment->appointment_date }}</td>
          <td>{{ $appointment->appointment_time }}</td>
          <!-- <td>Token</td> -->
          <td class="availablee-status">{{ $appointment->status }}</td>
          <!-- <td>
            <select class="form-select form-select-sm appointment-status
              @if($appointment->status == 'pending') status-pending
              @elseif($appointment->status == 'confirmed') status-confirmed
              @elseif($appointment->status == 'completed') status-completed
              @elseif($appointment->status == 'cancelled') status-cancelled
              @endif
            "data-id="{{ $appointment->id }}">
              <option value="pending" {{ $appointment->status == 'pending' ? 'selected' : '' }}>
                Pending
              </option>

              <option value="confirmed"
                  {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>
                  Confirmed
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
          <!-- <td>
            <button
              class="btn btn-sm btn-warning"
              data-bs-toggle="modal"
              data-bs-target="#sameditAppointmentModal{{ $appointment->id }}">
              Edit
            </button> -->
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
    {{ $completedToday->links() }}
  </div>
   <!-- view details -->
  @foreach ($completedToday as $appointment )
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
@endsection