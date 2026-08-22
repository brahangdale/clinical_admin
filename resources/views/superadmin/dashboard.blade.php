@extends('layouts.main') @section('main-container')
<!-- Content -->
<div class="sam-dashboard-content">
  <div class="row g-4">
    <div class="col-lg-3">
      <div class="sam-dashboard-card">
        <div class="sam-dashboard-card-icon">
          <i class="fa-solid fa-hospital"></i>
        </div>

        <div class="sam-dashboard-card-title">Total Clinics</div>

        <div class="sam-dashboard-card-value">{{$total_clinics}}</div>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="sam-dashboard-card">
        <div class="sam-dashboard-card-icon">
          <i class="fa-solid fa-circle-check"></i>
        </div>

        <div class="sam-dashboard-card-title">Active Clinics</div>

        <div class="sam-dashboard-card-value">{{ $active_clinics }}</div>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="sam-dashboard-card">
        <div class="sam-dashboard-card-icon">
          <i class="fa-solid fa-users"></i>
        </div>

        <div class="sam-dashboard-card-title">Total Patients</div>

        <div class="sam-dashboard-card-value">{{$total_patients}}</div>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="sam-dashboard-card">
        <div class="sam-dashboard-card-icon">
          <i class="fa-solid fa-calendar-check"></i>
        </div>

        <div class="sam-dashboard-card-title">Total Appointments</div>

        <div class="sam-dashboard-card-value">{{$total_appointments}}</div>
      </div>
    </div>
  </div>

  <!-- Recent Clinics -->

  <div class="sam-dashboard-table-card">
    <div class="sam-dashboard-table-title">Recent Clinics</div>

    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th>Clinic Name</th>
            <th>Owner</th>
            <th>Status</th>
            <th>Created</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($clinics as $clinic)
          <tr>
            <td>{{ $clinic->clinic_name }}</td>

            <td>{{ $clinic->user?->user_name ?? '-' }}</td>

            <td>
              @if($clinic->user?->status == 1)
              <span class="badge bg-success">Active</span>
              @else
              <span class="badge bg-danger">Inactive</span>
              @endif
              <!-- <span class="badge bg-success">
                    Active
                </span> -->
            </td>

            <td>{{ $clinic->created_at->format('d-M-Y') }}</td>

            <td>
              <button class="btn btn-sm btn-primary">View</button>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center">No Clinics Found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- </div> -->
@endsection
