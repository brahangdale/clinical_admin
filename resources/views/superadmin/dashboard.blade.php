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
              <!-- <button class="btn btn-sm btn-primary">View</button> -->
               <button class="btn btn-sm btn-primary" data-bs-toggle="offcanvas" data-bs-target="#samClinicViewOffcanvas{{ $clinic->id }}">
                        View
                      </button>
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

  @foreach($clinics as $clinic)  
      <div class="offcanvas offcanvas-end" tabindex="-1" id="samClinicViewOffcanvas{{ $clinic->id }}">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title">Clinic Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
          <div class="sam-clinic-view-section">
            <h6>Clinic Information</h6>
            <table class="table">
              <tr>
                <th>Clinic Name</th>
                <td>{{$clinic->clinic_name}}</td>
              </tr>

              <tr>
                  <th>Owner</th>
                  <td>{{$clinic->user?->user_name}}</td>
              </tr>

              <tr>
                  <th>Mobile</th>
                  <td>{{$clinic->mobile_number}}</td>
              </tr>

              <tr>
                  <th>Email</th>
                  <td>{{ $clinic->user?->email }}</td>
              </tr>

              <tr>
                  <th>Status</th>
                  <td>
                    @if($clinic->user?->status == 1)
                      <span class="badge bg-success">Active</span>
                    @else
                      <span class="badge bg-danger">Inactive</span>
                    @endif
                  </td>
              </tr>
            </table>
          </div>
          <hr>
          <div class="sam-clinic-view-section">

            <h6>Admin Credentials</h6>

            <table class="table">

                <tr>
                    <th>Username</th>
                    <td>{{$clinic->user?->user_name}}</td>
                </tr>

                <tr>
                    <th>Password</th>
                    <td>{{$clinic->user?->password}}</td>
                </tr>

                <tr>
                    <th>Admin URL</th>
                    <td>yourdomain.com/admin</td>
                </tr>

                <tr>
                    <th>Patient URL</th>
                    <td>yourdomain.com/akasa-clinic</td>
                </tr>

            </table>

          </div>

          <hr>

          <div class="row g-3">

                <div class="col-6">

                    <div class="sam-clinic-mini-card">

                        <h6>Doctors</h6>

                        <h3>{{ $clinic->doctors_count }}</h3>

                    </div>

                </div>

                <div class="col-6">

                    <div class="sam-clinic-mini-card">

                        <h6>Patients</h6>

                        <h3>{{ $clinic->appointments_count }}</h3>

                    </div>

                </div>

                <div class="col-6">

                    <div class="sam-clinic-mini-card">

                        <h6>Appointments</h6>

                        <h3>{{ $clinic->appointments_count }}</h3>

                    </div>

                </div>

                <!-- <div class="col-6">

                    <div class="sam-clinic-mini-card">

                        <h6>Receptionists</h6>

                        <h3>4</h3>

                    </div>

                </div> -->

          </div>
        </div>
      </div>
      @endforeach
</div>

<!-- </div> -->
@endsection
