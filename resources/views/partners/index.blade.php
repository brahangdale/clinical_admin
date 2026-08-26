@extends('layouts.main')
@section('main-container')
  <!-- <div class="sam-dashboard-main"> -->
  <div class="sam-clinic-header">
    <div>
      <h3 class="sam-clinic-title">Partners Management</h3>
      <p class="text-muted mb-0">
        Manage all Partners
      </p>
    </div>

    <button class="btn sam-clinic-add-btn" data-bs-toggle="modal" data-bs-target="#samAddClinicModal">
      <i class="fa-solid fa-plus"></i>Add New Partner
    </button>

    <!-- Add partner Modal -->
    <div class="modal fade" id="samAddClinicModal" tabindex="-1">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content sam-clinic-modal">
          <!-- Header -->
          <div class="modal-header">
            <h5 class="modal-title">
              <i class="fa-solid fa-hospital me-2"></i>Add New Partner
            </h5>
            <button type="reset" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <!-- Body -->

          <div class="modal-body">
            <form id="samClinicForm" action="{{ route('partners.store') }}" method="post">
              @csrf
              <input type="hidden" name="modal_id" value="samAddClinicModal">
              <div class="row">

                <div class="col-md-6 mb-3">
                  <label class="form-label">Partner Name *</label>
                  <input type="text" name="partner_name"  value="{{ old('partner_name') }}" class="form-control sam-clinic-input" placeholder="Enter Partner Name">
                  <span class="text-danger">
                    @error('partner_name')
                      <small>{{ $message }}</small> 
                    @enderror
                  </span>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">User Name *</label>
                  <input type="text" name="user_name" value="{{ old('user_name') }}" class="form-control sam-clinic-input" placeholder="Enter Owner Name">
                  <span class="text-danger">
                    @error('user_name')
                      <small>{{ $message }}</small> 
                    @enderror
                  </span>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Mobile Number *</label>
                  <input type="number" name="mobile_number" value="{{ old('mobile_number') }}" class="form-control sam-clinic-input" placeholder="Enter Mobile">
                  <span class="text-danger">
                    @error('mobile_number')
                      <small>{{ $message }}</small> 
                    @enderror
                  </span>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Email Address</label>
                  <input type="email" name="email" value="{{ old('email') }}" class="form-control sam-clinic-input" placeholder="Enter Email">
                  <span class="text-danger">
                    @error('email')
                      <small>{{ $message }}</small> 
                    @enderror
                  </span>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">City</label>
                  <input type="text" name="city" value="{{ old('city') }}" class="form-control sam-clinic-input" placeholder="Enter City">
                  
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">State</label>
                  <input type="text" name="state" value="{{ old('state') }}" class="form-control sam-clinic-input" placeholder="Enter State">
                </div>

                <div class="col-12 mb-3">
                  <label class="form-label">Address</label>
                  <textarea rows="3", name="address" class="form-control sam-clinic-input" placeholder="Enter Address">{{ old('address') }}</textarea>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Status</label>
                  <select class="form-select sam-clinic-input" name="status">
                    <option value="0" selected>Inactive</option>
                    <option value="1" >Active</option>
                  </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="reset" class="btn btn-light" data-bs-dismiss="modal">
                  Cancel
                </button>
                <button type="submit" class="btn btn-primary">Save Partner</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- after save clinic info -->
    @if(session('success'))
      <div class="modal fade" id="samCredentialModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title">
                Partner Created Successfully
              </h5>
            </div>

            <div class="modal-body">
              <p><strong>Username:</strong>
              {{ session('username') }}
              </p>
              <p><strong>Password:</strong>
                {{ session('password') }}
              </p>
              <p><strong>Admin URL:</strong>
                yourdomain.com/admin
              </p>
              <p><strong>Clinic Website URL:</strong>
                yourdomain.com/clinicname
              </p>
            </div>

            <div class="modal-footer">
              <button class="btn btn-primary" data-bs-dismiss="modal">
                Copy Credentials
              </button>
            </div>
          </div>
        </div>
      </div>
    @endif
    <!-- after save clinic info end -->
  </div>
  <!-- SEARCH -->
  <div class="sam-clinic-card">
    
      <form method="GET" action="{{ route('partners.index') }}">
      <div class="row">  
      <div class="col-lg-4">
          <input type="text" name="search" class="form-control sam-clinic-search"
          placeholder="Search Partner" value="{{ request('search') }}">
          <!-- <button type="submit" class="btn btn-primary">search</button> -->
        </div>
          <div class="col-lg-2 col-md-6">
            <div class="d-flex gap-2 sam-filter-btns">
              <button class="btn btn-primary flex-fill">
              Search
              </button>
              <!-- <button class="btn btn-outline-secondary flex-fill">
              Reset
              </button> -->
                <a href="{{ route('partners.index') }}"
                    class="btn btn-outline-secondary ">
                    Reset
                </a>
            </div>
          </div>
      </form>
    </div>
  </div>
  <!-- Content -->
  <div class="sam-dashboard-content">
        <div class="row g-4 mt-1">
          <div class="col-lg-4">
            <div class="sam-clinic-stats-card">
              <h6>Total Partners</h6>
              <h2>{{$total_partners}}</h2>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="sam-clinic-stats-card">
              <h6>Active Partners</h6>
              <h2>{{$active_partners}}</h2>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="sam-clinic-stats-card">
              <h6>Inactive Partners</h6>
              <h2>{{$inactive_partners}}</h2>
            </div>
          </div>

        </div>

        <!-- Recent Clinics -->

        <div class="sam-clinic-card mt-4">
          <div class="table-responsive">
            <table class="table align-middle sam-clinic-table">
              <thead>
                <tr>
                  <th>Partner Name</th>
                  <th>Owner/Username</th>
                  <th>Mobile</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Actions</th>
                </tr>
              </thead>

              <tbody>
                @forelse($partners as $partner)
                  <tr id="row-{{ $partner->id }}">
                    <td>
                      <strong>{{$partner->partner_name}}</strong>
                    </td>
                    <td>{{ $partner->user?->user_name }}</td>
                    <td>{{$partner?->mobile_number}}</td>
                    <td class="status-text"> 
                      @if($partner->user?->status == 1)
                        <span class="badge bg-success">Active</span>
                      @else
                        <span class="badge bg-danger">Inactive</span>
                      @endif
                    </td>
                    <td>
                      {{ $partner->created_at->format('d-M-Y') }}
                    </td>
                    <td>
                      <button class="btn btn-sm btn-primary" data-bs-toggle="offcanvas" data-bs-target="#samClinicViewOffcanvas{{ $partner->id }}">
                        View
                      </button>
                      <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#samEditClinicModal{{ $partner->id }}">
                        Edit
                      </button>
                      @if($partner->user?->status == 1)
                          <button class="btn btn-sm btn-danger toggle-partner"
                                  data-id="{{ $partner->id }}">
                              Disable
                          </button>
                      @else
                          <button class="btn btn-sm btn-success toggle-partner"
                                  data-id="{{ $partner->id }}">
                              Enable
                          </button>
                      @endif
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center">No Partners Found</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
        <div class="d-flex justify-content-end mt-3">
        {{ $partners->links() }}
    </div>
  </div>

  <!-- offcanvas and model code view and edit btn start -->
  @foreach($partners as $partner)  
    <div class="offcanvas offcanvas-end" tabindex="-1" id="samClinicViewOffcanvas{{ $partner->id }}">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title">Partner Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
      </div>
      <div class="offcanvas-body">
        <div class="sam-clinic-view-section">
          <h6>Clinic Information</h6>
          <table class="table">
            <tr>
              <th>Partner Name</th>
              <td>{{$partner->partner_name}}</td>
            </tr>

            <tr>
                <th>Owner</th>
                <td>{{$partner->user?->user_name}}</td>
            </tr>

            <tr>
                <th>Mobile</th>
                <td>{{$partner->mobile_number}}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                  @if($partner->user?->status == 1)
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
              <th>Email</th>
              <td>{{ $partner->user?->email  }}</td>
            </tr>

            <tr>
                <th>Password</th>
                <td>{{$partner->user?->visible_password}}<td>
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

                      <h3>{{ $partner->doctors_count }}</h3>

                  </div>

              </div>

              <div class="col-6">

                  <div class="sam-clinic-mini-card">

                      <h6>Patients</h6>

                      <h3>{{ $partner->patients_count }}</h3>

                  </div>

              </div>

              <div class="col-6">

                  <div class="sam-clinic-mini-card">

                      <h6>Appointments</h6>

                      <h3>{{ $partner->appointments_count }}</h3>

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
    <!-- edit module start -->
    <div class="modal fade" id="samEditClinicModal{{ $partner->id }}" tabindex="-1">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Partner</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">
            <form  action="{{ route('partners.update', $partner->id) }}" method="POST">
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
              <input type="hidden" name="modal_id" value="samEditClinicModal{{ $partner->id }}">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label"> Partner Name </label>
                  <input type="text" name="partner_name" class="form-control"  value="{{ old('partner_name', $partner->partner_name) }}">
                    <span class="text-danger">
                      @error('partner_name')
                        <small>{{ $message }}</small> 
                      @enderror
                    </span>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label"> Owner Name</label>
                  <input type="text", name="user_name"
                    class="form-control" value="{{ $partner->user?->user_name }}">
                    <span class="text-danger">
                      @error('user_name')
                        <small>{{ $message }}</small> 
                      @enderror
                    </span>
                  </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Mobile Number</label>
                  <input type="text", name="mobile_number" class="form-control"
                    value="{{ $partner->mobile_number }}">
                    <span class="text-danger">
                      @error('mobile_number')
                        <small>{{ $message }}</small> 
                      @enderror
                    </span>  
                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        Email *
                    </label>

                    <input
                    type="email" name="email"
                    class="form-control"
                    value="{{ $partner->user?->email }}">
                    <span class="text-danger">
                      @error('email')
                        <small>{{ $message }}</small> 
                      @enderror
                    </span> 
                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        City
                    </label>

                    <input
                    type="text" name="city"
                    class="form-control"
                    value="{{ $partner->city }}">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">
                        State
                    </label>

                    <input
                    type="text", name="state"
                    class="form-control"
                    value="{{ $partner->state }}">

                </div>

                <div class="col-12 mb-3">

                    <label class="form-label">
                        Address
                    </label>

                    <textarea
                    class="form-control"name="address"
                    rows="3">{{ $partner->address }}</textarea>

                </div>

                <div class="col-md-6">

                    <label class="form-label">
                        Status
                    </label>

                    <select class="form-select" name="status">

                        <option value="0"
                            {{ $partner->user?->status == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>

                        <option value="1"
                            {{ $partner->user?->status == 1 ? 'selected' : '' }}>
                            Active
                        </option>

                    </select>

                </div>

              </div>
              <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endforeach

  <div
    id="page-data"
    data-errors="{{ $errors->any() ? '1' : '0' }}"
    data-success="{{ session('success') ? '1' : '0' }}"
    data-modal-id="{{ old('modal_id') }}">
  </div>
@endsection